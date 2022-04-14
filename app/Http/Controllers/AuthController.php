<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthSignInRequest;
use App\Http\Requests\Auth\AuthSignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

  public function store(AuthSignUpRequest $request)
  {
    $validate = $request->validated();

    $validate['password'] = Hash::make($validate['password']);

    User::create($validate);

    return redirect('/')->with('success', 'Your account has been created!');
  }

  public function authenticate(AuthSignInRequest $request)
  {
    $credentials = $request->validated();

    // autentikasi user
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      return redirect()->intended('/dashboard');
    }

    // sign in gagal
    return back()->with('failed', "Sign in failed, please try again");
  }

  public function signOut(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'You have been logged out!');
  }
}
