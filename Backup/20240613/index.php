
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
      $OwnerID =  $_COOKIE['OwnerID'];

      if($OwnerID == "")
      {
        $OwnerID = getenv('OWNER_DEFAULT_ID');
        //echo "<script>console.log('Company ID is null' );</script>";
      }

      $hs_priority;

       if($_POST['txtseverity'] == "Minor")
      {
        $hs_priority = getenv('hs_priority_low');
      }
      if($_POST['txtseverity'] == "Major")
      {
        $hs_priority = getenv('hs_priority_medium');
         
      }
      if($_POST['txtseverity'] == "Critical")
      {
        $hs_priority = getenv('hs_priority_high');
         
      }
      

      $ContractID =  $_COOKIE['contractid'];
      $Product_Split = explode('|', $_POST['txtproduct']);
      $Product = $Product_Split[0];
      $Team = $Product_Split[1];
      $End_Point = $Product_Split[2];
      $data_array = "";
      
    $uploads_dir = './uploads';
	  $email = $_POST['txtemail'];
    //$product = $_POST['txtproduct'];
	  $subject = $_POST['txtsub'];
    $description = $_POST['txtdes'];
    $userlineid =  $_POST['txtlineid'];
    $fileattach =  array();   
    $fileattach_id =  array();  
    

    $countfile_attach = count(array_filter($_FILES["fileUpload"]['name']));

     echo "<script>console.log('" .  $subject . "' );</script>";
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
            $fileattach[] = $array['objects'][0]['friendly_url'] ;
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

    //echo "<script>console.log('Contract : " . json_encode($ContractID) . "' );</script>";
   

    if($ContractID == "0")
    {
 


      $data_array =  array(
        "properties"  => array(
              "hs_pipeline" => getenv('HS_PIPELINE'), 
              "hs_pipeline_stage" => getenv('HS_PIPELINE_STAGE_NEW'),
              "subject" =>  $Product . " - " .$_POST["txtsub"],
              "content" =>  $description,
              "sales_name"=>  getenv('OWNER_DEFAULT_ID'),
              "hs_ticket_priority" => $hs_priority
        )
    );

    }

    else
    {

    $data_array =  array(
      "properties"  => array(
            "hs_pipeline" => getenv('HS_PIPELINE'), 
            "hs_pipeline_stage" => getenv('HS_PIPELINE_STAGE_NEW'),
            "subject" =>  $Product . " - " .$_POST["txtsub"],
            "content" =>  $description,
            "sales_name"=>  $OwnerID,
            "hs_ticket_priority" => $hs_priority
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
}
 


  // $data_array =  array(
  //           "properties"  => array(
  //                 "hs_pipeline" => getenv('HS_PIPELINE'), 
  //                 "hs_pipeline_stage" => getenv('HS_PIPELINE_STAGE_NEW'),
  //                 "subject" =>  $Product . " - " .$_POST["txtsub"],
  //                 "content" =>  $description
  //           )
  //       );
   
      //Create Ticket Hubspot
        
     
        
        $resultCreateTic=json_encode(CreateTicketHubspot('POST', 'https://api.hubapi.com/crm/v3/objects/tickets', json_encode($data_array)), true);
        $response=json_decode($resultCreateTic, true);
        $array = json_decode($response, true);
        $ticket_id = $array['id'];

      echo "<script>console.log('" . json_encode($resultCreateTic) . "' );</script>";
      


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
                        "serverity" => $_POST['txtseverity']
              )
          )
    
        );
        


        //$GF_Endpoint_Team = "";
        
        //Dev
        //$make_call = json_encode(CreateAlertGN('POST', "https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/SfSeyieHlQZpn5g7zEC5ksO0z/" , json_encode($data_array)), true);
        //PROD
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
  <title>Support and Ticket</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>


  <style>
.table thead tr th, .table tbody tr td {
    border: none;}
.modal {
position: fixed;
top: 20px;
left: 20px;
right: 20px;
width: auto;
margin: 0;}
.img-fluid {
  max-width: 50%;
  height: auto;
}

  </style>
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
        Thanks for submitting the ticket. <br>

        
       <a href="javascript:close_liff_app()"><p style="text-align:center"> Click to exit</p></a> 
       <!-- <button type="button"  onClick= "javascript:close_liff_app()" class="btn btn-secondary">Close App</button> -->
     
</div>
</div>
</div>
</div>


        <span id="loading" <?php
                            if(isset($result) || isset($invalid_url)){
                            echo "hidden";
                            }
                            ?>>Loading...</span>
      




<div id="divmain" style="display: none">



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
                     <div class="text-center">
  <img style="text-align:center" src="./images/Logo_Askme.png" class="img-fluid" style="max-width:20%;">
                          
  <h3><p >Support and Ticket (Beta)</p></h3>
  </div>

  
  <form autocomplete="on" autofill="on" spellcheck="false"  action="index.php"  method="POST" class="needs-validated"  enctype="multipart/form-data" id="ticketform" name="ticketform" data-ajax="false">
    <div class="mb-3 mt-3">
      <label for="txtemail" class="form-label">Email</label>
      <input type="email" class="form-control" id="txtemail" placeholder="Enter Email" name="txtemail" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out email field.</div>
    </div>

 
    <div class="mb-3 mt-3">
      <label for="txtfirstname" class="form-label">First Name</label>
      <input type="text" class="form-control" id="txtfirstname" placeholder="Enter Firstname" name="txtfirstname" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out firstname field.</div>
    </div>
                        
    <div class="mb-3 mt-3">
      <label for="txtlastname" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="txtlastname" placeholder="Enter Lastname" name="txtlastname" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out lastname field.</div>
    </div>

    <div class="mb-3 mt-3">
      <label for="txtphone" class="form-label">Phone Number</label>
      <input type="text" pattern="^[0-9]{10}$" class="form-control" id="txtphone" placeholder="Enter Phone Number" name="txtphone" required minlength="10" maxlength="10">
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback" id="invalid_phone">Please fill out phonenumber field.</div>
    </div>

    <div class="mb-3 mt-3">
      <label for="txtbranch" class="form-label">Branch</label>
      <select id="txtbranch" class="form-control" name="txtbranch" required>

  
                                  <option selected disabled value="">Select Branch</option>
                                   <option value="Bangkok">Bangkok</option>
                                   <option value="Chiang Mai">Chiang Mai</option>
                                   <option value="Khon Kaen">Khon Kaen</option>
                                   <option value="Rayong">Rayong</option>
                               </select>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please select branch</div>
    </div>

   
    <div class="mb-3 mt-3">
      <label for="txtproduct" class="form-label">Product</label>
      <select id="txtproduct" class="form-control" name="txtproduct" required>

  
                                  <option selected disabled value="">Select Product</option>
                                  
                                   
                               </select>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please select product.</div>
    </div>


    <div class="mb-3">
      <label for="txtsub" class="form-label">Subject</label>
      <input  type="text" class="form-control" id="txtsub" placeholder="Enter Subject" name="txtsub" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out subject field.</div>
    </div>

    <div class="mb-3">
      <label for="txtdes" class="form-label">Description</label>
      <!-- <input type="text" class="form-control" id="txtdes" placeholder="Enter Description" name="txtdes" required> -->
      <textarea class="form-control" id="txtdes" name="txtdes" rows="3" required></textarea>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out deescription field.</div>
    </div>

    <div class="mb-3 mt-3">
      <label for="txtseverity" class="form-label">Serverity</label>
      <select id="txtseverity" class="form-control" name="txtseverity" required>

  
                                  <option selected disabled value="">Select Serverity</option>
                                  <option value="Minor">Minor</option>
                                  <option value="Major">Major</option>
                                  <option value="Critical">Critical</option>
                                   
                               </select>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please select product.</div>
    </div>

    
    <div class="mb-3 mt-3" >
      <label for="upload" class="form-label">Upload File</label>
      <input class="form-control" name="fileUpload[]" id="fileUpload" type="file" multiple="multiple"/>
      <!-- <input class="form-control" type="file" id="btnupload" name="btnupload" multiple required/> -->
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
  

    <div class="mb-3 mt-3" hidden>
      <label for="txtlineid" class="form-label">User Line ID</label>
      <input type="text" class="form-control" id="txtlineid" placeholder="Userlineid" name="txtlineid" >
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
    <!-- ReCaptcha -->
      <div>
                
      <div class="g-recaptcha" data-sitekey="6LdJ5uUpAAAAANdkPLv2AWtkWVsX9kbUawnZJPVx">
                            
        </div>


        </div>

  <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
  <button type="button" id="save"  class="btn btn-primary" onclick="show_dialog();">Submit</button>
    
  <!-- onclick="show_dialog();" -->
<!-- 
  data-bs-toggle="modal" data-bs-target="#Modal_Ticket_Detail" -->


<!-- Show Detial Before Confirm -->
<div class="modal fade" id="Modal_Ticket_Detail" tabindex="-1" role="dialog" aria-labelledby="Modal_Ticket_DetailTitle" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Modal_Ticket_DetailTitle">Ticket Detail</h5>
    
       
        
      </div>
      <div class="modal-body">

      <div  class='table table-responsive'>

      <table class="table">
        
       <tr class="row">
        <td class="col-4">
          Email
         </td>

         <td id="dt_email" class="col-8">
                          
          </td>
        </tr>


        <tr class="row">
        <td class="col-4">
          First Name
         </td>

         <td id="dt_fname" class="col-8">
          
          </td>
        </tr>

        <tr class="row">

        
        <td class="col-4">
          Last Name
         </td>

         <td id="dt_lname" class="col-8">
           
          </td>
        </tr>

        <tr class="row">
        <td class="col-4">
          Phone Number
         </td>

         <td id="dt_phnum" class="col-8">
           
          </td>
        </tr>

        <tr class="row">
        <td class="col-4">
          Branch
         </td>

         <td id="dt_branch" class="col-8">
           
          </td>
        </tr>

        <tr class="row">
        <td  class="col-4">
          Product
         </td>

         <td id="dt_product" class="col-8">
          
          </td>
        </tr>


         <tr class="row">

         <td class="col-4">
          Subject
         </td>
          
         <td id="dt_sub" class="col-8">
                
                          </td>
         </tr>


         <tr class="row">

<td class="col-4">
 Description
</td>
 
<td id="dt_des" class="col-8">
    
 </td>
</tr>

<tr class="row">

<td class="col-4">
 Serverity
</td>
 
<td id="dt_severity" class="col-8">
    
 </td>
</tr>


<tr class="row">
        <td class="col-4">
          File Attachment
         </td>

         <td id="dt_fileattch" class="col-8">
        
          </td>
        </tr>

      </table>
    
    </div>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary" id="submit" >Confirm</button>
      </div>
    </div>
  </div>
</div>
</form>
<!-- Loading Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="spinnerModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <!-- <span class="fa fa-spinner fa-spin fa-3x w-100"></span> -->
        <span class="spinner-border" role="status" aria-hidden="true" style="position: absolute;display: block;top: 50%;left: 45%;">
    </div>
</div>


  
</div>
   </div>


  <!-- Alert Modal -->
   <div class="modal fade" tabindex="-1" role="dialog" id="md_alert" data-bs-keyboard="false" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Error</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <p id="err_dt"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<script charset="utf-8" src="https://static.line-scdn.net/liff/edge/versions/2.22.3/sdk.js"></script>
<script type="text/javascript">var email_ex_list = "<?= getenv('EMAIL_EXCLUDE') ?>";</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript" src=./js/lib.js?cache=12345678></script>

<script>

    const main = async () => {
        await liff.init({ liffId: '<?php echo getenv('LIFF_ID'); ?>', withLoginOnExternalBrowser: true})
        const friend = await liff.getFriendship();
        const isFriend = friend.friendFlag;
        //console.log(isFriend);

        if(isFriend)
        {
          if(!liff.isLoggedIn())
        {
  
            liff.login()
            //console.log(profile.userId)
            return false
            
        }
        else
        {
          

             const profile = await liff.getProfile()
             document.getElementById("loading").style.display = "none";
             document.getElementById("divmain").style.display = "block";
             console.log("Loggined")
         
            $('input[name="txtlineid"]').val(profile.userId)

        }

        }
        else
        {
            //alert(liff.getOS());
            alert("Please add friend AskMe official account!");

            if(liff.getOS() == "ios")
            {
              location.replace("https://lin.ee/FNpF6TL");
            }
            else if(liff.getOS() == "andriod")
            {
              document.location= "https://lin.ee/FNpF6TL";
            }
            else if(liff.getOS() == "web")
            {
          
              window.location.replace("https://lin.ee/FNpF6TL");

            }
            
        }
        
       

    }
    main()

    </script>



</body>
</html>
