<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "shorturl";

try{
  $link = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
}catch(PDOException $e){
  echo "Connection failed: " . $e->getMessage();
}