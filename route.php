<?php

require('vendor/autoload.php');
use RebaseData\Client;

$client = new Client('freemium');

$file_name = $_GET['file_name'];

if($file_name !=''){

  $fil = 'uploads/'.$file_name;
  $inputFiles = [$fil];


  $tables = $client->getDatabaseTables($inputFiles);


}else{

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

  <div class="col-md-12">
<br>
    <form method="post" action="map.php?state=Analysing">
      <div class="panel panel-default">
  <div class="panel-heading">Initial Location</div><div class="panel-body">
    <p>Select respective colum of row and initial location from where delivery will started.</p>
<div class="form-inline">
      <div class="form-group">
          <label for="email">Latitude:</label>
          <input type="text" value="26.2047902" name="lat" class="form-control" id="email">
        </div>
        <div class="form-group">
          <label for="pwd">Longitude:</label>
          <input name="lon" value="78.1823709" class="form-control" id="pwd">
        </div>
    <div class="pull-right "><button type="submit"  name="submit" class="btn btn-primary">Build Route!</button></div>
</div>
</div></div>
    <table class="table table-hover">
        <thead>
          <tr>
            <th><div class="form-group">
<input type="hidden" value="<?php echo $file_name;?>" name="file_name">
  <select name="one" class="form-control" id="sel1">
    <option value="0">Name</option>
    <option value="1">Address</option>
    <option value="2">Phone No</option>
    <option value="3">GPS</option>
  </select>
</div></th>
            <th><div class="form-group">

  <select name="two" class="form-control" id="sel1">
    <option value="0">Name</option>
    <option value="1">Address</option>
    <option value="2">Phone No</option>
    <option value="3">GPS</option>
  </select>
</div></th>
            <th><div class="form-group">

  <select class="form-control" name="three" id="sel1">
    <option value="0">Name</option>
    <option value="1">Address</option>
    <option value="2">Phone No</option>
    <option value="3">GPS</option>
  </select>
</div></th>
            <th><div class="form-group">

  <select class="form-control" name="four" id="sel1">
    <option value="0">Name</option>
    <option value="1">Address</option>
    <option value="2">Phone No</option>
    <option value="3">GPS</option>
  </select>
</div>
</form>
</th>
          </tr>
        </thead>
        <tbody>

          <?php

          foreach ($tables as $table) {

            $rows = $client->getDatabaseTableRows($inputFiles, $table);
     foreach($rows as $row){



         ?>
      <tr>
        <td><?php echo $row[0];?></td>
        <td><?php echo $row[1];?></td>
        <td><?php echo $row[2];?></td>
        <td><?php echo $row[3];?></td>
      </tr>

      <?php
}

      }?>


        </tbody>
      </table>
  				</div>


</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  </body>
</html>
