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
  <title>Formulario Factura</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-gradient-to-bl from-[#505b96] to-[#1d2332] min-h-screen flex flex-col">
<div class="w-full flex flex-col items-end ">
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
          <div id="logoutMenu" class="hidden absolute right-0 top-8 w-40 bg-white rounded-md shadow-lg z-10">
            <a href="?logout=true" class="block px-4 py-2 rounded-md text-gray-800 hover:bg-gray-100">Cerrar sesión</a>
          </div>
        </div>
    </div>
  </div>

  <div class="p-8 w-full flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-md w-full max-w-2xl">
      <form class="p-6 space-y-6">
        <!-- Datos de la Factura -->
        <div>
          <h3 class="text-indigo-600 font-semibold text-sm mb-2">Datos de la Factura</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-medium">Tipo <span class="text-red-500">*</span></label>
              <select class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300">
                <option>Nota de Credito</option>
                <option>Factura</option>
              </select>
            </div>
            <div>
              <label class="text-sm font-medium">Fecha <span class="text-red-500">*</span></label>
              <input type="date" value="2024-12-19" class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300">
            </div>
            <div>
              <label class="text-sm font-medium">Método de Pago</label>
              <select class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300">
                <option>Efectivo</option>
                <option>Tarjeta</option>
              </select>
            </div>
            <div>
              <label class="text-sm font-medium">Vendedor</label>
              <select class="mt-1 w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300">
                <option>Seleccione vendedor</option>
              </select>
            </div>
          </div>
        </div>
    
        <!-- Productos -->
        <div>
          <h3 class="text-indigo-600 font-semibold text-sm mb-2">Productos / Servicios</h3>
          <table class="w-full text-sm border">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-3 py-1 text-left font-medium">Producto</th>
                <th class="px-3 py-1 text-right font-medium">Cant.</th>
                <th class="px-3 py-1 text-right font-medium">P. Unit.</th>
                <th class="px-3 py-1 text-right font-medium">Total</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              <tr>
                <td class="px-3 py-1">Paracetamol 500mg x 20 tab</td>
                <td class="px-3 py-1 text-right">2</td>
                <td class="px-3 py-1 text-right">S/ 8.50</td>
                <td class="px-3 py-1 text-right">S/ 17.00</td>
              </tr>
              <tr>
                <td class="px-3 py-1">Ibuprofeno 400mg x 10 cap</td>
                <td class="px-3 py-1 text-right">1</td>
                <td class="px-3 py-1 text-right">S/ 12.00</td>
                <td class="px-3 py-1 text-right">S/ 12.00</td>
              </tr>
              <tr>
                <td class="px-3 py-1">Vitamina C 1000mg x 30 tab</td>
                <td class="px-3 py-1 text-right">1</td>
                <td class="px-3 py-1 text-right">S/ 25.00</td>
                <td class="px-3 py-1 text-right">S/ 25.00</td>
              </tr>
              <tr>
                <td class="px-3 py-1">Omeprazol 20mg x 14 cap</td>
                <td class="px-3 py-1 text-right">2</td>
                <td class="px-3 py-1 text-right">S/ 15.50</td>
                <td class="px-3 py-1 text-right">S/ 31.00</td>
              </tr>
            </tbody>
          </table>
    
          <!-- Totales -->
          <div class="text-right mt-4 space-y-1">
            <p class="text-sm">Subtotal: <span class="ml-2">S/ 85.00</span></p>
            <p class="text-sm">IGV (18%): <span class="ml-2">S/ 15.30</span></p>
            <p class="text-sm font-semibold text-indigo-700">TOTAL: <span class="ml-2 font-bold">S/ 100.30</span></p>
          </div>
        </div>
    
        <!-- Observaciones -->
        <div>
          <h3 class="text-sm font-medium mb-1">Observaciones</h3>
          <textarea class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-indigo-300" placeholder="Observaciones adicionales (opcional)"></textarea>
        </div>
    
        <!-- Botones -->
        <div class="flex justify-end gap-4 pt-4">
          <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-300">CANCELAR</button>
          <button type="button" class="px-4 py-2 bg-indigo-200 text-indigo-900 text-sm font-medium rounded-md hover:bg-indigo-300">VISTA PREVIA</button>
          <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">GENERAR FACTURA</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
