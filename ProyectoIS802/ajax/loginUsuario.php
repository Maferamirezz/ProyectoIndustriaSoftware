<?php
    session_start();

    $email = $_GET["email"];
    $contrasenia = $_GET["contrasenia"];

    include_once '../class/conexionOracle.php';
    $conexion = new Conexion();
    $SQL= "SELECT * FROM Usuario";
    $resultado = $conexion->ejecutarConsulta($SQL);
    $respuesta = '';

    while ($usuario = $conexion->obtenerFila($resultado)){
        if($usuario["EMAIL"]==$email && $usuario["CONTRASENIA"]==$contrasenia){
            
            $_SESSION["user_idusuario"] = $usuario["IDUSUARIO"];
            $_SESSION["user_correo"] = $_GET["email"];
            $_SESSION["user_genero"] = $usuario["IDGENERO"];
            $_SESSION["user_primernombre"] = $usuario["PRIMERNOMBRE"];
            $_SESSION["user_primerapellido"] = $usuario["PRIMERAPELLIDO"];
            
            $respuesta["codigo"]=1;
            $respuesta["mensaje"]='Credenciales válidas';
            echo json_encode($respuesta);
            $conexion->cerrarConexion();
            exit();
        }
    }
    $respuesta["codigo"]=0;
    $respuesta["mensaje"]="Credenciales inválidas";
    echo json_encode($respuesta);
    $conexion->cerrarConexion();
?>