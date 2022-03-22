<?php

namespace App\Http\Controllers;

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

  public function authenticate(Request $request)
  {
    $credentials = $request->validate([
      'username' => "required",
      'password' => "required",
    ]);

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
