<?php

namespace App\Http\Requests\Profile;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
      'name'     => 'required|max:255',
      'username' => 'required|min:6|max:15|unique:users,username,' . auth()->user()->id,
      'email'    => 'required|email:dns|unique:users,email,' . auth()->user()->id,
    ];

    if (Request::instance()->oldPassword || Request::instance()->password || Request::instance()->password_confirmation) {
      $rules = [
        'oldPassword' => 'required',
        'password'    => 'required|confirmed|min:6',
      ];
    }

    return $rules;
  }
}
