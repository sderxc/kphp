<?php
class MissingController extends Controller {
  
  function __call($method, $params){
    $this->d('404 not found');
    print "404!";
  }
  
}