<?php
namespace app\middlewares;

use app\core\Auth;

class AuthMiddleware extends \app\core\BaseMiddleware
{
    public function execute()
    {
        var_dump('login middleware executed');
//        if(Auth::isGuest()){
//            return;
//        }
//
//        return redirect('/login');
    }
}
