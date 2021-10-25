<?php
// ---====== LOCAL SETTINGS ====-----
// $host = "localhost";
// $user = "root";
// $pass = "";
// $db = "shorturl";

// ---====== PRODUCTION SETTINGS ====-----
$host = "localhost";
$user = "u167323855_Gal1";
$pass = "Gal12345Shorti!";
$db = "u167323855_short_it";
try{
  $link = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
}catch(PDOException $e){
  echo "Connection failed: " . $e->getMessage();
}