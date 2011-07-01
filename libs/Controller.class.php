<?php
/**
 * Basic controller class
 */
class Controller {
  var $name;

  var $scaffold;
  var $data;
  
  var $models;
  
  function d($msg){
    Debugger::d($this->name, $msg);
  }
  
  /**
   * Create a controller, set up its name, autoload models if possible
   */
  public function __construct(){
    $this->name = trim(get_class($this),'Controller');
    if (class_exists(singular($this->name))) {
      $this->loadModel(singular($this->name));
    }
    $this->data = array();
    $this->d('Created a controller');
  }
  
  /**
   * Loads a model by its name
   * @param string $modelName 
   * @return Model
   */
  public function loadModel($modelName){
    if (class_exists($modelName)) {
      $this->models[$modelName] = new $modelName;
      return $this->models[$modelName];
    } else {
      return false; // TODO: Should raise an exception
    }
  }
  
  /**
   * Render a PHP template. Picks a view called similar to controller's name
   * @param string $view 
   */
  public function render($view = False){
    $template_dir = ROOT.DS.'app'.DS.'views';
    extract($this->data);
    if ($view) {
      include $template_dir.DS.$view.'.php';
    } else {
      include $template_dir.DS.$this->name.'.php';
    }
  }
  
  /**
   * Render using Smarty. Picks a view called similar to controller's name
   * @param string $view A custom view
   */
  public function __render($view = False){
    $smarty = new Smarty();
    $smarty->template_dir = ROOT.DS.'app'.DS.'views';
    $smarty->compile_dir = ROOT.DS.'app'.DS.'views_c';
    $smarty->cache_dir = ROOT.DS.'cache';
    foreach($this->data as $key=>$value){
      $smarty->assign($key, $value);
    }
    if ($view) {
      $smarty->display($view.'.tpl');
    } else {
      $smarty->display($this->name.'.tpl');
    }
  }

  /**
   * Shortcut to call models like $this->modelName
   * Autoloads models.
   * @param string $var
   * @return Model 
   */
  public function __get($var){
    if (@array_key_exists($var, $this->models)){
      return $this->models[$var];
    } else {
      return $this->loadModel($var);
    }
  }
  
  /**
   * Shortcut to raw redirect
   * @param type $url URL to redirect to
   */
  public function redirect($url){
    header('Location: '.$url);
    exit;
  }
  /*
  public function __set($var, $val){
    $this->data[$var] = $val;
  }*/
}