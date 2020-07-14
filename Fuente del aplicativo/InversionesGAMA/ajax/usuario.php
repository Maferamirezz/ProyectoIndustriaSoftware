<?php

 session_start();

    $pnombre = $_GET["pnombre"];
    $papellido= $_GET["papellido"];
    $contrasenia = $_GET["pcontraseña"];
    $tipo = $_GET["tipo"];
    $telefono = $_GET["telefono"];
    $area = $_GET["area"];
    $username = $_GET["username"];
    $direccion = $_GET["direccion"];
    $contrato = $_GET["contrato"];

    include_once '../class/conexionOracle.php';
    $conexion = new Conexion();
    $SQL= "SELECT * FROM Usuario";
    $resultado = $conexion->ejecutarConsulta($SQL);
    $respuesta = '';

    while ($usuario = $conexion->obtenerFila($resultado)){
        if($usuario["EMAIL"]==$email && $usuario["CONTRASENIA"]==$contrasenia){
            
            $_SESSION["user_pnombre"] = $usuario["pnombre"];
            $_SESSION["user_papellido"] = $_GET["papellido"];
            $_SESSION["user_tipo"] = $usuario["tipo"];
            $_SESSION["user_telefono"] = $usuario["telefono"];
            $_SESSION["user_area"] = $usuario["area"];
            $_SESSION["user_username"] = $usuario["username"];
            $_SESSION["user_direccion"] = $usuario["direccion"];
            $_SESSION["user_contrato"] = $usuario["contrato"];
       
            
            $respuesta["codigo"]=1;
            $respuesta["mensaje"]='Credenciales válidas';
            $respuesta["estado"] = 0;
            echo json_encode($respuesta);
            $conexion->cerrarConexion();
            exit();
        }
    }
    $respuesta["codigo"]=0;
    $respuesta["mensaje"]="Credenciales inválidas";
    echo json_encode($respuesta);

 case 'listaUsuarios':
            # code...
            break;


    $conexion->cerrarConexion();

 }




?>
