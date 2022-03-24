<?php

namespace App\Http\Controllers;

use App\Models\CriteriaAnalysis;
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
    ]);
  }
}
