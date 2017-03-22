<?php
use vendor\core\Router;
$query =trim($_SERVER['QUERY_STRING'], '/');
//require '../githubtoken';



define('WWW', __DIR__);
define('CORE', dirname(__DIR__).'vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__).'/app');
define('LAYOUT', 'default');

// CHANGE TO YOUR OWN GITHUB TOKEN!!
define('GITHUB_TOKEN', "Authorization: token $token");


require '../vendor/libs/functions.php';


spl_autoload_register(function ($class){
    $file = ROOT . '/' . str_replace('\\','/',$class). '.php';
    if(is_file($file)){
        require_once $file;
    }
});

require '../vendor/autoload.php';

Router::add('^user/(?P<user>[0-9-a-z-]+)?$', ['controller' => 'Main', 'action'=>'user']);
Router::add('^repo/(?P<owner>[0-9-a-z-]+)/(?P<repo>[0-9-a-z-]+)$', ['controller' => 'Main', 'action'=>'index']);
Router::add('^search/(?P<query>[0-9-a-z-]+)/?(page=)?(?P<page>[0-9]+)?$', ['controller' => 'Main', 'action'=>'search']);
Router::add('^search$', ['controller' => 'Main', 'action'=>'search']);

Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/?$');

//defaults routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);

Router::dispatch($query);


