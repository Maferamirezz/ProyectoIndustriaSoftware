<?php
    session_start();
    
    $accion = $_GET["accion"];
    $identificadorUsuario = $_SESSION["user_idusuario"];
    //$correoUsuario = $_SESSION["user_correo"];

    switch ($accion) {
        case 'ObtenerMisPosts':
            include_once '../class/conexionOracle.php';
            $conexion = new Conexion();
            $SQL = "SELECT * FROM VISTA_PUBLICACIONES WHERE idusuario='".$identificadorUsuario."' ORDER BY FECHAPUBLICACION DESC";
            $resultado = $conexion->ejecutarConsulta($SQL);
            $arreglo = array();
            
            while( $publicacion = $conexion->obtenerFila($resultado) ){
                $arreglo[] = $publicacion;
            }
            echo json_encode($arreglo);
            $conexion->cerrarConexion();
            break;
        case 'PublicarPost':
            $conn = oci_connect("walterwaleska","walterwaleska","localhost/xe") or die;
            $sql= 'BEGIN SP_PUBLICACIONUSUARIO(:pcIdPublicacion,:pcContenido,:pcFotoPost,:pcIdTipoPost,:pcIdUsuario,:pcAccion,:pcCodigo,:pcMessage); END;';
            $stmt = oci_parse($conn,$sql);
            //  Bind the input parameters
            oci_bind_by_name($stmt,':pcIdPublicacion',$pcIdPublicacion,38);
            oci_bind_by_name($stmt,':pcContenido',$pcContenido,4000);
            oci_bind_by_name($stmt,':pcFotoPost',$pcFotoPost,1000);
            oci_bind_by_name($stmt,':pcIdTipoPost',$pcIdTipoPost,38);
            oci_bind_by_name($stmt,':pcIdUsuario',$pcIdUsuario,38);
            oci_bind_by_name($stmt,':pcAccion',$pcAccion,45);
            //  Bind the output parameters
            oci_bind_by_name($stmt,':pcCodigo',$pcCodigo,1);
            oci_bind_by_name($stmt,':pcMessage',$pcMessage,500);

            // Assign a value to the inputs parameters
            $pcContenido= $_GET["texto"];
            $pcFotoPost= $_GET["img"];
            $pcIdTipoPost= $_GET["idtipopost"];
            $pcIdUsuario= $identificadorUsuario;
            $pcAccion= 'PublicarPost';

            oci_execute($stmt);
            // $message is now populated with the output value
            $respuesta["pcCodigo"] = "$pcCodigo";
            $respuesta["pcMessage"] = "$pcMessage";
            echo json_encode($respuesta);
            oci_close($conn);
            break;
        case 'BorrarPost':
            $conn2 = oci_connect("walterwaleska","walterwaleska","localhost/xe") or die;
            $sql2= 'BEGIN SP_PUBLICACIONUSUARIO(:pcIdPublicacion,:pcContenido,:pcFotoPost,:pcIdTipoPost,:pcIdUsuario,:pcAccion,:pcCodigo,:pcMessage); END;';
            $stmt2 = oci_parse($conn2,$sql2);
            //  Bind the input parameters
            oci_bind_by_name($stmt2,':pcIdPublicacion',$pcIdPublicacion,38);
            oci_bind_by_name($stmt2,':pcContenido',$pcContenido,4000);
            oci_bind_by_name($stmt2,':pcFotoPost',$pcFotoPost,1000);
            oci_bind_by_name($stmt2,':pcIdTipoPost',$pcIdTipoPost,38);
            oci_bind_by_name($stmt2,':pcIdUsuario',$pcIdUsuario,38);
            oci_bind_by_name($stmt2,':pcAccion',$pcAccion,45);
            //  Bind the output parameters
            oci_bind_by_name($stmt2,':pcCodigo',$pcCodigo,1);
            oci_bind_by_name($stmt2,':pcMessage',$pcMessage,500);

            // Assign a value to the inputs parameters
            $pcIdPublicacion= $_GET["idPost"];
            $pcContenido= null;
            $pcFotoPost= null;
            $pcIdTipoPost= null;
            $pcIdUsuario= $identificadorUsuario;
            $pcAccion= 'BorrarPost';

            oci_execute($stmt2);
            // $message is now populated with the output value
            $respuesta["pcCodigo"] = "$pcCodigo";
            $respuesta["pcMessage"] = "$pcMessage";
            echo json_encode($respuesta);
            oci_close($conn2);
            break;
        case 'ObtenerNumPosts':
            include_once '../class/conexionOracle.php';
            $cc = new Conexion();
            $SQLnAmi = "SELECT * FROM vista_InfoPerfil WHERE idUsuario='".$identificadorUsuario."'";
            $resultado = $cc->ejecutarConsulta($SQLnAmi);
            $ima = '';
            
            while( $nAmi = $cc->obtenerFila($resultado) ){
                $ima = $nAmi;
            }
            echo json_encode($ima);
            $cc->cerrarConexion();
            break;
	}
?>