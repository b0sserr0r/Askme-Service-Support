
window.onload = function() {
  //console.log("Page Load");

 


 
  
};

function products_list(branch) {


  if(branch == "Bangkok")
  {
    return  ["Server Storage and Infra Solutions|Infra_BKK|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/pFz4YqcUKYcttsnMbzTpCV6Av/", 
    "Backup Solutions|Infra_BKK|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/pFz4YqcUKYcttsnMbzTpCV6Av/", 
    "Network and Security Solutions|Infra_BKK|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/pFz4YqcUKYcttsnMbzTpCV6Av/",
    "Microsoft Solutions|Infra_BKK|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/pFz4YqcUKYcttsnMbzTpCV6Av/", 
    "Cloud and AI Solutions|Infra_BKK|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/pFz4YqcUKYcttsnMbzTpCV6Av/", 
    "Automation Solutions|Enterprise_BKK|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/iz2HtOFkO1j4a80xuMZFXtoGl/", 
    "Helpdesk and Event Management|Enterprise_BKK|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/iz2HtOFkO1j4a80xuMZFXtoGl/", 
    "APM and Observability Solutions|APM_BKK|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/mRvSty3PBpDnrhI874X3FbrB2/",
    "Etc.|Other_BKK|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/y1VD9Eo9pNO84HhOH7TIULcdx/"];
  }

  if(branch == "Chiang Mai")
  {
    return  ["Software Development|Development_CM|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/ycYQQsN53qepkrvaNelgL1cdL/", 
    "Microsoft Solutions|Infra_CM|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/LV1iIFTPE68EZxvYRpWTuxVpw/", 
    "Server Storage and Infra Solutions|Infra_CM|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/LV1iIFTPE68EZxvYRpWTuxVpw/", 
    "Backup Solutions|Infra_CM|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/LV1iIFTPE68EZxvYRpWTuxVpw/", 
    "Network and Security Solutions|Infra_CM|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/LV1iIFTPE68EZxvYRpWTuxVpw/", 
    "Cloud and AI Solutions|Infra_CM|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/LV1iIFTPE68EZxvYRpWTuxVpw/", //Alert 2 team Infra_CM,Development
    "Etc.|Other_CM|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/f2r206XPA1S8GFqFfZuFJ634n/"];
  }

  if(branch == "Khon Kaen")
  {
    return   ["All Products|Khon Kaen_All|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/Sbwa0VCd3OZr4WldB70k2FQ7o/"];
  }

  if(branch == "Rayong")
  {
    return  ["All Products|Rayong_All|https://oncall-prod-us-central-0.grafana.net/oncall/integrations/v1/webhook/cTctUaNbLfeqlqC8pFCnrOoDO/"];
  }
  

}

document.getElementById("ticketform").addEventListener("submit", myFunction);
function myFunction() {
 // alert("The form was submitted");
     var myModalEl = document.getElementById('Modal_Ticket_Detail');
     var modal = bootstrap.Modal.getInstance(myModalEl)
     modal.hide();  
     startLoading();
}

// $(document).ready(function () {
  // $('#ticketform').on('submit', function (event) {
  //      //event.preventDefault();
  //   // e.preventDefault(); // Prevent the page from submitting on click.
  //     //console.log("Submitted");
  //    // document.getElementById("submit").disabled = true;
  //    var myModalEl = document.getElementById('Modal_Ticket_Detail');
  //    var modal = bootstrap.Modal.getInstance(myModalEl)
  //    modal.hide();  
  //    startLoading();
  //     //$('#ticketform').submit();
   
   
  //     // Disabling form fields and button
  //     // $(this).find('input, button')
  //     //          .prop('disabled', true);
  // });
// });

// $("input[type='submit']").click(function(e) {
//   e.preventDefault(); // Prevent the page from submitting on click.
//   $(this).attr('disabled', true); // Disable this input.
//   //$(this).parent("form").submit(); // Submit the form it is in.
// });


function startLoading() {
    var myModal = new bootstrap.Modal(document.getElementById('spinnerModal'))
    myModal.show()
  }
  
  function stopLoading() {
    var myModalEl = document.getElementById('spinnerModal');
    var modal = bootstrap.Modal.getInstance(myModalEl)
     modal.hide();  
  }

    //         $("#ticketform").submit(function(e) {
    //     // e.preventDefault();
    //     liff.closeWindow();
    
    // });                     
  
    
          $('input[name="txtemail"]').change(async function(){
           // $('#Modal_Ticket_Detail').modal('show');
          
  
            // $( "#txtfirstname" ).prop( "disabled", true );   
            // $( "#txtlastname" ).prop( "disabled", true ); 
            // $( "#txtphone" ).prop( "disabled", true ); 
            // $( "#txtbranch" ).prop( "disabled", true );
            // $( "#txtproduct" ).prop( "disabled", true ); 
            // $( "#txtsub" ).prop( "disabled", true ); 
            // $( "#txtdes" ).prop( "disabled", true ); 
            // $( "#fileUpload" ).prop( "disabled", true ); 
  
              const user_email = $('input[name="txtemail"]').val();
              const emailSpit = user_email.split("@");
              var userexist = false;
             // console.log(emailSpit[1]);
              var emailFormat = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
              // var pd = $('#txtproduct').val();
              // console.log('Prodcut : ' + pd);
              var data;
              var data2;
              if(user_email.match(emailFormat) ) 
              {
                startLoading();
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
                            // $( "#txtfirstname" ).prop( "disabled", false );   
                            // $( "#txtlastname" ).prop( "disabled", false ); 
                            // $( "#txtphone" ).prop( "disabled", false ); 
                            // $( "#txtbranch" ).prop( "disabled", false );
                            // $( "#txtproduct" ).prop( "disabled", false ); 
                            // $( "#txtsub" ).prop( "disabled", false ); 
                            // $( "#txtdes" ).prop( "disabled", false ); 
                            document.cookie = "ComID=" + json.results[0].companyId ;
                            document.cookie = "OwnerID=" + json.results[0].properties.hubspot_owner_id.value ;
                       
                                    
                      //$('#spinnerModal').modal('hide');
                              //alert("ไม่พบข้อมูลในระบบ");
                              //console.log("พบข้อมูลในระบบ");
  
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
  
                          //console.log(status);
  
                          if(json2.status === undefined)
                          {
                            //  $( "#txtfirstname" ).prop( "disabled", false );   
                            // $( "#txtlastname" ).prop( "disabled", false ); 
                            // $( "#txtphone" ).prop( "disabled", false ); 
                            // $( "#txtbranch" ).prop( "disabled", false );
                            // $( "#txtproduct" ).prop( "disabled", false ); 
                            // $( "#txtsub" ).prop( "disabled", false ); 
                            // $( "#txtdes" ).prop( "disabled", false ); 
                            // $( "#fileUpload" ).prop( "disabled", false ); 
                            
                            //console.log("พบข้อมูล User");
                            //console.log(json2.vid);
                            document.cookie = "userexist=true";
                            document.cookie = "contractid=" + json2.vid;
                            userexist = true;
                            stopLoading();
                          }
                          else
                          {
                            
                            // $( "#txtfirstname" ).prop( "disabled", false );   
                            // $( "#txtlastname" ).prop( "disabled", false ); 
                            // $( "#txtphone" ).prop( "disabled", false ); 
                            // $( "#txtbranch" ).prop( "disabled", false );
                            // $( "#txtproduct" ).prop( "disabled", false ); 
                            // $( "#txtsub" ).prop( "disabled", false ); 
                            // $( "#txtdes" ).prop( "disabled", false ); 
                            // $( "#fileUpload" ).prop( "disabled", false ); 
                            document.cookie = "userexist=false";
                            userexist = false;
                            //console.log("ไม่พบข้อมูล User");   
                            
                            var email_ex = email_ex_list;
                            var email_ex_arr = email_ex.split(",");
                            const isInArray = email_ex_arr.includes("@" + emailSpit[1]);  
                            if(isInArray)
                            {
                              $( "#err_dt" ).text("ไม่พบข้อมูล Company ในระบบ");
                              document.cookie = "userexist=true";
                              document.cookie = "contractid=0";
                              var myModal = new bootstrap.Modal(document.getElementById('md_alert'))
                              myModal.show()
                              $('input[name="txtemail"]').val('');

                            }
                            
                            
                            //console.log("Exclude List : " + email_ex_list);
                            
                            stopLoading(); 
                          }
  
  
                      });
  
   
                          }
                          else             
                          {
  
                            // $( "#txtfirstname" ).prop( "disabled", false );   
                            // $( "#txtlastname" ).prop( "disabled", false ); 
                            // $( "#txtphone" ).prop( "disabled", false ); 
                            // $( "#txtbranch" ).prop( "disabled", false );
                            // $( "#txtproduct" ).prop( "disabled", false ); 
                            // $( "#txtsub" ).prop( "disabled", false ); 
                            // $( "#txtdes" ).prop( "disabled", false ); 
                            // $( "#fileUpload" ).prop( "disabled", false ); 
                              console.log("ไม่พบข้อมูล Company ในระบบ");
                            $( "#err_dt" ).text("ไม่พบข้อมูล Company ในระบบ");
                            document.cookie = "userexist=true";
                            document.cookie = "contractid=0";
                            var myModal = new bootstrap.Modal(document.getElementById('md_alert'))
                            myModal.show()
                              //alert("ไม่พบข้อมูล Company ในระบบ");
                            $('input[name="txtemail"]').val('');
                              stopLoading();
                          }
  
              }
              else
              {
  
                if(user_email != "")
                {
                  console.log("Email Not Correct");
                            // $( "#txtfirstname" ).prop( "disabled", false );   
                            // $( "#txtlastname" ).prop( "disabled", false ); 
                            // $( "#txtphone" ).prop( "disabled", false ); 
                            // $( "#txtbranch" ).prop( "disabled", false );
                            // $( "#txtproduct" ).prop( "disabled", false ); 
                            // $( "#txtsub" ).prop( "disabled", false ); 
                            // $( "#txtdes" ).prop( "disabled", false ); 
                            // $( "#fileUpload" ).prop( "disabled", false ); 
                            $( "#err_dt" ).text("รูปแบบอีเมลล์ไม่ถูกต้อง!");
                            var myModal = new bootstrap.Modal(document.getElementById('md_alert'))
                            myModal.show()
                           // alert("รูปแบบอีเมลล์ไม่ถูกต้อง!");
                            $('input[name="txtemail"]').val('');
                            //stopLoading();
  
  
                }
  
                        //    $( "#txtfirstname" ).prop( "disabled", false );   
                        //     $( "#txtlastname" ).prop( "disabled", false ); 
                        //     $( "#txtphone" ).prop( "disabled", false ); 
                        //     $( "#txtbranch" ).prop( "disabled", false );
                        //     $( "#txtproduct" ).prop( "disabled", false ); 
                        //     $( "#txtsub" ).prop( "disabled", false ); 
                        //     $( "#txtdes" ).prop( "disabled", false ); 
                        //     $( "#fileUpload" ).prop( "disabled", false ); 
               
                  
  
              }
  
              
  
                      
  
          });
  
  
          $("#txtbranch").change(async function () {
            startLoading(); 
            $("#txtproduct").empty();
            // $( "#txtproduct" ).prop( "disabled", true );
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

                      //console.log($("#txtbranch").val());
                      var pd_list = products_list($("#txtbranch").val());
                      //console.log(pd_list);
                     
                      $('#txtproduct').empty();
                      $.each(pd_list, function(i, p) {
                         var pd_name =  p.split("|")[0];
                          // $('#txtproduct').append($('<option></option>').val(p).html(p));
                          // $('#txtproduct').append($('<option></option>').val(p).html(p));
                          //console.log(pd_name);
                          $('#txtproduct').append($('<option></option>').val(p).html(pd_name));
                      });
                     
                      // for(var i = data-1; i >= 0; --i) {
                      //   //console.log(i);
                       
                      // var option = document.createElement('option');
                      // option.text = json.results[i].properties.name
                      // option.value = json.results[i].properties.name + "|" + json.results[i].properties.team + "|" + json.results[i].properties.end_point;
                      // select.add(option, 0);
                      
                      // }
                    //   $( "#txtproduct" ).prop( "disabled", false ); 
                       
                      });
                      stopLoading(); 
          });

          $("#txtproduct").change(async function () {

            //console.log($("#txtproduct").val());

          });
  
  
          
  //         $('input[type=file]').change(function () {
  //     console.log(document.getElementById("fileUpload").value);
  // });
          // $("#txtproduct").change(async function () {
  
          //   var product = $('#txtproduct').val();
          //   console.log(product);
          // });
  

      //Prevent resubmitted
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }

      

    function close_liff_app()
    {
      if(liff.getOS() == "web"){

        window.location.href = "https://www.askme.co.th/ticket/";

      }
      else
      {
        liff.closeWindow()

      }
      
    }

    function close_dialog()
    {
     
    }

    function show_dialog()
{

  var response = grecaptcha.getResponse();
  var phone_type = /^[0-9]{10}$/;
  var phone_number = $("#txtphone").val();
  //console.log(phone_number);
  
if($("#txtemail").val() == "")
{
   $('form').addClass('was-validated');
   $("#txtemail").focus();
}
else if($("#txtfirstname").val() == "")
{
  $('form').addClass('was-validated');
  $("#txtfirstname").focus();

}
else if($("#txtlastname").val() == "")
{
  $('form').addClass('was-validated');
  $("#txtlastname").focus();

}
else if($("#txtphone").val() == "")
{
  $('form').addClass('was-validated');
  $("#txtphone").focus();

}
else if($("#txtbranch").val() == null)
{
  $('form').addClass('was-validated');
  $("#txtbranch").focus();

}
else if($("#txtproduct").val() == null)
{
  $("#txtproduct").focus();

}
else if($("#txtsub").val() == "")
{
  $('form').addClass('was-validated');
  $("#txtsub").focus();

}
else if($("#txtdes").val() == "")
{
  $('form').addClass('was-validated');
  $("#txtdes").focus();

}
else if($("#txtseverity").val() == null)
{
  $('form').addClass('was-validated');
  $("#txtseverity").focus();

}
else if(!phone_number.match(phone_type))
{
  $('form').addClass('was-validated');
  //console.log("Invalid Phone Number Type");
  $("#invalid_phone").html("Invalid phone number type");
  $("#txtphone").focus();
}
else if(response.length == 0)
//reCaptcha not verified
{
$( "#err_dt" ).text("reCaptcha not verified"); 
var myModal = new bootstrap.Modal(document.getElementById('md_alert'))
myModal.show()

}
// else if(phone_number.length < 10 || phone_number.length > 10)
// {
//   $('form').addClass('was-validated');
//   //console.log("Phone number must 10 length");
//   $("#invalid_phone").html("Phone number must 10 length");
//   $("#txtphone").focus();
// }
else
{
 
  var email = $('#txtemail').val();
  var fname = $('#txtfirstname').val();
  var lname = $('#txtlastname').val();
  var phnum = $('#txtphone').val();
  var branch = $('#txtbranch').val();
  var product = $('#txtproduct').val();
  var subject = $('#txtsub').val();
  var desc = $('#txtdes').val();
  var severity = $('#txtseverity').val();
  var fileattch = $('#fileUpload').val();
  var product_split = product.split("|")
  var file_attach_count = document.getElementById('fileUpload').files.length;


  $('#dt_email').html(email); 
  $('#dt_fname').html(fname); 
  $('#dt_lname').html(lname); 
  $('#dt_phnum').html(phnum); 
  $('#dt_branch').html(branch); 
  $('#dt_product').html(product_split[0]); 
  $('#dt_sub').html(subject); 
  $('#dt_des').html(desc); 
  $('#dt_severity').html(severity);

  // if(severity == "3")
  // {
  //   $('#dt_severity').html("Minor"); 
  // }
  // if(severity == "2")
  // {
  //   $('#dt_severity').html("Major"); 
  // }
  // if(severity == "1")
  // {
  //   $('#dt_severity').html("Critical"); 
  // }


  

  var file_list_text = ""
  //console.log(file_attach_count);

  if(file_attach_count > 0){

    

    for (var i = 0; i<=file_attach_count-1; i++){
      //console.log($('#fileUpload')[0].files[i].mozFullPath);
      var file_name = (i+1) + ". " + $('#fileUpload')[0].files[i].name
      file_list_text =  file_list_text + "<br>" +  file_name 
    }
  }
  
  $('#dt_fileattch').html(file_list_text.replace("<br>","")); 
  var myModal = new bootstrap.Modal(document.getElementById('Modal_Ticket_Detail'))
  myModal.show()
 }




}

async function getFriend()
{

  const friend = await liff.getFriend()
  return friend.friendFlag
}

    //main()