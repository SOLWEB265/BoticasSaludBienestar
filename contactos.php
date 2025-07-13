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
    <title>Contactos</title>
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

  <body class="bg-gradient-to-bl from-[#505b96] to-[#1d2332] min-h-screen flex flex-col ">
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
    <div class="p-12 w-full flex items-center justify-center">
      <div class="bg-white rounded-xl shadow-md w-full max-w-6xl p-4">
        <!-- Encabezado -->
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            <h2 class="text-2xl font-bold text-blue-600">Contactos</h2>
          </div>
          <div class="relative">
            <input type="text" placeholder="Buscar..." class="pl-8 pr-4 py-1 border rounded-full focus:outline-none focus:ring focus:ring-indigo-300 text-sm">
            <svg class="absolute left-2 top-1.5 w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
              <path d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387-1.414 1.414-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z" />
            </svg>
          </div>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left border rounded-lg">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2 font-semibold">Nombre</th>
                <th class="px-4 py-2 font-semibold">Teléfono</th>
                <th class="px-4 py-2 font-semibold">Email</th>
                <th class="px-4 py-2 font-semibold">Dirección</th>
                <th class="px-4 py-2 font-semibold">Tipo</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr>
                <td class="px-4 py-2">Juan Pérez</td>
                <td class="px-4 py-2">987654321</td>
                <td class="px-4 py-2 text-blue-600">juanp@empresa.com</td>
                <td class="px-4 py-2">Av. Los Álamos</td>
                <td class="px-4 py-2">Proveedor</td>
              </tr>
              <tr>
                <td class="px-4 py-2">Carla Mendoza</td>
                <td class="px-4 py-2">912345678</td>
                <td class="px-4 py-2 text-blue-600">carlam@negocio.com</td>
                <td class="px-4 py-2">Jr. La Unión</td>
                <td class="px-4 py-2">Proveedor</td>
              </tr>
              <tr>
                <td class="px-4 py-2">Lucía Ramírez</td>
                <td class="px-4 py-2">999888777</td>
                <td class="px-4 py-2 text-blue-600">luciar@cliente.com</td>
                <td class="px-4 py-2">Av. Independencia</td>
                <td class="px-4 py-2">Cliente</td>
              </tr>
              <tr>
                <td class="px-4 py-2">Pedro Castillo</td>
                <td class="px-4 py-2">954321789</td>
                <td class="px-4 py-2 text-blue-600">pedroc@proveedor.com</td>
                <td class="px-4 py-2">Calle Comercio</td>
                <td class="px-4 py-2">Proveedor</td>
              </tr>
              <tr>
                <td class="px-4 py-2">Ana Torres</td>
                <td class="px-4 py-2">921123456</td>
                <td class="px-4 py-2 text-blue-600">ana.torres@email.com</td>
                <td class="px-4 py-2">Av. Central 102</td>
                <td class="px-4 py-2">Cliente</td>
              </tr>
              <tr>
                <td class="px-4 py-2">Mario Quiroz</td>
                <td class="px-4 py-2">923456789</td>
                <td class="px-4 py-2 text-blue-600">mquiroz@ventas.com</td>
                <td class="px-4 py-2">Av. Grau 450</td>
                <td class="px-4 py-2">Proveedor</td>
              </tr>
              <tr>
                <td class="px-4 py-2">Silvia Ríos</td>
                <td class="px-4 py-2">945612378</td>
                <td class="px-4 py-2 text-blue-600">silviar@cliente.net</td>
                <td class="px-4 py-2">Calle Sol N° 10</td>
                <td class="px-4 py-2">Cliente</td>
              </tr>
              <tr>
                <td class="px-4 py-2">Raúl Gutiérrez</td>
                <td class="px-4 py-2">951234567</td>
                <td class="px-4 py-2 text-blue-600">rgutierrez@empresa.com</td>
                <td class="px-4 py-2">Jr. Colón 204</td>
                <td class="px-4 py-2">Proveedor</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Botones -->
        <div class="flex justify-center gap-4 mt-6">
          <button class="bg-indigo-700 text-white px-6 py-2 rounded-md text-sm font-semibold hover:bg-indigo-800">+ Agregar</button>
          <button class="bg-gray-300 text-black px-6 py-2 rounded-md text-sm font-semibold hover:bg-gray-400">Editar</button>
          <button class="bg-indigo-700 text-white px-6 py-2 rounded-md text-sm font-semibold hover:bg-indigo-800">Eliminar</button>
        </div>
      </div>
    </div>
  </body>

  </html>