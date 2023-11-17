<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comprobar pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>     
	<style>
		table.table-bordered {
			border: 2px solid gray;
		}

		table.table-bordered th,
		table.table-bordered td {
			border: 6px solid gray;			
		}
		table.table-bordered th{background-color:#0d6efd;}
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

    <br>
    <div class="container">
        <h1>Pedidos de Alquiler de Usuarios no Verificados</h1>
        <table class="table table-bordered" style="background-color:gray;"">
            <thead>
                <tr>                
                    <th>Nombre y Apellido</th>
                    <th>Perfil</th>
                    <th>Fecha Inicial</th>                
                    <th>Fecha Fin</th>
                    <th>Cupo</th>
                    <th>Total</th>
                    <th>Fecha Pedido</th>
                    <th>Titulo de oferta</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conecta a la base de datos y realiza la consulta SQL
                $conn = mysqli_connect("localhost", "root", "", "trabajo integrador");
				$user_id=$_SESSION['usuario']['id'];
                if ($conn) {
                    $query = "SELECT u.id, u.nombre, u.apellido, u.correo, pa.fecha_ini, pa.fecha_fin, pa.cupo, pa.total, pa.fecha_pedido, oa.titulo, oa.usuario_id, pa.id_oferta 
					FROM
					usuarios AS u
					INNER JOIN
					pedidos_alquiler AS pa ON u.id = pa.id_usuario
					INNER JOIN
					oferta_alquileres AS oa ON pa.id_oferta = oa.id
					WHERE
					oa.usuario_id = '$user_id';";

                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";                     
                        echo "<td>" . $row['nombre'] . " " . $row['apellido'] . "</td>";
                        echo "<td><a href='perfil.php?id=" . $row['id'] . "' target='_blank'>Ver Perfil</a></td>";
                        echo "<td>" . $row['fecha_ini'] . "</td>";
                        echo "<td>" . $row['fecha_fin'] . "</td>";
                        echo "<td>" . $row['cupo'] . "</td>";
                        echo "<td>" . $row['total'] . "</td>";
                        echo "<td>" . $row['fecha_pedido'] . "</td>";
                        echo "<td><a href='publicacion.php?id_publicacion=" . $row['id_oferta'] . "' target='_blank'>" . $row['titulo'] . "</a></td>";
                        echo "<td>";
                        echo "<button class='btn btn-success' onclick=\"window.location.href='botonAceptarPedido.php?id_oferta=". $row['id_oferta'] ."&id_usuario=" . $row['id'] . "';\">Aceptar</button>";
						echo "<button class='btn btn-danger' onclick=\"window.location.href='botonRechazarPedido.php?id_oferta=". $row['id_oferta'] ."&id_usuario=" . $row['id'] . "';\">Rechazar</button>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    mysqli_close($conn);
                } else {
                    echo "Error en la conexión a la base de datos.";
                }				
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
