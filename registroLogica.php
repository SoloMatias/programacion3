<?php
//iniciar sesion
session_start();
// Conectarse a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");
// Verificar si el formulario se envió correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener los datos del formulario
  extract($_POST);
  //$nombre = $_POST["nombre"];  $apellido = $_POST["apellido"];  $correo = $_POST['correo'];  $contraseña = $_POST["contraseña"];  $intereses = $_POST["intereses"];$verificado = isset($_POST["verificado"]) ? 1 : 0;  $bio=$_POST["bio"];
  $hash = password_hash($contraseña, PASSWORD_BCRYPT);
  $archivo = $_FILES['foto'];      
	// Comprobamos si el archivo es válido
	if ($archivo['error'] == UPLOAD_ERR_OK) {    
    // Obtenemos el nombre del archivo temporal
    $nombre_temporal = $archivo['tmp_name'];
    // Guardamos los datos del usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, apellido, correo, contraseña, verificado, bio)
                VALUES
                ('$nombre', '$apellido', '$correo', '$hash', 0, '$bio');";
    $conexion->query($sql);	
    // Obtenemos el ID del usuario	
	$usuario_id = mysqli_insert_id($conexion); 		
	$rutaFotoPerfilActual= 'imagenesPerfil/' . $usuario_id .'_foto.jpg';	
    // Movemos el archivo al servidor
    move_uploaded_file($nombre_temporal,$rutaFotoPerfilActual);
    // Obtenemos la ruta del archivo de la imagen de perfil
    $foto = 'imagenesPerfil/' . $usuario_id.'_foto.jpg';
    // Insertar el registro en la tabla imagenes_perfil
    $sql = "INSERT INTO imagenes_perfil (usuario_id, foto)
                VALUES
                ('$usuario_id', '$foto');";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
	// Procesar las etiquetas seleccionadas
	if (isset($_POST['etiquetas'])) {
    // Si 'etiquetas' es una cadena de texto, conviértela en un arreglo
    $etiquetas = is_array($_POST['etiquetas']) ? $_POST['etiquetas'] : array($_POST['etiquetas']);

    foreach ($etiquetas as $etiquetaId) {
        // Inserta la relación en la tabla etiquetas_x_alquileres
        $query = "INSERT INTO usuarios_x_etiquetas (usuario_id , id_etiquetas ) VALUES ('$usuario_id', '$etiquetaId')";
        mysqli_query($conexion, $query);
    }
}

    // Redireccionar al usuario a la página principal
    header("Location: inicio.php");
  } 
  else {
    // Mostramos un error
    echo "El archivo no es válido";
  }
  
}
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
