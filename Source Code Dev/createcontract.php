<?php
$env = file_get_contents(__DIR__."/.env");
$lines = explode("\n",$env);

foreach($lines as $line){
  preg_match("/([^#]+)\=(.*)/",$line,$matches);
  if(isset($matches[2])){
    putenv(trim($line));
  }
} 

$dataArray =  array(
    "properties"  => array(
          "email" => "0",
          "domain"  
          )    
);
$data = json_encode($dataArray);
//echo $data;
$method = "POST";
$url = "https://api.hubapi.com/crm/v3/objects/contacts/";
$curl = curl_init();
        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
           'Authorization: Bearer ' . getenv('HUBSPOT_TOKEN')
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        // EXECUTE:
       
        $result = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        //echo $http_status;
        echo $result;

?>

