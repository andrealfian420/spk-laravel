<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AdminUserUpdateRequest extends FormRequest
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
    $id = $this->route('user')->id;

    $rules = [
      'name'     => 'required|max:255',
      'username' => 'required|min:6|max:15|unique:users,username,' . $id,
      'email'    => 'required|email:dns|unique:users,email,' . $id,
      'level'    => 'required'
    ];

    if (Request::instance()->password) {
      $rules['password'] = 'min:6';
    }

    return $rules;
  }
}
