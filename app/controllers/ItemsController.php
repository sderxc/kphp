<?php
class ItemsController extends Controller{

  function index(){
    $this->loadModel('Item');
    $this->data['Items'] = $this->Item->get();
    $this->data['Form'] = Form::create($this->Item);
    $this->render();
  }
  
  function view($id){
    $this->loadModel('Item');
    $this->loadModel('Genre');
    
    $this->data['Item'] = $this->Item->get(array('id'=>$id));
    $this->data['Genres'] = $this->Genre->getBTM('Item', $id);
    
    $this->render();
  }
  
  function delete($id){
    $this->loadModel('Item');
    $this->Item->drop(array('id'=>$id));
    $this->redirect('/items');
  }
  
  function edit($id){
    $this->loadModel('Item');
    $item = $this->Item->get(array('id'=>$id));
    $this->data['Form'] = Form::create($this->Item, $item);
    $this->data['Edit'] = True;
    $this->render();
  }
  
  function add($data){
    $this->loadModel('Item');
    $genres = $_POST['GenreSelect'];
    $errors = $this->Item->validate($_POST);
    if ($errors){
      $this->data['Form'] = Form::create($this->Item, $_POST, $errors);
      $this->data['Edit'] = True;
      $this->render();
    } else {
      unset($_POST['GenreSelect']);
      $data = $_POST;
      $data['poster'] = $this->processFileUploads();
      $itemId = $this->Item->put($data);
      if (is_array($genres)){
        $this->Item->dropHABTM('Genre', $itemId);
        foreach ($genres as $genreId){
          $this->Item->putHABTM('Genre', $genreId, $itemId);
        }
      }
      $this->redirect('/items');
    }
  }

  function processFileUploads(){
		if (!$_FILES['poster']['error']) {
			/*
			Некрасиво, надо это все в хэлпер запихать!
			*/
			$dest = ROOT.DS.'public'.DS.'posters'.DS.$_FILES['poster']['name'];
			$relpath = substr('posters/'.$_FILES['poster']['name'],0,-4);
			if ($_FILES['poster']['type'] == 'image/jpeg') {
				move_uploaded_file($_FILES['poster']['tmp_name'], $dest);
				$source = imagecreatefromjpeg($img);
				createThumb($dest, 100, 145);
				return $_FILES['poster']['name'];
			}
		}
  }
}

function createThumb($img, $width, $height){
  $source = imagecreatefromjpeg($img);
  list($width, $height) = getimagesize($img);
  $thumb_100 = imagecreatetruecolor(100, 145); //x145
  imagecopyresampled($thumb_100, $source, 0, 0, 0, 0, 100, 145, $width, $height);
  imagejpeg($thumb_100, substr($img,0,-4).'_100.jpg');
  imagedestroy($thumb_100);
}