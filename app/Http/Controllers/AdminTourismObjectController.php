<?php

namespace App\Http\Controllers;

use App\Models\TourismObject;
use Illuminate\Http\Request;

class AdminTourismObjectController extends Controller
{
  public function index(Request $request)
  {
    $this->authorize('viewAny', TourismObject::class);

    echo 'halo';
  }
}
