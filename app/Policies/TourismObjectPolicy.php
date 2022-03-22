<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourismObjectPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can view any models.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function viewAny(User $user)
  {
    return ($user->level === 'ADMIN' || $user->level === 'SUPERADMIN');
  }

  /**
   * Determine whether the user can create models.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function create(User $user)
  {
    return ($user->level === 'ADMIN' || $user->level === 'SUPERADMIN');
  }

  /**
   * Determine whether the user can update the model.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\TourismObject  $tourismObject
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function update(User $user)
  {
    return ($user->level === 'ADMIN' || $user->level === 'SUPERADMIN');
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\TourismObject  $tourismObject
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function delete(User $user)
  {
    return ($user->level === 'ADMIN' || $user->level === 'SUPERADMIN');
  }
}
