<?php
$servername = "pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "pokedex";

$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die(json_encode(["error" => 'Error de conexión: ' . $mysqli->connect_error]));
}

$query = 'SELECT id, name, no, image FROM pokemon ORDER BY no';
$result = $mysqli->query($query);

if (!$result) {
    echo json_encode(["error" => "Error en la consulta: " . $mysqli->error]);
    exit();
}

$pokemonList = [];
while ($row = $result->fetch_assoc()) {
    $pokemonList[] = $row;
}

echo json_encode($pokemonList);

$mysqli->close();
?>
