<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pizzaby.me</title>
</head>
<body>
<?php
$revi = file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?reference=' . $_GET[ref] . '&sensor=false&key=$API_KEY');
$decc = json_decode($revi);
?>
<h3><?php echo $decc->result->name; ?></h3>
<?php
foreach($decc->result->reviews as $rev){
  echo $rev->aspects->rating . "<br>";
  echo $rev->text;
  echo "<hr />";
}
?>
</body>
</html>
