<?php
    $accion = $_GET["accion"];

	switch ($accion) {
        case 'Obtener Generos':
            include_once '../class/conexionOracle.php';
            $conexion = new Conexion();
            $SQL = "SELECT idgenero, descripcion FROM genero";
            $resultado = $conexion->ejecutarConsulta($SQL);
            $arreglo = array();
            
            while( $genero = $conexion->obtenerFila($resultado) ){
                $arreglo[] = $genero;
            }
            echo json_encode($arreglo);
            $conexion->cerrarConexion();
            break;
        case 'Registrar':
            $conn = oci_connect("walterwaleska","walterwaleska","localhost/xe") or die;
            $sql= 'BEGIN SP_GESTIONUSUARIO(:pcPrimerNombre,:pcSegundoNombre,:pcPrimerApellido,:pcSegundoApellido,:pcGenero,:pcCorreo,:pcContrasenia,:pcAccion,:pcCodigo,:pcMessage); END;';
            $stmt = oci_parse($conn,$sql);
            //  Bind the input parameters
            oci_bind_by_name($stmt,':pcPrimerNombre',$primerNombre,45);
            oci_bind_by_name($stmt,':pcSegundoNombre',$segundoNombre,45);
            oci_bind_by_name($stmt,':pcPrimerApellido',$primerApellido,45);
            oci_bind_by_name($stmt,':pcSegundoApellido',$segundoApellido,45);
            oci_bind_by_name($stmt,':pcGenero',$genero,38);
            oci_bind_by_name($stmt,':pcCorreo',$email,45);
            oci_bind_by_name($stmt,':pcContrasenia',$contrasenia,45);
            oci_bind_by_name($stmt,':pcAccion',$pcAccion,45);
            //  Bind the output parameters
            oci_bind_by_name($stmt,':pcCodigo',$pcCodigo,1);
            oci_bind_by_name($stmt,':pcMessage',$pcMessage,500);

            // Assign a value to the inputs parameters
            $primerNombre= $_GET["pNombre"];
            $segundoNombre= $_GET["sNombre"];
            $primerApellido= $_GET["pApellido"];
            $segundoApellido= $_GET["sApellido"];
            $genero= $_GET["genero"];
            $email= $_GET["email"];
            $contrasenia= $_GET["password"];
            $pcAccion= 'Registrar';

            oci_execute($stmt);
            // $message is now populated with the output value
            $respuesta["pcCodigo"] = "$pcCodigo";
            $respuesta["pcMessage"] = "$pcMessage";
            echo json_encode($respuesta);
            oci_close($conn);
            break;
        case 'EditarPerfil':
            $conn = oci_connect("walterwaleska","walterwaleska","localhost/xe") or die;
            $sql= 'BEGIN SP_GESTIONPERFIL(:pcCorreo,:pcbirthday,:pcfoto,:pcreligion,:pcpolitica,:pcestadocivil,:pcapodo,:pctelefono,:pclugar1,:pclugar2,:pcsitioWeb,:pcdescripcion,:pcAccion,:pcCodigo,:pcMessage); END;';
            $stmt = oci_parse($conn,$sql);
            //  Bind the input parameters
            oci_bind_by_name($stmt,':pcCorreo',$pcCorreo,38);
            oci_bind_by_name($stmt,':pcbirthday',$pcbirthday,45);
            oci_bind_by_name($stmt,':pcfoto',$pcfoto,1000);
            oci_bind_by_name($stmt,':pcreligion',$pcreligion,45);
            oci_bind_by_name($stmt,':pcpolitica',$pcpolitica,45);
            oci_bind_by_name($stmt,':pcestadocivil',$pcestadocivil,45);
            oci_bind_by_name($stmt,':pcapodo',$pcapodo,45);
            oci_bind_by_name($stmt,':pctelefono',$pctelefono,45);
            oci_bind_by_name($stmt,':pclugar1',$pclugar1,38);
            oci_bind_by_name($stmt,':pclugar2',$pclugar2,38);
            oci_bind_by_name($stmt,':pcsitioWeb',$pcsitioWeb,45);
            oci_bind_by_name($stmt,':pcdescripcion',$pcdescripcion,1000);
            oci_bind_by_name($stmt,':pcAccion',$pcAccion,45);
            //  Bind the output parameters
            oci_bind_by_name($stmt,':pcCodigo',$pcCodigo,1);
            oci_bind_by_name($stmt,':pcMessage',$pcMessage,500);

            // Assign a value to the inputs parameters
            $pcCorreo= $_GET["correoe"];
            $pcbirthday= $_GET["birthday"];
            $pcfoto= $_GET["foto"];
            $pcreligion= $_GET["religion"];
            $pcpolitica= $_GET["politica"];
            $pcestadocivil= $_GET["estadocivil"];
            $pcapodo= $_GET["apodo"];
            $pctelefono= $_GET["telefono"];
            $pclugar1= $_GET["lugar1"];
            $pclugar2= $_GET["lugar2"];
            $pcsitioWeb= $_GET["sitioWeb"];
            $pcdescripcion= $_GET["descripcion"];
            $pcAccion= 'EditarPerfil';

            oci_execute($stmt);
            // $message is now populated with the output value
            $respuesta["pcCodigo"] = "$pcCodigo";
            $respuesta["pcMessage"] = "$pcMessage";
            echo json_encode($respuesta);
            oci_close($conn);
            break;
	}    
?>