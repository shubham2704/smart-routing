<?php
require('vendor/autoload.php');
use function BenTools\StringCombinations\string_combinations;

function sortByOrder($a, $b) {
    return $a['total'] - $b['total'];
}

function getDistance($from, $to, $unit = ''){
    // Google API key
    $apiKey = 'AIzaSyAisZDKLRygOQ-rbg9qcJiv5NVbEcwjbzA';

  // Geocoding API request with start address
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$from.'&destinations='.$to.'&key='.$apiKey);
    $outputFrom = json_decode($geocodeFrom, true);
    $dt = $outputFrom['rows'][0]['elements'][0]['distance']['text'];
    return substr($dt, 0, -3) * 1609.344;


}

function permute($arg) {
    $array = is_string($arg) ? str_split($arg) : $arg;
    if(1 === count($array))
        return $array;
    $result = array();
    foreach($array as $key => $item)
        foreach(permute(array_diff_key($array, array($key => $item))) as $p)
            $result[] = $item . $p;
    return $result;
}



function arr($array){

  $count = count($array);
  $str = '';
  $i = 0;
  foreach($array as $s){

   $str .= $i;

   $i++;
  }

  //echo $str;


  $arr =  array();
  $str = substr($str, 1);
  $n = strlen($str);


  return permute($str);

}

 ?>
