<?php
    session_start();
    unset($_SESSION["gama_idusuario"]); 
    unset($_SESSION["gama_username"]);
    unset($_SESSION["gama_nombre"]); 
    unset($_SESSION["gama_tipousuario"]);
    unset($_SESSION["gama_areatrabajo"]);
    session_destroy();
    header("Location: index.php");
    exit;
?>