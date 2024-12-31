<?php

namespace app\core;

class Auth
{
    public static function login(Authenticable $user)
    {
        Application::$app->session->set('user', $user);
    }

    public static function loggedInUser(): Authenticable
    {
        return Application::$app->session->get('user');
    }

    public static function isGuest(): bool
    {
        if(!Application::$app->session->get('user')){
            return true;
        }

        return false;
    }
}
