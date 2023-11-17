<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de usuario</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
<body>
  <nav class="navbar navbar-inverse navbar-expand-sm" style="background-color:gray;">
  <div class="container-fluid">
    <a href="index.php"><img src="logo.png" alt="Logo de mi sitio web" style="float: left; margin: 0 10px 0 10px;" 
    width="150px" hiegh="150px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
    data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" 
    aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <form action="index.php" method="post" style="width: 80%;">    
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown" style="margin: 5px 0 5px 30px; width: 100%;">       
			<input class="form-control me-2" type="text" name="busqueda" placeholder="Buscar">
			<button type="submit" class="btn btn-primary">Buscar</button>
		</div>
		</form>
	</div>
      <!-- Código PHP -->
      <?php      
      session_start();	  
	  $_SESSION["email"]=$_SESSION["email"];
  // Si el usuario está logueado
  if (isset($_SESSION["usuario"])) {
    // Cambiar el botón de inicio por un botón desplegable
    echo "<div class='btn-group'>
	<button class='btn btn-primary dropdown-toggle' type='button' data-bs-toggle='dropdown'>
      <span class='caret'></span><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
	<path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/>
	<path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z'/>
    </svg>
	<span><strong>" . $_SESSION['usuario']['nombre'] . "</strong></span>
    </button>
    <ul class='dropdown-menu' role='menu'>
	  <li><a href='perfil.php?id=" . $_SESSION['usuario']['id'] . "'>Perfil</a></li>
	  <li><a href='ofertaAlq.html'>Publicar alquiler</a></li>
      <li><a href='logout.php'>Cerrar sesión</a></li>
    </ul></div>";

    // Ocultar el botón de inicio original
    echo "<button type='button' class='btn btn-primary d-none'>Inicie sesion</button>";
  } else {
    // Mostrar el botón de inicio original
    echo "<button type='button' class='btn btn-primary' onclick='iniciarSesion()'>Inicie secion</button>";
  }
	?>
      <!-- Fin del código PHP -->
    </div>       
  </div>
  </nav>       
  <h1>Formulario de registro de usuarios</h1>

<form action="registroLogica.php" method="POST" enctype="multipart/form-data">

  <div class="form-group">
    <label for="nombre">Nombre:</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required minlength="3" pattern="^[A-Za-z\s]+$">
</div>

  <div class="form-group">
    <label for="apellido">Apellido:</label>
    <input type="text" class="form-control" id="apellido" name="apellido" required minlength="3" pattern="^[A-Za-z\s]+$">
  </div>
<?php
echo "
  <div class='form-group' style='display: none;'>
    <input type='email' class='form-control' id='correo' name='correo' required value=" . $_SESSION['email'] . ">
  </div>";
?>
  <div class="form-group">
    <label for="contraseña">Contraseña:</label>
    <input type="password" class="form-control" id="contraseña" name="contraseña" required minlength="8">
  </div>

  <div class="form-group">
      <label for="intereses">Intereses</label>
      <div class="input-group mb-3 flexbox-container">
		<?php
    // Realiza la conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

    // Verifica la conexión
    if (mysqli_connect_error()) {
      die("Conexión a la base de datos fallida: " . mysqli_connect_error());
    }

    // Realiza una consulta para obtener los etiquetas disponibles
    $query = "SELECT * FROM etiquetas";
    $result = mysqli_query($conexion, $query);

    // Recorre los resultados y crea un checkbox para cada etiquetas
    while ($row = mysqli_fetch_assoc($result)) {
      $idEtiquetas = $row['id'];
      $nombreEtiquetas = $row['nombre'];

      echo '<div class="form-check">';
      echo '<input class="form-check-input" type="checkbox" name="etiquetas[]" id="etiquetas' . $idEtiquetas . '" value="' . $idEtiquetas . '" style="background-color:#1c8adb">';
      echo '<label class="form-check-label" for="etiquetas' . $idEtiquetas . '">' . $nombreEtiquetas . '</label>';
      echo '</div>';
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
    ?>
	  </div>
	</div>

  <div class="form-group">
    <label for="foto">Foto de rostro:</label>
    <input type="file" class="form-control" id="foto" name="foto" required>
  </div>

  <div class="form-group">
    <label for="bio">Biografia: (0pcional)</label>
    <textarea class="form-control" id="bio" name="bio" rows="3"></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Registrar</button>

</form>

<!-- Código del modal de inicio de sesión -->
<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLoginLabel">Iniciar sesión</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="login.php" method="POST">
          <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="contraseña">Contraseña:</label>
            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
          </div>
          <div class="form-group">
            <a href="validarEmail.php">¿No te has registrado todavía?. Quiero registrarme.</a>
          </div>
          <button type="submit" class="btn btn-primary">
Iniciar sesión</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>