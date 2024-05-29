

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

<!-- <div class="container" <?php
                            if(!isset($result)){
                            echo "hidden";
                            }
                            ?>>
<div class="row align-items-center " 
        style="min-height: 50vh">
        <div class="d-flex justify-content-center">
        <div class="alert alert-info" role="alert">
        Thanks for submitting the form. <br>
       <a href="javascript:window.close();"><p style="text-align:center"> Click to return</p></a> 
     
</div>
</div>
</div>
</div> -->


<!-- Submit Success -->




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

  
  <form autocomplete="on" autofill="on" spellcheck="false"  action="#"  method="post" class="was-validated"  id="ticketform" name="ticketform" enctype="multipart/data">
    <div class="mb-3 mt-3">
      <label for="txtemail" class="form-label">Email</label>
      <input type="text" class="form-control" id="txtemail" placeholder="Enter Email" name="txtemail" required>
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
      <input type="text" pattern="\d*" class="form-control" id="txtphone" placeholder="Enter Phone Number" name="txtphone" required maxlength="10">
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please fill out phonenumber field.</div>
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


  <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
  <!-- <button type="button" id="save"  class="btn btn-primary" onclick="show_dialog();">Submit</button> -->
    
  <!-- onclick="show_dialog();" -->
<!-- 
  data-bs-toggle="modal" data-bs-target="#Modal_Ticket_Detail" -->


<!-- Show Detial Before Confirm -->
<div class="modal fade" id="Modal_Ticket_Detail" tabindex="-1" role="dialog" aria-labelledby="Modal_Ticket_DetailTitle" aria-hidden="true">
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
        <button type="submit" name="submit" class="btn btn-primary" >Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="spinnerModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <!-- <span class="fa fa-spinner fa-spin fa-3x w-100"></span> -->
        <span class="spinner-border" role="status" aria-hidden="true" style="position: absolute;display: block;top: 50%;left: 45%;">
    </div>
</div>


  
</div>
   </div>

   </form>
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
<script type="text/javascript" src=./js/lib_test.js></script>

<script>

    const main = async () => {
        await liff.init({ liffId: "2005151887-Y63q1mG4", withLoginOnExternalBrowser: true})
        if(!liff.isLoggedIn())
        {
  
            liff.login()
            //console.log(profile.userId)
            return false
            
        }
        else
        {
             const profile = await liff.getProfile()
          
            console.log(liff.getOS());
            document.getElementById("loading").style.display = "none";
             document.getElementById("divmain").style.display = "block";
            //  if(liff.getOS() == "web")
            //  {
            //   // window.location.href = "https://www.askme.co.th/";
            //   document.getElementById("loading").style.display = "block";
            //  document.getElementById("divmain").style.display = "none";
            //  }
             //else
            //  {
              
            //   document.getElementById("loading").style.display = "none";
            //  document.getElementById("divmain").style.display = "block";
            // //  console.log("Loggined")

            //  }
             
            $('input[name="txtlineid"]').val(profile.userId)
     
         
        }

    }
    main()

    </script>



</body>
</html>
