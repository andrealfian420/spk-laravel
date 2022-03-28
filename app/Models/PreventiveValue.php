<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreventiveValue extends Model
{
  use HasFactory;

  protected $fillable = ['criteria_analysis_id', 'criteria_id', 'value'];

  public function criteriaAnalysis()
  {
    return $this->belongsTo(CriteriaAnalysis::class, 'criteria_analysis_id', 'id');
  }

  public function criteria()
  {
    return $this->belongsTo(Criteria::class, 'criteria_id', 'id');
  }
}
