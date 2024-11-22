<?php

namespace app\routes;

use app\helpers\Uri;
use app\helpers\Request;
use app\helpers\ApiHelper;
use app\controllers\Controller;

class Router
{

    const CONTROLLER_NAMESPACE = 'app\\controllers';

    public static function load(string $controller, string $action, array $params = [])
    {
        try {
            if (!ApiHelper::isApiAccessible()) {
                Controller::view('error', ["msg" => "A API está inacessível no momento. Tente novamente mais tarde."]);
                exit;
            }

            $controllerNamespace = self::CONTROLLER_NAMESPACE . '\\' . $controller;

            if (!class_exists($controllerNamespace)) {
                throw new \Exception("O Controller {$controller} não existe");
            }

            $controllerInstance = new $controllerNamespace;

            if (!method_exists($controllerInstance, $action)) {
                throw new \Exception("O Método {$action} não existe no Controller {$controller}");
            }

            // Passa os parâmetros dinamicamente
            call_user_func_array([$controllerInstance, $action], $params);

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public static function routes():array
    {
        return [
            'GET' => [
                '/' => fn() => self::load('HomeController', 'index'),
                '/{category_slug}' => fn($category_slug) => self::load('ProductController', 'showProductsByCategory', [$category_slug]),
                '/{slug}_{id}' => fn($slug, $id) => self::load('ProductController', 'showProductDetail', [$slug, $id]),
                '/produtos' => fn() => self::load('ProductController', 'showAllProducts'),
                '/login' => fn() => self::load('UserController', 'indexLogin'),
                '/logout' => fn() => self::load('UserController', 'logout'),
                '/cadastro' => fn() => self::load('UserController', 'indexRegister'),
                '/boletos' => fn() => self::load('UserController', 'indexTickets'),
                '/pedidos' => fn() => self::load('UserController', 'indexOrders'),
                '/pesquisar' => fn() => self::load('ProductController', 'searchItems'),
                '/privacidade' => fn() => self::load('UserController', 'indexPrivacy'),
            ],
            
            'POST' => [
                '/check-user' => fn() => self::load('UserController', 'check'),
                '/auth' => fn() => self::load('UserController', 'authenticate'),
                '/register' => fn() => self::load('UserController', 'register'),
                '/download_xml' => fn() => self::load('UserController', 'decodeFile'),
            ],
        ];
    }

    public static function execute()
    {
        try {
            $routes = self::routes();
            $request = Request::get();
            $uri = Uri::get('path');
            
            // Verifica rotas fixas
            if (isset($routes[$request]) && array_key_exists($uri, $routes[$request])) {
                $router = $routes[$request][$uri];

                
                if (!is_callable($router)) {
                    throw new \Exception("Rota ({$request}) {$uri} não possui um método executável");
                }

                $router();
                return;
            }


            // Verifica rotas dinâmicas
            foreach ($routes[$request] as $route => $action) {
                // Substitui parâmetros dinâmicos como {category_slug} por regex
                $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([a-zA-Z0-9\-]+)', $route);
                $pattern = str_replace('/', '\/', $pattern); // Escapa as barras para regex
                
                // Verifica se a URI corresponde ao padrão gerado
                if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
                    array_shift($matches); // Remove o primeiro item que é a string completa
                   
                    // Chama o método com os parâmetros capturados
                    $action(...$matches);
                    return;
                }
            }


            throw new \Exception("A rota não existe");

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

}