<?php
    $mysqli = new mysqli('pokedex-server', 'admin','password', 'pokedex');

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM pokemon WHERE id = $id";
$result = $conn->query($sql);

$pokemonInfo = null;

if ($result->num_rows > 0) {
    $pokemonInfo = $result->fetch_assoc();
}

echo json_encode($pokemonInfo);

$conn->close();
?>
