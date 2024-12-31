<?php

namespace app\core;

class DependencyInjector
{
    public function __construct(private Request $request)
    {
    }

    public function resolveDependencies(array $params): array
    {
        $args = [];

        foreach ($params as $param) {
            $paramType = $param->getType();

            if ($paramType) {
                $typeName = $paramType->getName();

                if ($typeName === Request::class) {
                    $args[] = $this->request;
                }
                } else {
                    $args[] = null;
                }
        }

        return $args;
    }
}
