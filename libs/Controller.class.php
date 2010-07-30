<?php
class Controller {
  var $name;

  var $scaffold;
  var $data;
  
  var $models;
  
  public function __construct(){
    $this->name = trim(get_class($this),'Controller');
    $this->data = array();
  }
  
  public function loadModel($modelName){
    $this->models[$modelName] = new $modelName;
  }
  
  public function render($view = False){
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

  public function __get($var){
    if (@array_key_exists($var, $this->models)){
      return $this->models[$var];
    } else {
      $this->models[$var] = new $var; // automagic!
      return $this->models[$var];
    }
  }

  public function redirect($url){
    header('Location: '.$url);
    exit;
  }
  /*
  public function __set($var, $val){
    $this->data[$var] = $val;
  }*/
}