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

  public function tourismObject()
  {
    return $this->belongsTo(TourismObject::class, 'tourism_object_id');
  }

  public static function getDividerByCriteria($criterias)
  {
    $dividers = [];

    foreach ($criterias as $criteria) {
      if ($criteria->attribute === 'BENEFIT') {
        $divider = static::where('criteria_id', $criteria->id)
          ->max('alternative_value');
      } else if ($criteria->attribute === 'COST') {
        $divider = static::where('criteria_id', $criteria->id)
          ->min('alternative_value');
      }

      $data = [
        'criteria_id'   => $criteria->id,
        'name'          => $criteria->name,
        'attribute'     => $criteria->attribute,
        'divider_value' => floatval($divider)
      ];

      array_push($dividers, $data);
    }

    return $dividers;
  }

  public static function getAlternativesByCriteria($criterias)
  {
    $results = static::with('criteria', 'tourismObject')
      ->whereIn('criteria_id', $criterias)
      ->get();

    if (!$results->count()) {
      return $results;
    }

    $finalRes = [];

    foreach ($results as $result) {
      $isExists = array_search($result->tourism_object_id, array_column($finalRes, 'tourism_object_id'));

      if ($isExists !== '' && $isExists !== null && $isExists !== false) {
        array_push($finalRes[$isExists]['criteria_id'], $result->criteria->id);
        array_push($finalRes[$isExists]['criteria_name'], $result->criteria->name);
        array_push($finalRes[$isExists]['alternative_val'], $result->alternative_value);
      } else {
        $data = [
          'tourism_object_id' => $result->tourism_object_id,
          'tourism_name'      => $result->tourismObject->name,
          'criteria_id'       => [$result->criteria->id],
          'criteria_name'     => [$result->criteria->name],
          'alternative_val'   => [$result->alternative_value]
        ];

        array_push($finalRes, $data);
      }
    }

    return $finalRes;
  }

  public static function checkAlternativeByCriterias($criterias)
  {
    $isAllCriteriaPresent = false;

    foreach ($criterias as $criteria) {
      $check = static::where('criteria_id', $criteria)->get()->count();

      if ($check > 0) {
        $isAllCriteriaPresent = true;
      } else {
        $isAllCriteriaPresent = false;
        break;
      }
    }

    return $isAllCriteriaPresent;
  }
}
