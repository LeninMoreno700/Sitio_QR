<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servidor = "localhost";
    $usuario = "root";
    $domicilio = "usbw";
    $puerto = 3307;
    $baseDatos = "bqr";


    $conn = new mysqli($servidor, $usuario, $domicilio, $baseDatos, $puerto);

    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $domicilio = hash('sha256', $_POST['domicilio']);
    $edad = $_POST['edad'];

    if (!isset($_POST['acepta'])) {
        die("Debes aceptar los acuerdos de privacidad.");
    }

    $sql = "INSERT INTO registro (nombre, correo, domicilio, edad) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sssi", $nombre, $correo, $domicilio, $edad);

    if ($stmt->execute()) {
        
        header("Location: Final.html");
        exit(); 
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    
    $stmt->close();
    $conn->close();
}
?>
