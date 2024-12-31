<?php
namespace app\controllers;

use app\core\Application;
use app\core\Auth;
use app\core\Controller;
use app\core\Request;
use app\middlewares\AuthMiddleware;
use app\models\User;

class AppController extends Controller
{
    public function __construct()
    {
        $this->registerMiddlewares([new AuthMiddleware()]);
    }

    public function index(Request $request)
    {
        $user = new User();
        return $this->view('contact', 'main', ['user' => $user]);
    }

    public function login(){
        return $this->view('login');
    }

    public function postLogin(){
        $user = User::findOne(['email' => 'email@gmail.com', 'password' => 'password']);
        if(!$user){
            var_dump("email or password invalid");
            exit;
        }

        Auth::login($user);
    }


    public function handleSubmit(Request $request)
    {
        $user = new User();
        $user->loadData($request->all());

        if($user->validate() === true) {
            $user->save();
            Application::$app->session->setFlash('success','stored successfully');
            return $this->view('contact', 'main', [
                'user' => $user,
                'errors' => $user->getErrors()
            ]);
        }

        return $this->view('contact', 'main', [
            'user' => $user,
            'errors' => $user->getErrors()
            ]);
    }
}
