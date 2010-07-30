<?php
class DBO_MySQL extends DBO {
  
  protected $_link;

  public function __construct(){
    $this->connect();
  }

  private function connect(){
    $this->_link = mysql_connect(HOST, USER, PASS); // долэон храниться в конфиге
    if (mysql_select_db(BASE)){
      return True;
    } else {
      return False;
    }
  }
  
  public function query($query){
    if (!$this->_link) {
      $this->connect();
    }
    if ( substr($query,0,3) == 'INSE'
      || substr($query,0,3) == 'UPDA') {
      mysql_query($query, $this->_link);
      return mysql_insert_id();
      }
    //print $query."<br/>\n";
    return @mysql_query($query, $this->_link);
  }
  
  /**
   * Возвращает множество ассоциативных массивов внутри массива 
   **/
  private function object($data){
    $ret = array();
    if ($data){
      while ($row = mysql_fetch_assoc($data)){
        $ret[] = $row;
      }
      return $ret;
    }// else throw new Exception;
  }
   
  public function insert($tableName, $fields){
    if (is_array($fields)){
      $c = count($fields);
      $qfields = '';
      $qvalues = '';
      $i = 1;
      foreach ($fields as $field=>$value){
        $qfields .= '`'.$field.'`';
        $qvalues .= "'".$value."'";
        if ($i < $c) {
          $qfields .= ','; $qvalues .= ',';
        }
        $i++;
      }
      $query = "INSERT INTO $tableName ($qfields) VALUES ($qvalues)";
      return $this->query($query);
    } else {
      return False;
    }
  }
  
  private function update($tableName, $fields){
  /**
   * Обновляет строку таблицы
   **/
    if (is_array($fields)){
      $qfields = '';
      $qvalues = '';
      $i = 2;
      $c = count($fields);
      foreach ($fields as $field=>$value){
        if ($field != 'id') {
          $qfields .= "`$field` = '$value'";
          if ($i < $c) {$qfields .= ',';}
          $i++;
        } else {
          $qwhere = '`id` = '.$value;
        }        
      }
      $query = "UPDATE $tableName SET $qfields WHERE $qwhere";
      return $this->query($query);      
    }  
  }
  
  public function put($tableName, $fields){
    //print_r($fields);
    if (array_key_exists('id', $fields)){
      $this->update($tableName, $fields);
      return $fields['id'];
    } else {
      return $this->insert($tableName, $fields);
    }
  }
  
  private function _select($tableName, $fields = False, $count = False){
    if ($count){
      $query = "SELECT COUNT(*) FROM $tableName";
    } else {
      $query = "SELECT * FROM $tableName";
    }
    if (is_array($fields)){
      $query .= " WHERE ";
      $c = count($fields);
      $i = 0;
      foreach ($fields as $field=>$value){
        $query .= "`$field` = $value";
        if ($i != $c-1) {$query .= " AND ";}
      }
    }
    return $this->object($this->query($query));    
  }
  
  public function get($tableName, $fields = False){
    $ret = $this->_select($tableName, $fields, False);
    if (count($ret) > 1) {
      return $ret;
    } else {
      return $ret[0];
    }
  }
  
  public function drop($tableName, $fields){
    $qfields = '';
    $qwhere = '';
    $i = 1;
    $c = count($fields);
    foreach($fields as $field=>$value)  {
      if ($field != 'id') {
        $qwhere .= "`$field` = '$value'";
        if ($i < $c) {$qwhere .= ' AND ';}
        $i++;
      } else {
        $qwhere = '`id` = '.$value;
      }
    }
    $q = "DELETE FROM $tableName WHERE $qwhere";
    return $this->query($q);
  }
  
  public function count($tableName, $fields = False){
    $ret = $this->_select($tableName, $fields, True);
    return $ret['COUNT(*)'];
  }
  
  public function join($tableObj, $tableAdd, $id=-1){
	  /*
	  tableObj - подчиненная таблица
	  tableAdd - основная
	  */
	  $tableLink = $tableObj.'_'.$tableAdd;
	  $thisName = trim($tableAdd, 's');
	  $modelName = trim($tableObj, 's');
	  $query = "SELECT obj.*, lnk.".$modelName."_id "
            ."FROM $tableLink lnk JOIN $tableAdd obj "
              ."ON (obj.id = lnk.".$thisName."_id)";
	  if ($id >= 0){
	    $query .= " WHERE $modelName"."_id = $id";
	  }
	  return $this->object($this->query($query));
	}
  
  public function describe($tableName){
    $query = "DESCRIBE $tableName";
    $fields = $this->object($this->query($query));
    $ret = array();
    foreach ($fields as $field) {
      if ($field['Type'] == 'date') {$ret[$field['Field']]['Type']='date';}
      if (strstr($field['Type'],'varchar')) {$ret[$field['Field']]['Type']='text';}
      if (strstr($field['Type'],'text')) {$ret[$field['Field']]['Type']='longtext';}
      if (strstr($field['Field'],'_id')) {$ret[$field['Field']]['Type']='relation';}
      if (strstr($field['Type'],'int')) {$ret[$field['Field']]['Type']='int';}
      if (strstr($field['Field'],'id')) {$ret[$field['Field']]['Type']='id';}
      if (strstr($field['Null'], 'YES')) {
        $ret[$field['Field']]['Null'] = True;
      }
    }
    return $ret;
  }
}
