<?php

namespace App\Policies;

use App\Models\CriteriaAnalysis;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CriteriaAnalysisPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can view the model.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\CriteriaAnalysis  $criteriaAnalysis
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function view(User $user, CriteriaAnalysis $criteriaAnalysis)
  {
    return ($user->id === $criteriaAnalysis->user_id || $user->level === 'SUPERADMIN' || $user->level === 'ADMIN');
  }

  /**
   * Determine whether the user can update the model.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\CriteriaAnalysis  $criteriaAnalysis
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function update(User $user, CriteriaAnalysis $criteriaAnalysis)
  {
    return $user->id === $criteriaAnalysis->user_id;
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @param  \App\Models\User  $user
   * @param  \App\Models\CriteriaAnalysis  $criteriaAnalysis
   * @return \Illuminate\Auth\Access\Response|bool
   */
  public function delete(User $user, CriteriaAnalysis $criteriaAnalysis)
  {
    return $user->id === $criteriaAnalysis->user_id;
  }
}
