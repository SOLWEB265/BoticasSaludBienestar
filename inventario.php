<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "botica";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$categoria = $_GET['categoria'] ?? '';
$busqueda = $_GET['busqueda'] ?? '';

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
      $fecha_mysql = date("Y-m-d", strtotime(str_replace('/', '-', $busqueda)));
      $sql .= " WHERE fecha_vencimiento = '" . $conn->real_escape_string($fecha_mysql) . "'";
      break;
    case 'L Proveedor':
      $sql .= " WHERE proveedor LIKE '%" . $conn->real_escape_string($busqueda) . "%'";
      break;
  }
}

$result = $conn->query($sql);

//  obtener todos los proveedores únicos
$sql_proveedores = "SELECT DISTINCT proveedor FROM productos ORDER BY proveedor";
$result_proveedores = $conn->query($sql_proveedores);
$proveedores = [];
if ($result_proveedores->num_rows > 0) {
  while ($row = $result_proveedores->fetch_assoc()) {
    $proveedores[] = $row['proveedor'];
  }
}


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
  <title>Inventario</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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
  <script>
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

      if (checkboxes.length === 1) {
        btnEditar.disabled = false;
        btnEditar.classList.remove('opacity-50', 'cursor-not-allowed');
        btnEditar.classList.add('cursor-pointer');

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

    function validarYGuardar() {
      const modal = document.getElementById('editModal');
      const stock = parseFloat(modal.querySelector('input[name="stock"]').value);
      const precio = parseFloat(modal.querySelector('input[name="precio"]').value);
      const fechaVencimiento = modal.querySelector('input[name="fecha_vencimiento"]').value;
      let hayError = false;

      // Validar stock
      const stockError = document.getElementById('stockError');
      if (stock < 1 || stock > 5000 || !Number.isInteger(stock)) {
        stockError.textContent = stock < 1 ?
          "La cantidad mínima es 1." :
          stock > 5000 ?
          "La cantidad máxima es 5000." :
          "Debe ser un número entero.";
        stockError.classList.remove('hidden');
        hayError = true;
      } else {
        stockError.classList.add('hidden');
      }

      // Validar precio
      const precioError = document.getElementById('precioError');
      if (precio < 0.01 || precio > 1000) {
        precioError.textContent = precio < 0.01 ?
          "El precio mínimo es S/0.01." :
          "El precio máximo es S/1000.00.";
        precioError.classList.remove('hidden');
        hayError = true;
      } else {
        precioError.classList.add('hidden');
      }

      // Validar fecha de vencimiento
      const hoy = new Date();
      hoy.setHours(0, 0, 0, 0);
      const fechaVenc = new Date(fechaVencimiento);

      if (fechaVenc < hoy) {
        alert("La fecha de vencimiento no puede ser anterior a la fecha actual.");
        hayError = true;
      }

      if (!hayError) {
        guardarCambios();
      }
    }

    // Función para validar que el stock sea entero
    function validarEntero(input) {
      if (input.name === 'stock') {
        const errorElement = document.getElementById('stockError');
        if (input.value.includes('.')) {
          input.value = Math.floor(input.value);
          errorElement.textContent = "La cantidad debe ser un número entero.";
          errorElement.classList.remove('hidden');
        } else {
          errorElement.classList.add('hidden');
        }
      }
    }

    function openEditModal() {
      if (!productoSeleccionado) return;

      const modal = document.getElementById('editModal');
      modal.querySelector('input[name="producto"]').value = productoSeleccionado.producto;
      modal.querySelector('input[name="stock"]').value = productoSeleccionado.stock;
      modal.querySelector('input[name="precio"]').value = productoSeleccionado.precio;

      const selectProveedor = modal.querySelector('select[name="proveedor"]');
      selectProveedor.innerHTML = '';

      proveedores.forEach(proveedor => {
        const option = document.createElement('option');
        option.value = proveedor;
        option.textContent = proveedor;
        option.selected = (proveedor === productoSeleccionado.proveedor);
        selectProveedor.appendChild(option);
      });

      if (!proveedores.includes(productoSeleccionado.proveedor)) {
        const option = document.createElement('option');
        option.value = productoSeleccionado.proveedor;
        option.textContent = productoSeleccionado.proveedor;
        option.selected = true;
        selectProveedor.appendChild(option);
      }

      const [day, month, year] = productoSeleccionado.fecha_vencimiento.split('/');
      const fechaFormatoInput = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
      modal.querySelector('input[name="fecha_vencimiento"]').value = fechaFormatoInput;

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

    window.onclick = function(event) {
      const modal = document.getElementById('editModal');
      if (event.target === modal) {
        closeEditModal();
      }
    }

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
            location.reload();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al eliminar los productos');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', actualizarEstadoBotonEditar);
      });

      document.getElementById('btnEditar').disabled = true;
      document.getElementById('btnEditar').classList.add('opacity-50', 'cursor-not-allowed');
    });

    let categoriaSeleccionada = '';

    function seleccionarCategoria(categoria, event) {
      categoriaSeleccionada = categoria;
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

      const url = new URL(window.location.href);
      url.searchParams.set('categoria', categoriaSeleccionada);
      url.searchParams.set('busqueda', busqueda);

      window.location.href = url.toString();
    }

    function limpiarBusqueda() {
      window.location.href = window.location.pathname;
    }

    document.addEventListener('DOMContentLoaded', function() {
      const urlParams = new URLSearchParams(window.location.search);
      const categoriaURL = urlParams.get('categoria');
      const busquedaURL = urlParams.get('busqueda');

      if (categoriaURL) {
        categoriaSeleccionada = categoriaURL;
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
          <a href="inventario.php" class="hover:underline">INVENTARIO</a>
          <a href="productos.php" class="hover:underline">PRODUCTOS</a>
          <a href="reportes.php" class="hover:underline">REPORTES</a>
        </nav>
      </div>
      <div class="flex items-center gap-3 ">
        <a href="notificacion.php">
          <button>
            <img src="imagenes/Chat.png" alt="Chat" class="w-5 h-5 transition-all duration-200 hover:scale-130 group-hover:brightness-75 ">
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
          <div id="logoutMenu" class="hidden absolute right-0 top-8 w-40 bg-white rounded-md shadow-lg z-10">
            <a href="?logout=true" class="block px-4 py-2 rounded-md text-gray-800 hover:bg-gray-100">Cerrar sesión</a>
          </div>
        </div>
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
            <button onclick="aplicarBusqueda()" class="text-white bg-[#6276B9] flex justify-center items-center h-[23px] p-2 text-[15px] cursor-pointer">Buscar</button>
            <button onclick="limpiarBusqueda()" class="text-white bg-[#6276B9] flex justify-center items-center h-[23px] p-2 text-[15px] cursor-pointer">Limpiar</button>
          </div>
        </div>
      </aside>
      <section class="w-3/4 p-6">
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="border-b font-semibold text-left">
                <th class="px-3 py-2">
                  <input type="checkbox" onclick="toggleCheckboxes(this)" class="form-checkbox cursor-pointer h-5 w-5 text-blue-600" />
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
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $fecha_vencimiento = date("d/m/Y", strtotime($row["fecha_vencimiento"]));

                  echo '<tr class="border-b">';
                  echo '<td class="px-3 py-2"><input type="checkbox" class="form-checkbox cursor-pointer h-5 w-5 text-blue-600 row-checkbox" /></td>';
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
      <div class="flex justify-between items-center pb-3">
        <h3 class="text-[32px] text-center font-semibold text-[#6276B9]">Editar Producto</h3>
        <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

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
            <input type="number" name="stock" min="1" max="5000" oninput="validarEntero(this)" class="mt-1 block p-1 w-full h-[32px] rounded-md border-gray-300 shadow-sm outline-none" required>
            <p id="stockError" class="hidden text-red-500 text-xs mt-1">El stock debe ser entre 1 y 5000 unidades.</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Precio</label>
            <input type="number" step="0.01" name="precio" min="0.01" max="1000.00" class="mt-1 h-[32px] p-1 block w-full rounded-md border-gray-300 shadow-sm outline-none" required>
            <p id="precioError" class="hidden text-red-500 text-xs mt-1">El precio debe ser entre S/0.01 y S/1000.00.</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Proveedor</label>
            <select name="proveedor" class="mt-1 block w-full h-[32px] rounded-md border-gray-300 shadow-sm outline-none" required>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Fecha de Vencimiento</label>
          <input type="date" name="fecha_vencimiento" min="<?php echo date('Y-m-d'); ?>" class="mt-1 p-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
        </div>
      </form>

      <div class="flex justify-end pt-4 space-x-3">
        <button onclick="closeEditModal()" class="px-4 border-[#6276B9] cursor-pointer font-medium text-[#6276B9] border-[2px] py-2 text-sm rounded-md hover:bg-[#6276B9] hover:text-white transition-colors">
          Cancelar
        </button>
        <button onclick="validarYGuardar()" class="px-4 py-2 text-white cursor-pointer font-medium hover:bg-[#4D5F98] text-sm bg-[#6276B9] rounded-md">
          Guardar Cambios
        </button>
      </div>
    </div>
  </div>



</body>

</html>