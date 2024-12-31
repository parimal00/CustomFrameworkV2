<?php
namespace app\core;

class Router
{
    private $routers = [];

    private DependencyInjector $dependencyInjector;

    public function __construct(private Request $request, private Response $response, private View $view)
    {
        $this->dependencyInjector = new DependencyInjector($this->request);
    }

    public function get($url, $callback)
    {
        $this->routers['GET'][$url] = $callback;
    }

    public function POST($url, $callback)
    {
        $this->routers['POST'][$url] = $callback;
    }

    public function resolve()
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();

        if(!array_key_exists($method, $this->routers) || !array_key_exists($path, $this->routers[$method])) {
            $this->response->setStatusCode(404);
            return $this->view->renderView("_404");
        }

        $callback = $this->routers[$this->request->getMethod()][$this->request->getPath()];

        if(is_string($callback)) {
            return $this->view->renderView($callback);
        }

        if(is_array($callback)){
            $classname = $callback[0];
            $controller  = new $classname();
            $requestMethod = $callback[1];

            foreach ($controller->getMiddlewares() as $middleware){
                if(count($middleware->getMethods()) == 0 || in_array($requestMethod, $middleware->getMethods())) {
                    $middleware->execute();
                }
            }

            $reflection = new \ReflectionMethod($controller, $requestMethod);
            $params = $reflection->getParameters();

            $callback= [$controller, $callback[1]];

            return call_user_func($callback, $this->dependencyInjector->resolveDependencies($params));
        }

        return call_user_func($callback);
    }
}
