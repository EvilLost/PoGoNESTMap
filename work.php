<?php
header('Content-Type: application/json');
//CONNECTION DETAILS
$host = "host";
$dbase = "database";
$user = "user";
$passwd = "password";

$Link = new PDO("mysql:host=$host;dbname=$dbase", $user, $passwd);
if (isset($_GET["pid"]) && isset($_GET["lat"])) {
	$pokemon_id = $_GET["pid"];
	$distance = $_GET["dist"];
	$lat1 = $_GET["lat"] - $distance;
	$lat2 = $_GET["lat"] + $distance;
	$lon1 = $_GET["lon"] - $distance;
	$lon2 = $_GET["lon"] + $distance;
	$search = "SELECT * FROM nestdb WHERE pokemon_id IN (".$pokemon_id.") AND latitude > ".$lat1." AND latitude < ".$lat2." AND longitude > ".$lon1." AND longitude < ".$lon2;
} else if (isset($_GET["pid"])) {
	$pokemon_id = $_GET["pid"];
	$search = "SELECT * FROM nestdb WHERE pokemon_id IN (".$pokemon_id.")";
} else {
	$search = "SELECT * FROM nestdb";
}
$query = $Link->prepare($search);
$query->bindParam(':pokemon_id', $pokemon_id);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_CLASS);
$rjson = json_encode($result);

echo $rjson;
?>
