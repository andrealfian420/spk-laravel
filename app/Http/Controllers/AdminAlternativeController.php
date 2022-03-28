<?php

namespace App\Http\Controllers;

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

  public function store(Request $request)
  {
    $validate = $request->validate([
      'tourism_object_id' => 'required|exists:tourism_objects,id',
      'criteria_id'       => 'required|array',
      'alternative_value' => 'required|array'
    ]);

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
    //
  }

  public function update(Request $request, Alternative $alternative)
  {
    //
  }

  public function destroy(Alternative $alternative)
  {
    //
  }
}
