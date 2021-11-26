<?php

namespace GetTheTrophy\Extensions\Auth;

use BotMan\BotMan\BotMan;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher;

class ExternalUserProvider extends EloquentUserProvider
{
    /**
     ** Create a new external user provider, based on Eloquent.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $model
     * @return void
     */
    public function __construct(Hasher $hasher, $model)
    {
        $this->model = $model;
        $this->hasher = $hasher;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {

        // TODO Check the secret in the request key
        /*  $driverName = app('BotMan\BotMan\BotMan')->getDriver()->getName();
        if (config('gtt.auth.secrets')->{$driverName} == request()->secret_key) {
            return true;
        } else {
            return false;
        }*/
        //Until then always return true
        return true;
    }
}
