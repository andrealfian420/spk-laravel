<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\CriteriaAnalysis;
use App\Models\CriteriaAnalysisDetail;
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

    return redirect('/dashboard/criteria-comparisons')
      ->with('success', 'The chosen criteria has been added!');
  }
}
