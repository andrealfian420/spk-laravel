<?php

namespace App\Http\Requests\TourismObject;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class TourismObjectUpdateRequest extends FormRequest
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
    $id = $this->route('tourism_object')->id;

    return [
      'name'    => 'required|max:255|unique:tourism_objects,name,' . $id,
      'address' => 'required|max:255|unique:tourism_objects,address,' . $id,
    ];
  }
}
