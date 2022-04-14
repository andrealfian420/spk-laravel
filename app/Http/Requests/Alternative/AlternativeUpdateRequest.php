<?php

namespace App\Http\Requests\Alternative;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class AlternativeUpdateRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $rules = [
      'criteria_id'       => 'required|array',
      'alternative_id'    => 'required|array',
      'alternative_value' => 'required|array',
    ];

    if (Request::instance()->new_tourism_object_id) {
      $rules['new_tourism_object_id'] = 'required|exists:tourism_objects,id';
      $rules['new_criteria_id']       = 'required|array';
      $rules['new_alternative_value'] = 'required|array';
    }

    return $rules;
  }
}
