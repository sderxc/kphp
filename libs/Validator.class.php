<?php
/**
 * Form validator class, called statically
 * Returns FALSE on no errors or strings describing errors
 *
 */
class Validator {
  function __construct(){
    
  }
  
  /**
   * Validates a value as an integer, then checks if it looks like a year value
   * @param type $value
   * @return string|boolean
   */
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
  
  /**
   * 
   * @param type $value
   * @return type 
   */
  private function text($value){
    return False;
  }
  
  /**
   * Checks given calue to be an integer
   * @param ? $value
   * @return string|boolean
   */
  public function int($value){
    $valueT = $value + 0;
    if ($valueT == 0) {
      return "Not an integer passed: ".$value;
    }
    else return False;
  }
  
  /**
   * Checks a date with a regexp
   * TODO: should be more flexible, like checking and parsing dates to a format
   * @param string $value
   * @return string|boolean 
   */
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
  
  /**
   * Interface to do validation checks
   * @param array $field
   * @param ? $value
   * @return string|boolean
   */
  public function field(array $field, $value){
    $type = $field['Type'];
    return self::$type($value);
  }
}