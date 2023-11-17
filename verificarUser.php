<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificar usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>     
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
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
    <h1>Usuarios por Verificar</h1>
    <table class="table table-bordered" style="background-color:gray;">
        <thead>
            <tr>                
                <th>Nombre y Apellido</th>
                <th>Foto de Perfil</th>
                <th>Documento</th>                
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conecta a la base de datos y realiza la consulta SQL
            $conn = mysqli_connect("localhost", "root", "", "trabajo integrador");                

            if ($conn) {
                $query = "SELECT u.id, u.nombre, u.apellido, i.foto, ud.archivo, ud.estado
                          FROM usuarios AS u
                          INNER JOIN usuario_x_documento AS ud ON u.id = ud.usuario_id
                          LEFT JOIN imagenes_perfil AS i ON u.id = i.usuario_id
                          WHERE ud.estado = 0";

                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";                     
                    echo "<td>" . $row['nombre'] . " " . $row['apellido'] . "</td>";
                    echo "<td><a href='" . $row['foto'] . "' data-lightbox='image'><img src='" . $row['foto'] . "' alt='Foto de Perfil' width='100'></a></td>";
                    echo "<td><a href='" . $row['archivo'] . "' data-lightbox='image'><img src='" . $row['archivo'] . "' alt='Documento' width='100'></a></td>";                    
                    echo "<td>";
                    echo "<button class='btn btn-primary'onclick=\"window.location.href='botonVerificar.php?id=" . $row['id'] . "';\">Verificar</button>";
                    echo "<button class='btn btn-danger' onclick=\"window.location.href='botonRechazar.php?id=" . $row['id'] . "';\">Rechazar</button>";
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