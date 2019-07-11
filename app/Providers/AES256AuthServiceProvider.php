<?php namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

use Crypt;

class AES256AuthServiceProvider extends EloquentUserProvider
{
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];
        $authPassword = $user->getAuthPassword();

        try {
            return Crypt::decrypt($authPassword) == $plain;
        } catch (\Exception $e) {
            return false;
        }
    }
}