<?php

class App
{
    public static $router;

    public static $db;

    public static $kernel;

    public static function getInstance()
    {
        return new self();
    }

    public function init()
    {
        spl_autoload_register(['static', 'loadClass']);
        static::bootstrap();
        set_exception_handler(['App', 'handleException']);

    }

    public static function bootstrap()
    {
        static::$router = new \Core\Router();
        static::$kernel = new \Core\Kernel();
        static::$db = new \Core\Db();

    }

    public static function loadClass ($className)
    {

        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        require_once ROOTPATH.DIRECTORY_SEPARATOR . $className . '.php';

    }

    public function handleException (Throwable $throwable)
    {

//        if($e instanceof \App\Exceptions\InvalidRouteException) {
//            echo static::$kernel->launchAction('Error', 'error404', [$e]);
//        }else{
//            echo static::$kernel->launchAction('Error', 'error500', [$e]);
//        }

    }
}

