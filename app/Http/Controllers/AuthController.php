<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function index()
  {
    $data = [
      'title' => 'SPK Objek Wisata | Sign In',
    ];

    return view('auth.signin', $data);
  }

  public function signUp()
  {
    $data = [
      'title' => 'SPK Objek Wisata | Sign Up',
    ];

    return view('auth.signup', $data);
  }

  public function store(Request $request)
  {
    $validate = $request->validate([
      'name' => 'required|max:255',
      'username' => 'required|unique:users|min:6|max:15',
      'email' => 'required|unique:users|email:dns',
      'password' => 'required|min:6'
    ]);

    $validate['password'] = Hash::make($validate['password']);

    User::create($validate);

    return redirect('/')->with('success', 'Your account has been created!');
  }
}
