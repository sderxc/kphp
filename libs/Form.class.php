<?php
class Form {
  /*
  Генерация форм. По идее, здесь же надо добавлять всякие штуки для JS-валидации и ввода данных (напр. календарь для выбора даты)
  */
  static $fields;
  var $HTMLform;

  function __construct(Model $model, $id = False){
      
  }
  
  function create(Model $model, $data=False, $errors = False){
    /*
    Создает форму для указанной модели. По умолчанию поля пустые, ошибки валидации отсутствуют.
    Если в $data что-то передано, оно считается заполнителем полей формы.
    */
    $this->fields = $model->fields;
    $this->HTMLform = '';
    if (!$data){
      foreach ($this->fields as $field){
        $this->HTMLform .= self::createField($field);
      }
    } elseif (is_array($errors)) {
      foreach ($this->fields as $field){
        $this->HTMLform .= self::createField($field, $data[$field['Name']], $errors[$field['Name']]);
      }
    } else {
      foreach ($this->fields as $field){
        $this->HTMLform .= self::createField($field, $data[$field['Name']]);
      }    
    }
    if (is_array($model->hasAndBelongsToMany)){
      foreach($model->hasAndBelongsToMany as $modelName){
        $model = new $modelName();
        $this->HTMLform .= self::createHABTMField($model);
      }
    }
    return $this->HTMLform;
  }
   
  function createHABTMField(Model $model, $id=False){
    $out = "<tr><td><label for='".$model->name."'>".$model->name."</label></td><td>";
    $out .= "<select multiple='true' name='".$model->name."Select[]' id='".$model->name."'>";
    $entities = $model->get();

    foreach($entities as $entity){
      /*
      Нужен рефакторинг, чтобы поддерживать автовключение уже связанных экземпляров в списке.
      */
      $out .="<option value='".$entity['id']."'>".$entity['name']."</option>";
    }
    $out .= "</select></td></tr>";
    return $out;
  }

  function createField($field, $value = False, $invalid = False){
  /*
  Генерирует строчку в форме. Учитывается реляционная модель.
  */
    if ($field['Type'] != 'id') {
      if ($value) {$val = " value='$value'";}
      $out = "<tr><td><label for='".$field['Name']."'>".ucfirst($field['Desc'])."</label></td><td>\n";
      if ($field['Type'] == 'relation') {
        $out .= "<select name='".$field['Name']."' id='".$field['Name']."' multiple='true'>";
        //$model = new 
      }
      elseif ($field['Type'] == 'longtext') {
        $out.="<textarea id='".$field['Name']."' name='".$field['Name']."'".$val."></textarea>\n";
      }
      elseif ($field['Type'] == 'text'
           || $field['Type'] == 'int'
           || $field['Type'] == 'year'
           || $field['Type'] == 'date') {
        $out.="<input id='".$field['Name']."' name='".$field['Name']."'".$val."/>\n";
      }
      elseif ($field['Type'] == 'file'){
        $out.="<input type='file' id='".$field['Name']."' name='".$field['Name']."'".$val."/>\n";
      }
    } elseif ($value && $field['Type'] == 'id') {
      $out .= "<input type='hidden' name='id' value='".$value."'>";
    }
    if ($invalid) {return "<div class='invalid'>".$out." $invalid</div>";}
    return $out."</td></tr>\n";
  }
  }
