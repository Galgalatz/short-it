<?php

class Short {

  protected static $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  protected static $exist_flag = false;
  protected static $table = "short_urls";
  protected static $code_length = 7;

  protected $pdo;
  protected $timestamp;

  public static $error;


  public function __construct(PDO $pdo){
    $this->pdo = $pdo;
    $this->timestamp = date("Y-m-d H:i:s");
  }

  public function urlToShort($url, $alias){

    // empty($url) ?? $this->error = 'No URL';

    //check if url have been inserted
    if(empty($url)){
      throw new Exception("No URL was supplied.");
    }    

    //check if the inserted url is valid
    if(!$this->validURL($url)){
      throw new Exception("URL does't have a valid format.");
    }

    //check if the given url real url
    if(self::$exist_flag){
      if(!$this->verifyURLExist($url)){
        throw new Exception("URL doesn't exist.");
      }
    }

    //check if url already exist on DB
    $shortCode = $this->urlExistDB($url);    

    if(!$shortCode && $alias){
      $existAlias = $this->aliaslExistDB($alias);
      
      if(!$existAlias){
        $id = $this->insertURL($url,$alias); 
        return $alias;
      }else{
        throw new Exception("Try another alias");
      }

    }

    if(!$shortCode){
      $shortCode = $this->createShortCode($url);
    }

    return $shortCode;
  }

  protected function validURL($url){
    return filter_var($url,FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
  }

  protected function verifyURLExist($url){

    //post request to original URL 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);

    $res = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    return (!empty($res) && $res != 404);
  }

  protected function urlExistDB($url){
    $query = "SELECT short_code FROM " . self::$table . " WHERE long_url = :long_url LIMIT 1";
    $stmt = $this->pdo->prepare($query);
    $params = ["long_url" => $url];
    $stmt->execute($params);

    $result = $stmt->fetch();

    return (empty($result)) ? false : $result['short_code'];
  }

  protected function aliaslExistDB($alias){
    $query = "SELECT id FROM " . self::$table . " WHERE short_code = :alias LIMIT 1";
    $stmt = $this->pdo->prepare($query);
    $params = ["alias" => $alias];
    $stmt->execute($params);

    $result = $stmt->fetch();

    return (empty($result)) ? false : true;
  }

  protected function createShortCode($url){
    $shortCode = $this->generateRandomString(self::$code_length);
    $id = $this->insertURL($url,$shortCode); 
    return $shortCode;
  }

  protected function generateRandomString($length = 7){
    $chars_length = strlen(self::$chars);
    $rand_string = "";

    for($i = 0; $i <= $length; $i++){
      $rand_string .= self::$chars[rand(0,$chars_length - 1)];
    }

    return $rand_string;
  }

  protected function insertURL($url, $code){
    $query = "INSERT INTO " . self::$table . "(long_url, short_code, created) VALUES (:long_url, :short_code, :timestamp)";
    $stmt = $this->pdo->prepare($query);

    $params = [
      "long_url" => $url,
      "short_code" => $code,
      "timestamp" => $this->timestamp
    ];

    $stmt->execute($params);

    return $this->pdo->lastInsertId();
  }

  public function shortToUrl($code, $increment = true){
    if(empty($code)){
      throw new Exception("No short code was supplied.");
    }

    if(!$this->validShortCode($code)){
      throw new Exception("Short code does't have a valid format.");
    }

   $url_row = $this->getURL($code);
   

   if(empty($url_row)){
       throw new Exception("Short code does't exist.");
   }

  if($increment){
    $this->incrementCounter($url_row["id"]);
  } 

  return $url_row["long_url"];

 }

 protected function validShortCode($code){
   return preg_match("|[".self::$chars."]+|", $code);
 }

 protected function getURL($code){
   $query = "SELECT id, long_url FROM ".self::$table. " WHERE short_code = :short_code LIMIT 1";
   $stmt = $this->pdo->prepare($query);
   $params = [
     "short_code" => $code
   ];
   $stmt->execute($params);

   $result = $stmt->fetch();   

   return (empty($result)) ? false : $result;
 }

 protected function incrementCounter($id){
   $query = "UPDATE ".self::$table." SET hits = hits + 1 WHERE id = :id";

   $stmt = $this->pdo->prepare($query);

   $params = [ "id" => $id ];
   $stmt->execute($params);
 }
}