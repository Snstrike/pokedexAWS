<?php
$servername = "localhost";
$username = "root";
$password = "";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Crear base de datos
$sql = "CREATE DATABASE pokedex";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

// Seleccionar base de datos
$conn->select_db('pokedex');

// Crear tabla
$sql = "CREATE TABLE pokemon (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    type2 VARCHAR(50) DEFAULT '(None)',
    height INT NOT NULL,
    weight INT NOT NULL,
    hp INT NOT NULL,
    attack INT NOT NULL,
    defense INT NOT NULL,
    speed INT NOT NULL,
    image VARCHAR(255) DEFAULT 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/1.png'
)";

if ($conn->query($sql) === TRUE) {
    echo "Table pokemon created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
