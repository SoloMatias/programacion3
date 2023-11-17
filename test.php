<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inicio de sesión</title>
</head>
<body>
  <h1>Inicio de sesión</h1>

  <form action="login.php" method="POST">
    <input type="email" name="email" placeholder="Correo electrónico">
    <input type="password" name="contraseña" placeholder="Contraseña">
    <input type="submit" value="Iniciar sesión">
  </form>

  <?php
    // Iniciar sesión
    if (isset($_POST["email"]) && isset($_POST["contraseña"])) {

      // Obtener los datos del formulario
      $email = $_POST["email"];
      $contraseña = $_POST["contraseña"];

      // Verificar que el correo electrónico esté registrado
      $conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");
      $resultado = mysqli_query($conexion, "SELECT *
                                    FROM usuarios
                                    WHERE correo = '$email';");
      if (mysqli_num_rows($resultado) == 0) {
        // El correo electrónico no está registrado
        echo "El correo electrónico no está registrado";
      } else {

        // Verificar que la contraseña sea correcta
        $usuario = mysqli_fetch_assoc($resultado);
        if ($usuario["contraseña"] != $contraseña) {
          // La contraseña es incorrecta
          echo "La contraseña es incorrecta";
        } else {

          // Iniciar sesión correctamente
          // Crear una variable de sesión que almacene información sobre el usuario
          $_SESSION["usuario"] = $usuario;

          // Redireccionar al usuario a la página principal
          header("Location: inicio.php");
        }
      }

      mysqli_close($conexion);
    }
  ?>
</body>
</html>
