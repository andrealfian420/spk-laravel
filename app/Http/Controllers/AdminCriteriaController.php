<?php

namespace App\Http\Controllers;

use App\Http\Requests\Criteria\CriteriaStoreRequest;
use App\Http\Requests\Criteria\CriteriaUpdateRequest;
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
    $this->authorize('create', Criteria::class);

    return view('dashboard.criteria.create', [
      'title' => 'Add Criterias',
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CriteriaStoreRequest $request)
  {
    $this->authorize('create', Criteria::class);

    $validate = $request->validated();

    Criteria::create($validate);

    return redirect('/dashboard/criterias')
      ->with('success', 'The new criteria has been added!');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Criteria  $criteria
   * @return \Illuminate\Http\Response
   */
  public function edit(Criteria $criteria)
  {
    $this->authorize('update', Criteria::class);

    return view('dashboard.criteria.edit', [
      'title'    => "Edit $criteria->name",
      'criteria' => $criteria
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Criteria  $criteria
   * @return \Illuminate\Http\Response
   */
  public function update(CriteriaUpdateRequest $request, Criteria $criteria)
  {
    $this->authorize('update', Criteria::class);

    $validate = $request->validated();

    Criteria::where('id', $criteria->id)
      ->update($validate);

    return redirect('/dashboard/criterias')
      ->with('success', 'The selected criteria has been updated!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Criteria  $criteria
   * @return \Illuminate\Http\Response
   */
  public function destroy(Criteria $criteria)
  {
    $this->authorize('delete', Criteria::class);

    Criteria::destroy($criteria->id);

    return redirect('/dashboard/criterias')
      ->with('success', 'The selected criteria has been deleted!');
  }
}
