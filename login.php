<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $correo = $_POST['correo'];
  $contrasena = $_POST['contrasena'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "botica";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
  }

  $sql = "SELECT id, nombre, contrasena FROM usuarios WHERE correo = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $correo);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($contrasena === $row['contrasena']) {
    $_SESSION['loggedin'] = true;
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['nombre'];
    header("Location: interfaz.php");
    exit();
    } else {
      $error = "Contraseña incorrecta.";
    }
  } else {
    $error = "Usuario no encontrado.";
  }
  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Botica Salud y Bienestar</title>
</head>

<body class="h-screen bg-gradient-to-bl from-[#505b96] to-[#1d2332] font-serif">
  <div class="flex items-center justify-center h-full">
    <div class="bg-white pt-30 relative flex justify-center items-center flex-col w-96 p-10 text-center rounded-lg">
      <img src="imagenes/Botica.png" class="w-[152px] absolute -top-15 rounded-full h-[156px] mb-5" alt="Logo Botica" />
      <h1 class="text-xl font-bold mb-1">BOTICA SALUD Y</h1>
      <h1 class="text-xl font-bold mb-5">BIENESTAR</h1>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="correo" placeholder="Correo electrónico o número de teléfono" class="w-full p-3 mb-4 border border-gray-800 rounded" required />
        <input type="password" name="contrasena" placeholder="Contraseña" class="w-full p-3 mb-4 border border-gray-800 rounded" required />
        <?php if (!empty($error)): ?>
          <p class="text-red-500 text-sm mb-4"><?php echo $error; ?></p>
        <?php endif; ?>
        <button type="submit" class="w-full p-3 bg-[#5a82e8] text-white font-bold rounded hover:bg-[#4069c4]">INICIAR SESIÓN</button>
      </form>
      <p class="mt-3 text-sm text-gray-600">¿Has olvidado tu contraseña?</p>
    </div>
  </div>
</body>

</html>