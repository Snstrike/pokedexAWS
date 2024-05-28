<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "pokedex-db.cb0cik6msgrb.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "password";
$dbname = "pokedex";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Error de conexión: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $no = $_GET['no'];

    $stmt = $conn->prepare("SELECT * FROM pokemon WHERE no = ?");
    $stmt->bind_param('i', $no);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $pokemon = $result->fetch_assoc();
            echo json_encode($pokemon);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Pokémon no encontrado']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
