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
	color: white;
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

<!-- <img src="globepic.jpg" onmouseenter="this.src ="globe.gif';" onmouseout="this.src = 'globepic.jpg';" alt="something pithy"> -->
<div id='geolocation'>
<form method="post" action='geolocation.php'>
  <p>If it fails, check spelling or try again</p>
  <hr></hr>
  <textarea id='address' name='address' placeholder='Streetname,City or by Country'></textarea>
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
<td>Germay </td>
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
if(isset($_POST['submit_address']))
{
  $address =$_POST['address']; 
  $prepAddr = str_replace(' ','+',$address);
  $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
  $output= json_decode($geocode);
  $latitude = $output->results[0]->geometry->location->lat;
  $longitude = $output->results[0]->geometry->location->lng;

  
  echo " latitude = ".$latitude;
  echo " <hr>longitude = ".$longitude;
  echo " <hr>Save this? ".$address.": ".$latitude.": ".$longitude.": <button>YES</button> <button>NO</button>";
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
	echo "This place does not exist, please check spelling and try again";
  }
}
?>
</div>

