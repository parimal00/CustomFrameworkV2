<?php

namespace app\core;

class Application
{
    public Router $router;
    public Request $request;
    private Response $response;
    public View $view;
    public static string $root;
    public static Application $app;
    public Database $database;
    public Session $session;

    public function __construct(string $root, array $config)
    {
        self::$root = $root;
        $this->request = new Request();
        $this->response = new Response();
        $this->view= new View();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response, $this->view);
        $this->database = new Database($config['db']);
        self::$app = $this;
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
