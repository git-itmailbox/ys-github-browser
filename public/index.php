<?php

use vendor\core\Router;
$query =trim($_SERVER['QUERY_STRING'], '/');


define('WWW', __DIR__);
define('CORE', dirname(__DIR__).'vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__).'/app');
define('LAYOUT', 'default');
// CHANGE TO YOUR OWN GITHUB TOKEN!!
define('GITHUB_TOKEN', 'Authorization: token e1574a59e8b2eb3b7ff9e42a3275a9e6a79ae19d');


require '../vendor/libs/functions.php';


spl_autoload_register(function ($class){
    $file = ROOT . '/' . str_replace('\\','/',$class). '.php';
    if(is_file($file)){
        require_once $file;
    }
});

////переадресация с /pages в /main
//Router::add('^somepages/?(?P<action>[a-z-]+)?$', ['controller' => 'Main']);
//
//Router::add('^page/?(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']);
//Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action'=>'view']);
Router::add('^user/(?P<user>[0-9-a-z-]+)?$', ['controller' => 'Main', 'action'=>'user']);
Router::add('^repo/(?P<owner>[0-9-a-z-]+)/(?P<repo>[0-9-a-z-]+)$', ['controller' => 'Main', 'action'=>'index']);
Router::add('^search$', ['controller' => 'Main', 'action'=>'search']);

Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/?$');
//Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/user-(?P<user>[0-9-a-z-]+)$');

//defaults routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);

Router::dispatch($query);


