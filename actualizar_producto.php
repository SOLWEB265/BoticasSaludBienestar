<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "fuentesodamichel_boticassaludbienestar";
$password = "proyectobotica";
$dbname = "fuentesodamichel_boticassaludbienestar";

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data)) {
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
    exit;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("UPDATE productos SET 
                          producto = :producto,
                          stock = :stock,
                          precio = :precio,
                          proveedor = :proveedor,
                          fecha_vencimiento = :fecha_vencimiento
                          WHERE codigo = :codigo");

    $stmt->bindParam(':codigo', $data['codigo']);
    $stmt->bindParam(':producto', $data['producto']);
    $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
    $stmt->bindParam(':precio', $data['precio']);
    $stmt->bindParam(':proveedor', $data['proveedor']);
    $stmt->bindParam(':fecha_vencimiento', $data['fecha_vencimiento']);

    if ($stmt->execute()) {
        $affected_rows = $stmt->rowCount();
        if ($affected_rows > 0) {
            echo json_encode([
                'success' => true,
                'message' => "Producto actualizado correctamente"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "No se realizaron cambios en el producto"
            ]);
        }
    } else {
        throw new Exception("Error al ejecutar la consulta");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
