<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
	<div class="row">
	<div class="col-xs-12>
	<!-- titulo?-->
	<div class="col-md-2">
	</div>
	<div class="col-md-8 container-fluid">	
  <form action="verificarLogica.php" method="POST" enctype="multipart/form-data">

    
	<h1>Documentos por favor</h1><br>
      <label for="fotos">Frente del DNI</label>
      <input type="file" class="form-control" id="fotos" name="foto" required><br>    
	<div><Button type="submit" class="btn btn-primary" >Enviar</button></div>
	</form>
	</div>
	</div><!-- fin div row-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>