<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menú Principal - Botica Salud</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-gradient-to-bl from-[#505b96] to-[#1d2332] font-sans text-white">
  <div class="w-full flex justify-end ">
    <div class="flex justify-center items-center gap-3 p-4">
      <a href="notificacion.php">
        <button>
          <img src="imagenes/Chat.png" class="w-6 h-6" alt="Chat Icon">
        </button>
      </a>
      <a href="login.php">
        <button>
          <img src="imagenes/Salir.png" class="w-6 h-6" alt="Salir Icon">
        </button>
      </a>
      <img src="imagenes/Herramienta.png" class="w-6 h-6" alt="Herramienta Icon">
      <span class="text-lg font-medium">Botica salud y bienestar</span>
      <img src="imagenes/User.jpg" class="w-10 h-10 rounded-full" alt="User  Image">
    </div>
  </div>
  <div class="flex-col flex justify-center items-center w-full">
    <div class="flex items-start justify-center w-[80%] gap-16 p-14 pt-[10rem]">
      <a href="contactos.php" class="flex-col flex items-center justify-center transition-transform transform hover:scale-105 ">
        <img src="imagenes/Contactos.png" class="w-[105px] h-[105px]" alt="Contactos Icon">
        <p class="text-sm font-medium text-center w-[85px]">Contactos</p>
      </a>
      <a href="ventas.php" class="flex-col flex items-center justify-center transition-transform transform hover:scale-105 ">
        <img src="imagenes/Ventas.png" class="w-[105px] h-[105px]" alt="Ventas Icon">
        <p class="text-sm font-medium text-center w-[85px]">Ventas</p>
      </a>
      <a href="prov_pago.php" class="flex-col flex items-center justify-center transition-transform transform hover:scale-105 ">
        <img src="imagenes/Proveedor de Pago.png" class="w-[105px] h-[105px]" alt="Proveedor de Pago Icon">
        <p class="text-sm font-medium text-center w-[85px]">Proveedor de pago</p>
      </a>
      <a href="inventario.php" class="flex-col flex items-center justify-center transition-transform transform hover:scale-105 ">
        <img src="imagenes/Almacen 2.png" class="w-[105px] h-[105px]" alt="Almacen Icon">
        <p class="text-sm font-medium text-center w-[85px]">Inventario</p>
      </a>
      <a href="facturacion.php" class="flex-col flex items-center justify-center transition-transform transform hover:scale-105 ">
        <img src="imagenes/facturacion.png" class="w-[105px] h-[105px]" alt="Facturacion Icon">
        <p class="text-sm font-medium text-center w-[85px]">Facturacion</p>
      </a>
    </div>
  </div>
  <div class="flex-col flex justify-center items-center w-full">
    <div class="flex items-start justify-center w-[80%] gap-16 p-14">
      <a href="motor_pago.php" class="flex-col flex items-center justify-center transition-transform transform hover:scale-105 ">
        <img src="imagenes/Motor de Pago.png" class="w-[105px] h-[105px]" alt="Motor de Pago Icon">
        <p class="text-sm font-medium text-center w-[85px]">Motor de Pago</p>
      </a>
      <a href="documentos.php" class="flex-col flex items-center justify-center transition-transform transform hover:scale-105 ">
        <img src="imagenes/Documentos.png" class="w-[105px] h-[105px]" alt="Documentos Icon">
        <p class="text-sm font-medium text-center w-[85px]">Documentos</p>
      </a>
      <a href="dashboard.php" class="flex-col flex items-center justify-center transition-transform transform hover:scale-105 ">
        <img src="imagenes/Dasboard.png" class="w-[105px] h-[105px]" alt="Dashboard Icon">
        <p class="text-sm font-medium text-center w-[85px]">DashBoard</p>
      </a>
    </div>
  </div>
</body>

</html>