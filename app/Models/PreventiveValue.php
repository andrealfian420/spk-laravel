<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreventiveValue extends Model
{
  use HasFactory;

  protected $fillable = ['criteria_analysis_id', 'criteria_id', 'value'];
}
