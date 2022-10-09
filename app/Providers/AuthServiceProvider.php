<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        if(Schema::hasTable('resources')){
            $resources = \App\Models\Resource::all();
            foreach ($resources as $key => $resource) {
                Gate::define($resource->resource, function ($user) use ($resource) {
                    return $resource->roles->contains($user->role);
                });
            }
        }
        //dd(Gate::abilities());
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return \App\Models\User::where('api_token', $request->input('api_token'))->first();
            }
        });
    }
}
