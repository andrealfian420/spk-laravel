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
}
