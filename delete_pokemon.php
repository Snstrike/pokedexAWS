<?php
new mysqli('pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com', 'admin','password', 'pokedex-db');

if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $stmt = $mysqli->prepare("DELETE FROM pokemon WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
}

$mysqli->close();
?>
