<?php
class Item extends Model {
  var $fields = array(
    'start_filming' =>  array(
      'Type'=>'year',
      'Desc'=>'Year filming started',
      'Name'=>'start_filming'
    ),
    'end_filming'   =>  array(
      'Type'=>'year',
      'Desc'=>'Year filming ended',
      'Name'=>'end_filming'
    ),
    'poster'        =>  array(
      'Type'=>'file',
      'Desc'=>'Poster (a JPEG/PNG image)',
      'Name'=>'poster'
    ),
  );
  var $hasAndBelongsToMany = array('Genre');
}