<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriteriaComparison\UpdateValueRequest;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\CriteriaAnalysis;
use App\Models\CriteriaAnalysisDetail;
use App\Models\PreventiveValue;
use Illuminate\Http\Request;

class DashboardCriteriaComparisonController extends Controller
{
  public function index()
  {
    if (auth()->user()->level === 'USER') {
      $comparisons = CriteriaAnalysis::where('user_id', auth()->user()->id)
        ->with('user')
        ->get();
    }

    if (auth()->user()->level === 'SUPERADMIN' || auth()->user()->level === 'ADMIN') {
      $comparisons = CriteriaAnalysis::with('user')->get();
    }

    return view('dashboard.criteria-comparison.index', [
      'title'       => 'Criteria Comparisons',
      'comparisons' => $comparisons,
      'criterias'   => Criteria::all(),
    ]);
  }

  public function store(Request $request)
  {
    if (!isset($request->criteria_id)) {
      return redirect('/dashboard/criteria-comparisons')
        ->with('failed', 'Please check your selected criterias!');
    }

    $validate = $request->validate([
      'criteria_id' => 'required|array'
    ]);

    // data for criteria analyses table
    $analysisData = [
      'user_id' => auth()->user()->id
    ];

    $analysis = CriteriaAnalysis::create($analysisData);

    $analysisId = $analysis->id;
    $comparisonIds = [];

    for ($i = 0; $i < count($validate['criteria_id']); $i++) {
      // first data
      if ($i == 0) {
        $next = 0;
        for ($firstIndex = 0; $firstIndex < count($validate['criteria_id']); $firstIndex++) {
          $data = [
            'criteria_id_first'  => $validate['criteria_id'][$i],
            'criteria_id_second' => $validate['criteria_id'][$next]
          ];

          array_push($comparisonIds, $data);
          $next++;
        }
      } else { // the rest of the data
        //reverse loop
        $current = $i;
        for ($j = 0; $j < $current; $j++) {
          $data = [
            'criteria_id_first'  => $validate['criteria_id'][$current],
            'criteria_id_second' => $validate['criteria_id'][$j],
          ];

          array_push($comparisonIds, $data);
        }

        // forward loop
        $next = $i;
        for ($firstIndex = $i; $firstIndex < count($validate['criteria_id']); $firstIndex++) {
          $data = [
            'criteria_id_first'  => $validate['criteria_id'][$i],
            'criteria_id_second' => $validate['criteria_id'][$next]
          ];

          array_push($comparisonIds, $data);
          $next++;
        }
      }
    }

    // save data to criteria analysis details table
    foreach ($comparisonIds as $comparison) {
      $detail = [
        'criteria_analysis_id' => $analysisId,
        'criteria_id_first'    => $comparison['criteria_id_first'],
        'criteria_id_second'   => $comparison['criteria_id_second'],
        'comparison_value'     => 1
      ];

      CriteriaAnalysisDetail::create($detail);
    }

    return redirect('/dashboard/criteria-comparisons/' . $analysisId)
      ->with('success', 'The chosen criteria has been added!');
  }

  public function show(CriteriaAnalysis $criteriaAnalysis)
  {
    $this->authorize('view', $criteriaAnalysis);

    $criteriaAnalysis->load('details', 'details.firstCriteria', 'details.secondCriteria');

    $details        = filterDetailResults($criteriaAnalysis->details);
    $isDoneCounting = PreventiveValue::where('criteria_analysis_id', $criteriaAnalysis->id)
      ->exists();

    $criteriaAnalysis->unsetRelation('details');

    return view('dashboard.criteria-comparison.input-value', [
      'title'             => 'Input Criteria Comparison Values',
      'criteria_analysis' => $criteriaAnalysis,
      'details'           => $details,
      'isDoneCounting'    => $isDoneCounting,
    ]);
  }

  public function updateValue(UpdateValueRequest $request, CriteriaAnalysis $criteriaAnalysis)
  {
    $this->authorize('update', $criteriaAnalysis);

    $validate = $request->validated();

    foreach ($validate['criteria_analysis_detail_id'] as $key => $id) {
      CriteriaAnalysisDetail::where('id', $id)
        ->update([
          'comparison_value'  => $validate['comparison_values'][$key],
          'comparison_result' => $validate['comparison_values'][$key],
        ]);
    }

    $this->_countRestDetails($validate['id'], $validate['criteria_analysis_detail_id']);
    $this->_countPreventiveValue($validate['id']);


    return redirect()
      ->back()
      ->with('success', 'The comparison values has been updated!');
  }

  private function _countRestDetails($criteriaAnalysisId, $detailIds)
  {
    // get all comparisons data which the user didn't input it's values
    $restDetails = CriteriaAnalysisDetail::where('criteria_analysis_id', $criteriaAnalysisId)
      ->whereNotIn('id', $detailIds)
      ->get();

    // count and update comparison value
    if ($restDetails->count()) {
      $restDetails->each(function ($value, $key) use ($criteriaAnalysisId) {
        $prevComparison = CriteriaAnalysisDetail::where([
          'criteria_analysis_id' => $criteriaAnalysisId,
          'criteria_id_first'    => $value->criteria_id_second,
          'criteria_id_second'   => $value->criteria_id_first,
        ])->first();

        $comparisonResult = 1 / $prevComparison['comparison_value'];

        CriteriaAnalysisDetail::where([
          'criteria_analysis_id' => $criteriaAnalysisId,
          'criteria_id_first'    => $value->criteria_id_first,
          'criteria_id_second'   => $value->criteria_id_second,
        ])
          ->update(['comparison_result' => $comparisonResult]);
      });
    }
  }

  private function _countPreventiveValue($criteriaAnalysisId)
  {
    // get all criteria which is selected by user
    $criterias = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysisId);

    // loop criteria
    foreach ($criterias as $criteria) {
      // get all the comparison value of first criteria id that match the loop criteria id
      $dataDetails = CriteriaAnalysisDetail::select('criteria_id_second', 'comparison_result')
        ->where([
          'criteria_analysis_id' => $criteriaAnalysisId,
          'criteria_id_first'    => $criteria->id
        ])
        ->get();

      // temporary preventive value
      $tempValue = 0;

      // loop the comparison value
      foreach ($dataDetails as $detail) {
        // get the total sum of comparison result by the second criteria id
        // that match the second criteria id of the current loop
        $totalPerCriteria = CriteriaAnalysisDetail::where([
          'criteria_analysis_id' => $criteriaAnalysisId,
          'criteria_id_second'   => $detail->criteria_id_second
        ])
          ->sum('comparison_result');

        // temporary preventive value
        $res = substr($detail->comparison_result / $totalPerCriteria, 0, 11);

        $tempValue += $res;
      }

      // final preventive value = temporary value / total criteria count
      $FinalPrevValue = $tempValue / $criterias->count();

      $data = [
        'criteria_analysis_id' => $criteriaAnalysisId,
        'criteria_id'          => $criteria->id,
        'value'                => floatval($FinalPrevValue)
      ];

      // insert or create if doesnt exist
      PreventiveValue::updateOrCreate([
        'criteria_analysis_id' => $criteriaAnalysisId,
        'criteria_id'          => $criteria->id,
      ], $data);
    }
  }

  public function result(CriteriaAnalysis $criteriaAnalysis)
  {
    $this->authorize('view', $criteriaAnalysis);

    $criteriaAnalysis->load('details', 'details.firstCriteria', 'details.secondCriteria', 'preventiveValues', 'preventiveValues.criteria');

    $totalPerCriteria =  $this->_getTotalSumPerCriteria($criteriaAnalysis->id, CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id));

    $ruleRI = [
      1  => 0.0,
      2  => 0.0,
      3  => 0.58,
      4  => 0.90,
      5  => 1.12,
      6  => 1.24,
      7  => 1.32,
      8  => 1.41,
      9  => 1.45,
      10 => 1.49,
      11 => 1.51,
      12 => 1.48,
      13 => 1.56,
      14 => 1.57,
      15 => 1.59,
    ];

    $availableCriterias = Criteria::all()->pluck('id');
    $isAnyAlternative   = Alternative::checkAlternativeByCriterias($availableCriterias);
    $isAbleToRank       = false;

    if ($isAnyAlternative) {
      $isAbleToRank = true;
    }

    return view('dashboard.criteria-comparison.result', [
      'title'             => 'Comparison Results',
      'criteria_analysis' => $criteriaAnalysis,
      'totalSums'         => $totalPerCriteria,
      'ruleRI'            => $ruleRI,
      'isAbleToRank'      => $isAbleToRank,
    ]);
  }

  private function _getTotalSumPerCriteria($criteriaAnalysisId, $criterias)
  {
    $result = [];

    foreach ($criterias as $criteria) {
      $totalPerCriteria = CriteriaAnalysisDetail::where([
        'criteria_analysis_id' => $criteriaAnalysisId,
        'criteria_id_second'   => $criteria->id
      ])
        ->sum('comparison_result');

      $data = [
        'name'     => $criteria->name,
        'totalSum' => floatval($totalPerCriteria)
      ];

      array_push($result, $data);
    }

    return $result;
  }

  public function destroy(CriteriaAnalysis $criteriaAnalysis)
  {
    $this->authorize('delete', $criteriaAnalysis);

    CriteriaAnalysis::destroy($criteriaAnalysis->id);

    return redirect('/dashboard/criteria-comparisons')
      ->with('success', 'The selected criteria comparison has been deleted!');
  }
}
