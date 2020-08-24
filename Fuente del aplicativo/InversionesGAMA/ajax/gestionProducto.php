<?php  
    session_start();
	include("../class/class-conexion.php");
	include("../class/class-producto.php");

	$conexion = new Conexion();
	$username = $_SESSION["gama_username"];	

	switch($_GET["accion1"]) {		
		case'guardar':		
			$Producto = new Producto (  
										0,
										$_POST["nombre"],							
										$_POST["cantidadDisponible"],
										$_POST["precioCosto"],
										$_POST["impuesto15"],
										$_POST["impuesto18"],
										$_POST["descuento"],
										$_POST["precioVenta"],
										1,
										$_POST["tipo"]
							);
		   // echo($Insumo-> __toString());
			$Producto->guardarProducto($conexion);
			$respuestaProducto["codigo"] = $Producto->getCodigoResultado();
			$respuestaProducto["mensaje"] =$Producto->getMensaje();
			echo json_encode($respuestaProducto); 
			exit();            
		break;

		case'mostrar':
			$Producto = Producto::soloObjectoProducto();
			$respuestaMostrarProducto= $Producto->obtenerProductos ($conexion);
			echo json_encode($respuestaMostrarProducto); 
			exit();  
		break;

		case 'llenarTipoProducto':
			$Producto = Producto::soloObjectoProducto();
			$respuestaMostraTipoProducto= $Producto->obtenerTipoProducto ($conexion);
			echo json_encode($respuestaMostraTipoProducto); 
			exit();   
		 break;

		case 'mostrarDatosEditar':
			$Producto = Producto::soloObjectoProducto();
			$Producto->obtenerProducto ($conexion, $_GET["idProducto"]);

			$respuesta["idProducto"] = $Producto->getIDPRODUCTO();
            $respuesta["nombreProducto"] = $Producto->getNOMBREPRODUCTO();
            $respuesta["cantidad"] = $Producto->getCANTIDADDISPONIBLE();
            $respuesta["precioCosto"] = $Producto->getPRECIOCOSTO();
            $respuesta["impuesto15"] = $Producto->getIMPUESTO15();
            $respuesta["impuesto18"] = $Producto->getIMPUESTO18();
            $respuesta["descuento"] = $Producto->getDESCUENTO();
            $respuesta["nombre"] = $Producto->getPRECIOVENTA();
            $respuesta["estado"] = $Producto->getESTADO();
            $respuesta["nombre"] = $Producto->getTIPOPRODUCTO_IDPRODUCTO();
			
			echo json_encode($respuesta); 
			exit(); 
		break;

		case 'editarDatos':
			$Producto = new Producto(
									    $_POST["idProducto"],
										'',							
										$_POST["cantidad"],
										$_POST["precioCosto"],
										$_POST["impuesto15"],
										$_POST["impuesto18"],
										$_POST["descuento"],
										0,
										1,
										0
								);

			$Producto-> editarProducto($conexion);
			$respuesta["codigo"] = $Producto->getCodigoResultado();						
			$respuesta["mensaje"] =$Producto->getMensaje();
			
			echo json_encode($respuesta); 
			exit(); 
		break;

		case 'eliminarProducto':
			$Producto = Producto::soloObjectoProducto();
			$Producto->eliminarProducto($conexion,$_POST["idProducto"] );
			$respuestaProducto["codigo"] = $Producto->getCodigoResultado();
			$respuestaProducto["mensaje"] =$Producto->getMensaje();
			echo json_encode($respuestaProducto); 
			exit();   
		 break;

		default:
		 	echo 'Opcion invalida.';
		break;
		}

?>