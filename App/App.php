<?php

namespace App;

class APP
{
    public static $router;
    public static $db;
    public static $kernel;

    public static function init()
    {
        sql_autoload_register(['static', 'loadClass']);
        static::bootstrap();
        set_exception_handler(['App', 'handleException']);
    }

    public static function bootstrap($className)
    {
        static::$router = new App\Router();
        static::$kernel = new App\Kernel();
        static::$db = new App\DB();
    }


    public function loadClass($className)
    {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        require_once ROOTPATH . DIRECTORY_SEPARATOR . $className . '.php';
    }

    public function handleException(Throwable $e)
    {
        if ($e instanceof \App\Exceptions\InvalidRouteException) {
            echo static::$kernel->launchAction('Error', 'error404', [$e]);
        } else {
            echo static::$kernel->launchAction('Error', 'error500', [$e]);
        }
    }
}