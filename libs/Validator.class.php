<?php
class Validator {
  function __construct(){
    
  }
  
  private function year($value){
    if (!self::int($value)){
      if ($value > 1900 && $value < 2020) {// с потолка, конечно. правило должно быть другим
        return False;
      } else {
        return "Year must be 1900-2020";
      }
    } else {
      return "Year must be an integer!";
    }
  }
  
  private function text($value){
    return False;
  }
  
  public function int($value){
    $valueT = $value + 0;
    if ($valueT == 0) {
      return "Not an integer passed: ".$value;
    }
    else return False;
  }
  
  private function date($value){
  /* формат - 2010-07-14  */
    if (preg_match('/^\d{4}\-\d{1,2}\-\d{1,2}$/', $value)){
      return False;
    } else {
      return "Date must be formatted as YYYY-MM-DD!";
    }
  }
  
  private function file($value){
    return False;
  }
  
  private function id($value){
    return False;
  }
  
  private function longtext($value){
    
  }
    
  public function field(array $field, $value){
    $type = $field['Type'];
    return self::$type($value);
  }
}