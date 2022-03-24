<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardProfileController extends Controller
{
  public function index()
  {
    return view('dashboard.profile.index', [
      'title'    => 'My Profile',
      'userData' => auth()->user()
    ]);
  }

  public function update(Request $request, User $user)
  {
    $this->authorize('update', User::class);

    if ($user->id != auth()->user()->id) {
      abort(403);
    }

    $rules = [
      'name' => 'required|max:255',
      'username' => 'required|min:6|max:15|unique:users,username,' . $user->id,
      'email' => 'required|email:dns|unique:users,email,' . $user->id,
    ];

    if ($request->oldPassword || $request->password || $request->password_confirmation) {
      $rules = [
        'oldPassword' => 'required',
        'password'    => 'required|confirmed|min:6',
      ];
    }

    $validate = $request->validate($rules);

    if ($validate['oldPassword'] ?? false) {
      //check password
      if (Hash::check($validate['oldPassword'], $user->password)) {
        // password match
        $newPass = Hash::make($validate['password']);

        User::where('id', $user->id)
          ->update(['password' => $newPass]);

        return redirect('/dashboard/profile')
          ->with('success', "Your password has been updated!");
      } else {
        return redirect('/dashboard/profile')
          ->with('failed', "Your old password is invalid!");
      }
    }

    User::where('id', $user->id)
      ->update($validate);

    return redirect('/dashboard/profile')
      ->with('success', "Your profile has been updated!");
  }
}
