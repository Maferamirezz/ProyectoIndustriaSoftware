<?php
 
     iNFO ITEM
            // Seleccionar los datos SQL del producto con id = $_GET["idProducto]
            $respuesta["nombreProducto"] = "Zapayo";
            $respuesta["precioCosto"]= 100;
            $respuesta["impuesto15"]= 15;
            $respuesta["impuesto18"]= 18;
            $respuesta["descuento"]= 7;
            $respuesta["precioVenta"] = 126;
            $respuesta["cantidadDisponible"] = 255;
            echo json_encode($respuesta);
            
        registrar
            // Insertar los siguientes datos SQL en la tabla factura: $_GET["idFactura"], $_GET["idCliente"], $_GET["fecha"], $_GET["total"]
            // HACE FALTA MODIFICAR LAS FUNCIONES PARA GENERAR LOS DATOS DE SUBTOTAL, TOTAL DE IMPORTES EXONERADOS Y TOTAL DE IMPUESTOS, SINO HACERLO INTERNAMENTE EN SP

            // El SP debe SOLA Y UNICAMENTE devolver codigo y mensaje
            $respuesta["codigo"] = 1;
            $respuesta["mensaje"] ='Factura registrada correctamente';
            // RETORNAR RESPUESTA A JS
            echo json_encode($respuesta);
    
    }
?>
