<?php
$servername = "pokedex-db.cb0cik6msgrb.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "pokedex";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = 'SELECT id, name, no, image FROM pokemon ORDER BY no';
$result = $conn->query($query);

if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}

$pokemonList = [];
while ($row = $result->fetch_assoc()) {
    $pokemonList[] = $row;
}

echo json_encode($pokemonList);

$conn->close();
?>
