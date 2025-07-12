<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header("Location: login.php");
  exit;
}

if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario Proveedor</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function limpiarFormulario() {
      const form = document.querySelector('#formularioProveedor');
      form.querySelectorAll('input, textarea, select').forEach(el => {
        if (el.type === 'radio' || el.type === 'checkbox') {
          el.checked = false;
        } else {
          el.value = '';
        }
      });
    }
  </script>

  <script>
    function toggleLogoutMenu(event) {
      event.stopPropagation(); 
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

<body class="bg-gradient-to-bl from-[#505b96] to-[#1d2332] min-h-screen flex flex-col ">
  <div class="w-full flex justify-end ">
    <div class="flex justify-center items-center gap-3 p-4">
      <a href="interfaz.php" class="flex justify-center pr-2 items-center">
        <button>
          <img src="imagenes/Retroceder.png" alt="Retroceder" class="w-5 h-5 ">
        </button>
      </a>
      <span class="text-lg font-medium text-white">Botica salud y bienestar</span>

      <div class="relative flex justify-center items-center">
        <button onclick="toggleLogoutMenu(event)">
          <img src="imagenes/User.jpg" class="w-6 h-6 cursor-pointer rounded-full" alt="Salir Icon">
        </button>
        <div id="logoutMenu" class="hidden absolute right-0 top-6 w-40 bg-white rounded-md shadow-lg z-10">
          <a href="?logout=true" class="block px-4 py-2 rounded-md text-gray-800 hover:bg-gray-100">Cerrar sesión</a>
        </div>
      </div>
    </div>
  </div>

  <div class="flex items-center  justify-center w-full">
    <div class="bg-white rounded-xl shadow-md w-full max-w-2xl">
      <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white text-center py-4 rounded-t-xl">
        <h2 class="text-lg font-semibold">PROVEEDOR DE PAGO "BOTICA SALUD Y BIENESTAR"</h2>
      </div>
      <form id="formularioProveedor" class="p-6 space-y-6">
        <!-- Información Básica -->
        <div>
          <h3 class="text-indigo-600 font-semibold text-sm mb-2">Información Básica</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-medium">Nombre del Proveedor <span class="text-red-500">*</span></label>
              <input type="text" class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300" placeholder="Ingrese el nombre del proveedor">
            </div>
            <div>
              <label class="text-sm font-medium">RUC / Documento <span class="text-red-500">*</span></label>
              <input type="text" class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300" placeholder="Ingrese RUC o documento">
            </div>
            <div>
              <label class="text-sm font-medium">Teléfono</label>
              <input type="text" class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300" placeholder="Ingrese número de teléfono">
            </div>
            <div>
              <label class="text-sm font-medium">Email</label>
              <input type="email" class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300" placeholder="Ingrese correo electrónico">
            </div>
            <div class="md:col-span-2">
              <label class="text-sm font-medium">Dirección</label>
              <textarea class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300" placeholder="Ingrese la dirección completa"></textarea>
            </div>
          </div>
        </div>

        <!-- Información Bancaria -->
        <div>
          <h3 class="text-indigo-600 font-semibold text-sm mb-2">Información Bancaria</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-medium">Banco <span class="text-red-500">*</span></label>
              <select class="mt-1 w-full border rounded-md px-3 py-2 text-sm bg-white focus:outline-none focus:ring focus:ring-indigo-300">
                <option>Seleccione un banco</option>
              </select>
            </div>
            <div>
              <label class="text-sm font-medium">Tipo de Cuenta <span class="text-red-500">*</span></label>
              <div class="flex items-center mt-2 space-x-4">
                <label class="inline-flex items-center">
                  <input type="radio" name="cuenta" class="form-radio text-indigo-600">
                  <span class="ml-2 text-sm">Corriente</span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio" name="cuenta" class="form-radio text-indigo-600">
                  <span class="ml-2 text-sm">Ahorros</span>
                </label>
              </div>
            </div>
            <div>
              <label class="text-sm font-medium">Número de Cuenta <span class="text-red-500">*</span></label>
              <input type="text" class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300" placeholder="Ingrese número de cuenta">
            </div>
            <div>
              <label class="text-sm font-medium">CCI (Código de Cuenta Interbancaria)</label>
              <input type="text" class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300" placeholder="Ingrese CCI (20 dígitos)">
            </div>
          </div>
        </div>
        <!-- Botones -->
        <div class="flex justify-end space-x-3 pt-4">
          <button type="button" onclick="limpiarFormulario()" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-300">CANCELAR</button>
          <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">GUARDAR</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>