<?php
$conn = mysqli_connect("localhost", "root", "", "trabajo integrador");

if ($conn) {
    if (isset($_GET['id'])) {
        $userId = mysqli_real_escape_string($conn, $_GET['id']);

        // Obtén la fecha actual
        $fechaActual = date('Y-m-d');

        // Calcula la fecha de vencimiento sumándole un año a la fecha actual
        $vencimientoVerificado = date('Y-m-d', strtotime($fechaActual . ' + 1 year'));

        // Actualiza el campo 'verificado' y 'vencimiento_verificado' en la tabla usuarios
        $updateUsuariosQuery = "UPDATE usuarios SET verificado = 1, vencimiento_verificado = '$vencimientoVerificado' WHERE id = $userId";

        // Actualiza el campo 'estado' en la tabla usuario_x_documento
        $updateDocumentosQuery = "UPDATE usuario_x_documento SET estado = 1 WHERE usuario_id = $userId";

        if (mysqli_query($conn, $updateUsuariosQuery) && mysqli_query($conn, $updateDocumentosQuery)) {
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
