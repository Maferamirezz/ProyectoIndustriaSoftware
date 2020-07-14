<?php
    $accion = $_GET["accion"];
    switch ($accion) {
        case 'registrar':
            $respuesta["codigo"] = 1;
            $respuesta["mensaje"] ='Proveedor registrado correctamente';
            echo json_encode($respuesta);
            break;

        case 'abrirModal':
            // Buscar información del elemento con el id = $_GET["rtn"]
            $respuesta["mensaje"] = "Apertura ventana modal para editar proveedor";
                
            $respuesta["nombre"] = "Juanin Juan Jarris";
            $respuesta["rtn"] = $_GET["rtn_proveedor"];
            $respuesta["tipo"] = "Persona";
            $respuesta["direccion"] = "Avenida Gutenberg, dos cuadras adelante del hospital general";
            $respuesta["telefono"] = "22020090";
            $respuesta["email"] = "example@assa.adas";
            $respuesta["estado"] = 1;
            echo json_encode($respuesta);
            break;
            
        case 'editar':
            // Editar el elemento con el id = $_GET["rtn"]
            $respuesta["mensaje"] = "Se ha completado la edición de un proveedor";

            $respuesta["nombre"] = $_GET["nombre"];
            $respuesta["rtn"] = $_GET["rtn"]; // Retorno
            //$respuesta["tipo"] = $_GET["tipo"];
            $respuesta["tipo"] = 1;
            $respuesta["direccion"] = $_GET["direccion"];
            $respuesta["telefono"] = $_GET["telefono"];
            $respuesta["email"] = $_GET["email"];
            $respuesta["estado"] = $_GET["estado"];
            echo json_encode($respuesta);
            break;
            
        case 'listaProveedores':
            # code...
            break;
    }
?>