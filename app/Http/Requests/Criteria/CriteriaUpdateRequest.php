<?php

namespace App\Http\Requests\Criteria;

use Illuminate\Foundation\Http\FormRequest;

class CriteriaUpdateRequest extends FormRequest
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
    $id = $this->route('criteria')->id;

    return [
      'name'      => 'required|max:30|unique:criterias,name,' . $id,
      'attribute' => 'required',
    ];
  }
}
