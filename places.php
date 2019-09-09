<?php
$key = "REDACTED";
$json = file_get_contents("https://maps.googleapis.com/maps/api/place/search/json?keyword=pizza&location=" . $_POST[lat] . "," . $_POST[lon] . "&radius=5000&sensor=false&key=" . $key);
$res = json_decode($json);
$i = 0;
foreach($res->results as $ref){	
	$dets = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?reference=" . $ref->reference . "&sensor=false&key=" . $key);
	$place = json_decode($dets);
	$places[$i][name] = $place->result->name;
	$places[$i][lati] = $place->result->geometry->location->lat;
	$places[$i][long] = $place->result->geometry->location->lng;
	$places[$i][addr] = $place->result->vicinity;
	$places[$i][phon] = $place->result->formatted_phone_number;
	$places[$i][rate] = $place->result->rating;
	$places[$i][revi] = $place->result->reviews;
	$i++;
}
if(!(empty($places))){
  echo json_encode($places);
}else{
  $json = file_get_contents("https://maps.googleapis.com/maps/api/place/search/json?keyword=pizza&location=" . $_POST[lat] . "," . $_POST[lon] . "&radius=50000&sensor=false&key=" . $key);
  $res = json_decode($json);
  $j = 0;
  foreach($res->results as $ref){	
  	$dets = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?reference=" . $ref->reference . "&sensor=false&key=" . $key);
  	$place = json_decode($dets);
  	$places[$i][name] = $place->result->name;
  	$places[$i][lati] = $place->result->geometry->location->lat;
  	$places[$i][long] = $place->result->geometry->location->lng;
  	$places[$i][addr] = $place->result->vicinity;
  	$places[$i][phon] = $place->result->formatted_phone_number;
  	$places[$i][rate] = $place->result->rating;
  	$places[$i][revi] = $place->result->reviews;
  	$j++;
  }
  if(!(empty($places))){
    echo json_encode($places);
  }else{
    echo "No Results";
  }
}
?>
