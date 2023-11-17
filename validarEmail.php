<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
      <li><a href='#'>Perfil</a></li>
	  <li><a href='ofertaAlq.php'>Publicar alquiler</a></li>
	  <li><a href='comprobarPedidos.php'>Comprobar pedidos de alquileres</a></li>
      <li><a href='logout.php'>Cerrar sesión</a></li>
    </ul></div>";

    // Ocultar el botón de inicio original
    echo "<button type='button' class='btn btn-primary d-none'>Inicie sesión</button>";
  } else {
    // Mostrar el botón de inicio original
    echo "<button type='button' class='btn btn-primary' onclick='iniciarSesion()'>Inicie sesión</button>";
  }
?>

      <!-- Fin del código PHP -->
    </div>       
  </div>
  </nav>      
  <h1 style="text-align: center;">Validacion de email</h1>

<form action="emailExiste.php" method="POST">  
<div class="container-fluid row">
<div class="col-2"></div>
  <div class="form-group col-8">
    <label for="correo">Correo electrónico:</label>
    <input type="email" class="form-control" id="correo" name="correo" required>
	<?php if(isset($_GET["error"])){ echo "<label style='font-weight: bold; color: red;'>".$_GET['error']."</label>";} ?>
  </div><div class="col-6"></div>
  <div class="col-6">
  <br>
  <button type="submit" class="btn btn-primary" >Validar</button>
  </div>
  </div>
</form>
    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>