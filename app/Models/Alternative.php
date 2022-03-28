<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function tourismObject()
  {
    return $this->belongsTo(TourismObject::class, 'tourism_object_id');
  }
}
