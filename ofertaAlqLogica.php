<?php
session_start();
// Establecer la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

// Verificar la conexión
if (mysqli_connect_error()) {
    die("Conexión a la base de datos fallida: " . mysqli_connect_error());
}

// Recibir los datos del formulario
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$provincia = $_POST['provincia'];
$dept = $_POST['dept'];
$costo = $_POST['costo'];
$tiempoMinimo = $_POST['tiempoMinimo'];
$tiempoMaximo = $_POST['tiempoMaximo'];
$cupo=$_POST['cupo'];
$user_id=$_SESSION['usuario']['id'];
// Las fechas de inicio y fin son opcionales, así que verifica si se proporcionaron
if (empty($_POST['fechaInicio'])) {
    $fechaInicio = "NULL";
} else {
    $fechaInicio = "'" . $_POST['fechaInicio'] . "'";
}

if (empty($_POST['fechaFin'])) {
    $fechaFin = "NULL";
} else {
    $fechaFin = "'" . $_POST['fechaFin'] . "'";
}

// Subir imágenes
$archivos = $_FILES['fotos'];
$archivos_subidos = array();

foreach ($archivos['tmp_name'] as $key => $tmp_name) {
    $nombre_archivo = $archivos['name'][$key];
    $tmp_name = $archivos['tmp_name'][$key];

    $ruta_destino = 'galeria/' . $nombre_archivo;

    if (move_uploaded_file($tmp_name, $ruta_destino)) {
        $archivos_subidos[] = $ruta_destino;
    }
}
if($_SESSION['usuario']['verificado']){
	// Insertar datos en la tabla oferta_alquileres estado =1
	$query = "INSERT INTO oferta_alquileres (titulo, descripcion, provincia, departamento, costo, tiempoMinimo, tiempoMaximo, cupo, fechaInicio, fechaFin, estado, usuario_id)
	VALUES ('$titulo', '$descripcion', '$provincia', '$dept', '$costo', '$tiempoMinimo', '$tiempoMaximo', '$cupo', $fechaInicio, $fechaFin, 1, '$user_id')";
	$conexion->query($query);
}else{
	$sql=mysqli_query($conexion,"select * from oferta_alquileres where usuario_id='$user_id';");
	if (mysqli_num_rows($sql) == 0) {
	// Insertar datos en la tabla oferta_alquileres estado=0
	$query = "INSERT INTO oferta_alquileres (titulo, descripcion, provincia, departamento, costo, tiempoMinimo, tiempoMaximo, cupo, fechaInicio, fechaFin, estado, usuario_id)
	VALUES ('$titulo', '$descripcion', '$provincia', '$dept', '$costo', '$tiempoMinimo', '$tiempoMaximo', '$cupo', $fechaInicio, $fechaFin, 0,'$user_id')";
	$conexion->query($query);
	}else{echo "<script>alert('Los usuario no verificados solo pueden tener 1 publicacion');</script>";header("Location: inicio.php");die();}
}	
    // Obtener el ID de la última inserción
    $ofertaId = mysqli_insert_id($conexion);
    // Procesar las etiquetas seleccionadas
	if (isset($_POST['etiquetas'])) {
    // Si 'etiquetas' es una cadena de texto, conviértela en un arreglo
    $etiquetas = is_array($_POST['etiquetas']) ? $_POST['etiquetas'] : array($_POST['etiquetas']);

    foreach ($etiquetas as $etiquetaId) {
        // Inserta la relación en la tabla etiquetas_x_alquileres
        $query = "INSERT INTO etiquetas_x_alquileres (id_oferta , id_etiqueta ) VALUES ('$ofertaId', '$etiquetaId')";
        mysqli_query($conexion, $query);
    }
}
    // Procesar los servicios seleccionados
    if (isset($_POST['servicios'])) {
    // Si 'servicios' es una cadena de texto, conviértela en un arreglo
    $servicios = is_array($_POST['servicios']) ? $_POST['servicios'] : array($_POST['servicios']);

    foreach ($servicios as $servicioId) {
        // Inserta la relación en la tabla servicios_x_alquileres
        $query = "INSERT INTO servicios_x_alquileres (id_oferta , id_servicios ) VALUES ('$ofertaId', '$servicioId')";
        mysqli_query($conexion, $query);
    }
}
	// Procesar las imágenes subidas
    foreach ($archivos_subidos as $ruta_imagen) {
        $query = "INSERT INTO galeria (id_alquiler , foto) VALUES ($ofertaId , '$ruta_imagen')";
        mysqli_query($conexion, $query);
    }
    // Redirigir a una página de éxito o mostrar un mensaje de éxito
    echo "<script>alert('Los datos se han guardado correctamente');</script>";
	header("Location: inicio.php");

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
