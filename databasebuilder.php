<?php
$servername = "pokedex-db.cb0cik6msgrb.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Crear la base de datos
$sql = "CREATE DATABASE IF NOT EXISTS pokedex";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Seleccionar la base de datos
$conn->select_db("pokedex");

// Crear la tabla si no existe
$sql = "CREATE TABLE IF NOT EXISTS pokemon (
    no INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    type VARCHAR(30) NOT NULL,
    type2 VARCHAR(30),
    height INT(6),
    weight INT(6),
    hp INT(6),
    attack INT(6),
    defense INT(6),
    spattack INT(6),
    spdefense INT(6),
    speed INT(6),
    image VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table pokemon created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>

