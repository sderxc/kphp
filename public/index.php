<?php
define ('DS', DIRECTORY_SEPARATOR);
define ('ROOT', dirname(dirname(__FILE__)));

ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

require_once(ROOT.DS.'app'.DS.'config.php');
require_once(ROOT.DS.'libs'.DS.'Helpers.php');
require_once(ROOT.DS.'libs'.DS.'external'.DS.'Smarty.class.php');

function __autoload($className){
  if (file_exists(ROOT . DS . 'libs' . DS . strtolower($className) . '.class.php')) {
    require_once(ROOT . DS . 'libs' . DS . strtolower($className) . '.class.php');
  } else if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
    require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . strtolower($className) . '.php');
  } else if (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . strtolower($className) . '.php')) {
    require_once(ROOT . DS . 'app' . DS . 'models' . DS . strtolower($className) . '.php');
  }
  // TODO: error handling
}

$app = new Application();

print_r($app);
Debugger::d('Bootstrap', 'Hello world');

//print_r(Debugger::getInstance());
print_r(Debugger::html());

if (isset($_GET['url'])) {
  $app->route($_GET['url']);
}