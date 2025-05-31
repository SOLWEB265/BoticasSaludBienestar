<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "botica";

$data = json_decode(file_get_contents('php://input'), true);
$codigos = $data['codigos'] ?? [];

if (empty($codigos)) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron códigos de productos']);
    exit;
}

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    $placeholders = implode(',', array_fill(0, count($codigos), '?'));
    $sql = "DELETE FROM productos WHERE codigo IN ($placeholders)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }

    $types = str_repeat('s', count($codigos));
    $stmt->bind_param($types, ...$codigos);

    if ($stmt->execute()) {
        $affected_rows = $stmt->affected_rows;
        echo json_encode([
            'success' => true,
            'message' => "Se eliminaron $affected_rows producto(s) correctamente"
        ]);
    } else {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
