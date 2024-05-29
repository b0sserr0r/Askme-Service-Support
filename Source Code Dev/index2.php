<?php
    //require __DIR__ . '/CallAPI.php';
    require_once('CallAPI.php');
    //echo first(1, "omg lol"); //returns omg lol;

   
    

    if (isset($_POST["submit"]))
     {
    $uploads_dir = './uploads';
		$email = $_POST['txtemail'];
    $product = $_POST['txtproduct'];
		$subject = $_POST['txtsub'];
    $description = $_POST['txtdes'];
    $userlineid =  $_POST['txtlineid'];
    if(isset($_FILES["filUpload"]))
    {
	  foreach($_FILES['filUpload']['tmp_name'] as $key => $val)
	  {
		$file_name = $_FILES['filUpload']['name'][$key];
		$file_size =$_FILES['filUpload']['size'][$key];
		$file_tmp =$_FILES['filUpload']['tmp_name'][$key];
		$file_type=$_FILES['filUpload']['type'][$key];  
    $fullpath = $_FILES['filUpload']['full_path'][$key];
    $name = basename($_FILES["filUpload"]["name"][$key]);
    move_uploaded_file($file_tmp,"$uploads_dir/$name");
		//echo file_get_contents($file_tmp);
    // $files = scandir($uploads_dir);
    // foreach($files as $file) {
      //sleep(5);
      $result=json_encode(UploadFile("$uploads_dir/$name"), true);
      unlink("$uploads_dir/$name");
      //echo $file;
   // }
    
     
     //echo $name;
    //$response=json_decode($result, true);
    //$array = json_decode($response, true);
	  }
    }
        
        $data_array =  array(
            "properties"  => array(
                  "hs_pipeline" => "0", 
                  "hs_pipeline_stage" => "1",
                  "subject" =>  $subject,
                  "content" =>  $description
            )
        );

        //$result=json_encode(CreateTicketHubspot('POST', 'https://api.hubapi.com/crm/v3/objects/tickets', json_encode($data_array)), true);
        //$response=json_decode($result, true);
        //$array = json_decode($response, true);

        $data_array =  array(
			"payload"  => array(
				  "summary" => $_POST["txtsub"],
				  "severity" => "info",
				  "source" =>  "Alert source",
				  "custom_details" => array(
					"email" => $_POST["txtemail"],
                    "lineid" => $_POST['txtlineid'],
                    "hs_file_upload" => "",
                    "hs_ticket_id" => $array['id'],
                    "subject" => $_POST["txtsub"],
                    "content" => $_POST["txtdes"],
                    "product" => $_POST["txtproduct"]
				  )
			),
			"routing_key" =>  "b68ec85d29084a07c03819c14e884a46",
			"event_action" =>  "trigger"

		);


        //$make_call = json_encode(CreateIncidentPD('POST', 'https://events.pagerduty.com/v2/enqueue/', json_encode($data_array)), true);
        //$response = json_decode($make_call, true);

        //$result = "Success";
        //print_r($array);
        //echo "<script>console.log('Debug Objects: " . $description . "' );</script>";
      
     
       
    }
   


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
<!-- bg-success -->
<div class="container" <?php
                            if(!isset($result)){
                            echo "hidden";
                            }
                            ?>>
<div class="row align-items-center " 
        style="min-height: 50vh">
        <div class="d-flex justify-content-center">
        <div class="alert alert-info" role="alert">
        Thanks for submitting the form.
</div>
</div>
</div>
</div>

<div class="container mt-3"<?php
                            if(isset($result)){
                            echo "hidden";
                            }
                            ?>>
  <h3>Create Ticket</h3>
  

    
  <form id="ticketform" name='ticketform' action="index2.php?userlineid=<?php  echo $_GET['userlineid'];  ?>"  method="POST" class="was-validated" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
      <label for="txtemail" class="form-label">Email</label>
      <input type="email" class="form-control" id="txtemail" placeholder="Enter Email" name="txtemail" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>

    <div class="mb-3 mt-3">
      <label for="txtproduct" class="form-label">Product</label>
      <select id="txtproduct" class="form-control" name="txtproduct" required>
                                  <option selected disabled value="">Select Product</option>
                                   <option>UiPath</option>
                                   <option>Stonebranch</option>
                                   <option>Dynatrace</option>
                               </select>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>


    <div class="mb-3">
      <label for="txtsub" class="form-label">Subject</label>
      <input type="text" class="form-control" id="txtsub" placeholder="Enter Subject" name="txtsub" required>
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
      <input class="form-control" name="filUpload[]" id="filUpload" type="file" multiple="multiple" />
      <!-- <input class="form-control" type="file" id="btnupload" name="btnupload" multiple required/> -->
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>
  

    <div class="mb-3 mt-3" >
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
            const user_email = $('input[name="txtemail"]').val();
            const emailSpit = user_email.split("@");
            console.log(emailSpit[1]);
            var emailFormat = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            //console.log(user_email);
            var data;
            if(user_email.match(emailFormat))
            {
                var result;
                 // { domain: "askme.co.th" },
                    await $.ajax({
                     method: "POST",
                     url: "checkdomain.php",
                     data: { domain: emailSpit[1] },
                     }).done(function(response) {
                        result = response;
                        console.log(result);
                        var json = JSON.parse(result);
                        data = json.results.length;
                        //console.log(data);
                        //console.log(Object.keys(json.results[0]).length);
                    });
                    console.log(data);
                    if (data > 0)
                        {
                            //alert("ไม่พบข้อมูลในระบบ");
                            console.log("พบข้อมูลในระบบ ");
                        }
                        else             
                        {
                            console.log("ไม่พบข้อมูลในระบบ");
                            alert("ไม่พบข้อมูลในระบบ ");
                            $('input[name="txtemail"]').val('');
                        }

            }
            else
            {
                console.log("Email Not Correct");

            }

            

                    

        });



  
    </script>

<script>
    //Prevent resubmitted
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>


</body>
</html>
