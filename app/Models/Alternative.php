<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function getKeyName()
  {
    return 'tourism_object_id';
  }

  public function criteria()
  {
    return $this->belongsTo(Criteria::class, 'criteria_id');
  }
}
