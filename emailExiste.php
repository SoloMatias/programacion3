<?php
// Conectarse a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");
//recuperar email
$correo = $_POST["correo"];
//iniciar sesion
session_start();
// Validar que el correo electrónico no esté registrado
  $resultado = mysqli_query($conexion, "SELECT *
                                    FROM usuarios
                                    WHERE correo = '$correo';");

  if (mysqli_num_rows($resultado) > 0) {
    $error = "Este correo electrónico ya está registrado";	
	header("Location: validarEmail.php?error=".$error);
  }
  else{
	  $_SESSION['email']=$correo;
	  header("location: registro.php");
  }
  
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>