<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'./../vendor/autoload.php';

use app\core\Application;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db'=>[
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->post('/CustomFramework/public/',[\app\controllers\AppController::class,'handleSubmit']);
$app->router->get('/CustomFramework/public/', [\app\controllers\AppController::class,'index']);
//$app->router->get('/CustomFramework/public/', [\app\controllers\AppController::class,'index']);

$app->router->get('/', [\app\controllers\AppController::class,'index']);
$app->router->get('/login', [\app\controllers\AppController::class,'login']);
$app->router->post('/post-login', [\app\controllers\AppController::class,'postLogin']);

$app->run();

