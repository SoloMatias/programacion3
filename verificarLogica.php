<?php
session_start();

// Establecer la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

// Verificar la conexión
if (mysqli_connect_error()) {
    die("Conexión a la base de datos fallida: " . mysqli_connect_error());
}

$usuario_id = $_SESSION['usuario']['id'];
$archivo = $_FILES['foto'];

// Comprobamos si el archivo es válido
if ($archivo['error'] == UPLOAD_ERR_OK) {
    // Obtenemos el nombre del archivo temporal
    $nombre_temporal = $archivo['tmp_name'];
    $rutaFotoPerfilActual = 'documento/' . $usuario_id . '_dni.jpg';
    
    // Verificar si el registro ya existe en la tabla
    $consulta_existencia = "SELECT * FROM usuario_x_documento WHERE usuario_id = ?";
    $stmt_existencia = $conexion->prepare($consulta_existencia);
    $stmt_existencia->bind_param('i', $usuario_id);
    $stmt_existencia->execute();
    $resultado_existencia = $stmt_existencia->get_result();

    if ($resultado_existencia->num_rows > 0) {
        // Si ya existe, actualizamos el archivo/foto/dni
        move_uploaded_file($nombre_temporal, $rutaFotoPerfilActual);

        // Actualizamos la ruta del archivo en la base de datos
        $actualizar_archivo = "UPDATE usuario_x_documento SET archivo = ?, estado = 0 WHERE usuario_id = ?";
        $stmt_actualizar = $conexion->prepare($actualizar_archivo);
        $stmt_actualizar->bind_param('si', $rutaFotoPerfilActual, $usuario_id);
        $stmt_actualizar->execute();
    } else {
        // Si no existe, insertamos un nuevo registro
        move_uploaded_file($nombre_temporal, $rutaFotoPerfilActual);
        $foto = 'documento/' . $usuario_id . '_dni.jpg';

        $insertar_archivo = "INSERT INTO usuario_x_documento (usuario_id, archivo) VALUES (?, ?)";
        $stmt_insertar = $conexion->prepare($insertar_archivo);
        $stmt_insertar->bind_param('is', $usuario_id, $foto);
        $stmt_insertar->execute();
    }

    echo "<script>alert('Subida de documentación exitosa');</script>";
    // Redirigir a una página de éxito o mostrar un mensaje de éxito
    header("Location:perfil.php?id=" . $usuario_id);
} else {
    // Mostramos un error si el archivo no es válido
    echo "El archivo no es válido";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
