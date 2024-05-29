<?php
    error_reporting(0);
    $env = file_get_contents(__DIR__."/.env");
    $lines = explode("\n",$env);
    
    foreach($lines as $line){
      preg_match("/([^#]+)\=(.*)/",$line,$matches);
      if(isset($matches[2])){
        putenv(trim($line));
      }
    } 

    require_once('CallAPI.php');
  


      
    if (isset($_POST["submit"]))
     {
      
      $CompanyID =  $_COOKIE['ComID'];
      $ContractID =  $_COOKIE['contractid'];
      $Product_Split = explode('|', $_POST['txtproduct']);
      $Product = $Product_Split[0];
      $Team = $Product_Split[1];
      $End_Point = $Product_Split[2];
      

      //echo "<script>console.log('" .  $End_Point . "' );</script>";




    $uploads_dir = './uploads';
	  $email = $_POST['txtemail'];
    //$product = $_POST['txtproduct'];
	  $subject = $_POST['txtsub'];
    $description = $_POST['txtdes'];
    $userlineid =  $_POST['txtlineid'];
    $fileattach =  array();   
    $fileattach_id =  array();  
    //echo "<script>console.log('" . count(array_filter($_FILES["fileUpload"]['name'])). "' );</script>";

    $countfile_attach = count(array_filter($_FILES["fileUpload"]['name']));

     //echo "<script>console.log('" . isset($_FILES["fileUpload"]) . "' );</script>";
    if($countfile_attach > 0)
    {
     
	  foreach($_FILES['fileUpload']['tmp_name'] as $key => $val)
	  {
	    // $file_name = $_FILES['fileUpload']['name'][$key];
	    // $file_size =$_FILES['fileUpload']['size'][$key];
		 $file_tmp =$_FILES['fileUpload']['tmp_name'][$key];
		// $file_type=$_FILES['fileUpload']['type'][$key];  
        // $fullpath = $_FILES['fileUpload']['full_path'][$key];
         $name = basename($_FILES["fileUpload"]["name"][$key]);
       
        move_uploaded_file($file_tmp,"$uploads_dir/$name");
	
        $resultUpload=json_encode(UploadFile("$uploads_dir/$name"), true);
        //echo "<script>console.log('" .  $resultUpload . "' );</script>";
        $response = json_decode($resultUpload, true);
        $array = json_decode($response, true);
        //echo $name;

        if(isset($_FILES["fileUpload"]))
        {
            $fileattach[] =$array['objects'][0]['friendly_url'] ;
            $fileattach_id[] = $array['objects'][0]['id'];
  


        }


	  }

    

    }


     //Create Contract
     if($_COOKIE['userexist'] == "false"){
      // echo "<script>console.log('" . $_COOKIE['userexist'] . "' );</script>";
      // echo "<script>console.log('Create New Contract' );</script>";
      $companyname = explode("@", $_POST["txtemail"] );
      $dataArray =  array(
        "properties"  => array(
              "email" => $_POST["txtemail"],
              "firstname" => $_POST["txtfirstname"] ,
              "lastname" => $_POST["txtlastname"] ,
              "phone" => $_POST["txtphone"] ,
              "company" => $companyname[1]
              )
        );
    
    $data = json_encode($dataArray);

    $resultCreateContract=json_encode(CreateContract('POST', 'https://api.hubapi.com/crm/v3/objects/contacts/', json_encode($dataArray)), true);
    $response=json_decode($resultCreateContract, true);
    $array = json_decode($response, true);
    
    $ContractID = $array['id'];




    }
    

   
      //Create Ticket Hubspot
        $data_array =  array(
            "properties"  => array(
                  "hs_pipeline" => getenv('HS_PIPELINE'), 
                  "hs_pipeline_stage" => getenv('HS_PIPELINE_STAGE_NEW'),
                  "subject" =>  $Product . " - " .$_POST["txtsub"],
                  "content" =>  $description
            ),
            "associations" => [ array(
                      "to" => array(
                          "id"=> $ContractID
                      ),
                      "types" => [
                           array(
                              "associationCategory" => "HUBSPOT_DEFINED",
                              "associationTypeId" => 16
                          )
                      ]
                  )
              ]
        );

        
        $resultCreateTic=json_encode(CreateTicketHubspot('POST', 'https://api.hubapi.com/crm/v3/objects/tickets', json_encode($data_array)), true);
        $response=json_decode($resultCreateTic, true);
        $array = json_decode($response, true);
        $ticket_id = $array['id'];

      //echo "<script>console.log('" . $resultCreateTic . "' );</script>";
      


         //Create Alert in Grafana
         $data_array =  array(
          "payload"  => array(
              "summary" => $_POST["txtsub"],
              "custom_details" => array(
              "email" => $_POST["txtemail"],
                        "lineid" => $_POST['txtlineid'],
                        "hs_file_upload" => $fileattach,
                        "hs_ticket_id" => $ticket_id,
                        "subject" => $Product . " - " .$_POST["txtsub"],
                        "content" => $_POST["txtdes"],
                        "product" => $Product,
                        "firstname" => $_POST["txtfirstname"],
                        "lastname" => $_POST["txtlastname"],
                        "phonenumber" => $_POST["txtphone"],
              )
          )
    
        );
        


        //$GF_Endpoint_Team = "";

      
        $make_call = json_encode(CreateAlertGN('POST', $End_Point , json_encode($data_array)), true);
        $response = json_decode($make_call, true);
       

       
 
        
        if($countfile_attach == 0){

          echo "<script>console.log('File is empty' );</script>";

        }
        else //Add Attachment to Ticket

        {
          $Fileupload_String = array();
          foreach ($fileattach_id as $x) {
            //echo "<script>console.log('" . $x . "');</script>";
            $Fileupload_String[] = array(
              "id" => $x
            );


          }


          //echo "<script>console.log(JSON.parse('" . json_encode($Fileupload_String[0]) . "'));</script>";
         //echo "<script>console.log(JSON.parse('" . json_encode($Fileupload_String[1]) . "'));</script>";

     
          $dataArray =  array(
            "engagement"  => array(
                  "active" => true,
                  "type" => "NOTE" 
            ),
            "associations" => array(
              "contactIds" => [],
              "companyIds" => [ ],
              "dealIds" => [ ],
              "ownerIds" => [ ],
              "ticketIds" => [$ticket_id]
            ),
            "attachments" => 
              $Fileupload_String

            ,
            "metadata" => array(
              "body" => ""
            )
          );
       

    
          $resultAddAttachment=json_encode(AddAttachmenttoTicket('POST', 'https://api.hubapi.com/engagements/v1/engagements/', json_encode($dataArray)), true);


         

        
        }

         $result = "Success";




       
    }
//}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Ticket</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container pt-5">
      <form >
      <div class="mb-3">
      <div class="d-inline-flex align-items-center">
          <label for="exampleInputEmail1" class="form-label" style="min-width: 100px !important">User</label>
          <input type="text" class="form-control" name="exampleInputEmail1" style="width: 70%" aria-describedby="emailHelp"  required maxlength="4">
          
        </div>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
        
        
        <div class="mb-3">     
        <div class="d-inline-flex align-items-center">
          <label for="exampleInputPassword1" class="form-label" style="min-width: 100px !important">Password</label>
          <input type="password" class="form-control" name="exampleInputPassword1" style="width: 40%" required maxlength="4">
        </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Connection</button>
      </form>
    </div>


</body>
</html>
