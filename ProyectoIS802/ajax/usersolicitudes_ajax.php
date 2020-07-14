<?php
    session_start();
    
    $accion = $_GET["accion"];
    $identificadorUsuario = $_SESSION["user_idusuario"];

    switch ($accion) {
        case 'GetSolicitudes':
            include_once '../class/conexionOracle.php';
            $conexion = new Conexion();
            $SQL = "SELECT * FROM vista_listasolicitudes WHERE idreceptor='".$identificadorUsuario."'";
            $resultado = $conexion->ejecutarConsulta($SQL);
            $arreglo = array();
            
            while( $amigos = $conexion->obtenerFila($resultado) ){
                $arreglo[] = $amigos;
            }
            echo json_encode($arreglo);
            $conexion->cerrarConexion();
            break;
	}
?>