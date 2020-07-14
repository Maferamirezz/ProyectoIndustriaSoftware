<?php
    //REGISTRAR
            $respuesta["codigo"] = 1;
            $respuesta["mensaje"] ='Insumo registrado correctamente';
            // Se suma a la respuesta el nombre del empleado que registro el insumo, obteniendolo de las variables de sesion -> $_SESSION["nombreEmpleado"]
            $respuesta["nombreEmpleado"] = "Juan José Pérez López";
            // RETORNAR RESPUESTA A JS
            echo json_encode($respuesta);
            

       //Abrir modal
      

            $respuesta["cantidad"] = 1008;
            $respuesta["precio"] = 25.8;
            $respuesta["nombreInsumo"] ='Nombre insumo';
            echo json_encode($respuesta);
       
            
     //editar

            $respuesta["codigo"] = 1;
            $respuesta["mensaje"] ='Insumo editado correctamente';
            // Se suma a la respuesta el nombre del empleado que registro el insumo, obteniendolo de las variables de sesion -> $_SESSION["nombreEmpleado"]
            $respuesta["nombreEmpleado"] = "Lionel Andres Messi Cuccitini";
            echo json_encode($respuesta);
            break;
            
        case 'listaInsumos':
            # code...

    }
?>
