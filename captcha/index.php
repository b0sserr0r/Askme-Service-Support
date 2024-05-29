<?php

//index.php
echo $_SESSION['captcha_code'];

?>

<html>  
    <head>  
        <title>How to implement Custom Captcha Code in PHP</title>  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container" style="width: 600px">
   <br />
   
   <h3 align="center">How to implement Custom Captcha Code in PHP</a></h3><br />
   <br />
   <div class="panel panel-default">
      <div class="panel-heading">Register Form</div>
    <div class="panel-body">
     <form method="post" id="captch_form">
      <div class="form-group">
       <div class="row">
        <div class="col-md-6">
         <label>First Name</label>
         <input type="text" name="first_name" id="first_name" class="form-control" />
        </div>
        <div class="col-md-6">
         <label>Last Name</label>
         <input type="text" name="last_name" id="last_name" class="form-control" />
        </div>
       </div>
      </div>
      <div class="form-group">
       <label>Email Address</label>
       <input type="text" name="email" id="email" class="form-control" />
      </div>
      <div class="form-group">
       <label>Password</label>
       <input type="password" name="password" id="password" class="form-control" />
      </div>
      <div class="form-group">
       <div class="form-group">
                          <label>Code</label>
                          <div class="input-group">
                           <input type="text" name="captcha_code" id="captcha_code" class="form-control" />
                           <span class="input-group-addon" style="padding:0">
          <img src="image.php" id="captcha_image" />
         </span>
                          </div>
                         </div>
      </div>
      <div class="form-group">
       <input type="submit" name="register" id="register" class="btn btn-info" value="Register" />
      </div>
     </form>
    </div>
   </div>
  </div>
    </body>  
</html>



<script>
 $(document).ready(function(){
  
  $('#captch_form').on('submit', function(event){
   event.preventDefault();
   if($('#captcha_code').val() == '')
   {
    alert('Enter Captcha Code');
    $('#register').attr('disabled', 'disabled');
    return false;
   }
   else
   {
    alert('Form has been validate with Captcha Code');
    $('#captch_form')[0].reset();
    $('#captcha_image').attr('src', 'image.php');
   }
  });

  $('#captcha_code').on('blur', function(){
   var code = $('#captcha_code').val();
   
   if(code == '')
   {
    alert('Enter Captcha Code');
    $('#register').attr('disabled', 'disabled');
   }
   else
   {
    $.ajax({
     url:"check_code.php",
     method:"POST",
     data:{code:code},
     success:function(data)
     {
      if(data == 'success')
      {
       $('#register').attr('disabled', false);
      }
      else
      {
       $('#register').attr('disabled', 'disabled');
       alert('Invalid Code');
      }
     }
    });
   }
  });

 });
</script>
