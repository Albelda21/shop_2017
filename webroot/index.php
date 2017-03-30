<?php
error_reporting(E_ALL);

use Library\Request;
use Library\Controller;
use Library\Config;
use Library\Container;
use Library\RepositoryManager;
use Library\Router;
use Library\Route;
use Library\Session;
use Library\DbConnection;
use Library\MetaHelper;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS . '..' . DS );
define('VIEW_DIR', ROOT . 'View' . DS);
define('LIB_DIR', ROOT . 'Library' . DS);
define('CONFIG_DIR', ROOT . 'config' . DS);

spl_autoload_register(function($className) {
    $file = ROOT . str_replace('\\', DS, $className) . '.php';
    
    if (!file_exists($file)) {
        throw new \Exception("{$file} not found", 500);
    }
    
    require $file;
});

try {
    Session::start();
    $config = new Config(); // maybe: $config->main->something
    $request = new Request();
    $pdo = (new DbConnection($config))->getPDO();
    $repositoryManager = (new RepositoryManager())->setPDO($pdo);
    // todo: fix - new Router($config)
    $router = new Router(CONFIG_DIR . 'routes.php');
    $metaHelper = new MetaHelper($config);
    
    $container = new Container();
    $container->set('config', $config);
    $container->set('database_connection', $pdo);
    $container->set('repository_manager', $repositoryManager);
    $container->set('router', $router);
    $container->set('meta_helper', $metaHelper);
    
    $router->match($request);
    $route = $router->getCurrentRoute();
   
    $controller = 'Controller\\' . $route->controller . 'Controller';
    $action = $route->action . 'Action';
    
    $controller = new $controller();
    $controller->setContainer($container);
    
    if (!method_exists($controller, $action)) {
        throw new \Exception('Page not found', 404);
    }
    
    $content = $controller->$action($request); 
} catch (\Exception $e) {
    // var_dump($e);
    $content = Controller::renderError($e->getFile(), $e->getMessage());
}

echo $content;
