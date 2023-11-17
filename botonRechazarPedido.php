<?php				
					// Conecta a la base de datos
					$conn = mysqli_connect("localhost", "root", "", "trabajo integrador");
					if (isset($_GET['id_oferta']) && isset($_GET['id_usuario'])) {
						$id_oferta = $_GET['id_oferta'];
						$id_usuario = $_GET['id_usuario'];
					if ($conn) {
						// Borra el pedido de la tabla pedidos_alquiler
						$query_borrar = "DELETE FROM pedidos_alquiler WHERE id_oferta = $id_oferta AND id_usuario = $id_usuario";
						mysqli_query($conn, $query_borrar);
						mysqli_close($conn);
						header("Location: comprobarPedidos.php");
					} else {
						echo "Error en la conexión a la base de datos.";
						header("Location: comprobarPedidos.php");
					}
				}else{
					echo "Parámetros faltantes.";
				}
				?>