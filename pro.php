<?php

if(!isset($_GET)) die('Error');

if(!$_GET['req'] || empty($_GET['req'])) die('Error');

if($_GET['req'] !== 't') die('Error');

session_start();

$_SESSION['token'] = sha1(mt_rand(1, 90000) . 'SALT');

$token = $_SESSION['token'];

echo json_encode($token);



