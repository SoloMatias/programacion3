<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro oferta de alquiler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>    
	
    <style>
      .btn-primary {
      background-color: #007bff;
      color: white;
      }
      .dropdown-toggle {
      cursor: pointer;
      }
      .dropdown-menu {
      position: absolute;
      top: 100%;
      left: 0;
      z-index: 1000;
      display: none;
      float: left;
      min-width: 160px;
      padding: 5px 0;
      margin: 2px 0 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      }
      .dropdown-menu li a {
      display: block;
      padding: 3px 20px;
      clear: both;
      font-weight: 400;
      color: #333;
      white-space: nowrap;
      }
      .dropdown-menu li a:hover {
      background-color: #ddd;
      color: black;
      }
	  .flexbox-container {
	  display: flex;
	  justify-content: space-between;
	  }
	  .form-check {
		margin: 0px 15px 0px 0px;
	  }
	  .form-control{
	border-width: 5px;
	border-style: solid;	
	border-radius: 5px;
	box-shadow: 0 0 10px 0 black;	
}
	.form-group{
		padding-top: 10px;
		padding-bottom: 10px;
	}
	label{
		font-weight: bold;
	}
	 .navbar-input {
	  border-width: 0px;
	  border-style: solid;
	  border-radius: 5px;
	  box-shadow: 0 0 0px 0 black;  
	}
    </style>
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
          <input class="form-control navbar-input" type="text" name="busqueda" placeholder="Buscar">
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
	// Verificar si el usuario está logueado y es un usuario no verificado
	if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]["verificado"] == 0) {
    // Realiza la conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

    // Verifica la conexión
    if (mysqli_connect_error()) {
        die("Conexión a la base de datos fallida: " . mysqli_connect_error());
    }

    // Obtener el ID del usuario actual
    $usuario_id = $_SESSION["usuario"]["id"];

    // Verificar si el usuario tiene una oferta de alquiler en proceso o publicada
    $query = "SELECT COUNT(*) AS count FROM oferta_alquileres WHERE usuario_id = $usuario_id AND (estado = 1 OR estado = 0)";
    $result = mysqli_query($conexion, $query);

    // Obtener el resultado
    $row = mysqli_fetch_assoc($result);
    $ofertasCount = $row['count'];

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);

    // Verificar si el usuario tiene ofertas en proceso o publicadas
    if ($ofertasCount > 0) {
        echo "<script>
            alert('¡Atención! Usted es un usuario no verificado y tiene ofertas de alquiler en proceso o publicadas.');
            window.location.href = 'inicio.php';
          </script>";
    }
	}
  ?>
	<div class="row">
	<div class="col-xs-12>	
	<div class="col-md-2">
	</div>
	<div class="col-md-8 container-fluid">	
  <form action="ofertaAlqLogica.php" method="POST" enctype="multipart/form-data">

    <div class="form-group">
      <label for="titulo">Título</label>
      <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingrese el título de la oferta" required>
    </div>

    <div class="form-group">
      <label for="descripcion">Descripción</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="5" placeholder="Ingrese una descripción de la oferta"></textarea>
    </div>

    <div class="form-group">
  <div class="col-xs-12">
    <label>Ubicación</label></div>
  <div class="col-md-12">
    <label for="prov">Provincias</label>
    <select class="form-control" id="provincia" name="provincia" required>
		  <option value="" selected>Seleccione una provincia</option>
		  <option value="Buenos Aires">Buenos Aires</option>
		  <option value="Catamarca">Catamarca</option>
		  <option value="Chaco">Chaco</option>
		  <option value="Chubut">Chubut</option>
		  <option value="Córdoba">Córdoba</option>
		  <option value="Corrientes">Corrientes</option>
		  <option value="Entre Ríos">Entre Ríos</option>
		  <option value="Formosa">Formosa</option>
		  <option value="Jujuy">Jujuy</option>
		  <option value="La Pampa">La Pampa</option>
		  <option value="La Rioja">La Rioja</option>
		  <option value="Mendoza">Mendoza</option>
		  <option value="Misiones">Misiones</option>
		  <option value="Neuquén">Neuquén</option>
		  <option value="Río Negro">Río Negro</option>
		  <option value="Salta">Salta</option>
		  <option value="San Juan">San Juan</option>
		  <option value="San Luis">San Luis</option>
		  <option value="Santa Cruz">Santa Cruz</option>
		  <option value="Santa Fe">Santa Fe</option>
		  <option value="Santiago del Estero">Santiago del Estero</option>
		  <option value="Tierra del Fuego">Tierra del Fuego</option>
		  <option value="Tucumán">Tucumán</option>
</select>

  </div>
</div>
<div class="form-group row">
  <div class="col-md-12">
    <label for="dept">Departamento</label>
    <select class="form-control" id="dept" name="dept" required>	
	<option value="" selected>Seleccione un departamento</option>
    </select>
  </div>
</div>
    <div class="form-group">
      <label for="etiquetas">Etiquetas</label>
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
      <label for="fotos">Galería de fotos</label>
      <input type="file" class="form-control" id="fotos" name="fotos[]" multiple required>
    </div>

    <div class="form-group">
  <label for="servicios">Listado de servicios</label>
  <div class="input-group mb-3 flexbox-container">
    <?php
    // Realiza la conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

    // Verifica la conexión
    if (mysqli_connect_error()) {
      die("Conexión a la base de datos fallida: " . mysqli_connect_error());
    }

    // Realiza una consulta para obtener los servicios disponibles
    $query = "SELECT * FROM servicios";
    $result = mysqli_query($conexion, $query);

    // Recorre los resultados y crea un checkbox para cada servicio
    while ($row = mysqli_fetch_assoc($result)) {
      $idServicio = $row['id'];
      $nombreServicio = $row['nombre'];

      echo '<div class="form-check">';
      echo '<input class="form-check-input" type="checkbox" name="servicios[]" id="servicio' . $idServicio . '" value="' . $idServicio . '" style="background-color:#1c8adb">';
      echo '<label class="form-check-label" for="servicio' . $idServicio . '">' . $nombreServicio . '</label>';
      echo '</div>';
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
    ?>
  </div>
</div>



    <div class="form-group">
      <label for="costo">Costo de alquiler por día</label>
      <input type="number" step="0.01" class="form-control" id="costo" name="costo" placeholder="Ingrese el costo de alquiler por día" required>
    </div>

    <div class="form-group">
      <label for="tiempoMinimo">Tiempo mínimo de permanencia</label>
      <input type="number" class="form-control" id="tiempoMinimo" name="tiempoMinimo" placeholder="Ingrese el tiempo mínimo de permanencia" required>
    </div>

    <div class="form-group">
      <label for="tiempoMaximo">Tiempo máximo de permanencia</label>
      <input type="number" class="form-control" id="tiempoMaximo" name="tiempoMaximo" placeholder="Ingrese el tiempo máximo de permanencia" required>
	</div>
	<div class="form-group">
      <label for="cupo">Cupo</label>
      <input type="number" class="form-control" id="cupo" name="cupo" placeholder="Ingrese el cupo" required>
	</div>
	<div class="form-group">
    <label for="fechaInicio">Fecha de inicio (opcional)</label>
    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" placeholder="Seleccione la fecha de inicio (opcional)">
	</div>
	<div class="form-group">
    <label for="fechaFin">Fecha de fin (opcional)</label>
    <input type="date" class="form-control" id="fechaFin" name="fechaFin" placeholder="Seleccione la fecha de fin (opcional)">
	</div>		
	<div><Button type="submit" class="btn btn-primary" >Publicar</button></div>
	</form>
	</div>
	</div><!-- fin div row-->
	<script src="departamentos.js"></script>
	<script src="etiquetas.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>