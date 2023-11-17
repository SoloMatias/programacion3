<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio</title>
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
  <?php session_start(); ?>
 <nav class="navbar navbar-expand-md" style="background-color:gray;">
  <div class="container-fluid">
    <a href="index.PHP" class="navbar-brand"><img src="logo.png" alt="Logo de mi sitio web" width="150px" ></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
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
  </div>
</nav>
    
  
  <?php
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

if(isset($_POST['busqueda'])){
	$busqueda = mysqli_real_escape_string($conexion, $_POST["busqueda"]);

// Modificar la consulta SQL para seleccionar ofertas según la busqueda
$sql = "SELECT DISTINCT oa.*,u.verificado
        FROM oferta_alquileres oa
        LEFT JOIN usuarios u ON oa.usuario_id = u.id
        WHERE 
            (oa.titulo LIKE '%$busqueda%' OR
            oa.descripcion LIKE '%$busqueda%' OR
            oa.provincia LIKE '%$busqueda%' OR
            oa.departamento LIKE '%$busqueda%' OR
            oa.id IN (SELECT ea.id_oferta FROM etiquetas e, etiquetas_x_alquileres ea
                      WHERE e.id = ea.id_etiqueta AND e.nombre COLLATE utf8mb4_unicode_ci LIKE '%$busqueda%')
            )
            AND oa.estado = 1 
            AND (oa.fechaInicio IS NULL OR oa.fechaInicio <= NOW()) 
            AND (oa.fechaFin IS NULL OR NOW() <= oa.fechaFin)
        ORDER BY u.verificado DESC, oa.titulo ASC";



$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
    echo '<div class="container">';
    echo '<div class="row">'; // Iniciar la fila
    
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo '<div class="col-md-3" style="padding-top: 10px;">'; // Columna de 4 columnas para cada tarjeta
        // Envolver card-header y card-body en enlaces
		if($row['verificado']==1){
			echo '<div class="card text-bg-primary mb-3" style="height: 100%">';
			echo '<a href="publicacion.php?id_publicacion=' . $row['id'] . '" style="text-decoration:none;color:white;">';			
			echo '<div class="card-header">Destacado <br>' . $row['titulo'] . '</div>';
			echo '</a>';        
        }else{
			echo '<div class="card text-bg-secondary mb-3" style="height: 100%">';
			echo '<a href="publicacion.php?id_publicacion=' . $row['id'] . '" style="text-decoration:none;color:white;">';
			echo '<div class="card-header">' . $row['titulo'] . '</div>';
			echo '</a>';
		}        
        
        echo '<div class="card-body" style="height: 40%">';
        echo '<a href="publicacion.php?id_publicacion=' . $row['id'] . '">';                
        // Realizar una consulta SQL para obtener la primera imagen de la tabla galería correspondiente a esta oferta de alquiler
        $sql_imagen = "SELECT foto FROM galeria WHERE id_alquiler = " . $row['id'] . " LIMIT 1";
        $resultado_imagen = mysqli_query($conexion, $sql_imagen);
        
        if (mysqli_num_rows($resultado_imagen) > 0) {
            $row_imagen = mysqli_fetch_assoc($resultado_imagen);
            // Muestra la imagen si está disponible
            echo '<img src="' . $row_imagen['foto'] . '" alt="' . $row['titulo'] . '" style="height: 100%; width: 100%">';
        } else {
            // Puedes mostrar una imagen de marcador de posición si no hay imagen disponible.
            echo '<img src="imagen_de_marcador_de_posicion.jpg" alt="' . $row['titulo'] . '">';
        }
        
        echo '</div>';
        echo '</a>';
        
        echo '<div class="card-footer">Precio por noche: $' . $row['costo'] . '</div>';
        echo '</div>';
        echo '</div>'; // Cerrar la columna
    }
    
    echo '</div>'; // Cerrar la fila
    echo '</div>';
} else {
    echo "No se encontraron resultados.";
}
}
else{
$fechaActual = date('Y-m-d');
$sql = "SELECT DISTINCT oa.*,u.verificado
        FROM oferta_alquileres oa
        LEFT JOIN usuarios u ON oa.usuario_id = u.id
        WHERE oa.estado = 1 
            AND (oa.fechaInicio IS NULL OR oa.fechaInicio <= NOW()) 
            AND (oa.fechaFin IS NULL OR NOW() <= oa.fechaFin)
			ORDER BY u.verificado DESC, oa.titulo ASC";

$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
    echo '<div class="container">';
    echo '<div class="row">'; // Iniciar la fila
    
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo '<div class="col-md-3" style="padding-top: 10px;">'; // Columna de 4 columnas para cada tarjeta       
        
        // Envolver card-header y card-body en enlaces
		if($row['verificado']==1){
			echo '<div class="card text-bg-primary mb-3" style="height: 100%">';
			echo '<a href="publicacion.php?id_publicacion=' . $row['id'] . '" style="text-decoration:none;color:white;">';			
			echo '<div class="card-header">Destacado <br>' . $row['titulo'] . '</div>';
			echo '</a>';        
        }else{
			echo '<div class="card text-bg-secondary mb-3" style="height: 100%">';
			echo '<a href="publicacion.php?id_publicacion=' . $row['id'] . '" style="text-decoration:none;color:white;">';
			echo '<div class="card-header">' . $row['titulo'] . '</div>';
			echo '</a>';
		}
        echo '<div class="card-body" style="height: 40%">';
		echo '<a href="publicacion.php?id_publicacion=' . $row['id'] . '">';
        
        // Realizar una consulta SQL para obtener la primera imagen de la tabla galería correspondiente a esta oferta de alquiler
        $sql_imagen = "SELECT foto FROM galeria WHERE id_alquiler = " . $row['id'] . " LIMIT 1";
        $resultado_imagen = mysqli_query($conexion, $sql_imagen);
        
        if (mysqli_num_rows($resultado_imagen) > 0) {
            $row_imagen = mysqli_fetch_assoc($resultado_imagen);
            // Muestra la imagen si está disponible
            echo '<img src="' . $row_imagen['foto'] . '" alt="' . $row['titulo'] . '" style="height: 100%; width: 100%">';
        } else {
            // Puedes mostrar una imagen de marcador de posición si no hay imagen disponible.
            echo '<img src="imagen_de_marcador_de_posicion.jpg" alt="' . $row['titulo'] . '">';
        }
        
        echo '</div>';
        echo '</a>';
        
        echo '<div class="card-footer">Precio por noche: $' . $row['costo'] . '</div>';
        echo '</div>';
        echo '</div>'; // Cerrar la columna
    }
    
    echo '</div>'; // Cerrar la fila
    echo '</div>';
} else {
    echo "No se encontraron resultados.";
}}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);


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
		<?php if(isset($_GET["error"])){echo "<div class='form-group'><label style='font-weight: bold; color: red;'>".$_GET['error']."</label></div>";}?>
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

  <script src="departamentos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>