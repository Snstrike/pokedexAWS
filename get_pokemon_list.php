<?php
$servername = "pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "pokedex";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

$result = $mysqli->query('SELECT id, name, no, image FROM pokemon ORDER BY no');

$pokemonList = [];
while ($row = $result->fetch_assoc()) {
    $pokemonList[] = $row;
}

echo json_encode($pokemonList);

$mysqli->close();
?>
