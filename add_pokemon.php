<?php
new mysqli('pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com', 'admin','password', 'pokedex');


// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$type = $_POST['type'];
$type2 = $_POST['type2'];
$height = intval($_POST['height']);
$weight = intval($_POST['weight']);
$hp = intval($_POST['hp']);
$attack = intval($_POST['attack']);
$defense = intval($_POST['defense']);
$spattack = intval($_POST['spattack']);
$spdefense = intval($_POST['spdefense']);
$speed = intval($_POST['speed']);
$image = $_POST['image'];

$sql = "INSERT INTO pokemon (name, type, type2, height, weight, hp, attack, defense, spattack, spdefense, speed, image)
VALUES ('$name', '$type', '$type2', $height, $weight, $hp, $attack, $defense, $spattack, $spdefense, $speed, '$image')";

$response = array();

if ($conn->query($sql) === TRUE) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = $conn->error;
}

echo json_encode($response);

$conn->close();
?>
