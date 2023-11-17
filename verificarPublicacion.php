<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificar publicacion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>     
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-expand-sm" style="background-color:gray;">
	<div class="container-fluid">
		<a href=inicioAdmin.PHP><img src="logo.png" alt="Logo de mi sitio web" style="float: left; margin: 0 10px 0 10px;" 
		width="150px" hiegh="150px"></a>		
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
	<body>
    <div class="container">    
        <tbody>
            <h1>Ofertas de Alquiler listas para verificar</h1>
<table class="table table-bordered">
    <thead>
        <tr>                
            <th>Nombre y Apellido</th>
            <th>Publicación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Conecta a la base de datos y realiza la consulta SQL
        $conn = mysqli_connect("localhost", "root", "", "trabajo integrador");                

        if ($conn) {
            $query = "SELECT o.id, u.nombre, u.apellido, o.id AS oferta_id, o.estado, o.fecha_creacion,
                DATEDIFF(CURDATE(), o.fecha_creacion) -
                (WEEK(o.fecha_creacion) - WEEK(CURDATE())) * 2 -
                IF(WEEKDAY(o.fecha_creacion) = 6, 1, 0) -
                IF(WEEKDAY(CURDATE()) = 5, 1, 0) AS dias_habiles
				FROM oferta_alquileres AS o
				INNER JOIN usuarios AS u ON o.usuario_id = u.id
				WHERE o.estado = 0
				HAVING dias_habiles BETWEEN 3 AND 5
				ORDER BY dias_habiles DESC";


            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";                     
                echo "<td>" . $row['nombre'] . " " . $row['apellido'] . "</td>";
                echo "<td><a href='publicacion.php?id_publicacion=" . $row['oferta_id'] . "' target='_blank'>Ir a publicación</a></td>";
                echo "<td>";
                echo "<button class='btn btn-primary' onclick=\"window.location.href='botonVerificarOferta.php?id=" . $row['oferta_id'] . "';\">Verificar</button>";
                echo "<button class='btn btn-danger' onclick=\"window.location.href='botonRechazarOferta.php?id=" . $row['oferta_id'] . "';\">Rechazar</button>";
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

        </tbody>
    </table>
</div>


  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>