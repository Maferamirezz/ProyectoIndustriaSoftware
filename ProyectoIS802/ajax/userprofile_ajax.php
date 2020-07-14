<?php
    session_start();
    
    $accion = $_GET["accion"];
    $identificadorUsuario = $_SESSION["user_idusuario"];
    $correoUsuario = $_SESSION["user_correo"];

    switch ($accion) {
        case 'EditarPerfil':
            $conn = oci_connect("walterwaleska","walterwaleska","localhost/xe") or die;
            $sql= 'BEGIN SP_GESTIONPERFIL(:pcCorreo,:pcbirthday,:pcfoto,:pcreligion,:pcpolitica,:pcestadocivil,:pcapodo,:pctelefono,:pclugar1,:pclugar2,:pcsitioWeb,:pcdescripcion,:pcAccion,:pcCodigo,:pcMessage); END;';
            $stmt = oci_parse($conn,$sql);
            //  Bind the input parameters
            oci_bind_by_name($stmt,':pcCorreo',$pcCorreo,45);
            oci_bind_by_name($stmt,':pcbirthday',$pcbirthday,45);
            oci_bind_by_name($stmt,':pcfoto',$pcfoto,1000);
            oci_bind_by_name($stmt,':pcreligion',$pcreligion,45);
            oci_bind_by_name($stmt,':pcpolitica',$pcpolitica,45);
            oci_bind_by_name($stmt,':pcestadocivil',$pcestadocivil,45);
            oci_bind_by_name($stmt,':pcapodo',$pcapodo,45);
            oci_bind_by_name($stmt,':pctelefono',$pctelefono,45);
            oci_bind_by_name($stmt,':pclugar1',$pclugar1,45);
            oci_bind_by_name($stmt,':pclugar2',$pclugar2,45);
            oci_bind_by_name($stmt,':pcsitioWeb',$pcsitioWeb,45);
            oci_bind_by_name($stmt,':pcdescripcion',$pcdescripcion,1000);
            oci_bind_by_name($stmt,':pcAccion',$pcAccion,45);
            //  Bind the output parameters
            oci_bind_by_name($stmt,':pcCodigo',$pcCodigo,1);
            oci_bind_by_name($stmt,':pcMessage',$pcMessage,500);

            // Assign a value to the inputs parameters
            $pcCorreo= $correoUsuario;
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
            $respuesta["UACTIVO"] = $identificadorUsuario;
            echo json_encode($respuesta);
            oci_close($conn);
            break;
	}
?>