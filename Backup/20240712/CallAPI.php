<?php

function CreateTicketHubspot($method, $url, $data){
   /*$method  = "POST";
   $url = "https://events.pagerduty.com/v2/enqueue";
   $data = "";*/
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

   


   $response_json = curl_exec($curl);

   $result = json_encode($response_json);
   $array = json_decode($result, true);
   $array2 = json_decode($array, true);

   if(!$response_json)
   {
      error_log("Create Ticket Hubspot Connection Failure", 3, "./Log/" . date("Ymd") . ".log");
      die("Create Ticket Hubspot Connection Failure");
   }
   $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
   if($http_status != 201)
   {
     error_log("\n". date("d/m/Y") . " ". date("h:i:s") . " : " . " Create Ticket Hubspot Error Reason : " .  $array2['message'], 3, "./Log/" . date("Ymd") . ".log");
   }
   
   curl_close($curl);
   return $response_json;

/*$result=json_encode($response_json, true);
$response=json_decode($result, true);
$array = json_decode($response, true);
echo $array['id'];*/


}




function AssignCompanyTicket($method, $url, $data){
   /*$method  = "POST";
   $url = "https://events.pagerduty.com/v2/enqueue";
   $data = "";*/
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
   //if(!$result){die("Connection Failure");}
   curl_close($curl);
   //return $result;
}

 
function UploadFile($Filename)
{
$post_url = "https://api.hubapi.com/filemanager/api/v3/files/upload";

$upload_file = new CURLFile($Filename,'application/octet-stream');

$file_options = array(
    "access" => "PUBLIC_INDEXABLE",
    "overwrite" => false,
    "duplicateValidationStrategy" => "NONE",
    "duplicateValidationScope" => "ENTIRE_PORTAL"
);

$post_data = array(
    "file" => $upload_file,
    "options" => json_encode($file_options),
    "folderId" => getenv('HUBSPOT_FILE_FOLDER')
);

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_URL, $post_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   'Authorization: Bearer ' . getenv('HUBSPOT_TOKEN')
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

$response = curl_exec($ch); //Log the response from HubSpot as needed.
$result = json_encode($response);
$array = json_decode($result, true);
$array2 = json_decode($array, true);

   
   if(!$response)
   {
      error_log("Upload File Connection Failure " . $response, 3, "./Log/" . date("Ymd") . ".log");
      die("Upload File Connection Failure");
   }

 $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

   if($http_status != 200)
   {
     error_log("\n". date("d/m/Y") . " ". date("h:i:s") . " : " . "Upload File Error Reason : " .  $array2['message'], 3, "./Log/" . date("Ymd") . ".log");
   }


curl_close($ch);

return $response;
}

function CreateAlertGN($method, $url, $data)
{

// $method  = "POST";
//     $url = "https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/SfSeyieHlQZpn5g7zEC5ksO0z/";
//     $dataArray =  array(
//         "requestOptions"  => array(
//               "properties" => [
//               "domain"  
//               ]
//               )
//     );
//     $data = json_encode($dataArray);
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
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $response = curl_exec($curl);
    $result = json_encode($response);
    $array = json_decode($result, true);
    $array2 = json_decode($array, true);

   
   if(!$response)
   {
      error_log("Create Gragfana Alert Connection Failure", 3, "./Log/" . date("Ymd") . ".log");
      die("Create Gragfana Alert Connection Failure");
   }

   $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

   if($http_status != 200)
   {
     error_log("\n". date("d/m/Y") . " ". date("h:i:s") . " : " . "Create Gragfana Alert Error Reason : " .  $array2['message'], 3, "./Log/" . date("Ymd") . ".log");
   }
    curl_close($curl);

    return $response;


   }  


   function GetProducts($method, $url, $data)
   {
   // $method = "POST";
   // $url = "https://api.hubapi.com/crm/v3/objects/contacts/";
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

   
         if(!$response)
         {
            error_log("Get Products Connection Failure", 3, "./Log/" . date("Ymd") . ".log");
            die("Get Products Connection Failure");
         }

         $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

         if($http_status != 200)
         {
            error_log("\n". date("d/m/Y") . " ". date("h:i:s") . " : " . "Get Products Error Reason : " .  $array2['message'], 3, "./Log/" . date("Ymd") . ".log");
         }
          
           curl_close($curl);
           return $response;
           //echo $http_status;
         }

         function CreateContract($method, $url, $data)
         {
         // $method = "POST";
         // $url = "https://api.hubapi.com/crm/v3/objects/contacts/";
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
      
         
               if(!$response)
               {
                  error_log("Create Contract Connection Failure", 3, "./Log/" . date("Ymd") . ".log");
                  die("Create Contract Connection Failure");
               }
      
               $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      
               if($http_status != 200)
               {
                  error_log("\n". date("d/m/Y") . " ". date("h:i:s") . " : " . "Create Contract Error Reason : " .  $array2['message'], 3, "./Log/" . date("Ymd") . ".log");
               }
                
                 curl_close($curl);
                 return $response;
                 //echo $http_status;
               }


   function AddAttachmenttoTicket($method, $url, $data)
   {
   // $method = "POST";
   // $url = "https://api.hubapi.com/crm/v3/objects/contacts/";
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

  
        if(!$response)
        {
           error_log("Add Attachment Connection Failure", 3, "./Log/" . date("Ymd") . ".log");
           die("Add Attachment Connection Failure");
        }

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if($http_status != 200)
        {
           error_log("\n". date("d/m/Y") . " ". date("h:i:s") . " : " . "Add Attachment Error Reason : " .  $array2['message'], 3, "./Log/" . date("Ymd") . ".log");
        }
          
           curl_close($curl);
           return $response;
           //echo $http_status;
         }




         function AddAttachmenttoTicket_V2($method, $url, $data)
   {
   // $method = "POST";
   // $url = "https://api.hubapi.com/crm/v3/objects/contacts/";
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
               case "PATCH":
                     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
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
           return $result;
           //echo $http_status;
         }

         function CheckDomain($method, $url)
         {
         $dataArray =  array(
            "requestOptions"  => array(
                  "properties" => [
                  "domain"  
                  ]
                  )
        );
        $data = json_encode($dataArray);
        //echo $data;
      //   $method = "POST";
      //   $url = "https://api.hubapi.com/companies/v2/domains/". $_POST['domain'] ."/companies";
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
                return $result;

         }
?>