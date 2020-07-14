<?php
    session_start();

    // GUARDAR LAS CREDENCIALES INGRESADAS POR EL USUARIO
    $username = $_GET["username"];
    $contrasenia = $_GET["password"];

    // AQUI SE DEBE ESTABLECER UNA CONEXION CON LA BASE DE DATOS

    // AQUI SE DEBE EJECUTAR UNA SENTENCIA SQL PARA COMPARAR LAS CREDENCIALES CON LAS QUE
    // ESTAN GUARDADAS EN LA BASE DE DATOS. SUPONER QUE EL RESULTADO SE GUARDO EN $consultaSQL
    // DICHO RESULTADO ES UN ARRAY ASOCIATIVO
    $consultaSQL["idUsuario"]=20161003971;
    $consultaSQL["username"]="JuanDPC2016";
    $consultaSQL["password"]="contraseNIA@2020";
    $consultaSQL["pnombre"]="Juan";
    $consultaSQL["snombre"]="Carlos";
    $consultaSQL["papellido"]="Perez";
    $consultaSQL["sapellido"]="Dominguez";
    $consultaSQL["tipoUsuario"]="Empleado";
    $consultaSQL["areaTrabajo"]="Inventario";
    $consultaSQL["estado"]=1;
    $consultaSQL["genero"]=1;
    
    if ($consultaSQL["username"] == $_GET["username"] && $consultaSQL["password"] == $_GET["password"]) {
        // LUEGO ASIGNAR LOS SIGUIENTES VALORES A VARIABLES DE SESION:
        //      TABLA TipoUsuario = tipoUsuario
        //      TABLA Usuario = idUsuario, estado
        //      TABLA Persona = pnombre, snombre, papellido, sapellido, genero
        //      TABLA AreaTrabajo = areaTrabajo

        $_SESSION["gama_idusuario"] = $consultaSQL["idUsuario"];
        $_SESSION["gama_username"] = $_GET["username"];
        $_SESSION["gama_nombre"] = $consultaSQL["pnombre"]." ".$consultaSQL["snombre"]." ".$consultaSQL["papellido"]." ".$consultaSQL["sapellido"];
        $_SESSION["gama_tipousuario"] = $consultaSQL["tipoUsuario"];
        $_SESSION["gama_areatrabajo"] = $consultaSQL["areaTrabajo"];

        if ($consultaSQL["estado"] == 0) {
            $respuesta["codigo"]=99;
            $respuesta["mensaje"]='ACCESO DENEGADO. EL USUARIO ESTÁ DESACTIVADO';
            echo json_encode($respuesta);
            //$conexion->cerrarConexion();
            exit();
        }
        $respuesta["codigo"]=1;
        $respuesta["mensaje"]='Credenciales válidas';
        echo json_encode($respuesta);
        //$conexion->cerrarConexion();
        exit();
    }
    $respuesta["codigo"]=0;
    $respuesta["mensaje"]="El nombre de usuario y la contraseña no coinciden. Verifique e inténtelo de nuevo.";
    echo json_encode($respuesta);
    //$conexion->cerrarConexion();
?>