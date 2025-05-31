<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventario</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script>
    function toggleCheckboxes(source) {
      const checkboxes = document.querySelectorAll('.row-checkbox');
      checkboxes.forEach(checkbox => {
        checkbox.checked = source.checked;
      });
    }

    function openEditModal() {
      document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }

    // Cerrar modal al hacer clic fuera del contenido
    window.onclick = function(event) {
      const modal = document.getElementById('editModal');
      if (event.target === modal) {
        closeEditModal();
      }
    }
  </script>
</head>

<body class="bg-gradient-to-bl from-[#505b96] to-[#1d2332] min-h-screen font-sans">

  <!-- Main -->
  <main class="bg-white m-6 rounded shadow-lg flex-col flex">
    <header class="flex justify-between items-center bg-white px-6 ">
      <div class="flex items-center gap-2">
        <img src="imagenes/Almacen.png" alt="Icono" class="w-12 h-12 ">
        <nav class="flex gap-6 text-sm font-medium">
          <a href="#" class="hover:underline">INVENTARIO</a>
          <a href="#" class="hover:underline">PRODUCTOS</a>
          <a href="#" class="hover:underline">REPORTES</a>
          <a href="#" class="hover:underline">CONFIGURACION</a>
        </nav>
      </div>
      <div class="flex items-center gap-3 ">
        <a href="notificacion.html">
          <button>
            <img src="imagenes/Chat.png" alt="Chat" class="w-5 h-5 ">
          </button>
        </a>
        <a href="javascript:history.back()">
          <button>
            <img src="imagenes/Retroceder.png" alt="Retroceder" class="w-5 h-5 ">
          </button>
        </a>
        <img src="imagenes/Herramienta.png" alt="Tools" class="w-5 h-5">
        <img src="imagenes/Botica.png" alt="Logo" class="w-10 rounded-full">
      </div>
    </header>
    <div class="flex gap-6 mb-4 pt-6 pl-20 ">
      <a href="registro.html"><button href="registro.html" class="bg-yellow-200 cursor-pointer hover:bg-yellow-300 px-4 py-2 rounded text-sm">Agregar</button></a>
      <button onclick="openEditModal()" class="bg-yellow-200 hover:bg-yellow-300 cursor-pointer px-4 py-2 rounded text-sm">Editar</button>
      <button class="bg-yellow-200 hover:bg-yellow-300 px-4 py-2 rounded cursor-pointer text-sm">Eliminar</button>
    </div>
    <div class="border-b-[3px]">
    </div>
    <!-- Filtro -->
    <div class="w-full flex">
      <aside class="w-1/8 border-r p-4 text-sm">
        <div class="flex items-center gap-1 font-semibold text-yellow-600">
          <span>📁</span> <span>Filtro</span>
        </div>
        <ul class="mt-2 ml-4">
          <li class="mb-1">Todo</li>
          <li class="ml-4">L Codigo</li>
          <li class="ml-4">L Producto</li>
          <li class="ml-4">L Stock</li>
          <li class="ml-4">L Fech. Vencim</li>
          <li class="ml-4">L Proveedor</li>
        </ul>
        <div class="w-full flex gap-2 flex-col mt-2 items-center justify-center">
          <input class="w-full h-[23px] rounded-md border-[#6276B9] border-[1px]" />
          <div class="flex justify-between w-full">
            <button class="text-white bg-[#6276B9] flex justify-center items-center h-[23px] p-2 text-[15px]">Buscar</button>
            <button class="text-white bg-[#6276B9] flex justify-center items-center h-[23px] p-2 text-[15px]">Limpiar</button>
          </div>
        </div>
      </aside>
      <!-- Contenido -->
      <section class="w-3/4 p-6">
        <!-- Tabla -->
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="border-b font-semibold text-left">
                <th class="px-3 py-2">
                  <input type="checkbox" onclick="toggleCheckboxes(this)" class="form-checkbox h-5 w-5 text-blue-600" />
                </th>
                <th class="px-3 py-2">Codigo</th>
                <th class="px-3 py-2">Producto</th>
                <th class="px-3 py-2">Stock</th>
                <th class="px-3 py-2">Precio</th>
                <th class="px-3 py-2">Proveedor</th>
                <th class="px-3 py-2">Fech. Vencimiento</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Conexión a la base de datos
              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "botica";

              $conn = new mysqli($servername, $username, $password, $dbname);

              if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
              }

              // Consulta para obtener los productos
              $sql = "SELECT codigo, producto, stock, precio, proveedor, fecha_vencimiento FROM productos";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  // Formatear fecha de vencimiento (de YYYY-MM-DD a DD/MM/YYYY)
                  $fecha_vencimiento = date("d/m/Y", strtotime($row["fecha_vencimiento"]));

                  echo '<tr class="border-b">';
                  echo '<td class="px-3 py-2"><input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 row-checkbox" /></td>';
                  echo '<td class="px-3 py-2">' . $row["codigo"] . '</td>';
                  echo '<td class="px-3 py-2">' . $row["producto"] . '</td>';
                  echo '<td class="px-3 py-2">' . $row["stock"] . '</td>';
                  echo '<td class="px-3 py-2">' . number_format($row["precio"], 2) . '</td>';
                  echo '<td class="px-3 py-2">' . $row["proveedor"] . '</td>';
                  echo '<td class="px-3 py-2">' . $fecha_vencimiento . '</td>';
                  echo '</tr>';
                }
              } else {
                echo '<tr><td colspan="7" class="px-3 py-2 text-center">No hay productos registrados</td></tr>';
              }
              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </main>

  <!-- El resto de tu código (modal, etc.) permanece igual -->
  <div id="editModal" class="hidden fixed inset-0 bg-black/75 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-1/2 shadow-lg rounded-md bg-white">
      <!-- Modal Header -->
      <div class="flex justify-between items-center pb-3">
        <h3 class="text-[32px] text-center font-semibold text-[#6276B9]">Editar Producto</h3>
        <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Modal Body - Formulario -->
      <form class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Producto</label>
            <input type="text" class="mt-1 p-1  h-[32px] block w-full rounded-md border-gray-300 shadow-sm outline-none " value="Paracetamol">
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Stock</label>
            <input type="number" class="mt-1 block p-1 w-full  h-[32px] rounded-md border-gray-300 shadow-sm outline-none " value="50">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Precio</label>
            <input type="number" step="0.01" class="mt-1  h-[32px] p-1 block w-full rounded-md border-gray-300 shadow-sm outline-none" value="1.20">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
            <select class="mt-1 block w-full h-[32px] rounded-md border-gray-300 shadow-sm outline-none">
              <option>Drogueria Dicar</option>
              <option>Drogueria Cobefar</option>
              <option>Otro proveedor</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Fecha de Vencimiento</label>
          <input type="date" class="mt-1 p-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" value="2026-06-25">
        </div>
      </form>

      <!-- Modal Footer -->
      <div class="flex justify-end pt-4 space-x-3">
        <button
          onclick="closeEditModal()"
          class="px-4 border-[#6276B9] cursor-pointer font-medium text-[#6276B9] border-[2px] py-2 text-sm rounded-md hover:bg-[#6276B9] hover:text-white transition-colors">
          Cancelar
        </button>
        <button class="px-4 py-2 text-white cursor-pointer font-medium hover:bg-[#4D5F98] text-sm bg-[#6276B9] rounded-md">
          Guardar Cambios
        </button>
      </div>
    </div>
  </div>
</body>

</html>