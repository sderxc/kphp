<?php
class Debugger {
  
  var $log;
  
  static private $instance = NULL;

  static function getInstance()
  {
    if (self::$instance == NULL) {
      self::$instance = new Debugger();
    }
    return self::$instance;
  }

  private function __clone()
  {
  }
  
  private function __construct(){
    $this->log = array();
  }
  
  function d($sender, $message) {
    self::getInstance()->log[] = array(
        'sender'  =>  $sender,
        'message' =>  $message);
  }
  
  function json(){
    $data = array('debug'=>self::getInstance()->log);
    return json_encode($data);
  }
  
  function html($wrapper = 'ul', $class = 'debug', $el = 'li', $el_class = ''){
    $out = "<$wrapper class='$class'>";
    foreach (self::getInstance()->log as $record) {
      $out.= "<$el class='$el_class'>
              <strong>{$record['sender']}:</strong>
              {$record['message']}
              </$el>";
    }
    $out .= "</$wrapper>";
    return $out;
  }
}