<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaAnalysisDetail extends Model
{
  use HasFactory;

  protected $fillable = [
    'criteria_analysis_id',
    'criteria_id_first',
    'criteria_id_second',
    'comparison_value',
    'comparison_result'
  ];
}
