<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Alternative;
use Illuminate\Http\Request;
use App\Models\CriteriaAnalysis;
use App\Models\CriteriaAnalysisDetail;

class DashboardRankController extends Controller
{
  public function index()
  {
    if (auth()->user()->level === 'USER') {
      $criteriaAnalyses = CriteriaAnalysis::where('user_id', auth()->user()->id)
        ->with('user')
        ->get();
    }

    if (auth()->user()->level === 'SUPERADMIN' || auth()->user()->level === 'ADMIN') {
      $criteriaAnalyses = CriteriaAnalysis::with('user')->get();
    }

    $availableCriterias = Criteria::all()->pluck('id');
    $isAnyAlternative   = Alternative::checkAlternativeByCriterias($availableCriterias);
    $isAbleToRank       = false;

    if ($isAnyAlternative) {
      $isAbleToRank = true;
    }

    return view('dashboard.final-rank.index', [
      'title'             => 'Final Ranking',
      'criteria_analyses' => $criteriaAnalyses,
      'isAbleToRank'      => $isAbleToRank,
    ]);
  }

  public function show(CriteriaAnalysis $criteriaAnalysis)
  {
    $criteriaAnalysis->load('preventiveValues');

    $criterias      = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
    $criteriaIds    = $criterias->pluck('id');
    $alternatives   = Alternative::getAlternativesByCriteria($criteriaIds);
    $dividers       = Alternative::getDividerByCriteria($criterias);

    $normalizations = $this->_countNormalization($dividers, $alternatives);
    $ranking        = $this->_finalRanking($criteriaAnalysis->preventiveValues, $normalizations);

    return view('dashboard.final-rank.rank', [
      'title'        => 'Final Ranking',
      'dividers'     => $dividers,
      'alternatives' => $normalizations,
      'ranks'        => $ranking
    ]);
  }

  private function _countNormalization($dividers, $alternatives)
  {
    // return $alternatives;
    // return $dividers;
    $normalization = [];

    foreach ($alternatives as $alternative) {
      $normalizationNums = [];

      foreach ($alternative['alternative_val'] as $key => $val) {
        if ($val == 0) {
          $result = 0;
        }

        $attribute = $dividers[$key]['attribute'];

        if ($attribute === 'BENEFIT' && $val != 0) {
          $result = substr(floatval($val / $dividers[$key]['divider_value']), 0, 11);
        }

        if ($attribute === 'COST' && $val != 0) {
          $result = substr(floatval($dividers[$key]['divider_value'] / $val), 0, 11);
        }

        array_push($normalizationNums, $result);
      }

      array_push($normalization, [
        'tourism_object_id' => $alternative['tourism_object_id'],
        'tourism_name' => $alternative['tourism_name'],
        'results' => $normalizationNums
      ]);
    }

    return $normalization;
  }

  private function _finalRanking($preventiveValues, $normalizations)
  {
    foreach ($normalizations as $keyNorm => $normal) {
      foreach ($normal['results'] as $keyVal => $value) {
        $importanceVal = $preventiveValues[$keyVal]->value;

        $result = $importanceVal * $value;

        if (array_key_exists('rank_result', $normalizations[$keyNorm])) {
          $normalizations[$keyNorm]['rank_result'] += $result;
        } else {
          $normalizations[$keyNorm]['rank_result'] = $result;
        }
      }
    }

    usort($normalizations, function ($a, $b) {
      return $b['rank_result'] <=> $a['rank_result'];
    });

    return $normalizations;
  }
}
