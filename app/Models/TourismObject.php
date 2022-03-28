<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourismObject extends Model
{
  protected $fillable = [
    'name',
    'address',
  ];

  public function alternatives()
  {
    return $this->hasMany(Alternative::class);
  }
}
