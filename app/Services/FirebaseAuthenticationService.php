<?php

namespace App\Services;

class FirebaseAuthenticationService
{
    protected $auth;

    public function __construct()
    {
        $this->auth = app('firebase.auth');
    }

    public function registerUser(string $email, string $password)
    {
        $user = $this->auth->createUserWithEmailAndPassword($email, $password);
        return $user->uid;
    }

    public function loginUser(string $email, string $password)
    {
        return $this->auth->signInWithEmailAndPassword($email, $password);        
    }
}
