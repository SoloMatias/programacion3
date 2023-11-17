<?php
session_start();
// Establecer la conexión a la base de datos (asegúrate de reemplazar los valores con los de tu configuración)
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
echo "<p>hollaaaaa ".$_POST['nombre']."</p>";
$id_usuario = $_SESSION['usuario']['id']; // Asegúrate de tener un campo "id_usuario" en tu formulario
// Modificar una fila en la tabla "usuarios"
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $bio = $_POST['bio'];    
	echo "<p>hollaaaaa tabla usuario</p>";
    $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, apellido=?, correo=?, bio=? WHERE id = ?");
	$stmt->bind_param("ssssi", $nombre, $apellido, $correo, $bio, $id_usuario);
    $stmt->execute();
    $stmt->close();


// Modificar imagenes_perfil
if (isset($_FILES['foto'])) {
    $nuevaFoto = $_FILES['foto']['tmp_name']; // Ruta temporal del archivo cargado    
    $rutaFotoPerfilActual = 'imagenesPerfil/' . $id_usuario . '_foto.jpg'; // Ruta donde se encuentra la foto de perfil actual
    // Sobrescribe la foto de perfil actual con la nueva
    if (move_uploaded_file($nuevaFoto, $rutaFotoPerfilActual)) {
        // Foto de perfil actualizada correctamente    
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    } else {
        echo "Error al actualizar la foto de perfil.";
    }
}
// Procesar las etiquetas seleccionadas
$query = "SELECT id_etiquetas FROM usuarios_x_etiquetas WHERE usuario_id = $id_usuario";
$resultado = mysqli_query($conexion, $query);
$etiquetas_actuales = array();
while ($fila = mysqli_fetch_assoc($resultado)) {
    $etiquetas_actuales[] = $fila['id_etiquetas'];
}
// Obtener las etiquetas enviadas por el formulario
$etiquetas_seleccionadas = isset($_POST['etiquetas']) ? $_POST['etiquetas'] : array();

// Etiquetas que se deben agregar
$etiquetas_agregar = array_diff($etiquetas_seleccionadas, $etiquetas_actuales);

// Etiquetas que se deben eliminar
$etiquetas_eliminar = array_diff($etiquetas_actuales, $etiquetas_seleccionadas);

// Agregar nuevas etiquetas
foreach ($etiquetas_agregar as $etiquetaId) {
    $query = "INSERT INTO usuarios_x_etiquetas (usuario_id, id_etiquetas) VALUES ($id_usuario, $etiquetaId)";
    mysqli_query($conexion, $query);
}

// Eliminar etiquetas que ya no están seleccionadas
foreach ($etiquetas_eliminar as $etiquetaId) {
    $query = "DELETE FROM usuarios_x_etiquetas WHERE usuario_id = $id_usuario AND id_etiquetas = $etiquetaId";
    mysqli_query($conexion, $query);
}


header("Location: perfil.php?id=".$id_usuario);
exit; // Terminar el script después de la redirección
?>
