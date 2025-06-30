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
    "properties"  =>  ["team,name,branch,end_point"],
    "filters" => [
      array(
         "propertyName" => "branch",
         "operator" => "EQ",
         "value" => $_POST['branch']   
     )
      ],
      "sorts"=> [
         array(
           "propertyName"=> "name",
           "direction"=> "ASCENDING"
        )
       ]
          
);
$data = json_encode($dataArray);
//echo $data;
$method = "POST";
$url = "https://api.hubapi.com/crm/v3/objects/products/search";
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
        $response = curl_exec($curl);


        $result = json_encode($response);
        $array = json_decode($result, true);
        $array2 = json_decode($array, true);


        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if(!$result)
        {
          error_log("Get Product Connection Failure", 3, "/log/my-errors.log");
         die("Get ProductConnection Failure");
       }
         if($http_status != 200)
       {
         error_log("\n". date("d/m/Y") . " ". date("h:i:s") . " : " . " Get Product Error Reason : " .  $array2['message'], 3, "./Log/" . date("Ymd") . ".log");
       }
        curl_close($curl);
        //echo $http_status;
        echo $response;

?>

