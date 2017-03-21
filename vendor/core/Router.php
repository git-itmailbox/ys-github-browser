<?php
namespace vendor\core;
/**
 * Created by PhpStorm.
 * User: yura
 * Date: 01.03.17
 * Time: 23:27
 */
class Router
{
    protected static $routes = [];
    protected static $route = [];

    public static function add($regexp, $route = [])
    {

        self::$routes[$regexp] = $route;

    }

    /**
     *
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     *
     */
    public static function getRoute()
    {
        return self::$route;
    }

    private static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {

                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);

                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    public static function dispatch($url)
    {
        if (self::matchRoute($url)) {
            $controller ='app\controllers\\'. (self::$route['controller']) . 'Controller';
            if (class_exists($controller)) {
                $ctrlObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']).'Action';
                if (method_exists($ctrlObj, $action)) {
                    $ctrlObj->$action();
                    $ctrlObj->getView();
                } else {
                    echo  "Action $action  in $controller not found";
                }
            } else {
                echo "Not found class $controller";
            }

        } else {
            http_response_code(404);
            include '404.html';
        }
    }

    protected static function upperCamelCase($name)
    {
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return $name;
    }

    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }

}