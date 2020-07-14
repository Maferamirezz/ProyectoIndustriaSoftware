<?php
  
        registrar
            // Insertar los siguientes datos SQL en la tabla Producto:
            //$_GET["nombreProducto"], $_GET["tipo"], $_GET["estado"], $_GET["cantidadDisponible"], $_GET["precioCosto"], $_GET["impuesto15"], $_GET["impuesto18"], $_GET["descuento"], $_GET["precioVenta"]
            
            // El SP debe SOLA Y UNICAMENTE devolver codigo y mensaje
            $respuesta["codigo"] = 1;
            $respuesta["mensaje"] ='Producto registrado correctamente';
            // RETORNAR RESPUESTA A JS
            echo json_encode($respuesta);
          

        abrirModalEditarDatos
            // Seleccionar del elemento con el id = $_GET["idProducto"] los siguientes datos SQL $_GET["estado"], $_GET["precioCosto"], $_GET["impuesto15"], $_GET["impuesto18"], $_GET["descuento"]
            
            $respuesta["nombreProducto"] = "Kakaroto";
            $respuesta["estado"] = 0;
            $respuesta["precioCosto"] = 200;
            $respuesta["impuesto15"] = 30;
            $respuesta["impuesto18"] = 36;
            $respuesta["descuento"] = 30;

            echo json_encode($respuesta);
            
        abrirModalEditarCantidad
            // Seleccionar del elemento con el id = $_GET["idProducto"] el siguiente dato $_GET["cantidadDisponible"]
            
            $respuesta["nombreProducto"] = "Kakaroto Vegeta";
            $respuesta["cantidadDisponible"] = 1008;
            
            // RETORNAR RESPUESTA A JS
            echo json_encode($respuesta);
            break;
            
        editarDatos
            // Editar el elemento con el id = $_GET["id"] con los siguientes datos SQL: $_GET["estado"], $_GET["precioCosto"], $_GET["impuesto15"], $_GET["impuesto18"], $_GET["descuento"], $_GET["precioVenta"]

            // El SP debe SOLA Y UNICAMENTE devolver codigo y mensaje
            $respuesta["codigo"] = 1;
            $respuesta["mensaje"] = "Se ha completado la edición de un producto";
            // RETORNAR RESPUESTA A JS
            echo json_encode($respuesta);
        
            
        editarCantidad
            // Editar el elemento con el id = $_GET["id"] con los siguientes datos SQL: $_GET["cantidadDisponible"]
            // $_GET["estado"] → SOLO Y UNICAMENTE si la cantidad disponible es cero (0), el estado pasa a INACTIVO, es decir estado = 0

            // El SP debe SOLA Y UNICAMENTE devolver codigo y mensaje
            $respuesta["codigo"] = 1;
            $respuesta["mensaje"] = "Se ha completado la edición de un producto";
            // RETORNAR RESPUESTA A JS
            echo json_encode($respuesta);
         
            
        listaProductos
            // Seleccionar el dato "tipoProducto" de la tabla Producto y todos los datos de la tabla Producto
            
            $temp["nombreProducto"] = "Locura automática xd";
            $temp["idProducto"] = 12;
            $temp["nombreProducto"] = "Manzana";
            $temp["cantidadDisponible"] = 99;
            $temp["tipo"] = 2;
            $temp["tipoProducto"] = "Fruta";
            $temp["precioCosto"] = 100;
            $temp["impuesto15"] = 15;
            $temp["impuesto18"] = 18;
            $temp["descuento"] = 10;
            $temp["precioVenta"] = 123;
            $temp["estado"] = 0;
            $respuesta = [];
            $respuesta[0] = $temp;
            $temp["idProducto"] = 33;
            $temp["nombreProducto"] = "Zanahoria";
            $temp["cantidadDisponible"] = 42;
            $temp["tipo"] = 1;
            $temp["tipoProducto"] = "Verdura";
            $temp["precioCosto"] = 100;
            $temp["impuesto15"] = 15;
            $temp["impuesto18"] = 18;
            $temp["descuento"] = 10;
            $temp["precioVenta"] = 123;
            $temp["estado"] = 1;
            $respuesta[1] = $temp;
            echo json_encode($respuesta);
         
    }
?>
