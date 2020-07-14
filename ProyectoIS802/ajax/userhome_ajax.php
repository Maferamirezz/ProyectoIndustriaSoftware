<?php
    session_start();
    
    $accion = $_GET["accion"];
    $identificadorUsuario = $_SESSION["user_idusuario"];

	switch ($accion) {
        case 'ObtenerHomePerfil':
        /*Obtener la informacion del usuario y mostrarla en la tarjeta de resumen del perfil en userhome.php**/
            include_once '../class/conexionOracle.php';
            $conexion = new Conexion();
            $SQL = "SELECT * FROM vista_InfoPerfil WHERE idUsuario='".$identificadorUsuario."'";
            $resultado = $conexion->ejecutarConsulta($SQL);
            $respuesta = '';
            
            while( $perfil = $conexion->obtenerFila($resultado) ){
                $respuesta = $perfil;
            }
            echo json_encode($respuesta);
            $conexion->cerrarConexion();
            break;
        case 'ObtenerPostsAmigosEmisores':
        /*Lista de publicaciones de amigos que enviaron solicitud de amistad al usuario*/
            include_once '../class/conexionOracle.php';
            $identificadorUsuario = $_SESSION["user_idusuario"];
        
            $conexion = new Conexion();
            $sql = "SELECT * FROM VISTA_PUBLICACIONES WHERE IDUSUARIO IN (SELECT idEmisor FROM vista_listaamigosemisores where idReceptor='".$identificadorUsuario."')";
            $query = $conexion->ejecutarConsulta($sql);
            $respuesta = array();
            
            while( $post_amigosemisores = $conexion->obtenerFila($query) ){
                    $post_amigosemisores["UACTIVO"] = $identificadorUsuario;
                    $respuesta[] = $post_amigosemisores;
            }
        
            echo json_encode($respuesta);
            $conexion->cerrarConexion();
            break;
        case 'ObtenerPostsAmigosReceptores':
        /*Lista de publicaciones de amigos que recibieron solicitud de amistad del usuario*/
            include_once '../class/conexionOracle.php';
            $identificadorUsuario = $_SESSION["user_idusuario"];
        
            $conexion = new Conexion();
            $sql = "SELECT * FROM VISTA_PUBLICACIONES WHERE IDUSUARIO IN (SELECT idReceptor FROM vista_listaamigosreceptores where idEmisor='".$identificadorUsuario."')";
            $query = $conexion->ejecutarConsulta($sql);
            $respuesta = array();
            
            while( $post_amigosemisores = $conexion->obtenerFila($query) ){
                    $post_amigosemisores["UACTIVO"] = $identificadorUsuario;
                    $respuesta[] = $post_amigosemisores;
            }
        
            echo json_encode($respuesta);
            $conexion->cerrarConexion();
            break;
	}
?>