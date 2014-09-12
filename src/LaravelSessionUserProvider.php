<?php

namespace Portico\SessionUser;

class LaravelSessionUserProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function provides()
    {
        return ['Portico\SessionUser\SessionUser'];
    }

    public function register()
    {
        $this->app->bind('Portico\SessionUser\SessionUser', function() {
            $auth = $this->app->make('auth');
            if (!$auth->user()) {
                throw new NoAuthenticatedSessionUserException;
            }

            return $auth->user();
        });
    }
} 