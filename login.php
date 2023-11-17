<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

$email = $_POST["email"];
$contraseña = $_POST["contraseña"];

$resultado = mysqli_query($conexion, "SELECT *
                                    FROM usuarios
                                    WHERE correo = '$email';");

if (mysqli_num_rows($resultado) == 0) {
    $resultado = mysqli_query($conexion, "SELECT *
                                        FROM admin
                                        WHERE correo = '$email';");

    if (mysqli_num_rows($resultado) == 0) {
        $error = "El correo electrónico o la contraseña que has introducido son incorrectos. Por favor, comprueba tus datos e intentalo de nuevo.";
        mysqli_close($conexion);
        header("Location: index.php?error=" . $error);
    } else {
        $admin = mysqli_fetch_assoc($resultado);

        if (password_verify($contraseña, $admin["contraseña"])) {
            $_SESSION["admin"] = $admin;
            mysqli_close($conexion);
            header("Location: inicioAdmin.php");
        } else {
            $error = "El correo electrónico o la contraseña que has introducido son incorrectos. Por favor, comprueba tus datos e inténtalo de nuevo.";
            mysqli_close($conexion);
            header("Location: index.php?error=" . $error);
            die();
        }
    }
} else {
    $usuario = mysqli_fetch_assoc($resultado);

    if (password_verify($contraseña, $usuario["contraseña"])) {
        // Verificar la fecha de vencimiento
        if ($usuario["vencimiento_verificado"] !== null) {
            $fechaActual = date("Y-m-d");
            if ($usuario["vencimiento_verificado"] < $fechaActual) {
                // Actualizar el estado a 0
                mysqli_query($conexion, "UPDATE usuarios SET estado = 0 WHERE correo = '$email';");
            }
        }

        $_SESSION["usuario"] = $usuario;
        mysqli_close($conexion);
        header("Location: index.php");
    } else {
        $error = "El correo electrónico o la contraseña que has introducido son incorrectos. Por favor, comprueba tus datos e inténtalo de nuevo.";
        mysqli_close($conexion);
        header("Location: index.php?error=" . $error);
        die();
    }
}
?>
