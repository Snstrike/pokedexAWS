<?php
$servername = "pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "pokedex";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM pokemon WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $pokemon = $result->fetch_assoc();
        echo json_encode($pokemon);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
