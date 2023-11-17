			<?php
					// Conecta a la base de datos
					$conn = mysqli_connect("localhost", "root", "", "trabajo integrador");
					if (isset($_GET['id_oferta']) && isset($_GET['id_usuario'])) {
						$id_oferta = $_GET['id_oferta'];
						$id_usuario = $_GET['id_usuario'];
					if ($conn) {
						// Obtén los datos del pedido
						$query_pedido = "SELECT * FROM pedidos_alquiler WHERE id_oferta = $id_oferta AND id_usuario = $id_usuario";
						$result_pedido = mysqli_query($conn, $query_pedido);
						$pedido = mysqli_fetch_assoc($result_pedido);

						// Inserta los datos en la tabla usuarios_toman_alquileres
						$query_insertar = "INSERT INTO usuarios_toman_alquileres (usuario_id, id_oferta, fecha_ini, fecha_fin, cupo, total) 
										   VALUES ('$id_usuario', '$id_oferta', '" . $pedido['fecha_ini'] . "', '" . $pedido['fecha_fin'] . "', '" . $pedido['cupo'] . "', '" . $pedido['total'] . "')";
						mysqli_query($conn, $query_insertar);

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