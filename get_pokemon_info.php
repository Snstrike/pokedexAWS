<?php
new mysqli('pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com', 'admin','password', 'pokedex-db');

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
