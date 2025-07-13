<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    die('Acceso no autorizado');
}

// Conexión a la base de datos
$servername = "localhost";
$username = "fuentesodamichel_boticassaludbienestar";
$password = "proyectobotica";
$dbname = "fuentesodamichel_boticassaludbienestar";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM productos 
        WHERE producto LIKE '%$searchTerm%' 
           OR codigo LIKE '%$searchTerm%' 
           OR proveedor LIKE '%$searchTerm%'
        ORDER BY fecha_registro DESC";
$result = $conn->query($sql);

$productos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

$lowStock = array_filter($productos, function ($p) {
    return $p['stock'] < 10;
});
$nearExpiry = array_filter($productos, function ($p) {
    return strtotime($p['fecha_vencimiento']) < strtotime('+30 days');
});

$tableHTML = '';
foreach ($productos as $producto) {
    $stockClass = '';
    if ($producto['stock'] < 10) $stockClass = 'stock-low';
    elseif ($producto['stock'] < 30) $stockClass = 'stock-medium';
    else $stockClass = 'stock-high';

    $expiryClass = '';
    if (strtotime($producto['fecha_vencimiento']) < strtotime('+30 days')) $expiryClass = 'text-yellow-600';
    if (strtotime($producto['fecha_vencimiento']) < time()) $expiryClass = 'text-red-600';

    $tableHTML .= '<tr>
    <td>' . htmlspecialchars($producto['codigo']) . '</td>
    <td>' . htmlspecialchars($producto['producto']) . '</td>
    <td class="' . $stockClass . '">' . $producto['stock'] . '</td>
    <td>S/ ' . number_format($producto['precio'], 2) . '</td>
    <td>' . htmlspecialchars($producto['proveedor']) . '</td>
    <td class="' . $expiryClass . '">' . date('d/m/Y', strtotime($producto['fecha_vencimiento'])) . '</td>
  </tr>';
}

$response = [
    'table' => $tableHTML,
    'total' => count($productos),
    'lowStock' => count($lowStock),
    'nearExpiry' => count($nearExpiry)
];

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
