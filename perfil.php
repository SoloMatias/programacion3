<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
  function iniciarSesion() {    
    // Abre el modal de inicio de sesión
    $("#modalLogin").modal("show");
    }
  </script>    
  </head>
  <body>
  <?php session_start();?>
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
      <form action="index.php" method="post" class="d-flex" style="width:70%;">
        <div class="input-group">
          <input class="form-control" type="text" name="busqueda" placeholder="Buscar">
          <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
      </form>

      <div class="navbar-nav ml-auto">
        <?php if (isset($_SESSION['usuario'])) { ?>
          <a href="Recomendados.php" class="btn btn-primary">Recomendados</a>
        <?php } ?>

        <!-- Código PHP -->
      <?php         
	  // Si el usuario está logueado
	  if (isset($_SESSION["usuario"])) {
		// Cambiar el botón de inicio por un botón desplegable
		echo "<div class='btn-group' >
		<button class='btn btn-primary dropdown-toggle' type='button' data-bs-toggle='dropdown'>
		  <span class='caret'></span><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
		<path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/>
		<path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z'/>
		</svg>
		<span><strong>" . $_SESSION['usuario']['nombre'] . "</strong></span>
		</button>
		<ul class='dropdown-menu' role='menu'>
		  <li><a href='perfil.php?id=" . $_SESSION['usuario']['id'] . "'>Perfil</a></li>
		  <li><a href='ofertaAlq.php'>Publicar alquiler</a></li>
		  <li><a href='comprobarPedidos.php'>Ver pedidos de alquileres</a></li>
		  <li><a href='logout.php'>Cerrar sesión</a></li>
		</ul></div>";

		// Ocultar el botón de inicio original
		echo "<button type='button' class='btn btn-primary d-none'>Inicie sesión</button>";
	  } else {
		// Mostrar el botón de inicio original
		echo "<div class='btn-group' style='margin: 5px 0 5px 30px;'>";
		echo "<button type='button' id='iniB' class='btn btn-primary' onclick='iniciarSesion()'>Inicie sesión</button>";
		echo "</div>";
	  }  
	  if(isset($_GET['error'])){ if(isset($_GET['error'])) {
	  echo '<script>$(document).ready(function() { iniciarSesion(); });</script>';
	} }
	?>	
      <!-- Fin del código PHP -->
    </div>       
  </div>
  </nav>

<?php
// Obtén el ID del usuario desde $_GET
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];
} else {
    // Maneja el caso en que no se proporciona un ID válido en la URL
    // Puedes mostrar un mensaje de error o redirigir a otra página
    die("ID de usuario no válido.");
}

// Compara el ID del usuario actual con el ID en la URL
if ($_SESSION['usuario']['id'] == $idUsuario) {
    // Establece la conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

    // Consulta SQL para obtener la imagen del usuario
    $sql = "SELECT foto FROM imagenes_perfil WHERE usuario_id = " . $idUsuario;
    $result = $conexion->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Obtener la fila resultante
        $perfil = $result->fetch_assoc();        
    }
	// Consulta SQL para obtener la imagen del usuario
    $sql = "SELECT * FROM usuarios WHERE id = " . $idUsuario;
    $result = $conexion->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Obtener la fila resultante
        $user = $result->fetch_assoc();

        // Cerrar la conexión a la base de datos
        $conexion->close();
    }

    // HTML y formulario
    echo '<div class="container">';
    echo '<h1 class="text-center">Perfil de ' . $user['nombre'] . '</h1>';
    echo '<form action="modificarPerfilLogica.php" method="POST" enctype="multipart/form-data">';
    echo '<div class="row">';
    echo '<div class="col-md-3 offset-md-0">';
    echo '<div class="text-center">';
    echo '<span class="caret"></span>';    
    // Mostrar la imagen del perfil
    if (isset($perfil['foto'])) {
        echo '<img src="' . $perfil['foto'] . '" style="width:100%; height:200px; border-radius: 50%;">';
    }     
	echo '<br><br>';
    echo '<div>';
    echo '<label for="foto">Cambiar foto de perfil:</label>';
    echo '<input type="file" class="form-control" id="foto" name="foto">';
    echo '</div>';	
    echo '</div>';
    echo '</div>';//FIN DIV IMAGEN
    echo '<div class="col-md-3">';
	echo '<div>';
	echo '<br>';
	echo '<label>Nombre:</label>';
	echo '<input type="text" name="nombre" class="form-control" value="' . $user['nombre'] . '" pattern="[A-Za-z]{3,}">';
	echo '</div>';
	echo '<br><br><br>';
	echo '<div>';
	echo '<label>Email:</label>';
	echo '<input type="email" name="correo" class="form-control" value="' . $user['correo'] . '">';	
	echo '</div>';
	echo '</div>';//FIN DIV NOMBRE Y EMAIL

	echo '<div class="col-md-3">';
	echo '<br>';
	echo '<div>';
	echo '<label>Apellido:</label>';
	echo '<input type="text" name="apellido" class="form-control" value="' . $user['apellido'] . '" pattern="[A-Za-z]{3,}">';
	echo '</div>';
	echo '<br><br><br>';
	echo '<div>';
	echo '<label>Verificado:</label>';
	if($user['verificado']==1){
	echo '<p class="form-control">Sí</p>';
	}
	else{echo '<p class="form-control">Nó</p>';}
	echo '</div>';
	echo '</div>';
	
	if (!$user['verificado']) {
	echo '<div class="col-md-2" style="background-color: rgb(240, 240, 240); border: 1px solid #000; border-radius: 10px;">';
	echo '<br>';
	echo '<h5>Aun no está verificado?</h5><br>';
	echo '<h6>¡Qué espera! Verifique ahora dándole click al siguiente botón!</h6><br>';
	echo '<a href="papersPlease.php" class="btn btn-primary">Verificar!</a>';
	echo '</div>';
	}
	
	echo '<div class="col-md-12">';
	echo '<br>';
	echo '<div>';
	echo '<label>Biografía:</label>';
	echo '<textarea class="form-control" name="bio" style="height:auto;">' . $user['bio'] . '</textarea>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
	$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

// Consulta SQL para obtener las etiquetas asociadas al usuario
$sql = "SELECT id_etiquetas FROM usuarios_x_etiquetas WHERE usuario_id = " . $user['id'];
$result = $conexion->query($sql);

// Crear un array para almacenar los IDs de etiquetas asociadas al usuario
$etiquetasAsociadas = array();

// Verificar si hay etiquetas asociadas
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etiquetasAsociadas[] = $row['id_etiquetas'];
    }
}
// Cierra la conexión a la base de datos
$conexion->close();

echo '<div class="row">';
echo '<div class="col-md-12">';
echo '<div class="form-group">';
echo '<label for="etiquetas">Intereses</label>';
echo '<div class="input-group flexbox-container">';

// Realiza la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

// Realiza una consulta para obtener todas las etiquetas
$query = "SELECT * FROM etiquetas";
$result = mysqli_query($conexion, $query);

// Recorre los resultados y crea un checkbox para cada etiqueta
while ($row = mysqli_fetch_assoc($result)) {
    $idEtiqueta = $row['id'];
    $nombreEtiqueta = $row['nombre'];

    // Verifica si el ID de etiqueta está en el array de etiquetas asociadas
    $checked = in_array($idEtiqueta, $etiquetasAsociadas) ? 'checked' : '';

    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="checkbox" name="etiquetas[]" id="etiquetas' . $idEtiqueta . '" value="' . $idEtiqueta . '" ' . $checked . ' style="background-color:#1c8adb" readonly>';
    echo '<label class="form-check-label" for="etiquetas' . $idEtiqueta . '">' . $nombreEtiqueta . '</label>';
    echo '</div>';
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);

	echo '</div>';//input-group
	echo '<button class="btn btn-primary" type="submit" style="display: block; margin: 0 auto;">Modificar</button>';
	echo '</div>';//form-group	
	echo '</div>';//fin col-md-12
	echo '</div>';//fin row	
	echo '</form>';
	echo '</div>';

// Cierre de la condición
}//fin si 
//el visitante observa otro perfil
else{
	// Establece la conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

    // Consulta SQL para obtener la imagen del usuario
    $sql = "SELECT foto FROM imagenes_perfil WHERE usuario_id = " . $idUsuario;
    $result = $conexion->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Obtener la fila resultante
        $perfil = $result->fetch_assoc();        
    }
	// Consulta SQL para obtener la imagen del usuario
    $sql = "SELECT * FROM usuarios WHERE id = " . $idUsuario;
    $result = $conexion->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Obtener la fila resultante
        $user = $result->fetch_assoc();

        // Cerrar la conexión a la base de datos
        $conexion->close();
    }

    // HTML y formulario
    echo '<div class="container">';
    echo '<h1 class="text-center">Perfil de ' . $user['nombre'] . '</h1>';
    echo '<form action="modificarPerfil.php" method="POST" enctype="multipart/form-data">';
    echo '<div class="row">';
    echo '<div class="col-md-3 offset-md-0">';
    echo '<div class="text-center">';
    echo '<span class="caret"></span>';    
    // Mostrar la imagen del perfil
    if (isset($perfil['foto'])) {
        echo '<img src="' . $perfil['foto'] . '" style="width:100%; height:200px; border-radius: 50%;">';
    }
    echo '<br><br>';    
    echo '</div>';
    echo '</div>';//FIN DIV IMAGEN
    echo '<div class="col-md-3">';
	echo '<div>';
	echo '<br>';
	echo '<label>Nombre:</label>';
	echo '<input type="text" class="form-control" value="' . $user['nombre'] . '"readonly>';
	echo '</div>';
	echo '<br><br><br>';
	echo '<div>';
	echo '<label>Email:</label>';
	echo '<input type="email" class="form-control" value="' . $user['correo'] . '"readonly>';
	echo '</div>';
	echo '</div>';//FIN DIV NOMBRE Y EMAIL

	echo '<div class="col-md-3">';
	echo '<br>';
	echo '<div>';
	echo '<label>Apellido:</label>';
	echo '<input type="text" class="form-control" value="' . $user['apellido'] . '"readonly>';
	echo '</div>';
	echo '<br><br><br>';
	echo '<div>';
	echo '<label>Verificado:</label>';	
	if($user['verificado']==1){
	echo '<p class="form-control">Sí</p>';
	}
	else{echo '<p class="form-control">Nó</p>';}
	echo '</div>';
	echo '</div>';
	
	echo '<div class="col-md-12">';
	echo '<br>';
	echo '<div>';
	echo '<label>Biografía:</label>';
	echo '<textarea class="form-control" name="bio" style="height:auto;"readonly>' . $user['bio'] . '</textarea>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
	$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

// Consulta SQL para obtener las etiquetas asociadas al usuario
$sql = "SELECT e.id, e.nombre
        FROM etiquetas e
        JOIN usuarios_x_etiquetas ue ON e.id = ue.id_etiquetas
        WHERE ue.usuario_id = " . $user['id'];

$result = $conexion->query($sql);

// Crear un array para almacenar los IDs de etiquetas asociadas al usuario
$etiquetasAsociadas = array();

// Verificar si hay etiquetas asociadas
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $etiquetasAsociadas[] = $row;
    }
}

// Cierra la conexión a la base de datos
$conexion->close();

echo '<div class="row">';
echo '<div class="col-md-12">';
echo '<div class="form-group">';
echo '<label for="etiquetas">Intereses</label>';
echo '<div class="input-group flexbox-container">';

// Recorre las etiquetas asociadas y crea un checkbox para cada una
foreach ($etiquetasAsociadas as $etiqueta) {
    $idEtiqueta = $etiqueta['id'];
    $nombreEtiqueta = $etiqueta['nombre'];

    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="checkbox" name="etiquetas[]" id="etiquetas' . $idEtiqueta . '" value="' . $idEtiqueta . '" checked style="background-color:#1c8adb" readonly>';
    echo '<label class="form-check-label" for="etiquetas' . $idEtiqueta . '">' . $nombreEtiqueta . '</label>';
    echo '</div>';
}

	echo '</div>';
	echo '</div>';
	echo '</div>';	
	echo '</div>';	
	echo '</form>';
	echo '</div>';
}
?>

	


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