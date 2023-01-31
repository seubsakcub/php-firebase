<?php
/**
 * 
 * php firebase
 * author: Seubsak Jantamala
 * 
 */
if(file_exists('./controllers/config.php')){
   require('./controllers/config.php');
}
else{
   require('../controllers/config.php');
}
class Firebase{
   private $url = '';
   private $auth = '';
   function __construct() {
      if(FBURL == "" || FBURL == null) {
         throw new Exception("The database url is required");
         return;
      }
      $this->url = FBURL;
      $this->auth = FBAUTH;  
   }
   
   
   static function print_r($value){
      echo "<pre>";
      print_r($value);
      echo "</pre>";
   }
   static function getStorage($storageBucket, $folder, $filename){
      $urlencode = urlencode($folder.$filename);
      $baseurl = 'https://firebasestorage.googleapis.com/v0/b/'.$storageBucket.'/o/'.$urlencode.'?alt=media';
      return $baseurl;
   }
   static function matchStorage($path){
      preg_match('/\/b\/.*\/o\/(.*?)\?alt/', $path, $matches);
      if(count($matches) > 0){
         return  urldecode($matches[1]);
      }
      else{
         return '';
      }
   }


   public function requests($url, $method, $par=null){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      if(isset($par)){
         curl_setopt($ch, CURLOPT_POSTFIELDS, $par);
      }
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 120);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      $html = curl_exec($ch);
      return $html;
      curl_close($ch);
   }

   public function insert($table, $data){
      $path = $this->url."/$table.json?auth=".$this->auth;
      $requests = $this->requests($path, "POST", json_encode($data));
      return $requests;
   }

   public function insertKeys($table, $data){
      $path = $this->url."/$table.json?auth=".$this->auth;
      $requests = $this->requests($path, "PUT", json_encode($data));
      return $requests;
   }

   public function update($table, $data){
      $path = $this->url."/$table.json?auth=".$this->auth;
      $requests = $this->requests($path, "PATCH", json_encode($data));
      return $requests;
   }

   public function delete($table, $id){
      $path = $this->url."/$table/$id.json?auth=".$this->auth;
      $requests = $this->requests($path, "DELETE");
      return $requests;
   }

   public function select($dbPath, $queryKey=null, $queryType=null, $queryVal =null){
      if(isset($queryType) && isset($queryKey) && isset($queryVal)){
         $queryVal = urlencode($queryVal);
         if($queryType == "EQUAL"){
            $pars = "orderBy=\"$queryKey\"&equalTo=\"$queryVal\"";
         }elseif($queryType == "LIKE"){
            $pars = "orderBy=\"$queryKey\"&startAt=\"$queryVal\"";
         }
      }
      $pars = isset($pars) ? "&$pars" : "";
      $path = $this->url."/$dbPath.json?auth=".$this->auth.$pars;
      $requests = $this->requests($path, "GET");
      return $requests;
   }

}
?>