<?php

namespace App\Providers;

use App\Models\comment;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Laravel\Passport\Passport;




class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(1));
        Passport::personalAccessTokensExpireIn(now()->addDays(15));
        Gate::define('edit-comment', function (User $user,comment $commment) {
            return $user->id == $commment->user_id; // Nếu comment  dó có user_id = user_id
            // của token đang giữ
        });
        Gate::define('delete-comment', function ($user, $commment) {
            if ($user->type=='1'){
                return true;
            }
            elseif ($user->id == $commment->user_id){
                return true;
            }
            elseif ($user->type==1){ // Admin delete comment
                return  true;
            }
        });
    }
}
