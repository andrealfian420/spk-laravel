<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class AdminCriteriaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->authorize('viewAny', Criteria::class);

    return view('dashboard.criteria.index', [
      'title'     => 'Criterias',
      'criterias' => Criteria::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Criteria  $criteria
   * @return \Illuminate\Http\Response
   */
  public function edit(Criteria $criteria)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Criteria  $criteria
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Criteria $criteria)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Criteria  $criteria
   * @return \Illuminate\Http\Response
   */
  public function destroy(Criteria $criteria)
  {
    //
  }
}
