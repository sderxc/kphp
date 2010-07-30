<?php
class GenresController extends Controller{

  function index(){
    $this->loadModel('Genre');
    $this->data['Genres'] = $this->Genre->get();
    $this->data['Form'] = Form::create($this->Genre);
    $this->render();
  }
  
  function delete($id){
    $this->loadModel('Genre');
    $this->Genre->drop(array('id'=>$id));
    $this->redirect('/genres');
  }
  
  function edit($id){
    $this->loadModel('Genre');
    $genre = $this->Genre->get(array('id'=>$id));
    $this->data['Form'] = Form::create($this->Genre, $genre);
    $this->data['Edit'] = True;
    $this->render();
  }
  
  function add(){
    $this->loadModel('Genre');
    $errors = $this->Genre->validate($_POST);
    if ($errors){
      $this->data['Form'] = Form::create($this->Genre, $_POST, $errors);
      $this->render();
    } else {
      $this->Genre->put($_POST);
      $this->redirect('/genres');
    }
  }
}