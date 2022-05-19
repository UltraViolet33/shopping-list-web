<?php

namespace App\Router;

class Router
{

    private array $routes = [];


    /**
     * register
     *
     * @param  string $path
     * @param  callable|array $action
     * @param  string $requestedMethod
     * @return void
     */
    public function register(string $path, callable|array $action, string $requestedMethod): void
    {
        $this->routes[$requestedMethod][$path] = $action;
    }

    /**
     * get
     *
     * @param  string $path
     * @param  callable|array $action
     * @return void
     */
    public function get(string $path, callable|array $action): void
    {
        $this->register($path, $action, 'GET');
    }


    /**
     * post
     *
     * @param  string $path
     * @param  callable|array $action
     * @return void
     */
    public function post(string $path, callable|array $action): void
    {
        $this->register($path, $action, 'POST');
    }


    /**
     * resolve
     *
     * @param  string $method
     * @param  string $uri
     * @return string
     */
    public function resolve(string $method, string $uri): string
    {
        $path = explode('?', $uri)[0];
        $action = $this->routes[$method][$path] ?? null;

        if (is_callable($action)) {
            return $action();
        }

        if (is_array($action)) {

            [$class, $classMethod] = $action;

            if (class_exists($class) && method_exists($class, $classMethod)) {
                $controller = new $class;
                return call_user_func_array([$controller, $classMethod], []);
            }
        }
    }


    /**
     * getRoutes
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
