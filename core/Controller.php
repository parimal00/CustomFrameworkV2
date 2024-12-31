<?php

namespace app\core;

class Controller
{
    private $middlewares = [];

    protected function view($view, $layout='main', $params=[])
    {
        return Application::$app->view->renderView($view, $layout,params:$params);
    }

    protected function registerMiddlewares(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function getMiddlewares()
    {
        return $this->middlewares;
    }
}
