<?php
namespace app\core;

class Request
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getPath(): string
    {
        $path = ($_SERVER['REQUEST_URI']);

        $queryPosition = strpos($path, '?');
        if($queryPosition == false){
            return $path;
        }

        return substr($path, offset:0, length: $queryPosition);
    }

    public function get(string $queryParam): ?string
    {
        foreach($_GET as $key=>$value){
            if($key == $queryParam){
                return $value;
            }
        }

        return null;
    }

    public function body(string $payloadName)
    {
        foreach ($_POST as $key=>$value)
        {
            if($key == $payloadName){
                return $value;
            }
        }

        return null;
    }

    public function all(){
        $payloads = [];

        foreach ($_POST as $key=>$value)
        {
            $payloads[$key] = $value;
        }

        return $payloads;
    }

}
