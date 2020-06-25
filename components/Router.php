<?php

namespace App\Component;

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = include(ROOT.'/config/routes.php');
    }

    public function run()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = trim($_SERVER['REQUEST_URI'], '/');
        }

        foreach ($this->routes as $pattern => $path) {
        if (preg_match("~$pattern~", $uri)) {
                $parts = explode('/', $path);

                $controllerName = ucfirst(array_shift($parts). 'Controller');
                $actionName = 'action'. ucfirst(array_shift($parts));

                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    $controllerName = "\App\Controller\\$controllerName";
                } else {
                    $controllerName = "\App\Controller\\HomeController";
                    $actionName     = "actionIndex";
                }

                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName();
                if ($result != null) {
                    break;
                }

            }
        }

    }

}