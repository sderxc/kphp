<?php
/**
 * A generic model class
 */
class Model {
  var $name;
  var $tableName;
  var $dbo;
  
  var $hasAndBelongsToMany;
  
  /**
   * Creates a model instance
   * If given an ID, should really be ActiveRecord-like
   * Can use a different DBO than the whole app
   * @param integer $id 
   * @param DBO $dbo 
   */
  public function __construct($id=False, $dbo=False){
    $this->name = get_class($this);
    $this->tableName = get_class($this).'s';
    $this->dbo = new DBO_MySQL();
    $dboFields = $this->dbo->describe($this->tableName);
    $i = 0;
    foreach ($dboFields as $name=>$type) {
      if (!isset($this->fields[$name])){
        $this->fields[$name]['Name'] = $name;
        $this->fields[$name]['Type'] = $type['Type'];
        $this->fields[$name]['Null'] = $type['Null'];
        ++$i;
      }
      if (!isset($this->fields[$name]['Desc'])){
        $this->fields[$name]['Desc'] = $name;
      }
    }
  }
  
  public function putHABTM($modelName, $foreignId, $thisId){
    //$foreignModel = new $modelName();
    
    $tableName = $this->name .'s_'.$modelName.'s';
    $data = array(
        $modelName.'_id'  =>$foreignId,
        $this->name.'_id' =>$thisId
        );
    return $this->dbo->insert($tableName, $data);
  }
  
  public function getHABTM($modelName, $thisId){
    //$foreignModel = new $modelName();
    
    $tableName = $this->name .'s_'. $modelName.'s';
    $data = array(
        $this->name.'_id' =>$thisId
        );
    return $this->dbo->get($tableName, $data);
  }
  
  public function getBTM($modelName, $foreignId){
  /*
  Делает выборку строк этой модели, связанных со строкой $modelName, у которой $foreignId
  */
    $model = new $modelName();
    return $this->dbo->join($model->tableName, $this->tableName, $foreignId);
  }
  
  public function dropHABTM($modelName, $thisId){
    //$foreignModel = new $modelName();
    
    $tableName = $this->name .'s_'. $modelName.'s';
    $data = array(
      $this->name.'_id'   =>$thisId
      );
    return $this->dbo->drop($tableName, $data);
  }
  
  public function get($fields = Null){
   return $this->dbo->get($this->tableName, $fields); 
  }
  
  
  public function validate($data){
    /*
    Возвращает массив с ключом - именем поля или True, если форма нормально свалидировалась
    Значение элемента - False, если поле прошло валидацию, и строка с ошибкой, если не прошло
    */
    $ret = array();
    foreach($this->fields as $field){
      $name = $field['Name'];
      if(isset($data[$name])){
        $validationResult = Validator::field($field, $data[$name]);
        if ($validationResult) {
          $ret[$name] = $validationResult;
        }
      } elseif ($field['Type'] == 'file'
              ||$field['Type'] == 'id') {
        
      } else {
        $ret[$name] = 'Field not filled';
      }
      unset($data[$name]);
    }
    foreach ($data as $field=>$value){
      /*
      Здесь обрабатываются поля MTM
      */
    }
    if (count($ret) == 0) {
      return False;
    }
    return $ret;
  }
  
  public function put(array $fields){
    return $this->dbo->put($this->tableName, $fields);
  }
  
  public function drop(array $fields){
    return $this->dbo->drop($this->tableName, $fields);
  }
  
  public function count($fields = False){
    return $this->dbo->count($this->tableName, $fields);
  }
}
