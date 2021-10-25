<?php
  require_once 'config.php';
  require_once 'Short.class.php';
  
  session_start();

  $short = new Short($link);

  if (!$_POST) {
    echo(json_encode(array('status' => '0', 'code' => '1', 'message' => 'Nice try! :)')));
    die();
  }
  
  if(empty($_SESSION['token']) || empty($_POST['token']) || $_SESSION['token'] !== $_POST['token']){
    echo(json_encode(array('status' => '0', 'code' => '2', 'message' => 'Nice try! :)')));
    die();
  }

  // the url that the user inserted on the front form for make it shorter
  $long_URL = isset($_POST['url']) ? trim(filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING) ) : '';
  $alias = isset($_POST['alias']) ? trim(filter_input(INPUT_POST, 'alias', FILTER_SANITIZE_STRING) ) : '';
  // $shortURL_Prefix = 'https://xyz.com/'; // with URL rewrite
  // $shortURL_Prefix = 'https://xyz.com/?u='; // without URL rewrite

  $shortURL_Prefix = 'http://localhost/shortURL?u='; // without URL rewrite

  try{

    $short_code = $short->urlToShort($long_URL, $alias);

    $shortURL = $shortURL_Prefix.$short_code;
     // @TODO - BUILT ARRAY WITH CODE NUMBERS TO TRUE / FALSE SITUTATION
     // 0 - WITH ERR TEXT, AND 1 - RETURN VALID URL

    echo json_encode(["code" => 1, "url" => $shortURL ]);
    

  }catch(Exception $e){
     //@TODO - RETURN TEXT ERROR TO FRONT
    echo json_encode(["code" => 0, "msg" => $e->getMessage() ]);
  }