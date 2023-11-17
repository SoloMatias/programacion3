<?php
session_start();
// Conectarse a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");
extract($_POST);
$id_user=$_SESSION['usuario']['id'];
if($_SESSION['usuario']['verificado']==0){
	$fechaActual = date('Y-m-d');	
	// Guardamos los datos del pedido de alquiler en la base de datos
    $sql = "INSERT INTO pedidos_alquiler (id_oferta, id_usuario, fecha_ini, fecha_fin, cupo,total,fecha_pedido)
                VALUES
                ('$id_Oferta', '$id_user', '$fechaIni', '$fechaFin', '$cupo','$total','$fechaActual');";
    $conexion->query($sql);
	$conexion->close();
	$mensaje="se ha registrado su pedido de alquiler porfavor espere la respuesta del anfitrion";
	// Redireccionar al usuario a la página principal
    header("Location: publicacion.php?id_publicacion=" . $id_Oferta . "&mensaje=" . urlencode($mensaje));
}
else{	
	// Guardamos los datos del alquiler en la base de datos
    $sql = "INSERT INTO usuarios_toman_alquileres (id_oferta, id_usuario, fecha_ini, fecha_fin, cupo,total)
                VALUES
                ('$id_Oferta', '$id_user', '$fechaIni', '$fechaFin', '$cupo','$total');";
    $conexion->query($sql);
	$conexion->close();
	$mensaje="se ha registrado su alquiler existosamente";
	// Redireccionar al usuario a la página principal
    header("Location: publicacion.php?id_publicacion=" . $id_Oferta . "&mensaje=" . urlencode($mensaje));
}
?>