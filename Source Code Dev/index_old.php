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
<!-- Submit Success -->
<div class="container" <?php
                            if(!isset($result)){
                            echo "hidden";
                            }
                            ?>>
<div class="row align-items-center " 
        style="min-height: 50vh">
        <div class="d-flex justify-content-center">
        <div class="alert alert-info" role="alert">
        Thanks for submitting the form. <br>
       <a href="index.php?userlineid=<?php  echo $_GET['userlineid'];  ?>"><p style="text-align:center"> Click to return</p></a> 
     
</div>
</div>
</div>
</div>


<!-- No Param Userlineid Success -->
<div class="container" <?php
                            if(!isset($invalid_url)){
                            echo "hidden";
                            }
                            ?>>
<div class="row align-items-center " 
        style="min-height: 50vh">
        <div class="d-flex justify-content-center">
        <div class="alert alert-danger" role="alert">
        Invalid URL 
       
     
</div>
</div>
</div>
</div>



<div class="container mt-3"<?php
                            if(isset($result) || isset($invalid_url)){
                            echo "hidden";
                            }
                            ?>>
  <h3><p style="text-align:center">Create Ticket</p></h3>
  

    
  <form autocorrect="off" spellcheck="false" autocomplete="off" id="ticketform" name='ticketform' action="index.php?userlineid=<?php  echo $_GET['userlineid'];  ?>"  method="POST" class="was-validated" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
      <label for="txtemail" class="form-label">Email</label>
      <input type="email" class="form-control" id="txtemail" placeholder="Enter Email" name="txtemail" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>

 
    <div class="mb-3 mt-3">
      <label for="txtfirstname" class="form-label">First Name</label>
      <input type="text" class="form-control" id="txtfirstname" placeholder="Enter Firstname" name="txtfirstname" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
                        
    <div class="mb-3 mt-3">
      <label for="txtlastname" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="txtlastname" placeholder="Enter Lastname" name="txtlastname" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>

    <div class="mb-3 mt-3">
      <label for="txtphone" class="form-label">Phone Number</label>
      <input type="number" class="form-control" id="txtphone" placeholder="Enter Phone Number" name="txtphone" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>

    <div class="mb-3 mt-3">
      <label for="txtbranch" class="form-label">Branch</label>
      <select id="txtbranch" class="form-control" name="txtbranch" required>

  
                                  <option selected disabled value="">Select Product</option>
                                  
                                   <option value="Bangkok">Bangkok</option>
                                   <option value="Chiang Mai">Chiang Mai</option>
                                   <option value="Khon Kaen">Khon Kaen</option>
                                   <option value="Rayong">Rayong</option>
                               </select>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>

   
    <div class="mb-3 mt-3">
      <label for="txtproduct" class="form-label">Product</label>
      <select id="txtproduct" class="form-control" name="txtproduct" required disabled>

  
                                  <option selected disabled value="">Select Product</option>
                                  
                                   
                               </select>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>


    <div class="mb-3">
      <label for="txtsub" class="form-label">Subject</label>
      <input  type="text" class="form-control" id="txtsub" placeholder="Enter Subject" name="txtsub" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>

    <div class="mb-3">
      <label for="txtdes" class="form-label">Description</label>
      <!-- <input type="text" class="form-control" id="txtdes" placeholder="Enter Description" name="txtdes" required> -->
      <textarea class="form-control" id="txtdes" name="txtdes" rows="3" required></textarea>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>

    
    <div class="mb-3 mt-3" >
      <label for="upload" class="form-label">Upload File</label>
      <input class="form-control" name="fileUpload[]" id="fileUpload" type="file" multiple="multiple" />
      <!-- <input class="form-control" type="file" id="btnupload" name="btnupload" multiple required/> -->
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
  

    <div class="mb-3 mt-3" hidden>
      <label for="txtuserlineid" class="form-label">User Line ID</label>
      <input type="text" class="form-control" id="txtlineid" placeholder="Userlineid" name="txtlineid" value="<?php  echo $_GET['userlineid'];  ?>">
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>


  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </form>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>

<script>

    
     
        $('input[name="txtemail"]').change(async function(){
          $( "#txtfirstname" ).prop( "disabled", true );   
          $( "#txtlastname" ).prop( "disabled", true ); 
          $( "#txtphone" ).prop( "disabled", true ); 
          $( "#txtproduct" ).prop( "disabled", true ); 
          $( "#txtsub" ).prop( "disabled", true ); 
          $( "#txtdes" ).prop( "disabled", true ); 
          $( "#fileUpload" ).prop( "disabled", true ); 

            const user_email = $('input[name="txtemail"]').val();
            const emailSpit = user_email.split("@");
            var userexist = false;
            console.log(emailSpit[1]);
            var emailFormat = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            // var pd = $('#txtproduct').val();
            // console.log('Prodcut : ' + pd);
            var data;
            var data2;
            if(user_email.match(emailFormat) ) 
            {

                var result;
                var json;
                 // { domain: "askme.co.th" },
                    await $.ajax({
                     method: "POST",
                     url: "checkdomain.php",
                     data: { domain: emailSpit[1] },
                     }).done(function(response) {
                        result = response;
                        //console.log(result);
                        json = JSON.parse(result);
                        data = json.results.length;
                        //console.log(data);
                        //console.log(Object.keys(json.results[0]).length);
                    });
                    //console.log(json.results[0].companyId);
                    if (data > 0)
                        {
                          $( "#txtfirstname" ).prop( "disabled", false );   
                          $( "#txtlastname" ).prop( "disabled", false ); 
                          $( "#txtphone" ).prop( "disabled", false ); 
                          $( "#txtproduct" ).prop( "disabled", false ); 
                          $( "#txtsub" ).prop( "disabled", false ); 
                          $( "#txtdes" ).prop( "disabled", false ); 
                          document.cookie = "ComID=" + json.results[0].companyId ;
                            //alert("ไม่พบข้อมูลในระบบ");
                            console.log("พบข้อมูลในระบบ ");

                  var result2;
                  var json2;
                  var status;       
                     //Check Contract
                     await $.ajax({
                     method: "POST",
                     url: "checkcontract.php",
                     data: { email: user_email },
                     }).done(function(response) {
                        result2 = response;
                        json2 = JSON.parse(result2);
                        //console.log(result2);
                        status = json2.status

                        console.log(status);

                        if(json2.status === undefined)
                        {
                           $( "#txtfirstname" ).prop( "disabled", false );   
                          $( "#txtlastname" ).prop( "disabled", false ); 
                          $( "#txtphone" ).prop( "disabled", false ); 
                          $( "#txtproduct" ).prop( "disabled", false ); 
                          $( "#txtsub" ).prop( "disabled", false ); 
                          $( "#txtdes" ).prop( "disabled", false ); 
                          $( "#fileUpload" ).prop( "disabled", false ); 
                          
                          console.log("พบข้อมูล User");
                          //console.log(json2.vid);
                          document.cookie = "userexist=true";
                          document.cookie = "contractid=" + json2.vid;
                          userexist = true;
                        }
                        else
                        {
                          $( "#txtfirstname" ).prop( "disabled", false );   
                          $( "#txtlastname" ).prop( "disabled", false ); 
                          $( "#txtphone" ).prop( "disabled", false ); 
                          $( "#txtproduct" ).prop( "disabled", false ); 
                          $( "#txtsub" ).prop( "disabled", false ); 
                          $( "#txtdes" ).prop( "disabled", false ); 
                          $( "#fileUpload" ).prop( "disabled", false ); 
                          document.cookie = "userexist=false";
                          userexist = false;
                          console.log("ไม่พบข้อมูล User");    
                        }


                    });

 
                        }
                        else             
                        {

                          $( "#txtfirstname" ).prop( "disabled", false );   
                          $( "#txtlastname" ).prop( "disabled", false ); 
                          $( "#txtphone" ).prop( "disabled", false ); 
                          $( "#txtproduct" ).prop( "disabled", false ); 
                          $( "#txtsub" ).prop( "disabled", false ); 
                          $( "#txtdes" ).prop( "disabled", false ); 
                          $( "#fileUpload" ).prop( "disabled", false ); 
                            console.log("ไม่พบข้อมูล Company ในระบบ");
                            alert("ไม่พบข้อมูล Company ในระบบ");
                            $('input[name="txtemail"]').val('');
                        }

            }
            else
            {
              console.log("Email Not Correct");
              $( "#txtfirstname" ).prop( "disabled", false );   
                          $( "#txtlastname" ).prop( "disabled", false ); 
                          $( "#txtphone" ).prop( "disabled", false ); 
                          $( "#txtproduct" ).prop( "disabled", false ); 
                          $( "#txtsub" ).prop( "disabled", false ); 
                          $( "#txtdes" ).prop( "disabled", false ); 
                          $( "#fileUpload" ).prop( "disabled", false ); 
                

            }

            

                    

        });


        $("#txtbranch").change(async function () {
          $( "#txtproduct" ).prop( "disabled", false );    
          $("#txtproduct").empty();
                var result;
                var json;
                var branch = $('#txtbranch').val();
                    await $.ajax({
                     method: "POST",
                     url: "getproduct.php",
                     data: { branch: branch },
                     }).done(function(response) {
                        result = response;
                        //console.log(result);
                        json = JSON.parse(result);
                        data = json.results.length;
                        //console.log(json.results[0].properties.end_point.trim);
                        //console.log(data-1);
                    
                    var select = document.getElementById("txtproduct");
                    for(var i = data-1; i >= 0; --i) {
                      //console.log(i);
                     
                    var option = document.createElement('option');
                    option.text = json.results[i].properties.name
                    option.value = json.results[i].properties.name + "|" + json.results[i].properties.team + "|" + json.results[i].properties.end_point;
                    select.add(option, 0);
                    }

                     
                    });

                    
                
                   

        });



        // $("#txtproduct").change(async function () {

        //   var product = $('#txtproduct').val();
        //   console.log(product);
        // });

  
    </script>

<script>
    //Prevent resubmitted
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>


</body>
</html>
