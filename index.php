<?php

$BASE_URL = 'http://localhost/shortURL/';

if(!isset($_GET['u']) || empty($_GET['u'])){
  header("Location: app");
  die;
}

require_once 'config.php';
require_once 'Short.class.php';

$short = new Short($link);
$short_code = $_GET['u'];

try{

  $url = $short->shortToUrl($short_code);
  
  header("Location: ".$url);
  exit;
  
  }catch(Exception $e){

    echo $e->getMessage();
  }