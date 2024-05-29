<?php
$env = file_get_contents(__DIR__."/.env");
$lines = explode("\n",$env);

foreach($lines as $line){
  preg_match("/([^#]+)\=(.*)/",$line,$matches);
  if(isset($matches[2])){
    putenv(trim($line));
  }
} 


//echo $data;
   $method = "GET";
   $url = "https://api.hubapi.com/contacts/v1/contact/email/". $_POST['email'] ."/profile";
   $curl = curl_init( $url);
       
   // OPTIONS:

   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
         'Content-Type: application/json',
         'Authorization: Bearer ' . getenv('HUBSPOT_TOKEN')
   ));

   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   $response = curl_exec($curl);

   $result = json_encode($response);
   $array = json_decode($result, true);
   $array2 = json_decode($array, true);


   $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
   if(!$response)
   {
    error_log("Connection Failure", 3, "/log/my-errors.log");
    die("Check Contract Connection Failure");
   }  
   
 
   if($http_status != 200)
   {
    error_log("\n". date("d/m/Y") . " ". date("h:i:s") . " : " . " Check Contract Error Reason : " .  $array2['message'], 3, "./Log/" . date("Ymd") . ".log");
   }
   curl_close($curl);
   echo $response;
?>

