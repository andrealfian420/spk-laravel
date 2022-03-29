<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use Illuminate\Http\Request;
use App\Models\CriteriaAnalysis;

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

    $isAnyAlternative = Alternative::all();

    return view('dashboard.final-rank.index', [
      'title'             => 'Final Ranking',
      'criteria_analyses' => $criteriaAnalyses,
      'isAbleToRank'      => $isAnyAlternative->count() ? true : false,
    ]);
  }
}
