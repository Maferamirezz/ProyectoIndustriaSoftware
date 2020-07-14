/**
 * @fileoverview Gestión de administración: usuarios, jornada laboral, logs de sesión
 * @version         7.0
 * @author          Maria Ramirez, Gerardo Alvarenga, Juan Enriquez, Walter Rivera
 * @copyright       GAMA
 */
$(document).ready(function(){
    console.log("El DOM 'administracion.php' ha sido cargado ♥");
    //mostrarUsuarios();
    //mostrarJornadas();
    //mostrarLogs();
    changeSelect("usuario-txt-genero","usuario-span-genero");
    changeSelect("usuario-txt-area", "usuario-span-area");
    changeSelect("usuario-txt-tipo", "usuario-span-tipo");
    changeSelect("usuario-editar-area", "usuario-span-editar-area");
    changeSelect("usuario-editar-tipo", "usuario-span-editar-tipo");
});
/* ------ USUARIO ------ */
$("#btn-usuario").click(
    /**
     * Registrar nuevo usuario
     */
    function(){
        if (
            validarRegex("usuario-txt-id", "entero") &&
            validarCampoVacio("usuario-txt-pnombre") &&
            validarCampoVacio("usuario-txt-snombre") &&
            validarCampoVacio("usuario-txt-papellido") &&
            validarCampoVacio("usuario-txt-sapellido") &&
            validarSelectList("usuario-txt-genero", "usuario-span-genero") &&
            validarRegex("usuario-txt-telefono", "entero") &&
            validarSelectList("usuario-txt-area", "usuario-span-area") &&
            validarCampoVacio("usuario-txt-contrato") &&
            validarRegex("usuario-txt-username", "username") &&
            validarPasswordSignUp("usuario-txt-password1","usuario-txt-password2") &&
            validarSelectList("usuario-txt-tipo", "usuario-span-tipo") &&
            validarCampoVacio("usuario-txt-direccion")
        ) {
            var parametros ="id="+parseInt($("#usuario-txt-id").val())+"&"+
                            "pnombre="+$("#usuario-txt-pnombre").val()+"&"+
                            "snombre="+$("#usuario-txt-snombre").val()+"&"+
                            "papellido="+$("#usuario-txt-papellido").val()+"&"+
                            "sapellido="+$("#usuario-txt-sapellido").val()+"&"+
                            "genero="+parseInt($("#usuario-txt-genero").val())+"&"+
                            "telefono="+parseInt($("#usuario-txt-telefono").val())+"&"+
                            "area="+parseInt($("#usuario-txt-area").val())+"&"+
                            "contrato="+parseInt($("#usuario-txt-contrato").val())+"&"+
                            "username="+$("#usuario-txt-username").val()+"&"+
                            "password1="+$("#usuario-txt-password1").val()+"&"+
                            "tipo="+parseInt($("#usuario-txt-tipo").val())+"&"+
                            "direccion="+$("#usuario-txt-direccion").val()+"&"+
                            "estado="+1+"&"+
                            "accion=registrar";
            console.log(parametros);
            $("#btn-usuario").attr("disabled",true);
            $.ajax({
                url:"ajax/usuario.php",
                data:parametros,
                method:"GET",
                dataType:"json",
                success:function(respuesta){
                    console.log(respuesta);
                    alert(respuesta.mensaje);
                    if(respuesta.codigo==1){
                        let AREA_USUARIO = "";
                        let TIPO_USUARIO = "";
                        switch ($("#usuario-txt-area").val()) {
                            case 1:
                                AREA_USUARIO = "Ventas";
                                break;
                            case 2:
                                AREA_USUARIO = "Inventario";
                                break;
                            case 3:
                                AREA_USUARIO = "Administración";
                                break;
                        }
                        switch ($("#usuario-txt-tipo").val()) {
                            case 1:
                                TIPO_USUARIO = "Empleado";
                                break;
                            case 2:
                                TIPO_USUARIO = "Socio";
                                break;
                        }
                        $("#lista-usuarios").append(`
                            <li class="collection-item flex-div scroll-item grid-display">
                            <div class="flex-display">
                                <h6 class="btn-floating pulse green" style="width: 23.19px !important;height: 23.19px;" id="adm-estado-usuario${$("#usuario-txt-id").val()}"></h6>
                                <h6 id="adm-nombre-usuario${$("#usuario-txt-id").val()}">${$("#usuario-txt-pnombre").val()} ${$("#usuario-txt-snombre").val()} ${$("#usuario-txt-papellido").val()} ${$("#usuario-txt-sapellido").val()}</h6>
                            </div>
                            <div class="row">
                                <div class="col s12"> ID: <span class="grey-text" id="adm-id-usuario${$("#usuario-txt-id").val()}">${$("#usuario-txt-id").val()}</span></div>
                                <div class="col s12 m6">Rol: <span id="adm-tipo-usuario${$("#usuario-txt-id").val()}" class="grey-text">${TIPO_USUARIO}</span></div>
                                <div class="col s12 m6">Área de trabajo: <span id="adm-area-usuario${$("#usuario-txt-id").val()}" class="grey-text">${AREA_USUARIO}</span></div>
                                <div class="col s12 m6">No. Contrato: <span id="adm-contrato-usuario${$("#usuario-txt-id").val()}" class="grey-text">${parseInt($("#usuario-txt-contrato").val())}</span></div>
                                <div class="col s12 m6">Teléfono: <span id="adm-telefono-usuario${$("#usuario-txt-id").val()}" class="grey-text">${parseInt($("#usuario-txt-telefono").val())}</span></div>
                                <div class="col s12 m6">Nombre de usuario: <span id="adm-username-usuario${$("#usuario-txt-id").val()}" class="grey-text">${$("#usuario-txt-username").val()}</span></div>
                                <div class="col s12 m6">Contraseña: <span id="adm-password-usuario${$("#usuario-txt-id").val()}" class="grey-text">${$("#usuario-txt-password1").val()}</span></div>
                                <div class="col s12">Dirección: <span id="adm-direccion-usuario${$("#usuario-txt-id").val()}" class="grey-text">${$("#usuario-txt-direccion").val()}</span></div><div class="col s12">
                                <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_usuarioEditar('${$("#usuario-txt-id").val()}')"><i class="material-icons left">edit</i>Editar</button></div>
                            </div>
                            </li>
                        `);
                        $("#btn-usuario").attr("disabled",false);
                        cerrarModal("form-editar-usuario");
                    }
                    else{
                        alert("ERROR: Ya existe un usuario con el mismo No. de Identidad.");
                        $("#btn-usuario").attr("disabled",false);
                    }
                },
                error:function(error){
                    console.log(error);
                    $("#btn-usuario").attr("disabled",false);
                }
            });
        } else {
            alert("No es posible registrar el usuario: hay campos vacíos o algún tipo de dato no es válido.");
        }
});
/**
 * Abrir ventana modal con los datos del usuario a editar
 * @param {Numberº} idUsuario 
 */
function abrirModal_usuarioEditar(idUsuario) {
    console.log("Id usuario a editar: "+idUsuario);
    $.ajax({
        url:"ajax/usuario.php",
        data:"idUsuario="+idUsuario+"&accion=abrirModal",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            $('#adm-titulo-usuario-editar').html(respuesta.pnombre+" "+respuesta.snombre+" "+respuesta.papellido+" "+respuesta.sapellido+" - "+ idUsuario);
            switch (respuesta.estado) {
                case 1:
                    $("#div-estado-usuario").html('<label><span class="bold-text" id="usuario-inactivo">Inactivo</span><input type="checkbox" id="usuario-editar-estado" class="filled-in"><span class="bold-text lever" id="usuario-span-editar-estado"></span><span class="bold-text" id="usuario-activo">Activo</span></label>');
                    $("#usuario-editar-estado").attr("checked", true);
                    $("#usuario-activo").css("color", "#4caf50");
                    $("#usuario-inactivo").css("color", "grey");
                    changeCheckbox("usuario-editar-estado", "usuario-activo", "usuario-inactivo");
                    break;
                case 0:
                    $("#div-estado-usuario").html('<label><span class="bold-text" id="usuario-inactivo">Inactivo</span><input type="checkbox" id="usuario-editar-estado" class="filled-in"><span class="bold-text lever" id="usuario-span-editar-estado"></span><span class="bold-text" id="usuario-activo">Activo</span></label>');
                    $("#usuario-editar-estado").removeAttr("checked");
                    $("#usuario-inactivo").css("color", "red");
                    $("#usuario-activo").css("color", "grey");
                    changeCheckbox("usuario-editar-estado", "usuario-activo", "usuario-inactivo");
                    break;
            }
            $("input[id=usuario-editar-telefono]").val(respuesta.telefono)
            switch (respuesta.area) {
                case "Ventas":
                    $('#usuario-editar-area').html('<option value="1" selected="">Ventas</option><option value="2">Inventario</option><option value="3">Administración</option>');
                    break;
                case "Inventario":
                    $('#usuario-editar-area').html('<option value="1">Ventas</option><option value="2" selected="">Inventario</option><option value="3">Administración</option>');
                    break;
                case "Administración":
                    $('#usuario-editar-area').html('<option value="1">Ventas</option><option value="2">Inventario</option><option value="3" selected="">Administración</option>');
                    break;
            }
            $("input[id=usuario-editar-contrato]").val(respuesta.contrato);
            $("input[id=usuario-editar-username]").val(respuesta.username);
            switch (respuesta.tipo) {
                case "Empleado":
                    $('#usuario-editar-tipo').html('<option value="1" selected="">Empleado</option><option value="2">Socio</option>');
                    break;
                case "Socio":
                    $('#usuario-editar-tipo').html('<option value="1">Empleado</option><option value="2" selected="">Socio</option>');
                    break;
            }
            $("input[id=usuario-editar-direccion]").val(respuesta.direccion)
            $('#btn-modal-editar-usuario').attr("onclick", "editarUsuario('"+idUsuario+"')");
            $('#modal-usuario-editar').modal('open');
        },
        error:function(error){
            console.log(error);
        }
    });
}
/**
 * Editar información del usuario.
 * @param {Number} idUsuario 
 */
function editarUsuario(idUsuario) {
    if (
        validarRegex("usuario-editar-telefono", "entero") &&
        validarSelectList("usuario-editar-area", "usuario-span-editar-area") &&
        validarCampoVacio("usuario-editar-contrato") &&
        validarRegex("usuario-editar-username", "username") &&
        validarRegex("usuario-editar-oldPassword", "password") &&
        validarPasswordSignUp("usuario-editar-password1","usuario-editar-password2") &&
        validarSelectList("usuario-editar-tipo", "usuario-span-editar-tipo") &&
        validarCampoVacio("usuario-editar-direccion")
    ) {
        $("#btn-modal-editar-usuario").attr("disabled",true);
        //LA CONTRASEÑA ANTERIOR DEL USUARIO SE DEBE VALIDAR EN EL SP
        console.log("El usuario a editar tiene el código: "+parseInt(idUsuario));
        var parametros ="telefono="+parseInt($("#usuario-editar-telefono").val())+"&"+
                        "area="+parseInt($("#usuario-editar-area").val())+"&"+
                        "contrato="+parseInt($("#usuario-editar-contrato").val())+"&"+
                        "username="+$("#usuario-editar-username").val()+"&"+
                        "oldPassword="+$("#usuario-editar-oldPassword").val()+"&"+
                        "password="+$("#usuario-editar-password1").val()+"&"+
                        "tipo="+parseInt($("#usuario-editar-tipo").val())+"&"+
                        "direccion="+$("#usuario-editar-direccion").val()+"&"+
                        "idUsuario="+parseInt(idUsuario)+"&"+
                        "estado="+parseInt(obtenerValorCheckbox("usuario-editar-estado"))+"&"+
                        "accion=editar";
        console.log(parametros);
        $.ajax({
            url:"ajax/usuario.php",
            data:parametros,
            method:"GET",
            dataType:"json",
            success:function(respuesta){
                console.log(respuesta);
                alert(respuesta.mensaje);
                switch (respuesta.codigo) {
                    case 0:
                        addInvalid("usuario-editar-oldPassword");
                        $("#btn-modal-editar-usuario").attr("disabled",false);
                        break;
                
                    case 1:
                        if (parseInt(obtenerValorCheckbox("usuario-editar-estado")) == 0) {
                            $("#adm-estado-usuario"+idUsuario).removeClass("green");
                            $("#adm-estado-usuario"+idUsuario).addClass("red");
                        } else {
                            $("#adm-estado-usuario"+idUsuario).removeClass("red");
                            $("#adm-estado-usuario"+idUsuario).addClass("green");
                        }
                        switch (parseInt($("#usuario-editar-tipo").val())) {
                            case 1:
                                $("#adm-tipo-usuario"+idUsuario).html("Empleado");
                                break;

                            case 2:
                                $("#adm-tipo-usuario"+idUsuario).html("Socio");                            
                                break;
                        }
                        let _AREA_USUARIO = "";
                        switch (parseInt($("#usuario-editar-area").val())) {
                            case 1:
                                _AREA_USUARIO = "Ventas";
                                break;
                            case 2:
                                _AREA_USUARIO = "Inventario";
                                break;
                            case 3:
                            _AREA_USUARIO = "Administración";
                            break;
                        }
                        $("#adm-telefono-usuario"+idUsuario).html(parseInt($("#usuario-editar-telefono").val()));
                        $("#adm-area-usuario"+idUsuario).html(_AREA_USUARIO);
                        $("#adm-contrato-usuario"+idUsuario).html(parseInt($("#usuario-editar-contrato").val()));
                        $("#adm-username-usuario"+idUsuario).html($("#usuario-editar-username").val());
                        $("#adm-password-usuario"+idUsuario).html($("#usuario-editar-password1").val());
                        $("#adm-direccion-usuario"+idUsuario).html($("#usuario-editar-direccion").val());
                        cerrarModal("form-editar-usuario");
                        $("#btn-modal-editar-usuario").attr("disabled",false);
                        break;
                }
            },
            error:function(error){
                console.log(error);
                $("#btn-modal-editar-usuario").attr("disabled",false);
            }
        });
    } else {
        alert("No es posible editar el usuario: hay campos vacíos o algún tipo de dato no es válido.");
    }
}
/**
 * Mostrar lista de usuarios.
 */
function mostrarUsuarios() {
    console.log("Usuario: lista de usuarios");
}
/* ********************************************************* */
/* ********************************************************* */
/* ********************************************************* */
/* ------ JORNADA LABORAL ------ */
$("#btn-jornada").click(
    /**
     * Registrar una nuvea jornada laboral.
     */
    function(){
        if (
            validarCampoVacio("jornada-txt-fechaInicio") &&
            validarCampoVacio("jornada-txt-fechaFinal") &&
            validarCampoVacio("jornada-txt-archivo")
        ) { 
            alert("Datos jornada: "+
            $("#jornada-txt-fechaInicio").val()+", "+
            $("#jornada-txt-fechaFinal").val()+", "+
            $("#jornada-txt-archivo").val());
            var parametros ="fechaInicio="+$("#jornada-txt-fechaInicio").val()+"&"+
                            "fechaFinal="+$("#jornada-txt-fechaFinal").val()+"&"+
                            "archivo="+$("#jornada-txt-archivo").val()+"&"+
                            "accion=registrar";
            console.log(parametros);
            $("#btn-jornada").attr("disabled",true);
            $.ajax({
                url:"ajax/jornada.php",
                data:parametros,
                method:"GET",
                dataType:"json",
                success:function(respuesta){
                    console.log(respuesta);
                    alert(respuesta.mensaje);
                    if(respuesta.codigo==1){
                        // alert("¡Jornada laboral registrada!");
                        // mostrarJornadas();
                        $("#btn-jornada").attr("disabled",false);
                        cerrarModal("form-registrar-jornada");
                    }
                    else{
                        // alert("ERROR: Ya existe una jornada laboral con las mismas fechas.");
                        $("#btn-jornada").attr("disabled",false);
                    }
                },
                error:function(error){
                    console.log(error);
                    $("#btn-jornada").attr("disabled",false);
                }
            });
        } else {
            alert("No es posible registrar la jornada laboral: hay campos vacíos o algún tipo de dato no es válido.");
        }
});
/**
 * Mostrar lista de jornadas laborales.
 */
function mostrarJornadas() {
    console.log("Jornada: Lista de jornadas laborales");
    $("#lista-jornadas").html("");
}
/**
 * Abrir en una ventana modal la imagen de archivo de una jornada laboral.
 * @param {String} urlJornada 
 */
function abrirModal_jornadaArchivo(urlJornada) {
    console.log("Archivo de jornada laboral a mostrar: "+urlJornada);
    $("#imagen-jornada-laboral").html('<img class="total-width" src=" '+ urlJornada +' ">');    
    $('#a-modal-descargar-jornada').attr("href", urlJornada);  
    $('#modal-jornada-archivo').modal('open');
}
/* ********************************************************* */
/* ********************************************************* */
/* ********************************************************* */
/* ------ Logs LABORAL ------ */
/**
 * Mostrar lista de registros de inicios de sesión al sistema.
 */
function mostrarLogs() {
    console.log("Logs: registros de inicios de sesión.");
    $("#lista-logs").html("");
}