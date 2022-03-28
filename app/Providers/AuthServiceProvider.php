<?php

namespace App\Providers;

use App\Models\CriteriaAnalysis;
use App\Models\User;
use App\Models\TourismObject;
use App\Policies\CriteriaAnalysisPolicy;
use App\Policies\CriteriaPolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\TourismObjectPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    TourismObject::class => TourismObjectPolicy::class,
    Criteria::class => CriteriaPolicy::class,
    User::class => UserPolicy::class,
    CriteriaAnalysis::class => CriteriaAnalysisPolicy::class
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    Gate::define('admin', function (User $user) {
      return ($user->level === 'SUPERADMIN' || $user->level === 'ADMIN');
    });
  }
}
