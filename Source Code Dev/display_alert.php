<?php
error_reporting(E_ERROR | E_PARSE);
require_once('CallAPI.php');




  $make_call = json_encode(GetAlert(), true);
  $response = json_decode($make_call, true);
  $array = json_decode($response, true);



//     foreach ($array['$results'][$i]['payload']['payload']['custom_details']['lineid'] as $item)
//     {
//         // do what you want
//         echo $item['content' ]. '<br>'
//     }
// }

  //echo count($array['results']);
  //echo "<script>console.log('" . $response . "' );</script>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Display Alery</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>


</head>
<body>
<div class="container mt-3">
    <table class="table">
    <tr>   
    <td> Alert Name </td>
    <td> Status </td>
</tr>

    <?php

for ($i = 0; $i < count($array['results']); $i++){

    $line_id = $array['results'][$i]['payload']['payload']['custom_details']['lineid'];
    $content = $array['results'][$i]['payload']['payload']['custom_details']['content'];

    if($line_id == "U098ef76a079cd842f4998349d41a6f40"){
        echo "<tr>";
        echo "<td>";
        echo $line_id . "<br>";
        echo "</td>";
        echo "<td>";
        echo $content . "<br>";
        echo "</td>";
        echo "</tr>";
    }
    


  }

    ?>

    </table>

</div>

</body>

</html>