<?php  
    session_start();
	include("../class/class-conexion.php");
	include("../class/class-Cliente.php");

	$conexion = new Conexion();
	$username = $_SESSION["gama_username"];	

	switch($_GET["accion1"]) {		
		case'guardar':		
			$Cliente = new Cliente (  
										0,
										$_POST["nombre"],							
										$_POST["estado"],
										$_POST["direccion"],
										$_POST["telefono"],
										$_POST["tipo"]
							);
		   // echo($Insumo-> __toString());
			$Cliente->guardarCliente($conexion);
			$respuestaCliente["codigo"] = $Cliente->getCodigo();
			$respuestaCliente["mensaje"] =$Cliente->getMensaje();
			echo json_encode($respuestaCliente); 
			exit();            
		break;

		case'mostrar':
			$Cliente = Cliente::soloObjectoCliente();
			$respuestaMostrarCliente= $Cliente->obtenerClientes ($conexion);
			echo json_encode($respuestaMostrarCliente); 
			exit();  
		break;

		case 'llenarTipoCliente':
			$Cliente = Cliente::soloObjectoCliente();
			$respuestaMostraTipoCliente= $Cliente->obtenerTipoCliente ($conexion);
			echo json_encode($respuestaMostraTipoCliente); 
			exit();   
		 break;

		case 'mostrarDatosEditar':
			$Cliente = Cliente::soloObjectoCliente();
			$Cliente->obtenerCliente ($conexion, $_GET["idCliente"]);
			$respuesta["idCliente"] = $Cliente->getIDCLIENTE();
            $respuesta["nombreCliente"] = $Cliente->getNOMBRECLIENTE();
            $respuesta["direccion"] = $Cliente->getDIRECCION();
			$respuesta["telefono"] = $Cliente->getTELEFONO();
			$respuesta["estado"] = $Cliente->getESTADO();
            $respuesta["tipo"] = $Cliente->getTIPOCLIENTE();
			echo json_encode($respuesta); 
			exit(); 
		break;

		case 'editarDatos':
			$Cliente = new Cliente(
									$_POST["idCliente"],	
									$_POST["nombreCliente"],							
									$_POST["estado"],
									$_POST["direccion"],
									$_POST["telefono"],
									$_POST["tipo"]
								);

			$Cliente-> editarCliente($conexion);
			$respuesta["codigo"] = $Cliente->getCodigo();						
			$respuesta["mensaje"] =$Cliente->getMensaje();
			
			echo json_encode($respuesta); 
			exit(); 
		break;

		case 'eliminarCliente':
			$Cliente = Cliente::soloObjectoCliente();
			$Cliente->eliminarCliente($conexion,$_POST["idCliente"] );
			$respuestaCliente["codigo"] = $Cliente->getCodigo();
			$respuestaCliente["mensaje"] =$Cliente->getMensaje();
			echo json_encode($respuestaCliente); 
			exit();   
		 break;

		default:
		 	echo 'Opcion invalida.';
		break;
		}

?>