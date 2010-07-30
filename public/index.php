<?php
define ('DS', DIRECTORY_SEPARATOR);
define ('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT.DS.'config'.DS.'config.php');
require_once(ROOT.DS.'libs'.DS.'external'.DS.'Smarty.class.php');

function __autoload($className){
  if (file_exists(ROOT . DS . 'libs' . DS . strtolower($className) . '.class.php')) {
    require_once(ROOT . DS . 'libs' . DS . strtolower($className) . '.class.php');
  } else if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
    require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . strtolower($className) . '.php');
  } else if (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . strtolower($className) . '.php')) {
    require_once(ROOT . DS . 'app' . DS . 'models' . DS . strtolower($className) . '.php');
  }
  // обработка ошибок, ага  
}

function call($controller, $action, $params = False) {
  $controllerName = ucfirst($controller).'Controller';
  
  $dispatch = new $controllerName();
  if (count($params) == 1) {
    $dispatch->$action($params[0]);
  } else {$dispatch->$action($params);};
}

function Route($request){
  $controller = 'index';
  $action = 'index';
  $url = explode('/', trim($request,'/'));
  if ($url[0] != ''){
    $controller = $url[0];
  }
  $params = False;
  array_shift($url);
  if (isset($url[0])){
    $action = $url[0];
    array_shift($url);
    //$params = $url[0];
    $params = $url;
  } else {
    $action = 'index';
  }
  call($controller, $action, $params);
}

if (isset($_GET['url'])) {
  Route($_GET['url']);
}