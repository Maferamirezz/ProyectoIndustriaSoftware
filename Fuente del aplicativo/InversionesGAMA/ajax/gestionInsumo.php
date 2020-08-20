<?php  
    session_start();
	include("../class/class-conexion.php");
	include("../class/class-insumo.php");

	$conexion = new Conexion();
	$username = $_SESSION["gama_username"];	

	switch($_GET["accion1"]) {		
		case'guardar':			
			$Insumo = new Insumo ( $_POST["insumo-txt-nombre"],
                                         $_POST["insumo-txt-fecha"],
                                         $_POST["insumo-txt-cantidad"],
										 $_POST["insumo-txt-precio"],
										 $_POST["insumo-txt-tipo"],
										 $username,
										 $_POST["insumo-txt-proveedor"]
									);                                         
		   // echo($Insumo-> __toString());
			$Insumo->guardarInsumo($conexion);
			$respuestaInsumo["codigo"] = $Insumo->getCodigoResultado();
			$respuestaInsumo["mensaje"] =$Insumo->getMensaje();
			echo json_encode($respuestaInsumo); 
			exit();            
		break;

		case'mostrar':
			$Insumo = Insumo::soloObjectoInsumo();
			$respuestaMostrarInsumo = $Insumo->obtenerInsumos ($conexion);
			echo json_encode($respuestaMostrarInsumo); 
			exit();  
		break;

		case 'llenarTipoInsumo':
			$Insumo = Insumo::soloObjectoInsumo();	
			$respuestaMostrarInsumo = $Insumo->obtenerTipoInsumo ($conexion);
			echo json_encode($respuestaMostrarInsumo); 
			exit();  
		 break;
		 case 'llenarProveedor':
			$Insumo = Insumo::soloObjectoInsumo();	
			$respuestaMostraProveedores = $Insumo->obtenerProveedores ($conexion);
			echo json_encode($respuestaMostraProveedores); 
			exit();  
	     break;

			case 'mostrarModalEditar':
				# code...
				break;

		default:
		 	echo 'Opcion invalida.';
		break;
		}

?>