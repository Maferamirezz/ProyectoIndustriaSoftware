/**
 * @fileoverview Inicio de sesión: validar credenciales, recuperar contraseña
 * @version         2.0
 * @author          Maria Ramirez, Gerardo Alvarenga, Juan Enriquez, Walter Rivera
 * @copyright       GAMA
 */
$(document).ready(function(){
    console.log("El DOM 'index.php' ha sido cargado ♥");
    alert("Las credenciales para entrar son: username = JuanDPC2016, password = contraseNIA@2020");
});

// VALIDAR CREDENCIALES DEL USUARIO
$("#btn-login").click(function(){
    if(
        validarRegex("login-txt-username", "username") &&
        validarRegex("login-txt-password", "password")
    ) {
        // Objetivo: validar la existencia del nombre de usuario y contraseña
        var parametros = "username="+$("#login-txt-username").val()+"&"+
                         "password="+$("#login-txt-password").val();
        console.log(parametros);
        $("#btn-login").attr("disabled",true);
        $.ajax({
            url:"ajax/login.php",
            data:parametros,
            method:"GET",
            dataType:"json",
            success:function(respuesta){
                console.log(respuesta);
                alert(respuesta.mensaje);
                switch (respuesta.codigo) {
                    case 1:
                        window.location = "panel.php";
                        break;
                    case 0:
                        addInvalid("login-txt-username");
                        addInvalid("login-txt-password");
                        $("#btn-login").attr("disabled",false);
                        break;
                    case 99:
                        $("#btn-login").attr("disabled",false);
                        break;
                }
            },
            error:function(error){
                console.log(error);
                $("#btn-login").attr("disabled",false);
            }
        });
    }
    else{alert("Credenciales mal escritas.")}
});