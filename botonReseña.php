<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "trabajo integrador");
if (mysqli_connect_errno()) {
    echo "Error al conectarse a la base de datos: " . mysqli_connect_error();
    exit();
}

// Obtiene los datos del formulario
$oferta_id = $_GET['id_publicacion'];
$usuario_id = $_SESSION['usuario']['id'];
$puntaje = isset($_POST['puntaje']) ? $_POST['puntaje'] : 1;
$comentario = $_POST['comentario'];

// Verifica si ya existe una reseña para la oferta y usuario específicos
$sql_verificar = "SELECT * FROM reseña_alquileres WHERE oferta_id = '$oferta_id' AND usuario_id = '$usuario_id'";
$resultado_verificar = $conn->query($sql_verificar);

if ($resultado_verificar->num_rows > 0) {
    // Si ya existe una reseña, actualiza los campos puntaje y comentario
    $sql_update = "UPDATE reseña_alquileres SET calificacion = '$puntaje', comentario = '$comentario' WHERE oferta_id = '$oferta_id' AND usuario_id = '$usuario_id'";
    $conn->query($sql_update);
} else {
    // Si no existe una reseña, inserta una nueva
    $sql_insert = "INSERT INTO reseña_alquileres (oferta_id, calificacion, comentario, usuario_id) VALUES ('$oferta_id', '$puntaje', '$comentario', '$usuario_id')";
    $conn->query($sql_insert);
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
header("Location: publicacion.php?id_publicacion=" . $oferta_id); // Redirige a la página de verificación de ofertas
?>
