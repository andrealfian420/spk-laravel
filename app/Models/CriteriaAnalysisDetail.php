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

  public function criteriaAnalysis()
  {
    return $this->belongsTo(CriteriaAnalysis::class);
  }

  public function firstCriteria()
  {
    return $this->belongsTo(Criteria::class, 'criteria_id_first', 'id');
  }

  public function secondCriteria()
  {
    return $this->belongsTo(Criteria::class, 'criteria_id_second', 'id');
  }

  public static function getSelectedCriterias($analysisId)
  {
    return static::where('criteria_analysis_id', $analysisId)
      ->join('criterias', 'criteria_id_first', '=', 'criterias.id')
      ->select('criterias.*')
      ->groupBy('criterias.name')
      ->orderBy('criterias.id')
      ->get();
  }
}
