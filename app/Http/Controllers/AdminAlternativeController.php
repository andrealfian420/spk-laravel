<?php

namespace App\Http\Controllers;

use App\Http\Requests\Alternative\AlternativeStoreRequest;
use App\Http\Requests\Alternative\AlternativeUpdateRequest;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\TourismObject;
use Illuminate\Http\Request;

class AdminAlternativeController extends Controller
{
  public function index()
  {
    $this->authorize('admin');

    $usedIds    = Alternative::select('tourism_object_id')->distinct()->get();
    $usedIdsFix = [];

    foreach ($usedIds as $usedId) {
      array_push($usedIdsFix, $usedId->tourism_object_id);
    }

    $alternatives = TourismObject::whereIn('id', $usedIdsFix)
      ->with('alternatives')
      ->get();

    $tourismObjects = TourismObject::whereNotIn('id', $usedIdsFix)->get();

    return view('dashboard.alternative.index', [
      'title'           => 'Alternatives',
      'alternatives'    => $alternatives,
      'criterias'       => Criteria::all(),
      'tourism_objects' => $tourismObjects
    ]);
  }

  public function store(AlternativeStoreRequest $request)
  {
    $validate = $request->validated();

    foreach ($validate['criteria_id'] as $key => $criteriaId) {
      $data = [
        'tourism_object_id' => $validate['tourism_object_id'],
        'criteria_id'       => $criteriaId,
        'alternative_value' => $validate['alternative_value'][$key],
      ];

      Alternative::create($data);
    }

    return redirect('/dashboard/alternatives')
      ->with('success', 'The New Alternative has been added!');
  }

  public function edit(Alternative $alternative)
  {
    $this->authorize('admin');

    // check if there is any new criteria which the user haven't filled the value
    $selectedCriteria = Alternative::where('tourism_object_id', $alternative->tourism_object_id)->pluck('criteria_id');
    $newCriterias     = Criteria::whereNotIn('id', $selectedCriteria)->get();

    $alternative      = TourismObject::where('id', $alternative->tourism_object_id)
      ->with('alternatives', 'alternatives.criteria')->first();

    return view('dashboard.alternative.edit', [
      'title'        => "Edit $alternative->name's Values",
      'alternative'  => $alternative,
      'newCriterias' => $newCriterias
    ]);
  }

  public function update(AlternativeUpdateRequest $request, Alternative $alternative)
  {
    $this->authorize('admin');

    $validate = $request->validated();

    // insert new alternative values if the new criteria exists
    if ($validate['new_tourism_object_id'] ?? false) {
      foreach ($validate['new_criteria_id'] as $key => $newCriteriaId) {
        $data = [
          'tourism_object_id' => $validate['new_tourism_object_id'],
          'criteria_id'       => $newCriteriaId,
          'alternative_value' => $validate['new_alternative_value'][$key],
        ];

        Alternative::create($data);
      }
    }

    foreach ($validate['criteria_id'] as $key => $criteriaId) {
      $data = [
        'criteria_id'       => $criteriaId,
        'alternative_value' => $validate['alternative_value'][$key],
      ];

      Alternative::where('id', $validate['alternative_id'][$key])
        ->update($data);
    }

    return redirect('/dashboard/alternatives')
      ->with('success', 'The selected alternative has been updated!');
  }

  public function destroy(Alternative $alternative)
  {
    $this->authorize('admin');

    Alternative::where('tourism_object_id', $alternative->tourism_object_id)
      ->delete();

    return redirect('/dashboard/alternatives')
      ->with('success', 'The selected alternative has been deleted!');
  }
}
