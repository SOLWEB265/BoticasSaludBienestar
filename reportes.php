<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header("Location: login.php");
  exit;
}

// Manejar el logout
if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "botica";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$sql_proveedores = "SELECT DISTINCT proveedor FROM productos ORDER BY proveedor";
$result_proveedores = $conn->query($sql_proveedores);
$proveedores = [];
if ($result_proveedores->num_rows > 0) {
  while ($row = $result_proveedores->fetch_assoc()) {
    $proveedores[] = $row['proveedor'];
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generar Reportes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleLogoutMenu(event) {
      event.stopPropagation(); // Evita que el clic se propague al documento
      const menu = document.getElementById('logoutMenu');
      menu.classList.toggle('hidden');
    }

    document.addEventListener('click', function() {
      const menu = document.getElementById('logoutMenu');
      if (!menu.classList.contains('hidden')) {
        menu.classList.add('hidden');
      }
    });

    document.getElementById('logoutMenu').addEventListener('click', function(event) {
      event.stopPropagation();
    });
  </script>
</head>

<body class="bg-gradient-to-bl from-[#505b96] to-[#1d2332] min-h-screen font-sans">
  <main class="bg-white m-6 rounded shadow-lg flex-col flex">
    <header class="flex justify-between items-center bg-white px-6 ">
      <div class="flex items-center gap-2">
        <img src="imagenes/Almacen.png" alt="Icono" class="w-12 h-12 ">
        <nav class="flex gap-6 text-sm font-medium">
          <a href="inventario.php" class="hover:underline">INVENTARIO</a>
          <a href="productos.php" class="hover:underline">PRODUCTOS</a>
          <a href="reportes.php" class="hover:underline underline">REPORTES</a>
          <a href="#" class="hover:underline">CONFIGURACION</a>
        </nav>
      </div>
      <div class="flex items-center gap-3 ">
        <a href="notificacion.php">
          <button>
            <img src="imagenes/Chat.png" alt="Chat" class="w-5 h-5 ">
          </button>
        </a>
        <a href="interfaz.php">
          <button>
            <img src="imagenes/Retroceder.png" alt="Retroceder" class="w-5 h-5 ">
          </button>
        </a>
        <img src="imagenes/Herramienta.png" alt="Tools" class="w-5 h-5">
        <div class="relative flex justify-center items-center">
          <button onclick="toggleLogoutMenu(event)">
            <img src="imagenes/Botica.png" class="w-10 cursor-pointer rounded-full" alt="Salir Icon">
          </button>
          <div id="logoutMenu" class="hidden absolute right-0 mt-24 w-40 bg-white rounded-md shadow-lg z-10">
            <a href="?logout=true" class="block px-4 py-2 rounded-md text-gray-800 hover:bg-gray-100">Cerrar sesión</a>
          </div>
        </div>
      </div>
    </header>

    <div class="flex flex-col items-center py-10">
      <h1 class="text-2xl font-bold text-[#2a3c96] mb-6">Generar Reportes</h1>
      <div class="bg-gray-100 w-[600px] p-8 rounded shadow-md">
        <form action="#" method="POST" class="space-y-4">
          <div>
            <label for="reporte" class="block font-semibold text-sm">Seleccionar Reporte</label>
            <select id="reporte" name="reporte" class="w-full mt-1 border border-gray-300 rounded px-3 py-2">
              <option>Reporte de stock actual</option>
              <option>Movimientos de inventarios(en proceso)</option>
              <option>Productos Vencidos</option>
            </select>
          </div>

          <div class="flex gap-4">
            <div class="flex-1">
              <label for="fecha_desde" class="block text-sm font-medium">Fecha Desde</label>
              <input type="date" id="fecha_desde" name="fecha_desde" class="w-full border border-gray-300 rounded px-3 py-2" value="2024-05-10">
            </div>
            <div class="flex-1">
              <label for="fecha_hasta" class="block text-sm font-medium">Fecha Hasta</label>
              <input type="date" id="fecha_hasta" name="fecha_hasta" class="w-full border border-gray-300 rounded px-3 py-2" value="2025-05-10">
            </div>
          </div>

          <div>
            <label for="proveedor" class="block text-sm font-medium">Proveedor</label>
            <select id="proveedor" name="proveedor" class="w-full border border-gray-300 rounded px-3 py-2">
              <?php foreach ($proveedores as $proveedor) : ?>
                <option value="<?php echo $proveedor; ?>"><?php echo $proveedor; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="flex justify-end gap-4 pt-4">
            <button type="reset" class="bg-[#6276B9] text-white px-6 py-2 rounded hover:bg-[#4d5f98]">CANCELAR</button>
            <button type="submit" class="bg-[#6276B9] text-white px-6 py-2 rounded hover:bg-[#4d5f98]">GENERAR REPORTE</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</body>

</html>