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
}
