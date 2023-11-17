<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>      
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-expand-sm" style="background-color:gray;">
	<div class="container-fluid">
		<a href=inicioAdmin.PHP><img src="logo.png" alt="Logo de mi sitio web" style="float: left; margin: 0 10px 0 10px;" 
		width="150px" hiegh="150px"></a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
		data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" 
		aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
    <div class="collapse navbar-collapse" id="navbarCollapse">                
    <div class='btn-group'>
		<button class='btn btn-primary dropdown-toggle' type='button' data-bs-toggle='dropdown'>
      <span class='caret'></span><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
		<path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/>
		<path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z'/>
		</svg>
		<span><strong>Admin</strong></span>
		</button>
    <ul class='dropdown-menu' role='menu'>
      <li><a href='verificarUser.php'>Verificar Usuarios</a></li>
	  <li><a href='verificarPublicacion.php'>Publicar ofertas de Usuarios regulares</a></li>
      <li><a href='logout.php'>Cerrar sesión</a></li>
    </ul></div>     
		</div>       
		</div>
	</nav>    
	<br>
	<div class="container row">
        <div class="card-group col-md-12 offset-md-1" style="height:500px;">			
            <!-- Primera tarjeta -->
				<div class="card text-bg-secondary mb-3 col-md-6">
					<div class="card-header" style="text-align: center;"><h2>Usuarios para verificar</h2></div>
					<div class="card-body">
						<h5 class="card-title"></h5>
						<?php 						
						$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");
						// Verificar la conexión
						if ($conexion->connect_error) {
							die("Conexión fallida: " . $conexion->connect_error);
							}
						// Seleccionar todas las filas de la tabla
						$consulta = "SELECT u.*, ud.*
						 FROM usuarios u
						 INNER JOIN usuario_x_documento ud ON u.id = ud.usuario_id
						 WHERE u.verificado = 0 AND ud.estado = 0;";
						$resultado = $conexion->query($consulta);
						// Contar el número de filas
						$numero_filas = $resultado->num_rows;
						// Imprimir el número de filas
						echo '<h3 style="position: absolute; top: 50%;width: 100%; text-align: center;">Cantidad de usuarios: <span id="cantidadUsuarios">'.$numero_filas.'</span></h3>';
						// Cerrar la conexión a la base de datos
						$conexion->close();
						?>						
					</div>
				</div>
				<!-- Segunda tarjeta -->
				<div class="card text-bg-secondary mb-3 col-md-6">
					<div class="card-header" style="text-align: center;"><h2>Publicaciones para comprobar</h2></div>
					<div class="card-body">
						<h5 class="card-title"></h5>
						<?php 						
						$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");
						// Verificar la conexión
						if ($conexion->connect_error) {
							die("Conexión fallida: " . $conexion->connect_error);
							}
						// Seleccionar todas las filas de la tabla
						$consulta = "SELECT * FROM oferta_alquileres WHERE estado=0";
						$resultado = $conexion->query($consulta);
						// Contar el número de filas
						$numero_filas = $resultado->num_rows;
						// Imprimir el número de filas
						echo '<h3 style="position: absolute; top: 50%;width: 100%; text-align: center;">Cantidad de publicaciones: <span id="cantidadPublicaciones">'.$numero_filas.'</span></h3>';
						// Cerrar la conexión a la base de datos
						$conexion->close();
						?>						
					</div>
				</div>
				
        </div>
    </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>