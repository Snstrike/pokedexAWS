<?php
$mysqli = new mysqli('localhost', 'root', '', 'pokedex');

if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = ucfirst(strtolower($_POST['name']));
    $type = $_POST['type'];
    $type2 = $_POST['type2'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $hp = $_POST['hp'];
    $attack = $_POST['attack'];
    $defense = $_POST['defense'];
    $spattack = $_POST['spattack'];
    $spdefense = $_POST['spdefense'];
    $speed = $_POST['speed'];

    $stmt = $mysqli->prepare("UPDATE pokemon SET name = ?, type = ?, type2 = ?, height = ?, weight = ?, hp = ?, attack = ?, defense = ?, spattack = ?, spdefense = ?, speed = ? WHERE id = ?");
    $stmt->bind_param('sssiiiiiiiii', $name, $type, $type2, $height, $weight, $hp, $attack, $defense, $spattack, $spdefense, $speed, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
}

$mysqli->close();
?>
