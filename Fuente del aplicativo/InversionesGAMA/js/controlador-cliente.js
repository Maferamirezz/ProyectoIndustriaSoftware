/**
 * @fileoverview Gestión de administración: clientes, jornada laboral, logs de sesión
 * @version         7.0
 * @author          Maria Ramirez, Gerardo Alvarenga, Juan Enriquez, 
 * @copyright       GAMA
 */
$(document).ready(function(){
    console.log("El DOM 'administracion.php' ha sido cargado ♥");
    //mostrarclientes();
    //mostrarJornadas();
    //mostrarLogs();
    changeSelect("cliente-txt-tipo","cliente-span-tipo");
    changeSelect("cliente-txt-area", "cliente-span-area");
    changeSelect("cliente-txt-tipo", "cliente-span-tipo");
    changeSelect("cliente-editar-area", "cliente-span-editar-area");
    changeSelect("cliente-editar-tipo", "cliente-span-editar-tipo");
});
/* ------ cliente ------ */
$("#btn-cliente").click(
    /**
     * Registrar nuevo cliente
     */
    function(){
        if (
            validarRegex("cliente-txt-id", "entero") &&
            validarCampoVacio("cliente-txt-pnombre") &&
            validarSelectList("cliente-txt-tipo", "cliente-span-tipo") &&
            validarRegex("cliente-txt-telefono", "entero") &&
            validarCampoVacio("cliente-txt-correo") &&
            validarCampoVacio("cliente-txt-direccion")
        ) {
            var parametros ="id="+parseInt($("#cliente-txt-id").val())+"&"+
                            "pnombre="+$("#cliente-txt-pnombre").val()+"&"+                            
                            "tipo="+parseInt($("#cliente-txt-tipo").val())+"&"+
                            "telefono="+parseInt($("#cliente-txt-telefono").val())+"&"+                            
                            "correo="+$("#cliente-txt-correo").val()+"&"+  
                            "direccion="+$("#cliente-txt-direccion").val()+"&"+
                            "estado="+1+"&"+
                            "accion=registrar";
            console.log(parametros);
            $("#btn-cliente").attr("disabled",true);
            $.ajax({
                url:"ajax/cliente.php",
                data:parametros,
                method:"GET",
                dataType:"json",
                success:function(respuesta){
                    console.log(respuesta);
                    alert(respuesta.mensaje);
                    if(respuesta.codigo==1){
                        let AREA_cliente = "";
                        let TIPO_cliente = "";
                        switch ($("#cliente-txt-area").val()) {
                            case 1:
                                AREA_cliente = "Ventas";
                                break;
                            case 2:
                                AREA_cliente = "Inventario";
                                break;
                            case 3:
                                AREA_cliente = "Administración";
                                break;
                        }
                        switch ($("#cliente-txt-tipo").val()) {
                            case 1:
                                TIPO_cliente = "Comerciante Individual ";
                                break;
                            case 2:
                                TIPO_cliente = "Empresa";
                                break;
                        }
                        $("#lista-clientes").append(`
                            <li class="collection-item flex-div scroll-item grid-display">
                            <div class="flex-display">
                                <h6 style="width: 23.19px !important;height: 23.19px;" id="adm-estado-cliente${$("#cliente-txt-id").val()}"></h6>
                                <h6 RTN="adm-nombre-cliente${$("#cliente-txt-id").val()}">${$("#cliente-txt-pnombre").val()}</h6>
                            </div>
                            <div class="row">
                                <div class="col s12"> RTN: <span class="grey-text" id="adm-id-cliente${$("#cliente-txt-id").val()}">${$("#cliente-txt-id").val()}</span></div>
                                <div class="col s12"> Tipo de Cliente: <span class="grey-text" id="adm-tipo-cliente${$("#cliente-txt-tipo").val()}">${$("#cliente-txt-tipo").val()}</span></div>
                                
                                <div class="col s12 m6">Teléfono: <span id="adm-telefono-cliente${$("#cliente-txt-id").val()}" class="grey-text">${parseInt($("#cliente-txt-telefono").val())}</span></div>
                                <div class="col s12 m6">Correo: <span id="adm-correo-cliente${$("#cliente-txt-id").val()}" class="grey-text">${$("#cliente-txt-correo").val()}</span></div>
                                <div class="col s12">Dirección: <span id="adm-direccion-cliente${$("#cliente-txt-id").val()}" class="grey-text">${$("#cliente-txt-direccion").val()}</span></div><div class="col s12">
                                <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_clienteEditar('${$("#cliente-txt-id").val()}')"><i class="material-icons left">edit</i>Editar</button></div>
                            </div>
                            </li>
                        `);
                        $("#btn-cliente").attr("disabled",false);
                        cerrarModal("form-editar-cliente");
                    }
                    else{
                        alert("ERROR: Ya existe un cliente con el mismo No. de Identidad.");
                        $("#btn-cliente").attr("disabled",false);
                    }
                },
                error:function(error){
                    console.log(error);
                    $("#btn-cliente").attr("disabled",false);
                }
            });
        } else {
            alert("No es posible registrar el cliente: hay campos vacíos o algún tipo de dato no es válido.");
        }
});
/**
 * Abrir ventana modal con los datos del cliente a editar
 * @param {Numberº} idcliente 
 */
function abrirModal_clienteEditar(idcliente) {
    console.log("Id cliente a editar: "+idcliente);
    $.ajax({
        url:"ajax/cliente.php",
        data:"idcliente="+idcliente+"&accion=abrirModal",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            $('#adm-titulo-cliente-editar').html(respuesta.pnombre+" "+respuesta.snombre+" "+respuesta.papellido+" "+respuesta.sapellido+" - "+ idcliente);
            switch (respuesta.estado) {
                case 1:
                    $("#div-estado-cliente").html('<label><span class="bold-text" id="cliente-inactivo">Inactivo</span><input type="checkbox" id="cliente-editar-estado" class="filled-in"><span class="bold-text lever" id="cliente-span-editar-estado"></span><span class="bold-text" id="cliente-activo">Activo</span></label>');
                    $("#cliente-editar-estado").attr("checked", true);
                    $("#cliente-activo").css("color", "#4caf50");
                    $("#cliente-inactivo").css("color", "grey");
                    changeCheckbox("cliente-editar-estado", "cliente-activo", "cliente-inactivo");
                    break;
                case 0:
                    $("#div-estado-cliente").html('<label><span class="bold-text" id="cliente-inactivo">Inactivo</span><input type="checkbox" id="cliente-editar-estado" class="filled-in"><span class="bold-text lever" id="cliente-span-editar-estado"></span><span class="bold-text" id="cliente-activo">Activo</span></label>');
                    $("#cliente-editar-estado").removeAttr("checked");
                    $("#cliente-inactivo").css("color", "red");
                    $("#cliente-activo").css("color", "grey");
                    changeCheckbox("cliente-editar-estado", "cliente-activo", "cliente-inactivo");
                    break;
            }
            $("input[id=cliente-editar-telefono]").val(respuesta.telefono)
            switch (respuesta.area) {
                case "Ventas":
                    $('#cliente-editar-area').html('<option value="1" selected="">Ventas</option><option value="2">Inventario</option><option value="3">Administración</option>');
                    break;
                case "Inventario":
                    $('#cliente-editar-area').html('<option value="1">Ventas</option><option value="2" selected="">Inventario</option><option value="3">Administración</option>');
                    break;
                case "Administración":
                    $('#cliente-editar-area').html('<option value="1">Ventas</option><option value="2">Inventario</option><option value="3" selected="">Administración</option>');
                    break;
            }
            $("input[id=cliente-editar-contrato]").val(respuesta.contrato);
            $("input[id=cliente-editar-username]").val(respuesta.username);
            switch (respuesta.tipo) {
                case "Empleado":
                    $('#cliente-editar-tipo').html('<option value="1" selected="">Empleado</option><option value="2">Socio</option>');
                    break;
                case "Socio":
                    $('#cliente-editar-tipo').html('<option value="1">Empleado</option><option value="2" selected="">Socio</option>');
                    break;
            }
            $("input[id=cliente-editar-direccion]").val(respuesta.direccion)
            $('#btn-modal-editar-cliente').attr("onclick", "editarcliente('"+idcliente+"')");
            $('#modal-cliente-editar').modal('open');
        },
        error:function(error){
            console.log(error);
        }
    });
}
/**
 * Editar información del cliente.
 * @param {Number} idcliente 
 */
function editarcliente(idcliente) {
    if (
        validarRegex("cliente-editar-telefono", "entero") &&
        validarSelectList("cliente-editar-area", "cliente-span-editar-area") &&
        validarCampoVacio("cliente-editar-contrato") &&
        validarRegex("cliente-editar-username", "username") &&        
        validarSelectList("cliente-editar-tipo", "cliente-span-editar-tipo") &&
        validarCampoVacio("cliente-editar-direccion")
    ) {
        $("#btn-modal-editar-cliente").attr("disabled",true);
        //LA CONTRASEÑA ANTERIOR DEL cliente SE DEBE VALIDAR EN EL SP
        console.log("El cliente a editar tiene el código: "+parseInt(idcliente));
        var parametros ="telefono="+parseInt($("#cliente-editar-telefono").val())+"&"+
                        
                        "tipo="+parseInt($("#cliente-editar-tipo").val())+"&"+
                        "direccion="+$("#cliente-editar-direccion").val()+"&"+
                         "correo="+$("#cliente-editar-correo").val()+"&"+
                        "idcliente="+parseInt(idcliente)+"&"+
                        "estado="+parseInt(obtenerValorCheckbox("cliente-editar-estado"))+"&"+
                        "accion=editar";
        console.log(parametros);
        $.ajax({
            url:"ajax/cliente.php",
            data:parametros,
            method:"GET",
            dataType:"json",
            success:function(respuesta){
                console.log(respuesta);
                alert(respuesta.mensaje);
                switch (respuesta.codigo) {
                    case 0:
                        addInvalid("cliente-editar-oldPassword");
                        $("#btn-modal-editar-cliente").attr("disabled",false);
                        break;
                
                    case 1:
                        if (parseInt(obtenerValorCheckbox("cliente-editar-estado")) == 0) {
                            $("#adm-estado-cliente"+idcliente).removeClass("green");
                            $("#adm-estado-cliente"+idcliente).addClass("red");
                        } else {
                            $("#adm-estado-cliente"+idcliente).removeClass("red");
                            $("#adm-estado-cliente"+idcliente).addClass("green");
                        }
                        switch (parseInt($("#cliente-editar-tipo").val())) {
                            case 1:
                                $("#adm-tipo-cliente"+idcliente).html("Comerciante Individual");
                                break;

                            case 2:
                                $("#adm-tipo-cliente"+idcliente).html("Empresa");                            
                                break;
                        }
                        let _AREA_cliente = "";
                        switch (parseInt($("#cliente-editar-area").val())) {
                            case 1:
                                _AREA_cliente = "Ventas";
                                break;
                            case 2:
                                _AREA_cliente = "Inventario";
                                break;
                            case 3:
                            _AREA_cliente = "Administración";
                            break;
                        }
                        $("#adm-telefono-cliente"+idcliente).html(parseInt($("#cliente-editar-telefono").val()));
                        
                        $("#adm-contrato-cliente"+idcliente).html(parseInt($("#cliente-editar-contrato").val()));
                        $("#adm-username-cliente"+idcliente).html($("#cliente-editar-username").val());
                        $("#adm-password-cliente"+idcliente).html($("#cliente-editar-password1").val());
                        $("#adm-direccion-cliente"+idcliente).html($("#cliente-editar-direccion").val());
                        cerrarModal("form-editar-cliente");
                        $("#btn-modal-editar-cliente").attr("disabled",false);
                        break;
                }
            },
            error:function(error){
                console.log(error);
                $("#btn-modal-editar-cliente").attr("disabled",false);
            }
        });
    } else {
        alert("No es posible editar el cliente: hay campos vacíos o algún tipo de dato no es válido.");
    }
}
/**
 * Mostrar lista de clientes.
 */
function mostrarclientes() {
    console.log("cliente: lista de clientes");
}
/* ********************************************************* */
/* ********************************************************* */


/* clientes */
$("#btn-cliente").click(
    /**
     * Registrar nuevo cliente
     */
    function(){
        if (
            validarRegex("cliente-txt-id", "entero") &&
            validarCampoVacio("cliente-txt-pnombre") &&            
            validarSelectList("cliente-txt-tipo", "cliente-span-tipo") &&
            validarRegex("cliente-txt-telefono", "entero") &&   
            validarSelectList("cliente-txt-tipo", "cliente-span-tipo") &&
            validarRegex("cliente-txt-correo") &&
            validarCampoVacio("cliente-txt-direccion")

            ) {
             var parametros ="id="+parseInt($("#cliente-txt-id").val())+"&"+
                            "pnombre="+$("#cliente-txt-pnombre").val()+"&"+                            
                            "tipo="+parseInt($("#cliente-txt-tipo").val())+"&"+
                            "telefono="+parseInt($("#cliente-txt-telefono").val())+"&"+                            
                            "tipo="+parseInt($("#cliente-txt-tipo").val())+"&"+
                            "direccion="+$("#cliente-txt-direccion").val()+"&"+
                            "estado="+1+"&"+
                            "accion=registrar";
            console.log(parametros);
            $("#btn-cliente").attr("disabled",true);
            $.ajax({
                url:"ajax/cliente.php",
                data:parametros,
                method:"GET",
                dataType:"json",
                success:function(respuesta){
                    console.log(respuesta);
                    alert(respuesta.mensaje);
                    if(respuesta.codigo==1){
                        let AREA_cliente = "";
                        let TIPO_cliente = "";
                        switch ($("#cliente-txt-area").val()) {
                            case 1:
                                AREA_cliente = "Ventas";
                                break;
                            case 2:
                                AREA_cliente = "Inventario";
                                break;
                            case 3:
                                AREA_cliente = "Administración";
                                break;
                        }
                        switch ($("#cliente-txt-tipo").val()) {
                            case 1:
                                TIPO_cliente = "Comerciante Individual";
                                break;
                            case 2:
                                TIPO_cliente = "Empresa";
                                break;
                        }
                        $("#lista-clientes").append(`
                            <li class="collection-item flex-div scroll-item grid-display">
                            <div class="flex-display">
                                <h6 class="btn-floating pulse green" style="width: 23.19px !important;height: 23.19px;" id="adm-estado-cliente${$("#cliente-txt-id").val()}"></h6>
                                <h6 id="adm-nombre-cliente${$("#cliente-txt-id").val()}">${$("#cliente-txt-pnombre").val()}</h6>
                            </div>
                            <div class="row">
                                <div class="col s12"> ID: <span class="grey-text" id="adm-id-cliente${$("#cliente-txt-id").val()}">${$("#cliente-txt-id").val()}</span></div>
                                <div class="col s12 m6">Rol: <span id="adm-tipo-cliente${$("#cliente-txt-id").val()}" class="grey-text">${TIPO_cliente}</span></div>                                
                                <div class="col s12 m6">Teléfono: <span id="adm-telefono-cliente${$("#cliente-txt-id").val()}" class="grey-text">${parseInt($("#cliente-txt-telefono").val())}</span></div>
                                <div class="col s12 m6">Nombre de cliente: <span id="adm-username-cliente${$("#cliente-txt-id").val()}" class="grey-text">${$("#cliente-txt-username").val()}</span></div>
                                <div class="col s12 m6">Correo: <span id="adm-correo-cliente${$("#cliente-txt-id").val()}" class="grey-text">${$("#cliente-txt-username").val()}</span></div>

                                <div class="col s12">Dirección: <span id="adm-direccion-cliente${$("#cliente-txt-id").val()}" class="grey-text">${$("#cliente-txt-direccion").val()}</span></div><div class="col s12">
                                <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_clienteEditar('${$("#cliente-txt-id").val()}')"><i class="material-icons left">edit</i>Editar</button></div>
                            </div>
                            </li>
                        `);
                        $("#btn-cliente").attr("disabled",false);
                        cerrarModal("form-editar-cliente");
                    }
                    else{
                        alert("ERROR: Ya existe un cliente con el mismo No. de Identidad.");
                        $("#btn-cliente").attr("disabled",false);
                    }
                },
                error:function(error){
                    console.log(error);
                    $("#btn-cliente").attr("disabled",false);
                }
            });
        } else {
            alert("No es posible registrar el cliente: hay campos vacíos o algún tipo de dato no es válido.");
        }
});

