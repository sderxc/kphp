<?php

class Config_test {
  var $db = array(
    'host' => '127.0.0.1',
    'user' => 'kphp',
    'pass' => '',
    'base' => 'kphp'
  );
  var $debug = true;
  var $libs = array(
    
  );
}

class Config_prod {
  var $libs = Config_test::libs;
}

define ('HOST','127.0.0.1');
define ('USER','kphp');
define ('BASE','kphp');
define ('PASS','');