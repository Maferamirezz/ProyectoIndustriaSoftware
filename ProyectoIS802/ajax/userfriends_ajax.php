<?php
    session_start();
    
    $accion = $_GET["accion"];
    $identificadorUsuario = $_SESSION["user_idusuario"];

    switch ($accion) {
        case 'agregarAmigo':
            $conn1 = oci_connect("walterwaleska","walterwaleska","localhost/xe") or die;
            $sql1= 'BEGIN SP_AMISTAD(:pcIdEmisor,:pcIdReceptor,:pcAccion,:pcCodigo,:pcMessage); END;';
            $stmt1 = oci_parse($conn1,$sql1);
            //  Bind the input parameters
            oci_bind_by_name($stmt1,':pcIdEmisor',$pcIdEmisor,38);
            oci_bind_by_name($stmt1,':pcIdReceptor',$pcIdReceptor,38);
            oci_bind_by_name($stmt1,':pcAccion',$pcAccion,45);
            //  Bind the output parameters
            oci_bind_by_name($stmt1,':pcCodigo',$pcCodigo,1);
            oci_bind_by_name($stmt1,':pcMessage',$pcMessage,500);

            // Assign a value to the inputs parameters
            $pcIdEmisor= $_GET["idUser"];
            $pcIdReceptor= $_GET["idFriend"];
            $pcAccion= 'agregarAmigo';

            oci_execute($stmt1);
            // $message is now populated with the output value
            $respuesta["pcCodigo"] = "$pcCodigo";
            $respuesta["pcMessage"] = "$pcMessage";
            echo json_encode($respuesta);
            oci_close($conn1);
            break;
        case 'EliminarAmigo':
            $conn2 = oci_connect("walterwaleska","walterwaleska","localhost/xe") or die;
            $sql2= 'BEGIN SP_AMISTAD(:pcIdEmisor,:pcIdReceptor,:pcAccion,:pcCodigo,:pcMessage); END;';
            $stmt2 = oci_parse($conn2,$sql2);
            //  Bind the input parameters
            oci_bind_by_name($stmt2,':pcIdEmisor',$pcIdEmisor,38);
            oci_bind_by_name($stmt2,':pcIdReceptor',$pcIdReceptor,38);
            oci_bind_by_name($stmt2,':pcAccion',$pcAccion,45);
            //  Bind the output parameters
            oci_bind_by_name($stmt2,':pcCodigo',$pcCodigo,1);
            oci_bind_by_name($stmt2,':pcMessage',$pcMessage,500);

            // Assign a value to the inputs parameters
            $pcIdEmisor= $_GET["idUser"];
            $pcIdReceptor= $_GET["idFriend"];
            $pcAccion= 'agregarAmigo';

            oci_execute($stmt2);
            // $message is now populated with the output value
            $respuesta["pcCodigo"] = "$pcCodigo";
            $respuesta["pcMessage"] = "$pcMessage";
            echo json_encode($respuesta);
            oci_close($conn2);
            break;
        case 'GetAmigosEmisores':
        /*Lista de amigos que han ENVIADO solicitud de amistad al usuario*/
            include_once '../class/conexionOracle.php';
            $conexion = new Conexion();
            $SQL = "SELECT * FROM vista_listaamigosemisores WHERE idReceptor='".$identificadorUsuario."'";
            $resultado = $conexion->ejecutarConsulta($SQL);
            $arreglo = array();
            
            while( $amigos = $conexion->obtenerFila($resultado) ){
                $amigos["UACTIVO"] = $identificadorUsuario;
                $arreglo[] = $amigos;
            }
            echo json_encode($arreglo);
            $conexion->cerrarConexion();
            break;
        case 'GetAmigosReceptores':
        /*Lista de amigos que han RECIBIDO solicitud de amistad del usuario*/
            include_once '../class/conexionOracle.php';
            $conexion = new Conexion();
            $SQL = "SELECT * FROM vista_listaamigosreceptores WHERE idEmisor='".$identificadorUsuario."'";
            $resultado = $conexion->ejecutarConsulta($SQL);
            $arreglo = array();
            
            while( $amigos = $conexion->obtenerFila($resultado) ){
                $amigos["UACTIVO"] = $identificadorUsuario;
                $arreglo[] = $amigos;
            }
            echo json_encode($arreglo);
            $conexion->cerrarConexion();
            break;
	}
?>