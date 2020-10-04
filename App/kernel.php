<?php


namespace App;


class kernel
{
    public $defaultControllerName = 'Home';
    public $defautlActionName = 'index';

    public function launch(){
        list($controllerName, $actionName, $params) = App::$router->resolve();
        echo $this->launchAction($controllerName, $actionName, $params);
    }

    public function launchAction($controllerName, $actionName, $params) {
        $controllerName = empty($controllerName) ? $this->defautlActionName : ucfirst($controllerName);
        if (!file_exists(ROOTPATH.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$controllerName.'.php')) {
            throw new \App\Exceptions\InvalidRouteException();
        }
        require_once ROOTPATH.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$controllerName.'.php';

        if (!class_exists("\\Controllers\\".ucfirst($controllerName))) {
            throw new \App\Exception\InvalidRouteException();
        }
        $controllerName ='\\Controllers\\'.ucfirst($controllerName);
        $controller = new $controllerName;
        $actionName = empty($actionName) ? $this->defautlActionName : $actionName;
        if (!method_exists($controller, $actionName)) {
            throw new \App\Exceptions\InvalidRouteException();
        }
        return $controller->$actionName($params);
    }

}