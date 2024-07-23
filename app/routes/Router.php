<?php

namespace app\routes;

use app\helpers\Uri;
use app\helpers\Request;

class Router
{

    const CONTROLLER_NAMESPACE = 'app\\controllers';

    public static function load(string $controller, string $action)
    {
        try {
            
            $controllerNamespace = self::CONTROLLER_NAMESPACE.'\\'.$controller;

            if(!class_exists($controllerNamespace)) {
                throw new \Exception("O Controller {$controller} não existe");
            }

            $controllerInstance = new $controllerNamespace;
            
            if(!method_exists($controllerInstance, $action)) {
                throw new \Exception("O Método {$action} não existe no Controller {$controller}");
            }

            $controllerInstance->$action();

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public static function routes():array
    {
        return [
            'GET' => [
                '/' => fn() => self::load('HomeController', 'index'),
                '/categorias' => fn() => self::load('CategoryController', 'index'),
                '/produtos' => fn() => self::load('ProductController', 'showProducts'),
                '/produto' => fn() => self::load('ProductController', 'showProductDetail'),
                '/login' => fn() => self::load('UserController', 'indexLogin'),
                '/cadastro' => fn() => self::load('UserController', 'indexRegister'),
            ],
            
            'POST' => [
                // '/produtos' => fn() => self::load('ProductController', 'proccessCategoryItems'),
                '/auth' => fn() => self::load('UserController', 'authenticate'),
            ],
        ];
    }

    public static function execute()
    {
        try {

            $routes = self::routes();
            $request = Request::get();
            $uri = Uri::get('path');

            if(!isset($routes[$request])) {
                throw new \Exception("A rota não existe");
            }
            
            if(!array_key_exists($uri, $routes[$request])) {
                throw new \Exception("A rota não existe");
            }
            
            $router = $routes[$request][$uri];
            
            if(!is_callable($router)) {
                throw new \Exception("Rota ({$request}) {$uri} não possui um método executável");
            }

            $router();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}