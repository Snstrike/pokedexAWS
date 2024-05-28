<?php
$servername = "pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "pokedex";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error);
    die('Error de conexión: ' . $conn->connect_error);
}

// Ejecutar consulta
$sql = 'SELECT id, name, no, image FROM pokemon ORDER BY no';
$result = $conn->query($sql);

// Verificar resultado
if (!$result) {
    error_log("Error en la consulta: " . $conn->error);
    echo json_encode(['error' => "Error en la consulta: " . $conn->error]);
    die();
}

// Procesar resultado
$pokemonList = [];
while ($row = $result->fetch_assoc()) {
    $pokemonList[] = $row;
}

// Devolver resultado en formato JSON
header('Content-Type: application/json');
echo json_encode($pokemonList);

// Cerrar conexión
$conn->close();
?>
