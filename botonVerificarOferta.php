<?php
$conn = mysqli_connect("localhost", "root", "", "trabajo integrador");

if ($conn) {
    if (isset($_GET['id'])) {
        $ofertaId = mysqli_real_escape_string($conn, $_GET['id']);

        // Actualiza el campo 'estado' en la tabla oferta_alquiler
        $updateOfertaQuery = "UPDATE oferta_alquileres SET estado = 1 WHERE id = $ofertaId";

        if (mysqli_query($conn, $updateOfertaQuery)) {
            mysqli_close($conn);
            header("Location: verificarPublicacion.php"); // Redirige a la página de verificación de ofertas
            exit;
        } else {
            echo "Error en la actualización.";
        }
    } else {
        echo "ID de oferta no proporcionado.";
    }

    mysqli_close($conn);
} else {
    echo "Error en la conexión a la base de datos.";
}
?>
