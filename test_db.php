<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "botica";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "¡Conexión exitosa a la base de datos 'botica'!";
}

// Opcional: Listar tablas
$result = $conn->query("SHOW TABLES LIKE 'usuarios'");
if ($result->num_rows > 0) {
    echo "<br>La tabla 'usuarios' existe.";
} else {
    echo "<br>Error: La tabla 'usuarios' NO existe.";
}
$conn->close();
