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

#lat: focus-within {
	    box-shadow: 0 0 4px yellow;
}

#lat {
	background-color: white;
    border-radius: 4px;
	text-align: center;
}

#lng {
	background-color: white;
    border-radius: 4px;
	text-align: center;
}

#lng: focus-within {
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
<div id='geolocation'>
<form action="testdb.php" method="post">

<!-- <img src="globepic.jpg" onmouseenter="this.src ="globe.gif';" onmouseout="this.src = 'globepic.jpg';" alt="something pithy"> -->

<?php
$servername = "localhost";
$username	= "root";
$password	= "usbw";
$dbname 	= "GEO";

//this makes the connection_aborted
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed because of: " . $conn->connect_error);
} else {
	echo "Connected to the database";
}

if (isset($_POST['submit']))
{
    $address    = $_POST['address'];
    $lat	    = $_POST['lat'];
    $lng	    = $_POST['lng'];

     $query = ("INSERT INTO locations ([address], [lat], [lng]) VALUES ('$address', '$lat', '$lng')");

if(mysql_query($query))
 {
echo "It's been succesfully added to my database-table";
}
else
 {
 echo "Something failed, please try again";
 }

 }
?>


  <p>If it fails, check spelling or try again</p>
  <hr></hr>
  <textarea id='address' name='address' placeholder='Streetname,City or by Country'></textarea>
  <input type="submit" id="button" name="submit_address" value="Get Coordinates">


<form method="post" action='geolocation.php'>
  <p>Enter lat</p>
  <input type='text' id='lat' name='lat' placeholder='Enter lat'>
  <p>Enter lng</p>
  <input type='text' id='lng' name='lng' placeholder='Enter lng'>
  <input type="submit" id="button" name="submit_coordinates" value="Get Address">
  
  <button type ="submit" name="submit" value="send to database"> SEND TO DATABASE </button>
</form>
</div>

<div id="countries">
<table>
<tr>
<th>Country</th>
<th>lat</th>
<th>lng</th>
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
  $lat = $output->results[0]->geometry->location->lat;
  $lng = $output->results[0]->geometry->location->lng;

  echo " lat = ".$lat;
  echo " <hr>lng = ".$lng;
  }

if(isset($_POST['submit_coordinates']))
{
  $lat=$_POST['lat'];
  $long=$_POST['lng'];
	
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
</form>
</div>

