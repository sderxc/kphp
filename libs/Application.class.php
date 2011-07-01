<?php
/**
 * Main application class
 */
class Application {
  
  var $dispatch;
  
  function d($msg){
    if (class_exists('Debugger') && $this->config->debug) {
      Debugger::d('Application', $msg);
    } else {
      die('No debugger attached');
    }
  }
  
  /**
   * 
   * @param type $config 
   */
  function __construct($config = 'Test') {
    $configClassName = 'Config_'.$config;
    $this->config = new $configClassName;
    
    if (isset($this->config->libs) & is_array($this->config->libs)) {
      foreach($this->config->libs as $libName) {
        $this->d('Loading lib '.$libName);
        if (class_exists($libName))
          $this->$libName = new $libName($this);
      }
    }
  }
  
  function call($controller, $action, $params = False) {
    $controllerName = ucfirst($controller).'Controller';
    $this->d("Call for $controller#$action");
    if (class_exists($controllerName)) {
      $this->dispatch = new $controllerName();
    } else {
      $this->dispatch = new MissingController();
    }
    if (count($params) == 1) {
      $this->dispatch->$action($params[0]);
    } else {$this->dispatch->$action($params);};    
  }

  
  function route($request){
    $this->d('Routing request '.json_encode($request));
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
      $params = $url;
    } else {
      $action = 'index';
    }
    
    //$params = array_merge($params, $_REQUEST);
    
    $this->call($controller, $action, $params);
  }
  
}