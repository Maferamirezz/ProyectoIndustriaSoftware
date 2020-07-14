<?php

        registrar
            // Insertar los siguientes datos SQL en tabla Proveedor
            /*$_GET["rtn"], $_GET["nombreProveedor"], $_GET["tipo"], $_GET["direccion"], $_GET["cantidad"], $_GET["precio"]*/

            $respuesta["codigo"] = 1;
            $respuesta["mensaje"] ='Proveedor registrado correctamente';
            echo json_encode($respuesta);
    

        abrirModal
            // Buscar del elemento con el id = $_GET["rtn"] los siguientes datos SQL: $respuesta["nombreProveedor"], $_GET["rtn"], $_GET["tipo"], $_GET["direccion"], $_GEt["telefono"], $_GET["email"], $_GET["estado"]
                
            $respuesta["nombreProveedor"] = "Juanin Juan Jarris";
            $respuesta["rtn"] = 20161003928;
            $respuesta["tipo"] = "Persona";
            $respuesta["direccion"] = "Avenida Gutenberg, dos cuadras adelante del hospital general";
            $respuesta["telefono"] = 22020090;
            $respuesta["email"] = "example@assa.adas";
            $respuesta["estado"] = 1;
            echo json_encode($respuesta);
            
        editar
            // Editar el elemento con el id = $_GET["rtn"] conn los siguientes datos: $_GET["direccion"], $_GET["telefono"], $_GET["email"], $_GET["estado"];
            
            //El SP debe SOLA Y UNICAMENTE devolver codigo y mensaje
            $respuesta["codigo"] = 1;
            $respuesta["mensaje"] ='Insumo editado correctamente';
            echo json_encode($respuesta);
          
            
    }
?>
