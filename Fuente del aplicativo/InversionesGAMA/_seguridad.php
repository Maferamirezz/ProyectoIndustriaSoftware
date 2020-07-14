<?php
    session_start(); 
    if (!isset($_SESSION["gama_idusuario"]) &&
        !isset($_SESSION["gama_username"]) &&
        !isset($_SESSION["gama_nombre"]) &&
        !isset($_SESSION["gama_tipousuario"]) &&
        !isset($_SESSION["gama_areatrabajo"])){
        header("Location: index.php");
    }
?>