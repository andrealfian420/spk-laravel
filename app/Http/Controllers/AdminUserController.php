<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->authorize('viewAny', User::class);

    return view('dashboard.user.index', [
      'title' => 'User Management',
      'users' => User::whereNot('id', auth()->user()->id)->get()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->authorize('create', User::class);

    return view('dashboard.user.create', [
      'title' => 'User Management',
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->authorize('create', User::class);

    $validate = $request->validate([
      'name'     => 'required|max:255',
      'username' => 'required|unique:users|min:6|max:15',
      'email'    => 'required|unique:users|email:dns',
      'password' => 'required|min:6',
      'level'    => 'required'
    ]);

    $validate['password'] = Hash::make($validate['password']);

    User::create($validate);

    return redirect('/dashboard/users')
      ->with('success', 'The new user has been added!');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    $this->authorize('update', User::class);

    return view('dashboard.user.edit', [
      'title' => 'User Management',
      'user'  => $user
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {
    $this->authorize('update', User::class);

    $rules = [
      'name'     => 'required|max:255',
      'username' => 'required|min:6|max:15|unique:users,username,' . $user->id,
      'email'    => 'required|email:dns|unique:users,email,' . $user->id,
      'level'    => 'required'
    ];

    if ($request->password) {
      $rules['password'] = 'min:6';
    }

    $validate = $request->validate($rules);

    if ($validate['password'] ?? false) {
      $validate['password'] = Hash::make($validate['password']);
    }

    User::where('id', $user->id)
      ->update($validate);

    return redirect('/dashboard/users')
      ->with('success', 'The selected user has been updated!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    $this->authorize('delete', User::class);

    User::destroy($user->id);

    return redirect('/dashboard/users')
      ->with('success', 'The selected user has been deleted!');
  }
}
