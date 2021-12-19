<?php


namespace Core;


use App;

class Kernel
{
    public $defaultControllerName = 'Home';
    public $defaultActionName = "index";

    public function launch()
    {

        list($controllerName, $actionName, $params) = App::$router->resolve();
        var_dump($controllerName, $actionName, $params);
        echo $this->launchAction($controllerName, $actionName, $params);

    }

    public function launchAction($controllerName, $actionName, $params)
    {

        $controllerName = empty($controllerName) ? $this->defaultControllerName : ucfirst($controllerName);
        if(!file_exists(ROOTPATH.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$controllerName.'.php')){
            throw new \App\Exceptions\InvalidRouteException();
        }
        require_once ROOTPATH.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$controllerName.'.php';
        if(!class_exists("\\Controllers\\".ucfirst($controllerName))){
            throw new \App\Exceptions\InvalidRouteException();
        }
        $controllerName = "\\Controllers\\".ucfirst($controllerName);
        $controller = new $controllerName;
        $actionName = empty($actionName) ? $this->defaultActionName : $actionName;
        if (!method_exists($controller, $actionName)){
            throw new \App\Exceptions\InvalidRouteException();
        }
        return $controller->$actionName($params);

    }
}