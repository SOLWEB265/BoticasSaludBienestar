<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Alertas por Productos</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-bl from-[#505b96] to-[#1d2332]">
  <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "botica";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
  }

  $sql = "SELECT producto, fecha_vencimiento 
          FROM productos 
          WHERE fecha_vencimiento > CURDATE()
          ORDER BY fecha_vencimiento ASC
          LIMIT 1";

  $result = $conn->query($sql);
  $alerta_producto = "";
  $alerta_fecha = "";
  $mostrar_alerta = false;

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $alerta_producto = $row['producto'];
    $alerta_fecha = date("d/m/Y", strtotime($row['fecha_vencimiento']));

    $fecha_vencimiento = new DateTime($row['fecha_vencimiento']);
    $hoy = new DateTime();
    $dias_restantes = $hoy->diff($fecha_vencimiento)->days;

    $mostrar_alerta = true;
  }
  $conn->close();
  ?>

  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-4xl">
    <h2 class="text-2xl font-bold mb-6 text-center">Alertas por Productos Próximos a Vencer</h2>

    <?php if ($mostrar_alerta): ?>
      <div class="bg-red-200 text-red-900 font-semibold p-4 rounded mb-10">
        <span class="font-bold">Alerta:</span>
        El producto <span class="font-bold"><?php echo htmlspecialchars($alerta_producto); ?></span>
        vence en <?php echo $dias_restantes; ?> días (Fecha: <span class="italic"><?php echo $alerta_fecha; ?></span>)
      </div>
    <?php else: ?>
      <div class="bg-green-200 text-green-900 font-semibold p-4 rounded mb-10">
        No hay productos próximos a vencer en este momento.
      </div>
    <?php endif; ?>

    <div class="flex justify-start">
      <a href="javascript:history.back()">
        <button class="bg-yellow-200 text-gray-800 px-4 py-2 rounded hover:bg-yellow-300 transition">
          Regresar Al Menú Anterior
        </button>
      </a>
    </div>
  </div>
</body>

</html>