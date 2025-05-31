<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrar Nuevo Producto</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-bl from-[#505b96] to-[#1d2332]">

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "botica";

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $conn->prepare("INSERT INTO productos (codigo, producto, stock, precio, proveedor, fecha_vencimiento) 
                               VALUES (:codigo, :producto, :stock, :precio, :proveedor, :fecha_vencimiento)");

      $fecha_mysql = $_POST['fecha_vencimiento'];

      $stmt->bindParam(':codigo', $_POST['codigo']);
      $stmt->bindParam(':producto', $_POST['producto']);
      $stmt->bindParam(':stock', $_POST['cantidad'], PDO::PARAM_INT);
      $stmt->bindParam(':precio', $_POST['precio']);
      $stmt->bindParam(':proveedor', $_POST['proveedor']);
      $stmt->bindParam(':fecha_vencimiento', $fecha_mysql);

      $stmt->execute();

      header("Location: inventario.php?success=1");
      exit();
    } catch (PDOException $e) {
      $error_message = "Error: " . $e->getMessage();
    }
  }
  ?>

  <div class="bg-white shadow-lg rounded-lg px-[5rem] py-[4rem] w-full max-w-[43rem] ">
    <h2 class="text-2xl font-bold mb-6">Registrar Nuevo Producto</h2>

    <?php if (isset($error_message)): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?php echo $error_message; ?></span>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">
      <div>
        <label for="producto" class="block text-sm font-medium text-gray-700">Nombre del producto</label>
        <input type="text" id="producto" name="producto" placeholder="Ej. Paracetamol 500mg"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300" required />
      </div>

      <div>
        <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
        <input type="text" id="codigo" name="codigo"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300" required />
      </div>

      <div>
        <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">Fecha de Vencimiento</label>
        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300"
          min="<?php echo date('Y-m-d'); ?>" required />
      </div>

      <div>
        <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
        <input type="number" id="cantidad" name="cantidad" min="1"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300" required />
      </div>

      <div>
        <label for="proveedor" class="block text-sm font-medium text-gray-700">Proveedor</label>
        <input type="text" id="proveedor" name="proveedor"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300" required />
      </div>

      <div>
        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0.01"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300" required />
      </div>

      <div class="flex justify-between mt-6">
        <button type="reset" class="bg-yellow-200 text-gray-700 px-4 py-2 rounded hover:bg-yellow-300 transition">Descartar</button>
        <button type="submit" class="bg-yellow-200 text-gray-700 px-4 py-2 rounded hover:bg-yellow-300 transition">Finalizar / Guardar</button>
      </div>
    </form>
  </div>
</body>

</html>