<?php
$conn = mysqli_connect("localhost", "root", "", "trabajo integrador");

if ($conn) {
    if (isset($_GET['id'])) {
        $userId = mysqli_real_escape_string($conn, $_GET['id']);

        // Actualiza el campo 'estado' en la tabla usuario_x_documento
        $updateDocumentosQuery = "UPDATE usuario_x_documento SET estado = 2 WHERE usuario_id = $userId";

        if (mysqli_query($conn, $updateDocumentosQuery)) {
            mysqli_close($conn);
            header("Location: verificarUser.php");
            exit;
        } else {
            echo "Error en la actualización.";
        }
    } else {
        echo "ID de usuario no proporcionado.";
    }

    mysqli_close($conn);
} else {
    echo "Error en la conexión a la base de datos.";
}
?>
