<?php
error_reporting(0);
if (isset($_POST["origin"])) {

$from = !empty($_POST["origin"]) ? 	urlencode($_POST["origin"]) : null ;
$to = !empty($_POST["destination"]) ? 	urlencode($_POST["destination"]) : null ;
$url_api = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$from."&destinations=" .$to. "&key=AIzaSyCeHT7BfdJQzdguxmJHNWT43f6Jup0h4t0" ;
$result = file_get_contents($url_api);
$data = json_decode($result, true);

$distance = $data['rows']['0']['elements']['0']['distance']['value'];
$distance_in_km = ($distance/1000);
session_start();
$_SESSION["km_for_js"] = $distance_in_km;
$bus_fare_calculation = ($distance/1000)*0.42;
$bus_fare = round($bus_fare_calculation);
$max_bus_fare = round(($distance/1000)*0.75);

}
?>
<!-- 
Designed & Developed by Istardevelopers.in [ http://istardevelopers.in ]
Author: Manobala.S and Hassan Hameed.S.H
Team Istardevelopers.in
-->
<!DOCTYPE html>
<html>
<head>
<title>DiDu App</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="description" content="Distance and Duration Calculator">
<meta name="keywords" content="didu">
<meta name="author" content="Hassan Hammed">
</head>
<body>
<br>
<h5 class="center-align flow-text">Distance & Duration Calculator</h5>
<div class="row">
<div class="col s12 m6 offset-m3 card-panel">
<form method="post" action="index.php">
<div class="input-field col s4">
<input id="origin" name="origin" type="text" class="validate">
<label for="origin">From</label>
</div>
<div class="input-field col s4">
<input id="destination" name="destination" type="text" class="validate">
<label for="destination">To</label>
</div>
<div class="col s4">
<br>
<input style="border-radius: 20px; width: 100%; text-transform: capitalize;" class="cyan btn" type="submit">
</div>
</form>
</div>
<div class="col s12 m6 offset-m3 card-panel">
<h5>Information</h5>
<p style="font-weight: bold" >
<?php
if (isset($_POST["origin"])) {			
echo "From: ";
echo $data['origin_addresses']['0'];
echo "<br>";
echo "To: ";
echo $data['destination_addresses']['0'];
echo "<br>";
echo "Distance: ";
echo $data['rows']['0']['elements']['0']['distance']['text'];
echo "<br>";
echo "Duration: ";
echo $data['rows']['0']['elements']['0']['duration']['text'];
echo "<br>";
echo "Bus Fare [approx]: Min ";
echo "Rs.$bus_fare - Max: Rs.$max_bus_fare";
?>

<div class="row">
<div class="col s12 m6">
<form onsubmit="return false;">
<div class="input-field col s4">
<input type="hidden" id="kmfun" value="<?php if(isset($_SESSION['km_for_js'])){ echo $_SESSION['km_for_js']; } ?>" >
<input id="mile" placeholder="Mileage" type="text">
</div>
<div class="input-field col s4">
<input id="fcost" placeholder="Fuel Cost" type="text">
</div>
<div class="col s4">
<br>
<input style="border-radius: 20px; text-transform: capitalize;" class="teal btn" type="submit" id='submit' value='Calculate' onclick="myFunction()">
</div>
</form>

</div>
</div>
<h5 class="flow-text" id="eres">Total Cost</h5>
<?php
}else{
echo "Type From & To, to get info!";
}
?>
</p>
<br>
<p>&copy; 2017, <a href="http://Istardevelopers.in">Istardevelopers.in</a></p>
</div>
</div>
<script>
function myFunctionn() {
var km = <?php if(isset($_SESSION['km_for_js'])){ echo $_SESSION['km_for_js']; } ?>;
alert("Welcome again " + km);
}

function myFunction(){
var km = document.getElementById("kmfun").value;
var mile = document.getElementById("mile").value;
var fcost = document.getElementById("fcost").value;
var res = Math.round((km/mile)*fcost);
var ht = "Total Cost = Rs.";
document.getElementById("eres").innerHTML =  ht.concat(res);
}
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
</body>
</html>
