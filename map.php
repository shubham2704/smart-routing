<?php
require('vendor/autoload.php');
require('functions.php');
require('dj.php');


use RebaseData\Client;

function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            asort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}

$client = new Client('freemium');

$ana  = false;
$rows = array();
$get  = $_GET['state'];


$ana = true;
if (isset($_POST['submit'])) {

    $file_name = $_POST['file_name'];
    $one       = $_POST['one'];
    $two       = $_POST['two'];
    $three     = $_POST['three'];
    $four      = $_POST['four'];
    $la        = $_POST['lat'];
    $lo        = $_POST['lon'];

    $initial = array(
        array(
            'name' => "Initial",
            'address' => "",
            'phone' => "",
            "gps" => $la . "," . $lo
        )
    );


    $inputFiles = ['uploads/'.$file_name];


    $tables = $client->getDatabaseTables($inputFiles);
    $i      = -2;



    foreach ($_POST as $key => $value) {



        if ($value == "0") {

            $ie = 1;
            foreach ($tables as $table) {

                $rows = $client->getDatabaseTableRows($inputFiles, $table);
                foreach ($rows as $row) {

                    $initial[$ie]['name'] = $row[0];
                    $ie++;
                }

            }
        } elseif ($value == "1") {
            $ie = 1;
            foreach ($tables as $table) {

                $rows = $client->getDatabaseTableRows($inputFiles, $table);
                foreach ($rows as $row) {
                    $rows                    = $rows;
                    $initial[$ie]['address'] = $row[1];
                    $ie++;
                }

            }

        } elseif ($value == "2") {
            $ie = 1;
            foreach ($tables as $table) {

                $rows = $client->getDatabaseTableRows($inputFiles, $table);
                foreach ($rows as $row) {
                    $initial[$ie]['phone'] = $row[2];
                    $ie++;
                }

            }
        } elseif ($value == "3") {
            $ie = 1;
            foreach ($tables as $table) {

                $rows = $client->getDatabaseTableRows($inputFiles, $table);
                foreach ($rows as $row) {
                    $initial[$ie]['gps'] = $row[3];
                    $ie++;
                }

            }
        }



        $i++;
    }

    $ii = 0;

    $pre = 0;
    foreach ($initial as $key => $value) {
        $iii = 0;
        foreach ($initial as $keyy => $valuee) {

            $array[$ii][$iii] = getDistance($value['gps'], $valuee['gps']);

            $iii++;

        }

        $ii++;

    }

    foreach ($tables as $table) {

        $rows = $client->getDatabaseTableRows($inputFiles, $table);

        //  $exp = explode(" ",);

        $start = 0;
        foreach (arr($rows) as $arr) {

            $sc = '0' . $arr;

            $len = strlen($sc);


            $substr = array();
            $ip     = 0;
            for ($i = 0; $i < strlen($sc) - 1; $i++) {
                $substr[$ip] = substr($sc, $i, 2);

                $ip++;
            }


            foreach ($substr as $su) {

                $firstCharacter        = substr($su, 0, 1);
                $lastCharacter         = substr($su, -1);
                $ade[$pre]['distance'] = $array[$firstCharacter][$lastCharacter];
                $ade[$pre]['id']       = $start;
                $ade[$pre]['su']       = $su;
                $ade[$pre]['from']     = $rows[$firstCharacter][3];
                $ade[$pre]['to']       = $rows[$lastCharacter][3];
                $ade[$pre]['name']       = $rows[$lastCharacter][0];
                $ade[$pre]['address']       = $rows[$lastCharacter][1];

                $pre++;
            }
        }

        $start++;
    }

    $ek = $len - 1;
    $o  = count($ade);

    $ewq = array();

    $epp = 1;
    $pk  = 0;

    for ($ih = 0; $ih < $o; $ih++) {

    if($epp == $ek){

    $ewq[$pk]['total'] += $ade[$ih]['distance'];
    $ewq[$pk]['la'] = $ade[$ih]['from'];
    $ewq[$pk]['lo'] = $ade[$ih]['to'];
    $ewq[$pk]['name'] = $ade[$ih]['name'];
    $ewq[$pk]['address'] = $ade[$ih]['address'];

    $epp = 1;
    $pk++;

    }else{

   $ewq[$pk]['total'] += $ade[$ih]['distance'];
   $ewq[$pk]['la'] = $ade[$ih]['from'];
   $ewq[$pk]['lo'] = $ade[$ih]['to'];
   $ewq[$pk]['name'] = $ade[$ih]['name'];
   $ewq[$pk]['address'] = $ade[$ih]['address'];

   $epp++;


  }

}


$ewq = msort($ewq, 'total');



} else {

    header('location:/iiitm/');

}



?>


<!DOCTYPE html>
<html lang="en">
 <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <title>Delivery Route Builder</title>

   <!-- Latest compiled and minified CSS -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

 <!-- Optional theme -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

 <!-- Latest compiled and minified JavaScript -->
 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
     <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->
   <style type="text/css">
     	body{
 		background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(background.jpg);
 		height: 100vh;
 		background-size: cover;
 		background-position: center;
 	}
 	.container{
 		background-color: white;
 		border-radius: 25px;
 	}
 	.table{
 		padding-bottom: 25px;
 	}
     </style>
 </head>
 <body>
   <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
 <div class="container-fluid">
   <div class="navbar-header">
     <a class="navbar-brand" href="#">Router</a>
   </div>
   <ul class="nav navbar-nav">
     <li class="active"><a href="#">Route Build</a></li>
   </ul>
 </div>
</nav>

<div  class="container">

<div class="row">
<div class="col-md-8">
  <div id="map" style="width:100%;height:600px;margin-left:-15px;border-radius: 25px 0px 0px 25px;"></div>
  <!-- Replace the value of the key parameter with your own API key. -->

</div>
<div class="col-md-4">

  <table class="table">
      <thead>
        <tr>
          <th>DS No.</th>
          <th>Consignee Details</th>
          <th>Address</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $p = 1;
      $ina[] = '';
       foreach($ewq as $k){


if(in_array($k['name'], $ina) == true){
//echo $k['lo'];
?>

<tr>
  <td><?php echo $p;?></td>
  <td><?php echo $k['name'];?></td>
  <td><?php echo $k['address'];?></td>
</tr>


<?php
$p++;
}
$ina[] = $k['name'];
       }

       ?>
      </tbody>
    </table>
</div>

</div>

</div>

   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
   <script>
   // In the following example, markers appear when the user clicks on the map.
   // Each marker is labeled with a single alphabetical character.
   var labels = '0123456789';
   var labelIndex = 0;

   function initialize() {
     var initial = { lat: <?php echo $_POST['lat'];?>, lng: <?php echo $_POST['lon'];?> };

     var map = new google.maps.Map(document.getElementById('map'), {
       zoom: 12,
       center: initial
     });



     // Add a marker at the center of the map.
     addMarker(initial, map);
     <?php

     $inaa[] = array();
      foreach($ewq as $k){


     if(in_array($k['name'], $inaa) == true){
     $str = str_shuffle("asdghk");
     ?>

     var <?php echo $str;?> = { lat: <?php echo explode(',',$k['lo'])[0]?>, lng:<?php echo explode(',',$k['lo'])[1]?> };
     addMarker(<?php echo $str;?>, map);


     <?php

     }
     $inaa[] = $k['name'];
    }

      ?>


   }

   // Adds a marker to the map.
   function addMarker(location, map) {
     // Add the marker at the clicked location, and add the next-available label
     // from the array of alphabetical characters.
     var marker = new google.maps.Marker({
       position: location,
       label: labels[labelIndex++ % labels.length],
       map: map,
       labelContent: "ABCD",
     });


   }

   google.maps.event.addDomListener(window, 'load', initialize);

 </script>

   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv6GFkcQPM-W6PFNv4Plwax6w9ad_RHgc&callback=initialize"></script>


 </body>
</html>
