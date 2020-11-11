<html>
<head>
<style>
* {
	font-family: Sans-serif;
}

#geolocation {
    width: 160px;
    position: relative;
    left: 100%;
	font-family: fantasy;
	top: 30%;
}

#button {
	border-radius: 4px;
	margin: 2% 0% 1% 22%;
}

#latitude: focus-within {
	    box-shadow: 0 0 4px yellow;
}

#latitude {
	background-color: white;
    border-radius: 4px;
	text-align: center;
}

#longitude {
	background-color: white;
    border-radius: 4px;
	text-align: center;
}

#longitude: focus-within {
	box-shadow: 0 0 4px yellow;
}

#address {
	background-color: white;
    border-radius: 4px;
	text-align: center;
}

#text {
	color: black;
	width: 50%;
}
	
body {
    background-image: url("globe.gif");
    background-color: #cccccc;
	display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
	background-repeat: no-repeat

}	

</style>
</head>
<body>

<div id='geolocation'>
<form method="post" action='geolocation.php'>
  <p>If it fails, check spelling and try again</p>
  <hr></hr>
  <textarea id='address' name='address' placeholder='Town, Streetname, number, postal code'></textarea>
  <input type="submit" id="button" name="submit_address" value="Get Coordinates">
</form>

<form method="post" action='geolocation.php'>
  <p>Enter Latitude</p>
  <input type='text' id='latitude' name='latitude' placeholder='Enter Latitude'>
  <p>Enter Longitude</p>
  <input type='text' id='longitude' name='longitude' placeholder='Enter Longitude'>
  <input type="submit" id="button" name="submit_coordinates" value="Get Address">
</form>
</div>

<div id="countries">
<table>
<tr>
<th>Country</th>
<th>Latitude</th>
<th>Longitude</th>
</tr>
<tr>
<td>Germany </td>
<td>51.165691</td>
<td>10.451526</td>
</tr>

<tr>
<td>Chile</td>
<td>-35.675147</td>
<td>-71.542969</td>
</tr>

<tr>
<td>Spain</td>
<td>40.463667</td>
<td>-3.74922</td>
</tr>
</table>
</div>

</body>
</html>
<div id="text">
<?php
error_reporting(0); //this hides all errors

if(isset($_POST['submit_address']))
{
  $address =$_POST['address']; 
  $prepAddr = str_replace(' ','+',$address);
  $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
  //It might be handy to learn a little bit about REST API's
  /* 
   Normally you would need an api key, to access to Google Maps API, I did not not use because it's locked behind a paywall where you need a credit card, which I didn't have 
   so I followed some older tutorials which apparently don't require keys as they make use of an older google maps version 
   */
  $output= json_decode($geocode);
  $latitude = $output->results[0]->geometry->location->lat;
  $longitude = $output->results[0]->geometry->location->lng;

  echo " latitude = ".$latitude;
  echo " <hr>longitude = ".$longitude;
  echo " <hr>Save this? ".$address.": ".$latitude.": ".$longitude.": <button>YES</button> <button>NO</button>";
  /* 
   This was something I was working on, it would save the values in a DB in MYSQL and from there export all rows to excel file
   You can delete this part, as there is a much easier way in doing this using PHPExcel 
   */
  }

if(isset($_POST['submit_coordinates']))
{
  $lat=$_POST['latitude'];
  $long=$_POST['longitude'];
	
  $url  = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat. "," .$long."&sensor=false";
  $json = @file_get_contents($url);
  $data = json_decode($json);
  $status = $data->status;
  $address = '';
  if($status == "OK")
  {
	echo $address = $data->results[0]->formatted_address;
  }
  else
  {
	echo "No results";
  }
}
?>
</div>

