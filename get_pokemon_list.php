<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "pokedex";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit();
}

$query = 'SELECT no, name, image FROM pokemon ORDER BY no';
$result = $conn->query($query);

if ($result === false) {
    echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
    $conn->close();
    exit();
}

$pokemonList = [];
while ($row = $result->fetch_assoc()) {
    $pokemonList[] = $row;
}

echo json_encode($pokemonList);

$conn->close();
?>

