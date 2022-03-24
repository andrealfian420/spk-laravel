<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user)
  {
    return $user->level === 'SUPERADMIN';
  }

  public function create(User $user)
  {
    return $user->level === 'SUPERADMIN';
  }

  public function update(User $user)
  {
    return ($user->level === 'SUPERADMIN' || $user->id == auth()->user()->id);
  }

  public function delete(User $user)
  {
    return $user->level === 'SUPERADMIN';
  }
}
