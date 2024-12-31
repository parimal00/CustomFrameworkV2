<?php

namespace app\core;

abstract class BaseMiddleware
{
    public function __construct(protected array $methods=[])
    {
    }

    public function execute(){
    }

    public function getMethods(): array
    {
        return $this->methods;
    }
}
