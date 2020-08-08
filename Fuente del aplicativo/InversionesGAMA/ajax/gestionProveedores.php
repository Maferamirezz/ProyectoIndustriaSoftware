<?php  

	include("../class/class-conexion.php");
	$conexion = new Conexion();
	
	switch($_GET["accion1"]) {
		
		case'guardar':
			include("../class/class-proveedor.php");
			$Proveedor = new Proveedor ($_POST["proveedor-txt-rtn"],
                                         $_POST["proveedor-txt-nombre"],
                                         $_POST["proveedor-txt-direccion"],
                                         $_POST["proveedor-txt-email"],
                                         $_POST["proveedor-txt-telefono"],
                                         "1",
										 "1");
                                         
										
                                         
                                         
		    echo($Proveedor-> __toString());
			$Proveedor->guardarProveedor($conexion);
			break;

			default:
			 	echo 'Opcion invalida.';
			 break;
		}

?>