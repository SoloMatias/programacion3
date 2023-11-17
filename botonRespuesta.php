<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "trabajo integrador");
if (mysqli_connect_errno()) {
    echo "Error al conectarse a la base de datos: " . mysqli_connect_error();
    exit();
}

// Obtiene los datos del formulario
$oferta_id = $_GET['id_publicacion'];
$usuario_id = $_GET['usuario_id'];
$respuesta = $_POST['Respuesta'];

// Verifica si ya existe una reseña para la oferta y usuario específicos
$sql_verificar = "SELECT * FROM reseña_alquileres WHERE oferta_id = '$oferta_id' AND usuario_id = '$usuario_id'";
$resultado_verificar = $conn->query($sql_verificar);

if ($resultado_verificar->num_rows > 0) {
    // Si ya existe una reseña, actualiza el campo respuesta
    $sql_update = "UPDATE reseña_alquileres SET respuesta = '$respuesta' WHERE oferta_id = '$oferta_id' AND usuario_id = '$usuario_id'";
    $conn->query($sql_update);
} else {
    // Puedes manejar esto según tus requisitos, por ejemplo, mostrar un mensaje de error    
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
header("Location: publicacion.php?id_publicacion=" . $oferta_id); // Redirige a la página de verificación de ofertas
?>
