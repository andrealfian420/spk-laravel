<?php

namespace App\Http\Controllers;

use App\Models\TourismObject;
use Illuminate\Http\Request;

class AdminTourismObjectController extends Controller
{
  public function index()
  {
    $this->authorize('viewAny', TourismObject::class);

    return view('dashboard.tourism-object.index', [
      'title' => 'Tourism Objects',
      'objects' => TourismObject::all()
    ]);
  }

  public function create()
  {
    $this->authorize('create', TourismObject::class);

    return view('dashboard.tourism-object.create', [
      'title' => 'Create Tourism Objects',
    ]);
  }

  public function store(Request $request)
  {
    $this->authorize('create', TourismObject::class);

    $validate = $request->validate([
      'name'    => 'required|unique:tourism_objects|max:255',
      'address' => 'required|unique:tourism_objects|max:255',
    ]);

    TourismObject::create($validate);

    return redirect('/dashboard/tourism-objects')
      ->with('success', 'The new tourism object has been added!');
  }

  public function edit(TourismObject $tourismObject)
  {
    $this->authorize('update', TourismObject::class);

    return view('dashboard.tourism-object.edit', [
      'title'  => "Edit $tourismObject->name",
      'object' => $tourismObject
    ]);
  }

  public function update(Request $request, TourismObject $tourismObject)
  {
    $this->authorize('update', TourismObject::class);

    $validate = $request->validate([
      'name'    => 'required|max:255|unique:tourism_objects,name,' . $tourismObject->id,
      'address' => 'required|max:255|unique:tourism_objects,address,' . $tourismObject->id,
    ]);

    TourismObject::where('id', $tourismObject->id)
      ->update($validate);

    return redirect('/dashboard/tourism-objects')
      ->with('success', 'The selected tourism object has been updated!');
  }

  public function destroy(TourismObject $tourismObject)
  {
    $this->authorize('delete', TourismObject::class);

    TourismObject::destroy($tourismObject->id);

    return redirect('/dashboard/tourism-objects')
      ->with('success', 'The selected tourism object has been deleted!');
  }
}
