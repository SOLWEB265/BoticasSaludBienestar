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

// Obtener parámetros de búsqueda
$categoria = $_GET['categoria'] ?? '';
$busqueda = $_GET['busqueda'] ?? '';

// Consulta base
$sql = "SELECT codigo, producto, stock, precio, proveedor, fecha_vencimiento FROM productos";

if (!empty($busqueda)) {
  switch ($categoria) {
    case 'L Codigo':
      $sql .= " WHERE codigo LIKE '%" . $conn->real_escape_string($busqueda) . "%'";
      break;
    case 'L Producto':
      $sql .= " WHERE producto LIKE '%" . $conn->real_escape_string($busqueda) . "%'";
      break;
    case 'L Stock':
      $sql .= " WHERE stock = " . intval($busqueda);
      break;
    case 'L Fech. Vencim':
      // Convertir fecha de búsqueda a formato MySQL
      $fecha_mysql = date("Y-m-d", strtotime(str_replace('/', '-', $busqueda)));
      $sql .= " WHERE fecha_vencimiento = '" . $conn->real_escape_string($fecha_mysql) . "'";
      break;
    case 'L Proveedor':
      $sql .= " WHERE proveedor LIKE '%" . $conn->real_escape_string($busqueda) . "%'";
      break;
  }
}

$result = $conn->query($sql);

// Consulta para obtener todos los proveedores únicos
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
  <title>Inventario</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script>
    // Variables globales
    let productoSeleccionado = null;
    const botonEditar = document.getElementById('btnEditar');

    function toggleCheckboxes(source) {
      const checkboxes = document.querySelectorAll('.row-checkbox');
      checkboxes.forEach(checkbox => {
        checkbox.checked = source.checked;
      });
      actualizarEstadoBotonEditar();
    }

    function actualizarEstadoBotonEditar() {
      const checkboxes = document.querySelectorAll('.row-checkbox:checked');
      const btnEditar = document.getElementById('btnEditar');

      // Habilitar/deshabilitar botón editar
      if (checkboxes.length === 1) {
        btnEditar.disabled = false;
        btnEditar.classList.remove('opacity-50', 'cursor-not-allowed');
        btnEditar.classList.add('cursor-pointer');

        // Guardar datos del producto seleccionado
        const fila = checkboxes[0].closest('tr');
        productoSeleccionado = {
          codigo: fila.cells[1].textContent,
          producto: fila.cells[2].textContent,
          stock: fila.cells[3].textContent,
          precio: fila.cells[4].textContent,
          proveedor: fila.cells[5].textContent,
          fecha_vencimiento: fila.cells[6].textContent
        };
      } else {
        btnEditar.disabled = true;
        btnEditar.classList.add('opacity-50', 'cursor-not-allowed');
        btnEditar.classList.remove('cursor-pointer');
        productoSeleccionado = null;
      }
    }

    function openEditModal() {
      if (!productoSeleccionado) return;

      const modal = document.getElementById('editModal');
      // Llenar el modal con los datos del producto
      modal.querySelector('input[name="producto"]').value = productoSeleccionado.producto;
      modal.querySelector('input[name="stock"]').value = productoSeleccionado.stock;
      modal.querySelector('input[name="precio"]').value = productoSeleccionado.precio;

      // Seleccionar el proveedor correcto
      const selectProveedor = modal.querySelector('select[name="proveedor"]');
      selectProveedor.innerHTML = ''; // Limpiar opciones existentes

      // Agregar todas las opciones de proveedores
      proveedores.forEach(proveedor => {
        const option = document.createElement('option');
        option.value = proveedor;
        option.textContent = proveedor;
        option.selected = (proveedor === productoSeleccionado.proveedor);
        selectProveedor.appendChild(option);
      });

      // Agregar opción "Otro proveedor" si no está en la lista
      if (!proveedores.includes(productoSeleccionado.proveedor)) {
        const option = document.createElement('option');
        option.value = productoSeleccionado.proveedor;
        option.textContent = productoSeleccionado.proveedor;
        option.selected = true;
        selectProveedor.appendChild(option);
      }

      // Convertir fecha de DD/MM/YYYY a YYYY-MM-DD para el input type="date"
      const [day, month, year] = productoSeleccionado.fecha_vencimiento.split('/');
      const fechaFormatoInput = `${year}-${month}-${day}`;
      modal.querySelector('input[name="fecha_vencimiento"]').value = fechaFormatoInput;

      // Mostrar el modal
      modal.classList.remove('hidden');
    }

    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }

    function guardarCambios() {
      const modal = document.getElementById('editModal');
      const formData = {
        codigo: productoSeleccionado.codigo,
        producto: modal.querySelector('input[name="producto"]').value,
        stock: modal.querySelector('input[name="stock"]').value,
        precio: modal.querySelector('input[name="precio"]').value,
        proveedor: modal.querySelector('select[name="proveedor"]').value,
        fecha_vencimiento: modal.querySelector('input[name="fecha_vencimiento"]').value
      };

      fetch('actualizar_producto.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert(data.message);
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al actualizar el producto');
        });
    }

    // Cerrar modal al hacer clic fuera del contenido
    window.onclick = function(event) {
      const modal = document.getElementById('editModal');
      if (event.target === modal) {
        closeEditModal();
      }
    }

    // Función para eliminar productos seleccionados
    function eliminarProductos() {
      const checkboxes = document.querySelectorAll('.row-checkbox:checked');
      if (checkboxes.length === 0) {
        alert('Por favor seleccione al menos un producto para eliminar');
        return;
      }

      if (!confirm(`¿Está seguro que desea eliminar ${checkboxes.length} producto(s)?`)) {
        return;
      }

      const codigos = Array.from(checkboxes).map(checkbox => {
        return checkbox.closest('tr').querySelector('td:nth-child(2)').textContent;
      });

      // Enviar los códigos al servidor para eliminación
      fetch('eliminar_productos.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            codigos: codigos
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert(data.message);
            location.reload(); // Recargar la página para ver los cambios
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al eliminar los productos');
        });
    }

    // Inicializar eventos después de que el DOM esté cargado
    document.addEventListener('DOMContentLoaded', function() {
      // Agregar evento a todos los checkboxes
      document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', actualizarEstadoBotonEditar);
      });

      // Configurar botón editar inicialmente deshabilitado
      document.getElementById('btnEditar').disabled = true;
      document.getElementById('btnEditar').classList.add('opacity-50', 'cursor-not-allowed');
    });

    // Variables globales
    let categoriaSeleccionada = '';

    function seleccionarCategoria(categoria, event) {
      categoriaSeleccionada = categoria;
      // Resaltar la categoría seleccionada
      document.querySelectorAll('aside ul li').forEach(item => {
        item.classList.remove('text-yellow-600', 'font-semibold');
      });
      event.target.classList.add('text-yellow-600', 'font-semibold');
    }

    function aplicarBusqueda() {
      const busqueda = document.getElementById('inputBusqueda').value;
      if (!categoriaSeleccionada) {
        alert('Por favor seleccione una categoría para filtrar');
        return;
      }

      // Construir URL con parámetros de búsqueda
      const url = new URL(window.location.href);
      url.searchParams.set('categoria', categoriaSeleccionada);
      url.searchParams.set('busqueda', busqueda);

      window.location.href = url.toString();
    }

    function limpiarBusqueda() {
      // Redirigir a la página sin parámetros de búsqueda
      window.location.href = window.location.pathname;
    }

    // Inicializar categoría seleccionada si viene en la URL
    document.addEventListener('DOMContentLoaded', function() {
      const urlParams = new URLSearchParams(window.location.search);
      const categoriaURL = urlParams.get('categoria');
      const busquedaURL = urlParams.get('busqueda');

      if (categoriaURL) {
        categoriaSeleccionada = categoriaURL;
        // Resaltar la categoría seleccionada
        document.querySelectorAll('aside ul li').forEach(item => {
          if (item.textContent === categoriaURL) {
            item.classList.add('text-yellow-600', 'font-semibold');
          }
        });
      }

      if (busquedaURL) {
        document.getElementById('inputBusqueda').value = busquedaURL;
      }
    });
  </script>
  <script>
    // Pasar los proveedores desde PHP a JavaScript
    const proveedores = <?php echo json_encode($proveedores); ?>;
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
        <img src="imagenes/Herramienta.png" alt="Tools" class="w-5 h-5">
        <img src="imagenes/Botica.png" alt="Logo" class="w-10 rounded-full">
      </div>
    </header>
    <div class="flex gap-6 mb-4 pt-6 pl-20 ">
      <a href="registro.php"><button href="registro.html" class="bg-yellow-200 cursor-pointer hover:bg-yellow-300 px-4 py-2 rounded text-sm">Agregar</button></a>
      <button id="btnEditar" onclick="openEditModal()" class="bg-yellow-200 hover:bg-yellow-300 px-4 py-2 rounded text-sm">Editar</button> <button onclick="eliminarProductos()" class="bg-yellow-200 hover:bg-yellow-300 px-4 py-2 rounded cursor-pointer text-sm">Eliminar</button>
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
          <li class="ml-4 cursor-pointer hover:text-yellow-600" onclick="seleccionarCategoria('L Codigo', event)">L Codigo</li>
          <li class="ml-4 cursor-pointer hover:text-yellow-600" onclick="seleccionarCategoria('L Producto', event)">L Producto</li>
          <li class="ml-4 cursor-pointer hover:text-yellow-600" onclick="seleccionarCategoria('L Stock', event)">L Stock</li>
          <li class="ml-4 cursor-pointer hover:text-yellow-600" onclick="seleccionarCategoria('L Fech. Vencim', event)">L Fech. Vencim</li>
          <li class="ml-4 cursor-pointer hover:text-yellow-600" onclick="seleccionarCategoria('L Proveedor',event)">L Proveedor</li>
        </ul>
        <div class="w-full flex gap-2 flex-col mt-2 items-center justify-center">
          <input id="inputBusqueda" class="w-full p-2 h-[23px] rounded-md border-[#6276B9] border-[1px]" />
          <div class="flex justify-between w-full">
            <button onclick="aplicarBusqueda()" class="text-white bg-[#6276B9] flex justify-center items-center h-[23px] p-2 text-[15px]">Buscar</button>
            <button onclick="limpiarBusqueda()" class="text-white bg-[#6276B9] flex justify-center items-center h-[23px] p-2 text-[15px]">Limpiar</button>
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
      <form id="formEditar" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Producto</label>
            <input type="text" name="producto" class="mt-1 p-1 h-[32px] block w-full rounded-md border-gray-300 shadow-sm outline-none">
          </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Stock</label>
            <input type="number" name="stock" class="mt-1 block p-1 w-full h-[32px] rounded-md border-gray-300 shadow-sm outline-none">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Precio</label>
            <input type="number" step="0.01" name="precio" class="mt-1 h-[32px] p-1 block w-full rounded-md border-gray-300 shadow-sm outline-none">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
            <select name="proveedor" class="mt-1 block w-full h-[32px] rounded-md border-gray-300 shadow-sm outline-none">
            </select>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Fecha de Vencimiento</label>
          <input type="date" name="fecha_vencimiento" class="mt-1 p-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
        </div>
      </form>

      <!-- Modal Footer -->
      <div class="flex justify-end pt-4 space-x-3">
        <button onclick="closeEditModal()" class="px-4 border-[#6276B9] cursor-pointer font-medium text-[#6276B9] border-[2px] py-2 text-sm rounded-md hover:bg-[#6276B9] hover:text-white transition-colors">
          Cancelar
        </button>
        <button onclick="guardarCambios()" class="px-4 py-2 text-white cursor-pointer font-medium hover:bg-[#4D5F98] text-sm bg-[#6276B9] rounded-md">
          Guardar Cambios
        </button>
      </div>
    </div>
  </div>
</body>

</html>