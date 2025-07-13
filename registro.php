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

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "fuentesodamichel_boticassaludbienestar";
    $password = "proyectobotica";
    $dbname = "fuentesodamichel_boticassaludbienestar";

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      if (!preg_match('/^N\d{5}$/', $_POST['codigo'])) {
        $error_message = "El código debe tener el formato N seguido de 5 dígitos (ejemplo: N00001)";
      } else {
        $stmt = $conn->prepare("SELECT codigo FROM productos WHERE codigo = :codigo");
        $stmt->bindParam(':codigo', $_POST['codigo']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
          $stmt = $conn->query("SELECT MAX(codigo) as ultimo_codigo FROM productos");
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $ultimoCodigo = $result['ultimo_codigo'];
          $numero = intval(substr($ultimoCodigo, 1));
          $siguienteCodigo = 'N' . str_pad($numero + 1, 5, '0', STR_PAD_LEFT);
          $error_message = "El código ya existe. El siguiente código disponible es: $siguienteCodigo";
        } else {
          $stmt = $conn->query("SELECT MAX(codigo) as ultimo_codigo FROM productos");
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $ultimoCodigo = $result['ultimo_codigo'] ?? 'N00000';
          $numeroUltimo = intval(substr($ultimoCodigo, 1));
          $numeroNuevo = intval(substr($_POST['codigo'], 1));

          if ($numeroNuevo !== $numeroUltimo + 1) {
            $siguienteCorrecto = 'N' . str_pad($numeroUltimo + 1, 5, '0', STR_PAD_LEFT);
            $error_message = "El código debe ser correlativo. El siguiente código debería ser: $siguienteCorrecto";
          } else {
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
          }
        }
      }
    } catch (PDOException $e) {
      $error_message = "Error: " . $e->getMessage();
    }
  }
  ?>

  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrar Nuevo Producto</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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

  <body class="flex flex-col  min-h-screen bg-gradient-to-bl from-[#505b96] to-[#1d2332]">

    <div class="w-full flex justify-end ">
      <div class="flex justify-center items-center gap-3 p-4">
        <a href="inventario.php" class="flex justify-center pr-2 items-center">
          <button>
            <img src="imagenes/Retroceder.png" alt="Retroceder" class="w-5 h-5 transition-all duration-200 hover:scale-130 group-hover:brightness-75 ">
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

    <div class="flex justify-center mt-6 items-center">
      <div class="bg-white  shadow-lg rounded-lg px-[5rem] py-[4rem] w-full max-w-[43rem] ">
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
            <label for="codigo" class="block text-sm font-medium text-gray-700">Codigo</label>
            <input type="text" id="codigo" name="codigo"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300" required />
            <p id="codigoError" class="hidden text-red-500 text-xs mt-1"></p>
          </div>
          <script>
            async function obtenerSiguienteCodigo() {
              try {
                const response = await fetch('obtener_ultimo_codigo.php');
                const data = await response.json();

                if (data.ultimoCodigo) {
                  const numero = parseInt(data.ultimoCodigo.substring(1)) + 1;
                  const siguienteCodigo = 'N' + numero.toString().padStart(5, '0');
                  document.getElementById('codigo').value = siguienteCodigo;
                } else {
                  document.getElementById('codigo').value = 'N00001';
                }
              } catch (error) {
                console.error('Error al obtener el último código:', error);
              }
            }
            window.addEventListener('DOMContentLoaded', obtenerSiguienteCodigo);
            document.getElementById('codigo').addEventListener('blur', async function() {
              const codigoInput = this.value.trim();
              const errorElement = document.getElementById('codigoError');

              if (!/^N\d{5}$/.test(codigoInput)) {
                errorElement.textContent = "Formato incorrecto. Debe ser N seguido de 5 dígitos (ej: N00001)";
                errorElement.classList.remove('hidden');
                return;
              }

              try {
                const response = await fetch(`verificar_codigo.php?codigo=${encodeURIComponent(codigoInput)}`);
                const data = await response.json();

                if (data.existe) {
                  const nextResponse = await fetch('obtener_ultimo_codigo.php');
                  const nextData = await nextResponse.json();
                  const numero = parseInt(nextData.ultimoCodigo.substring(1)) + 1;
                  const siguienteCodigo = 'N' + numero.toString().padStart(5, '0');
                  errorElement.textContent = `El código ya existe. El siguiente código disponible es: ${siguienteCodigo}`;
                  errorElement.classList.remove('hidden');
                } else {
                  errorElement.classList.add('hidden');
                }
              } catch (error) {
                console.error('Error al verificar código:', error);
              }
            });
          </script>

          <div>
            <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">Fecha de Vencimiento</label>
            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300"
              min="<?php echo date('Y-m-d'); ?>" required />
          </div>

          <div>
            <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
            <input
              type="number"
              id="cantidad"
              name="cantidad"
              min="1"
              max="5000"
              oninput="validarEntero(this)"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300" required />
            <p id="cantidadError" class="hidden text-red-500 text-xs mt-1">La cantidad debe ser entre 1 y 5000 unidades.</p>
          </div>

          <div>
            <label for="proveedor" class="block text-sm font-medium text-gray-700">Proveedor</label>
            <input type="text" id="proveedor" name="proveedor"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300" required />
          </div>

          <div>
            <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
            <input
              type="number"
              id="precio"
              name="precio"
              step="0.01"
              min="0.01"
              max="1000.00"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 text-sm focus:ring focus:ring-indigo-300" required />
            <p id="precioError" class="hidden text-red-500 text-xs mt-1">El precio debe ser entre S/0.01 y S/1000.00.</p>
          </div>
          <script>
            function validarEntero(input) {
              const errorElement = document.getElementById('cantidadError');
              if (input.value.includes('.')) {
                input.value = Math.floor(input.value);
                errorElement.textContent = "La cantidad debe ser un número entero.";
                errorElement.classList.remove('hidden');
              } else {
                errorElement.classList.add('hidden');
              }
            }

            document.querySelector('form').addEventListener('submit', function(e) {
              const cantidad = parseFloat(document.getElementById('cantidad').value);
              const precio = parseFloat(document.getElementById('precio').value);
              let hayError = false;

              if (cantidad < 1 || cantidad > 5000 || !Number.isInteger(cantidad)) {
                document.getElementById('cantidadError').textContent = cantidad < 1 ?
                  "La cantidad mínima es 1." :
                  cantidad > 5000 ?
                  "La cantidad máxima es 5000." :
                  "Debe ser un número entero.";
                document.getElementById('cantidadError').classList.remove('hidden');
                hayError = true;
              }

              if (precio < 0.01 || precio > 1000) {
                document.getElementById('precioError').textContent = precio < 0.01 ?
                  "El precio mínimo es S/0.01." :
                  "El precio máximo es S/1000.00.";
                document.getElementById('precioError').classList.remove('hidden');
                hayError = true;
              }

              if (hayError) {
                e.preventDefault();
              }
            });
          </script>
          <div class="flex justify-between mt-6">
            <button type="reset" class="bg-yellow-200 text-gray-700 px-4 py-2 rounded hover:bg-yellow-300 transition">Limpiar</button>
            <button type="submit" class="bg-yellow-200 text-gray-700 px-4 py-2 rounded hover:bg-yellow-300 transition">Finalizar / Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </body>

  </html>