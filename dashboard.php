<?php
// Iniciar sesión y verificar autenticación
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
  $servername = "localhost";
  $username = "root";  // Usuario por defecto de XAMPP
  $password = "";      // Contraseña por defecto (vacía)
  $dbname = "botica";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consultar productos
$sql = "SELECT * FROM productos ORDER BY fecha_registro DESC";
$result = $conn->query($sql);
$productos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Botica Salud y Bienestar - Dashboard</title>
  <style>
    .sidebar {
      width: 250px;
      background: #1d2332;
      color: white;
      position: fixed;
      height: 100%;
      padding: 20px;
    }
    .topbar {
      margin-left: 250px;
      background: white;
      padding: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .content {
      margin-left: 250px;
      padding: 20px;
      background: #f5f7fa;
      min-height: calc(100vh - 60px);
    }
    .product-card {
      background: white;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .product-table {
      width: 100%;
      border-collapse: collapse;
    }
    .product-table th, .product-table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #e0e0e0;
    }
    .product-table th {
      background: #f8f9fa;
      font-weight: 600;
    }
    .stock-low {
      color: #e53e3e;
      font-weight: bold;
    }
    .stock-medium {
      color: #dd6b20;
    }
    .stock-high {
      color: #38a169;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="logo mb-8">
      <img src="imagenes/Botica.png" alt="Logo Botica" class="w-20 mx-auto rounded-full">
      <h2 class="text-center mt-2 text-xl font-bold">BOTICA SALUD</h2>
    </div>
    <ul class="space-y-2">
      <li class="p-2 hover:bg-[#505b96] rounded cursor-pointer">Dashboard</li>
      <li class="p-2 hover:bg-[#505b96] rounded cursor-pointer">Productos</li>
      <li class="p-2 hover:bg-[#505b96] rounded cursor-pointer">Ventas</li>
      <li class="p-2 hover:bg-[#505b96] rounded cursor-pointer">Proveedores</li>
      <li class="p-2 hover:bg-[#505b96] rounded cursor-pointer">Inventario</li>
      <li class="p-2 hover:bg-[#505b96] rounded cursor-pointer">Reportes</li>
      <li class="p-2 hover:bg-[#505b96] rounded cursor-pointer">Configuración</li>
    </ul>
  </div>

  <div class="topbar">
    <div class="search">
      <input type="text" placeholder="Buscar productos..." class="px-4 py-2 border rounded-lg">
    </div>

    <div class="welcome flex justify-center items-center">
          <a href="javascript:history.back()" class="flex justify-center pr-2 items-center">
          <button>
            <img src="imagenes/Retroceder.png" alt="Retroceder" class="w-5 h-5 ">
          </button>
        </a>
      <span class="mr-3">Bienvenido, <?php echo $_SESSION['user_name']; ?></span>
      <img src="imagenes/Persona.png" alt="Usuario" class="w-8 h-8 rounded-full">
    </div>
  </div>

  <div class="content">
    <div class="breadcrumbs mb-4 text-sm text-gray-600">Home / Dashboard</div>
    
    <h1 class="text-2xl font-bold mb-6">INVENTARIO DE PRODUCTOS</h1>
    
    <div class="metrics grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="metric bg-white p-4 rounded-lg shadow">
        <h3 class="text-gray-500">TOTAL PRODUCTOS</h3>
        <span class="text-2xl font-bold"><?php echo count($productos); ?></span>
      </div>
      <div class="metric bg-white p-4 rounded-lg shadow">
        <h3 class="text-gray-500">STOCK BAJO (<10) </h3>
        <span class="text-2xl font-bold text-red-500">
          <?php 
            $lowStock = array_filter($productos, function($p) { return $p['stock'] < 10; });
            echo count($lowStock);
          ?>
        </span>
      </div>
      <div class="metric bg-white p-4 rounded-lg shadow">
        <h3 class="text-gray-500">PRÓXIMOS A VENCER</h3>
        <span class="text-2xl font-bold text-yellow-500">
          <?php 
            $nearExpiry = array_filter($productos, function($p) { 
              return strtotime($p['fecha_vencimiento']) < strtotime('+30 days'); 
            });
            echo count($nearExpiry);
          ?>
        </span>
      </div>
    </div>

    <div class="product-list bg-white p-6 rounded-lg shadow">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">LISTA DE PRODUCTOS</h2>        
      </div>
      
      <table class="product-table w-full">
        <thead>
          <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Proveedor</th>
            <th>Vencimiento</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($productos as $producto): 
            $stockClass = '';
            if ($producto['stock'] < 10) {
              $stockClass = 'stock-low';
            } elseif ($producto['stock'] < 30) {
              $stockClass = 'stock-medium';
            } else {
              $stockClass = 'stock-high';
            }
            
            $expiryClass = '';
            if (strtotime($producto['fecha_vencimiento']) < strtotime('+30 days')) {
              $expiryClass = 'text-yellow-600';
            }
            if (strtotime($producto['fecha_vencimiento']) < time()) {
              $expiryClass = 'text-red-600';
            }
          ?>
          <tr>
            <td><?php echo htmlspecialchars($producto['codigo']); ?></td>
            <td><?php echo htmlspecialchars($producto['producto']); ?></td>
            <td class="<?php echo $stockClass; ?>"><?php echo $producto['stock']; ?></td>
            <td>S/ <?php echo number_format($producto['precio'], 2); ?></td>
            <td><?php echo htmlspecialchars($producto['proveedor']); ?></td>
            <td class="<?php echo $expiryClass; ?>">
              <?php echo date('d/m/Y', strtotime($producto['fecha_vencimiento'])); ?>
            </td>            
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>