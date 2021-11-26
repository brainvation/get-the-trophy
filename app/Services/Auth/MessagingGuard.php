<?php

namespace GetTheTrophy\Services\Auth;

use GetTheTrophy\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class MessagingGuard implements Guard
{
    protected $request;
    protected $provider;
    protected $user;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->user = null;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return ($this->user() !== null);
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        //If we already have a user, return that
        if (isset($this->user)) {
            return $this->user;
        }

        //Otherwise try to do that based on the data from the messaging services
        //and see if it is a valid user
        if ($this->validate($this->getExternalUserData())) {
            //Yeah! Authenticated!
            return $this->user;
        }

        //in all other cases return null
        return null;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        if (isset($this->user)) {
            return $this->user()->getAuthIdentifier();
        }
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        if (isset($user) && $this->provider->validateCredentials($user, $credentials)) {
            //User good -> set it and return
            $this->setUser($user);

            return true;
        }

        //in all other cases
        return false;
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    /**
     * Retrieve the external user data of the current connection
     *
     * @return array External User Data containing Service and ID
     */
    public function getExternalUserData()
    {
        $botman = app('BotMan\BotMan\BotMan');
        $botUser = $botman->getUser();

        if (isset($botUser)) {
            return [
                'external_service' => $botman->getDriver()->getName(),
                'external_id' => $botUser->getId(),
            ];
        }

        return null;
    }
}
