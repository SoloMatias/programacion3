<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alquiler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos.css">	
	<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
	<script> window.jQuery || document.write('<script src="path/to/jquery-3.5.0.js"><\/script>')</script>	
	<script src="https://cdn.jsdelivr.net/npm/zebra_datepicker@1.9.13/dist/zebra_datepicker.min.js"></script>
	<link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/css/bootstrap/zebra_datepicker.min.css">	
	<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

	<script>
	$(document).ready(function() {			
            // Obtén las fechas deshabilitadas desde la base de datos y formatea al formato esperado
			<?php
			session_start();
			// Establece la conexión a la base de datos (ajusta los valores según tu configuración)
			$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

			// Verifica la conexión
			if (mysqli_connect_error()) {
				die("Conexión a la base de datos fallida: " . mysqli_connect_error());
			}

			// Realiza la consulta para obtener las fechas deshabilitadas
			$queryFechas = "SELECT fecha_ini, fecha_fin FROM usuarios_toman_alquileres";
			$resultFechas = mysqli_query($conexion, $queryFechas);

			// Verifica si se encontraron resultados
			if ($resultFechas) {
				$fechasDeshabilitadas = array();

				// Recorre los resultados y formatea las fechas
				while ($rowFecha = mysqli_fetch_assoc($resultFechas)) {
					// Asume que el formato de fecha en la base de datos es 'Y-m-d'
					$fechaIniFormateada = date('Y-m-d', strtotime($rowFecha['fecha_ini']));
					$fechaFinFormateada = date('Y-m-d', strtotime($rowFecha['fecha_fin']));

					// Analiza las fechas para obtener los componentes
					$fechaIniComponents = date_parse_from_format('Y-m-d', $fechaIniFormateada);
					$fechaFinComponents = date_parse_from_format('Y-m-d', $fechaFinFormateada);

					// Construye el rango deshabilitado
					$rangoDeshabilitado = $fechaIniComponents['day'] . "-" . $fechaFinComponents['day'] . " " . $fechaIniComponents['month'] . "-" . $fechaFinComponents['month'] . " " . $fechaIniComponents['year'];

					// Agrega las fechas al array
					$fechasDeshabilitadas[] = $rangoDeshabilitado;
				}
				// Cierra el resultado de la consulta
				mysqli_free_result($resultFechas);
			} else {
				// Manejo de errores si la consulta falla o no se encontro nada				
			}

			// Cierra la conexión a la base de datos
			mysqli_close($conexion);

			// Ahora $fechasDeshabilitadas contiene las fechas formateadas
			// Puedes usar este array en tu código JavaScript
			// Imprime el array directamente en el script					
			echo "var fechasDeshabilitadas = " . json_encode($fechasDeshabilitadas, JSON_UNESCAPED_SLASHES) . ";\n";

			?>
			function calcularTotal() {
    var fechaInicio = $('#datepicker-range-start').val();
    var fechaFin = $('#datepicker-range-end').val();
    var costoPorNoche = parseFloat($('#costo').val());

    console.log('Fecha de inicio:', fechaInicio);
    console.log('Fecha de fin:', fechaFin);
    console.log('Costo por noche:', costoPorNoche);

    // Convierte las fechas al formato esperado 'Y-m-d'
    var fechaInicioFormatoCorrecto = moment(fechaInicio, 'DD/MM/YYYY').format('YYYY-MM-DD');
    var fechaFinFormatoCorrecto = moment(fechaFin, 'DD/MM/YYYY').format('YYYY-MM-DD');

    // Realiza el cálculo solo si ambas fechas están seleccionadas
    if (fechaInicioFormatoCorrecto && fechaFinFormatoCorrecto) {
        // Convierte las fechas a objetos de fecha
        var fechaInicioObj = new Date(fechaInicioFormatoCorrecto);
        var fechaFinObj = new Date(fechaFinFormatoCorrecto);

        console.log('Fecha de inicio (objeto):', fechaInicioObj);
        console.log('Fecha de fin (objeto):', fechaFinObj);

        // Calcula la diferencia en días
        var diasTotales = Math.ceil((fechaFinObj - fechaInicioObj) / (1000 * 60 * 60 * 24));

        console.log('Días totales:', diasTotales);

        // Calcula el total
        var total = diasTotales * costoPorNoche;

        // Actualiza el campo de total
        $('#total').val(total.toFixed(1));
    } else {
        // Si alguna fecha no está seleccionada, establece el total en 0
        $('#total').val('0');
    }
}

			<?php
			// Lógica para determinar el caso y establecer la dirección correspondiente
			$direction = ($_SESSION['usuario']['verificado']) ? 1 : 3;
			// Establece la conexión a la base de datos (ajusta los valores según tu configuración)
    $conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");
    // Realiza la consulta para obtener tiempoMinimo y tiempoMaximo desde la tabla oferta_alquileres
	$id_publicacion = $_GET['id_publicacion'];
    $queryOfertaAlquileres = "SELECT tiempoMinimo, tiempoMaximo FROM oferta_alquileres WHERE id=$id_publicacion";
    $resultOfertaAlquileres = mysqli_query($conexion, $queryOfertaAlquileres);
    // Verifica si se encontraron resultados
    if ($resultOfertaAlquileres) {
        // Recupera los valores de tiempoMinimo y tiempoMaximo
        $rowOfertaAlquileres = mysqli_fetch_assoc($resultOfertaAlquileres);
        $tiempoMinimo = $rowOfertaAlquileres['tiempoMinimo'];
        $tiempoMaximo = $rowOfertaAlquileres['tiempoMaximo']-$tiempoMinimo;
        // Libera el resultado de la consulta
        mysqli_free_result($resultOfertaAlquileres);
    } else {
        // Manejo de errores si la consulta falla o no se encontró nada
        $tiempoMinimo = 1; // Puedes establecer un valor predeterminado en caso de error
        $tiempoMaximo = 9;
    }
    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
			?>
		
            // Inicializa los datepickers
            $('#datepicker-range-start').Zebra_DatePicker({
                direction: <?php echo $direction; ?>,
				show_select_today: 'today',
                pair: $('#datepicker-range-end'),
                format: 'd/m/Y',
                disabled_dates: fechasDeshabilitadas,
				onSelect: function() {
				// Llama a la función calcularTotal después de seleccionar una fecha
				calcularTotal();
				}
            });

            $('#datepicker-range-end').Zebra_DatePicker({
                direction: <?php echo '['.$tiempoMinimo.','.$tiempoMaximo.']'; ?>,
				show_select_today: 'today',
                format: 'd/m/Y',
                disabled_dates: fechasDeshabilitadas,
				onSelect: function() {
				// Llama a la función calcularTotal después de seleccionar una fecha
				calcularTotal();
				}
            });
			calcularTotal();
        });
	</script>
	<style>
        .rating {
			
            display: flex;
            flex-direction: row-reverse;
        }
        .rating input {
            display: none;
        }
        .rating label {
            font-size: 30px;
            cursor: pointer;
            color: #ccc;
			
        }
        .rating label:hover,
        .rating label:hover > label {
            color: orange;
        }
        .rating input:checked ~ label {
            color: orange;
        }
        .rating .selected {
            color: orange;
        }
    </style>
    <script>
  function iniciarSesion() {    
    // Abre el modal de inicio de sesión
    $("#modalLogin").modal("show");
    }
  </script>
  </head>
  <body>
  <nav class="navbar navbar-expand-md" style="background-color:gray;">
  <div class="container-fluid">
		<?php
		if (isset($_SESSION["admin"])) {
			echo '<a href="inicioAdmin.php" class="navbar-brand"><img src="logo.png" alt="Logo de mi sitio web" width="150px" ></a>';
		} else {
			echo '<a href="index.php" class="navbar-brand"><img src="logo.png" alt="Logo de mi sitio web" width="150px" ></a>';
		}
		?>
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
	  <li><a href='ofertaAlq.php'>Publicar alquiler</a></li>
      <li><a href='comprobarPedidos.php'>Comprobar pedidos de alquileres</a></li>
      <li><a href='logout.php'>Cerrar sesión</a></li>
    </ul></div>";

    // Ocultar el botón de inicio original
    echo "<button type='button' class='btn btn-primary d-none'>Inicie sesión</button>";
  } elseif(isset($_SESSION["admin"])) {
	  echo "<div class='btn-group'>
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
    </ul></div> ";
  }
  else {
    // Mostrar el botón de inicio original
    echo "<button type='button' class='btn btn-primary' onclick='iniciarSesion()'>Inicie sesión</button>";
  }
?>

      <!-- Fin del código PHP -->

      </div>
    </div>
  </div>
</nav>   
  <?php
// Establecer la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "trabajo integrador");

// Verificar la conexión
if (mysqli_connect_error()) {
    die("Conexión a la base de datos fallida: " . mysqli_connect_error());
}

// Obtener el id_publicacion de la URL
if (isset($_GET['id_publicacion'])) {
    $id_publicacion = $_GET['id_publicacion'];

    // Realizar una consulta SQL para obtener información de la tabla oferta_alquileres
    $query = "SELECT * FROM oferta_alquileres WHERE id = $id_publicacion";
    $result = mysqli_query($conexion, $query);

    // Comprueba si se encontró la publicación
    if ($row = mysqli_fetch_assoc($result)) {
        // Aquí puedes acceder a los datos de la publicación
        $titulo = $row['titulo'];
        $descripcion = $row['descripcion'];
        $provincia = $row['provincia'];
        $departamento = $row['departamento'];
        $costo = $row['costo'];
        $tiempoMinimo = $row['tiempoMinimo'];
        $tiempoMaximo = $row['tiempoMaximo'];
        $cupo = $row['cupo'];
        $fechaInicio = $row['fechaInicio'];
        $fechaFin = $row['fechaFin'];
        $usuario_id = $row['usuario_id'];

        // Consultar la tabla de usuarios para obtener el nombre del usuario
        $queryUsuario = "SELECT nombre FROM usuarios WHERE id = $usuario_id";
        $resultUsuario = mysqli_query($conexion, $queryUsuario);
        if ($rowUsuario = mysqli_fetch_assoc($resultUsuario)) {
            $nombreUsuario = $rowUsuario['nombre'];
        } else {
            $nombreUsuario = "Usuario Desconocido";
        }

        // Consultar la tabla imagenes_perfil para obtener la imagen de perfil del usuario
        $queryImagenPerfil = "SELECT foto FROM imagenes_perfil WHERE usuario_id = $usuario_id";
        $resultImagenPerfil = mysqli_query($conexion, $queryImagenPerfil);
        if ($rowImagenPerfil = mysqli_fetch_assoc($resultImagenPerfil)) {
            $rutaImagenPerfil = $rowImagenPerfil['foto'];
        } else {
            // Define una imagen por defecto si no se encontró una imagen de perfil
            $rutaImagenPerfil = "ruta_imagen_por_defecto.jpg";
        }

        // A continuación, puedes mostrar la información de la publicación en tu HTML
        echo '<div class="text-center">';
        echo '<h1>' . $titulo . '</h1>';
        
        echo '</div>';
        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-md-12 offset-md-0">';
        echo '<div id="carouselExample" class="carousel slide position-relative">';
        echo '<div class="carousel-inner">';

        // Realiza una consulta SQL para obtener las imágenes de la galería
        $queryGaleria = "SELECT foto FROM galeria WHERE id_alquiler = $id_publicacion";
        $resultGaleria = mysqli_query($conexion, $queryGaleria);

        $active = true; // Para la primera imagen

        while ($rowGaleria = mysqli_fetch_assoc($resultGaleria)) {
            $rutaImagen = $rowGaleria['foto'];

            // Agrega las imágenes al carrusel
            echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
            echo '<img src="' . $rutaImagen . '" class="d-block w-100" style="height: 300px;" alt="Imagen de la galería">';
            echo '</div>';

            $active = false; // Desactiva la bandera después de la primera imagen
        }

        echo '</div>'; //fin carruse-inner
        echo '<button class="carousel-control-prev btn btn-primary" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" style="width:40px;">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Previous</span>';
        echo '</button>';
        echo '<button class="carousel-control-next btn btn-primary" type="button" data-bs-target="#carouselExample" data-bs-slide="next" style="width:40px;">';
        echo '<span class="carousel-control-next-icon" ariahidden="true"></span>';
        echo '<span class="visually-hidden">Next</span>';
        echo '</button>';
        echo '<ol class="carousel-indicators">';

        // Agrega indicadores para cada imagen
        $resultGaleria = mysqli_query($conexion, $queryGaleria);
        $indicatorIndex = 0;

        while ($rowGaleria = mysqli_fetch_assoc($resultGaleria)) {
            echo '<li data-bs-target="#carouselExample" data-bs-slide-to="' . $indicatorIndex . '" ' . ($indicatorIndex == 0 ? 'class="active"' : '') . '></li>';
            $indicatorIndex++;
        }

        echo '</ol>';
        echo '</div>';//fin carruselExample
        echo '</div>';//fin col-md-12
        echo '</div>';//fin row
        echo '</div><br>';//fin container
        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-md-8 offset-md-0">';
		if (isset($_SESSION["usuario"])||isset($_SESSION["admin"])){
		echo '<h5>';
        echo '<a href="http://localhost/TP/perfil.php?id=' . $usuario_id . '" style="text-decoration: none; color:black;">';
        echo 'Anfitrión: '.$nombreUsuario;        
        echo '<img src="' . $rutaImagenPerfil . '" alt="Imagen de perfil" width="40" height="40">';
		echo '</a>';
        echo '</h5>';
		}
		else{
			echo '<h5>';
        echo '<p>';
        echo 'Anfitrión: '.$nombreUsuario;        
        echo '<img src="' . $rutaImagenPerfil . '" alt="Imagen de perfil" width="40" height="40">';
		echo '</p>';
        echo '</h5>';
		}
        echo '<h2>Descripcion</h2>';
        echo '<p>' . $descripcion . '</p>';
		echo '<h2>Provincia</h2>';
		echo '<p>' . $provincia . '</p>';
		echo '<h2>Departamento</h2>';
		echo '<p>' . $departamento . '</p>';
        echo '<h2>Servicios</h2>';
        echo '<div class="row">';
        echo '<div class="form-group">';	//copiar desde aqui para hacer etiquetas
        echo "<div class='input-group mb-3 flexbox-container'>";

        // Consulta para obtener los servicios asociados a esta publicación
        $queryServicios = "SELECT s.nombre FROM servicios_x_alquileres sa
            INNER JOIN servicios s ON sa.id_servicios = s.id
            WHERE sa.id_oferta = $id_publicacion";
        $resultServicios = mysqli_query($conexion, $queryServicios);

        while ($rowServicio = mysqli_fetch_assoc($resultServicios)) {
            $nombreServicio = $rowServicio['nombre'];

            echo '<div class="form-check" style="padding-right:15px;">';
            echo '<label class="form-check-label">' . $nombreServicio . '</label>';
            echo '</div>';
        }
        echo '</div>';// fin input-group
        echo '</div>';// fin form-group 		pegar aqui abajo para etiquetas
		echo '<div class="form-group">';	//copiar desde aqui para hacer etiquetas
		echo '<h2>Etiquetas</h2>';
        echo "<div class='input-group mb-3 flexbox-container'>";

        // Consulta para obtener los servicios asociados a esta publicación
        $queryServicios = "SELECT e.nombre FROM etiquetas_x_alquileres ea
            INNER JOIN etiquetas e ON ea.id_etiqueta = e.id
            WHERE ea.id_oferta = $id_publicacion";
        $resultServicios = mysqli_query($conexion, $queryServicios);

        while ($rowServicio = mysqli_fetch_assoc($resultServicios)) {
            $nombreServicio = $rowServicio['nombre'];

            echo '<div class="form-check" style="padding-right:15px;">';
            echo '<label class="form-check-label">' . $nombreServicio . '</label>';
            echo '</div>';
        }

        
        echo '</div>';// fin input-group
        echo '</div>';// fin form-group
        echo '</div>';// fin input-group mb-3
		
if(isset($_SESSION['usuario'])) {
	
  $rese = mysqli_query($conexion, "SELECT * FROM reseña_alquileres WHERE usuario_id = {$_SESSION['usuario']['id']} AND oferta_id = $id_publicacion");
  if (mysqli_num_rows($rese) > 0) {
	  $r=mysqli_fetch_assoc($rese);
  echo '<h2>Tu opinion</h2>';
    echo '<div class="d-flex justify-content-left">
		<form action="botonReseña.php?id_publicacion='. $id_publicacion .'" method="post">
        <div class="rating" >
         <input type="radio" name="puntaje" id="star1" value="5" /><label for="star1" class="label-star">★ </label>
         <input type="radio" name="puntaje" id="star2" value="4" /><label for="star2" class="label-star">★ </label>
         <input type="radio" name="puntaje" id="star3" value="3" /><label for="star3" class="label-star">★ </label>
         <input type="radio" name="puntaje" id="star4" value="2" /><label for="star4" class="label-star">★ </label>
         <input type="radio" name="puntaje" id="star5" value="1" /><label for="star5" class="label-star">★</label>       
         </div></div>
         <label for="comentario">Comentario:</label><br>
		<textarea name="comentario" id="comentario" rows="4" cols="50">'.$r["comentario"].'</textarea>
        <br>
         <input type="submit" value="Editar">
     </form>';
  }else{
  $resultado = mysqli_query($conexion, "SELECT * FROM usuarios_toman_alquileres WHERE usuario_id = {$_SESSION['usuario']['id']} AND fecha_fin <= CURDATE()");
  if (mysqli_num_rows($resultado) == 0) {
    // El usuario no tiene ningún alquiler activo    	
  } else {
    // El usuario tiene algún alquiler activo
    echo '<h2>Califica esta oferta</h2>';
    echo '<div class="d-flex justify-content-left">
		<form action="botonReseña.php?id_publicacion='. $id_publicacion .'" method="post">
        <div class="rating" >
         <input type="radio" name="puntaje" id="star1" value="5" /><label for="star1" class="label-star">★ </label>
         <input type="radio" name="puntaje" id="star2" value="4" /><label for="star2" class="label-star">★ </label>
         <input type="radio" name="puntaje" id="star3" value="3" /><label for="star3" class="label-star">★ </label>
         <input type="radio" name="puntaje" id="star4" value="2" /><label for="star4" class="label-star">★ </label>
         <input type="radio" name="puntaje" id="star5" value="1" /><label for="star5" class="label-star">★</label>       
         </div></div>
         <label for="comentario">Comentario:</label><br>
         <textarea name="comentario" id="comentario" rows="4" cols="50"></textarea>
        <br>
         <input type="submit" value="Publicar">
     </form>';
  }
}
}
	echo "<h2>Reseñas</h2>";
	// Obtenemos todas las reseñas de la publicación
$consulta = "SELECT r.*, u.nombre
             FROM reseña_alquileres r
             JOIN usuarios u ON r.usuario_id = u.id
             WHERE r.oferta_id = '$id_publicacion'
             ORDER BY r.fecha_creacion DESC";

$reseñas = mysqli_query($conexion, $consulta);

	echo '<div class="container">';
    echo '<div class="row">';
	
// Iteramos sobre las reseñas
foreach ($reseñas as $resena) {

  // Mostramos la reseña
  echo '<div class=col-md-4>';
  echo "<div class='card-group'>";
  echo "<div class='card text-bg-secondary mb-3'>";
  echo "<div class='card-body'>";
  echo "<h5 class='card-title'>$resena[nombre]</h5>";
  echo "<p class='card-text'>";$i=0;
  while($i<$resena['calificacion']){
	  echo "<label for='star1' class='label-star'>★ </label>";$i++;
  }
  echo "</p>";
  echo "<p class='card-text'>Comentario: $resena[comentario]</p>";
  if(isset($_SESSION['usuario'])){
  if ($resena['respuesta'] != null) {	  
	  if (($_SESSION['usuario']['id'] != $usuario_id)) { 
    echo "<p class='card-text'>Respuesta del autor: $resena[respuesta]</p>";
	  }else{
		  echo '<p class="card-text">
		<form action="botonRespuesta.php?id_publicacion='. $id_publicacion .'&usuario_id=' . $resena['usuario_id'] . '" method="post">
			<label for="Respuesta">Respuesta:</label><br>
			 <textarea name="Respuesta" id="Respuesta" rows="2" cols="20">'.$resena["respuesta"].'</textarea>
			<br>
			 <input type="submit" value="Editar">
		 </form>';
	  }
  }else{
	  if (($_SESSION['usuario']['id'] == $usuario_id)) { 
	  echo '<p class="card-text">
		<form action="botonRespuesta.php?id_publicacion='. $id_publicacion .'&usuario_id=' . $resena['usuario_id'] . '" method="post">
			<label for="Respuesta">Respuesta:</label><br>
			 <textarea name="Respuesta" id="Respuesta" rows="2" cols="20"></textarea>
			<br>
			 <input type="submit" value="Publicar">
		 </form>';
	  }
  }
  }
  else{echo "<p class='card-text'>Respuesta del autor: $resena[respuesta]</p>";}
  echo "</div>";
  echo "</div>";
  echo '</div>';//col-md-4
  echo "</div>";
}
echo '</div>';		
		
        echo '</div>';echo '</div>';// fin col-md-8
		echo '<div class="col-md-4 offset-md-0" style="background-color: rgb(240, 240, 240); border: 1px solid #000; border-radius: 10px;">'; //FORMULARIO ALQUILER
		echo '<form action="reserva.php" method="POST">';
		echo '<p>FICHA PARA CONCRETAR EL ALQUILER</p>';		
		echo '<div class="form-group">';
		$fechaActual = date('Y-m-d');
		echo '<label for="fechaIni">Fecha de inicio</label>';
		echo '<input id="datepicker-range-start" name="fechaINI" type="text" class="form-control" data-zdp_readonly_element="false" style="position: relative; float: none; inset: auto; margin: 0px; padding-right: 40px;">';		
		echo '</div>';
		echo '<div class="form-group">';
		echo '<label for="fechaFin">Fecha de fin</label>';
		echo '<input id="datepicker-range-end" name="fechaFIN" type="text" class="form-control" data-zdp_readonly_element="false" style="position: relative; float: none; inset: auto; margin: 0px; padding-right: 40px;">';		
		echo '</div>';
		echo '<div class="form-group">';
		echo '<label for="cupo">Cantidad de Personas</label>';
		echo '<input type="number" class="form-control" id="cupo" name="cupo" placeholder="Ingrese el cupo" min="1" value="1" max="'.$cupo.'" required>';
		echo '</div>';
		echo '<label for="costo">PRECIO POR NOCHE: </label>';		
		echo '<input type="number" id="costo" name="costo" value="'.$costo.'" readonly style="text-decoration:none;border:0;background-color:rgb(240, 240, 240);padding-left:10px">';
		echo '<p>Total: <input type="text" id="total" name="total" value="0" readonly></p>';
		if (isset($_SESSION['usuario'])) {
			// La clave 'usuario' existe en el arreglo		 
		if (($_SESSION['usuario']['id'] == $usuario_id)) { 
		echo '<button type="button" class="btn btn-primary" disabled>Reservar Deshabilitado</button>';		
		}else{
			if ($_SESSION["usuario"]["verificado"] == 0) {  
			// Verificar si el usuario tiene una oferta de alquiler en proceso o publicada
			$query = "SELECT COUNT(*) AS count FROM pedidos_alquiler WHERE id_usuario = {$_SESSION['usuario']['id']}";
			$result = mysqli_query($conexion, $query);
			// Obtener el resultado
			$row = mysqli_fetch_assoc($result);
			$pedidoCount = $row['count'];
			if ($pedidoCount == 0) {
			if((($fechaFin == null)|| ($fechaFin >= $fechaActual))&&(($fechaInicio == null)|| ($fechaInicio <= $fechaActual))){
				echo '<button type="submit" class="btn btn-primary">RESERVAR</button>';
			}else{
				echo '<button type="button" class="btn btn-primary" disabled>Botón de Reserva Deshabilitado</button>';
				echo "<label style='font-weight: bold; color: red;'>oferta ya no está disponible</label>";
			}
			}else{
				echo '<button type="button" class="btn btn-primary" disabled>Botón de Reserva Deshabilitado</button>';
				echo "<label style='font-weight: bold; color: red;'>ya tienes un pedido de alquiler en curso</label>";
			}
			}
			else{
			if((($fechaFin == null)|| ($fechaFin >= $fechaActual))&&(($fechaInicio == null)|| ($fechaInicio <= $fechaActual))){
				echo '<button type="submit" class="btn btn-primary">RESERVAR</button>';
			}
			else{
				echo '<button type="button" class="btn btn-primary" disabled>Botón de Reserva Deshabilitado</button>';
			}
			}
			}
			}
		echo '<input type="number" class="form-control" id="id_Oferta" name="id_Oferta" value="'.$id_publicacion.'" style="display:none">';
		echo '<input type="text" class="form-control" id="titulo" name="titulo" value="'.$titulo.'" style="display:none">';
		echo '</form>';
		echo '</div>';//fin col-md-4 offset-md-0
				
		// Cierra la conexión a la base de datos
        mysqli_close($conexion);
		
        echo '</div></div>';//fin row y container			
    } else {
        echo "La publicación no fue encontrada.";
    }
} else {
    echo "Falta el parámetro id_publicacion en la URL.";
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