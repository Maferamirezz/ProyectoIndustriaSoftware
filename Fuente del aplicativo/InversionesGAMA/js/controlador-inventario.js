﻿/**
 * @fileoverview Gestión de inventario: insumos, proveedores, historial de ventas
 * @version         7.0
 * @author          Maria Ramirez, Gerardo Alvarenga, Juan Enriquez, Walter Rivera
 * @copyright       GAMA
 */
$(document).ready(function(){
    console.log("El DOM 'inventario.php' ha sido cargado ♥");
    mostrarInsumos();
    //mostrarProveedores();
    //mostrarFacturas();
    changeSelect("insumo-txt-proveedor", "insumo-span-proveedor");
    $("#insumo-txt-proveedor").blur(function(){
        validarSelectList("insumo-txt-proveedor", "insumo-span-proveedor");
    });
    changeSelect("insumo-txt-tipo", "insumo-span-tipo");
    $("#insumo-txt-tipo").blur(function(){
        validarSelectList("insumo-txt-tipo", "insumo-span-tipo");
    });
    changeSelect("proveedor-txt-tipo", "proveedor-span-tipo");
    $("#proveedor-txt-tipo").blur(function(){
        validarSelectList("proveedor-txt-tipo", "proveedor-span-tipo");
    });
    changeSelect("proveedor-editar-tipo", "proveedor-span-editar-tipo");
    $("#proveedor-editar-tipo").blur(function(){
        validarSelectList("proveedor-editar-tipo", "proveedor-span-editar-tipo");
    });
});

/* ------ INSUMO ------ */
$("#btn-insumo").click(
    /**
     * Registrar nuevo insumo.
     */
    function(){
        if (
            validarCampoVacio("insumo-txt-nombre") &&
            validarCampoVacio("insumo-txt-fecha") &&
            validarSelectList("insumo-txt-proveedor", "insumo-span-proveedor") &&
            validarSelectList("insumo-txt-tipo", "insumo-span-tipo") &&
            validarRegex("insumo-txt-cantidad", "entero") &&
            validarRegex("insumo-txt-precio", "decimal")
        ) { 
            var parametros ="insumo-txt-nombre="+$("#insumo-txt-nombre").val()+"&"+
                            "insumo-txt-fecha="+$("#insumo-txt-fecha").val()+"&"+       
                            "insumo-txt-proveedor="+$('#insumo-txt-proveedor option:selected' ).val()+"&"+
                            "insumo-txt-tipo="+parseInt($('#insumo-txt-tipo option:selected' ).val())+"&"+                            
                            "insumo-txt-cantidad="+parseInt($("#insumo-txt-cantidad").val())+"&"+
                            "insumo-txt-precio="+parseFloat($("#insumo-txt-precio").val())+"&"+
                            "accion=registrar";
            console.log(parametros);
            $("#btn-insumo").attr("disabled",true);
            $.ajax({
                url:"ajax/gestionInsumo.php?accion1=guardar",
                data:parametros,
                method:"POST",
                dataType:"json",
                success:function(respuestaInsumo){
                    console.log(respuestaInsumo);                   
                    alert(respuestaInsumo.mensaje);
                    if(respuestaInsumo.codigo==1){
                        //alert("¡Insumo registrado!");
                        mostrarInsumos();                       
                        cerrarModal("form-registrar-insumo");
                        $("#btn-insumo").attr("disabled",false);                     
                    }
                    else{
                    //    alert("ERROR:".respuesta.mensaje);
                        alert("ERROR AL INSERTAR :");
                        $("#btn-insumo").attr("disabled",false);
                    }
                }, 
                error:function(error){
                    alert("ERROR: ".error);
                    $("#btn-insumo").attr("disabled",false);
                }
            }); 
        } else {
            alert("No es posible registrar el insumo: hay campos vacíos o algún tipo de dato no es válido.");
        }
});
/**
 * Abrir ventana modal con los datos del insumo a editar.
 * @param {Number} idInsumo 
 */
function abrirModal_insumoEditar(idInsumo) {
    console.log("Id insumo a editar: "+idInsumo);
    $('#modal-insumo-editar').modal('open'),
    $.ajax({
        url:"..ajax/inventario.php",
        data:"id_insumo="+idInsumo+"&accion=abrirModal",
        method:"POST",
        dataType:"json",      
        success:function(respuesta){
            console.log(respuesta);
            $('#inv-titulo-insumo-editar').html(respuesta.nombreInsumo+" - "+ idInsumo);
            $('input[id=insumo-editar-cantidad]').val(respuesta.cantidad);
            $('input[id=insumo-editar-precio]').val(respuesta.precio);
            $('#btn-modal-editar-insumo').attr("onclick", "editarInsumo('"+idInsumo+"')");
            $('#modal-insumo-editar').modal('open');
        },       
        error:function(error){
            console.log(error);
        }
    });
}

// $(document).on('submit', '#form-registrar-insumo' , function(event){ 
//   event.preventDefault();
//   //var cantidad = 
//   //$( '#insumo-txt-cantidad') = 23 ;
// }
// );
$('#btn-modal-nuevo-insumo').click(
    function(){ 
    console.log("Id insumo a editar: ");    
    $('#modal-insumo-registrar').modal('open');
     $.ajax({
         url:"ajax/gestionInsumo.php?accion1=llenarTipoInsumo",
         data:"'modal_id' : modal-insumo-registrar",
         method:"POST",
         dataType:"text",      
         success:function(respuestaMostraTipoInsumo){
            console.log('Ingresa Aqui');
              $("#insumo-txt-tipo").html("");
              $("#insumo-txt-tipo").append(respuestaMostraTipoInsumo); 
              console.log(respuestaMostraTipoInsumo);    
           },       
    error:function(error){
             console.log(error);
        }
 });
 //$('#modal-insumo-registrar').modal('open');
 $.ajax({
     url:"ajax/gestionInsumo.php?accion1=llenarProveedor",
     data:"'modal_id' : modal-insumo-registrar",
     method:"POST",
     dataType:"text",      
     success:function(respuestaMostraProveedores){
        console.log('Ingresa Aqui');
          $("#insumo-txt-proveedor").html("");
          $("#insumo-txt-proveedor").append(respuestaMostraProveedores);     
       },       
error:function(error){
         console.log(error);
    }
});
});

/**
 * Editar la cantidad disponible y/o el precio de un insumo.
 * @param {Number} idInsumo 
 */
function editarInsumo(idInsumo) {
    if (
        validarRegex("insumo-editar-cantidad", "entero") &&
        validarRegex("insumo-editar-precio", "decimal")
    ) {
        var parametros ="cantidad="+parseInt($("#insumo-editar-cantidad").val())+"&"+
                        "precio="+parseFloat($("#insumo-editar-precio").val())+"&"+
                        "idInsumo="+idInsumo+"&"+
                        "accion=editar";
        console.log(parametros);
        $("#btn-modal-editar-insumo").attr("disabled",true);
        $.ajax({
            url:"ajax/inventario.php",
            data:parametros,
            method:"GET",
            dataType:"json",
            success:function(respuesta){
                console.log(respuesta);
                alert(respuesta.mensaje);
                if (respuesta.codigo == 0) {
                    $("#btn-modal-editar-insumo").attr("disabled",false);                    
                } else {
                    if (parseInt($("#insumo-editar-cantidad").val()) == 0) {
                        $("#inv-cantidad-insumo"+idInsumo).html(parseInt($("#insumo-editar-cantidad").val()));
                        $("#inv-cantidad-insumo"+idInsumo).removeClass("green-text");
                        $("#inv-cantidad-insumo"+idInsumo).addClass("red-text");
                    } else {
                        $("#inv-cantidad-insumo"+idInsumo).html(parseInt($("#insumo-editar-cantidad").val()));
                        $("#inv-cantidad-insumo"+idInsumo).removeClass("red-text");
                        $("#inv-cantidad-insumo"+idInsumo).addClass("green-text");                  
                    }
                    $("#inv-precio-insumo"+idInsumo).html( parseFloat($("#insumo-editar-precio").val()).toFixed(2) );
                    $("#inv-nombreEmpleado-insumo"+idInsumo).html(respuesta.nombreEmpleado);
                    cerrarModal("form-editar-insumo");
                    $("#btn-modal-editar-insumo").attr("disabled",false);
                }
            },
            error:function(error){
                console.log(error);
                alert("ERROR: ".error);
                $("#btn-modal-editar-insumo").attr("disabled",false);
            }
        });
    } else {
        alert("No es posible registrar el insumo: hay campos vacíos o algún tipo de dato no es válido.");
    }
}
/**
 * Mostrar lista de insumos.
 */
function mostrarInsumos() {
    console.log("Insumo: Lista de insumos");
    $("#lista-insumos").html("");
    $.ajax({
        url:"ajax/gestionInsumo.php?accion1=mostrar",
        data:"accion=listaInsumos",
        method:"POST",
        DataType:"json",
        success:function(respuestaMostrarInsumo){
         //   console.log(respuestaMostrarInsumo);
            $("#lista-insumos").html("");
            $("#lista-insumos").append(respuestaMostrarInsumo);                              
        },
        error:function(error){                   
            alert("ERROR AL CARGAR LOS DATOS: ");                     
        }
    });
}
/* ********************************************************* */
/* ********************************************************* */
/* ********************************************************* */
/* ------ PROVEEDORES ------ */
$("#btn-proveedor").click(   /**
    * Registrar nuevo proveedor.
    */
   function(){
       if (
           validarRegex("proveedor-txt-rtn", "entero") &&
           validarCampoVacio("proveedor-txt-nombre") &&
           validarSelectList("proveedor-txt-tipo", "proveedor-span-tipo") &&
           validarCampoNoObligatorio("proveedor-txt-direccion") &&
           validarRegex("proveedor-txt-telefono", "entero") &&
           validarEmailNoObligatorio("proveedor-txt-email")
       ) {
           var parametro = "proveedor-txt-rtn="+$("#proveedor-txt-rtn").val()+"&"+
           "proveedor-txt-nombre="+$("#proveedor-txt-nombre").val()+"&"+
           "proveedor-txt-tipo="+1+"&"+
           "proveedor-txt-direccion="+$("#proveedor-txt-direccion").val()+"&"+
           "proveedor-txt-telefono="+parseInt($("#proveedor-txt-telefono").val())+"&"+
           "proveedor-txt-email="+$("#proveedor-txt-email").val()+"&"+
           "estado="+1+"&"+"accion1 = guardar";
           
           $("#btn-proveedor").attr("disabled",true);
           $.ajax({
               url:"ajax/gestionProveedores.php?accion1=guardar",
               data:parametro,
               method:"POST",
               
               success:function(respuesta){
                   console.log(respuesta);
                   alert(respuesta.mensaje);
                   if(respuesta.codigo==1){
                       //alert("¡Proveedor registrado!");
                       let TIPO_PROVEEDOR = "";                    
                       switch (parseInt($("#proveedor-txt-tipo").val())) {
                           case 1:
                               TIPO_PROVEEDOR = "Persona";
                               break;
                           case 2:
                               TIPO_PROVEEDOR = "Empresa";
                               break;
                       }
                       $("#lista-proveedores").append(`
                           <li class="collection-item avatar flex-div scroll-item grid-display">
                               <div>
                                   <div class="col s12"><img src="img/producto2.jpg" alt="" class="circle"></div>
                                   <div class="bold-text col s12 m6" id="inv-nombre-proveedor${$("#proveedor-txt-rtn").val()}">${$("#proveedor-txt-nombre").val()}</div>
                                   <div class="grey-text col s12 m6">RTN: <span id="inv-rtn-proveedor${$("#proveedor-txt-rtn").val()}" class="black-text">${$("#proveedor-txt-rtn").val()}</span></div>
                                   <div class="grey-text col s12 m6">Estado: <span id="inv-estado-proveedor${$("#proveedor-txt-rtn").val()}" class="bold-text green-text">ACTIVO</span></div>
                                   <div class="grey-text col s12 m6">Tipo de proveedor: <span id="inv-tipo-proveedor${$("#proveedor-txt-rtn").val()}" class="black-text">${TIPO_PROVEEDOR}</span></div>
                                   <div class="grey-text col s12 m6">Teléfono: <span id="inv-telefono-proveedor${$("#proveedor-txt-rtn").val()}" class="black-text">${parseInt($("#proveedor-txt-telefono").val())}</span></div>
                                   <div class="grey-text col s12 m6">Correo electrónico: <span id="inv-email-proveedor${$("#proveedor-txt-rtn").val()}" class="black-text">${$("#proveedor-txt-email").val()}</span></div>
                                   <div class="grey-text col s12">Dirección: <span id="inv-direccion-proveedor${$("#proveedor-txt-rtn").val()}" class="black-text">${$("#proveedor-txt-direccion").val()}</span></div>
                                   <div class="col s12">
                                   <button class="modal-trigger link-style" onclick="abrirModal_proveedorEditar('${$("#proveedor-txt-rtn").val()}')">Editar</button>
                                   </div>
                               </div>
                           </li>
                       `);
                       $("#btn-proveedor").attr("disabled",false);
                       cerrarModal("form-registrar-proveedor");
                   }
                   else{
                       //alert("ERROR: Ya existe un proveedor con el mismo RTN.");
                       $("#btn-proveedor").attr("disabled",false);
                   }
               },
               error:function(error){
                   console.log(error);
                   $("#btn-proveedor").attr("disabled",false);
               }
           });
       } else {
           alert("No es posible registrar al proveedor: hay campos vacíos o algún tipo de dato no es válido.");
       }
});
/**
 * Abrir ventana modal con los datos del proveedor a editar
 * @param {Number} rtnProveedor 
 */
function abrirModal_proveedorEditar(rtnProveedor) {
    $.ajax({
        url:"ajax/proveedores.php",
        data:"rtn_proveedor="+rtnProveedor+"&accion=abrirModal",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            switch (respuesta.estado) {
                case 1:
                    $("#div-estado-proveedor").html('<label><span class="bold-text" id="proveedor-inactivo">Inactivo</span><input type="checkbox" id="proveedor-editar-estado" class="filled-in"><span class="bold-text lever" id="proveedor-span-editar-estado"></span><span class="bold-text" id="proveedor-activo">Activo</span></label>');
                    $("#proveedor-editar-estado").attr("checked", true);
                    $("#proveedor-activo").css("color", "#4caf50");
                    $("#proveedor-inactivo").css("color", "grey");
                    changeCheckbox("proveedor-editar-estado", "proveedor-activo", "proveedor-inactivo");
                    break;
                case 0:
                    $("#div-estado-proveedor").html('<label><span class="bold-text" id="proveedor-inactivo">Inactivo</span><input type="checkbox" id="proveedor-editar-estado" class="filled-in"><span class="bold-text lever" id="proveedor-span-editar-estado"></span><span class="bold-text" id="proveedor-activo">Activo</span></label>');
                    $("#proveedor-editar-estado").removeAttr("checked");
                    $("#proveedor-inactivo").css("color", "red");
                    $("#proveedor-activo").css("color", "grey");
                    changeCheckbox("proveedor-editar-estado", "proveedor-activo", "proveedor-inactivo");
                    break;
            }
            $('#inv-titulo-proveedor-editar').html(respuesta.nombreProveedor+" - "+ rtnProveedor);
            $('input[id=proveedor-editar-direccion]').val(respuesta.direccion);
            $('input[id=proveedor-editar-telefono]').val(respuesta.telefono);
            $('input[id=proveedor-editar-email]').val(respuesta.email);
            $('#btn-modal-editar-proveedor').attr("onclick", "editarProveedor('"+rtnProveedor+"')");
            $('#modal-proveedor-editar').modal('open');
        },
        error:function(error){
            console.log(error);
        }
    });
}
/**
 * Editar los datos de un proveedor.
 * @param {Number} rtnProveedor 
 */
function editarProveedor(rtnProveedor) {
    if (
        validarCampoNoObligatorio("proveedor-editar-direccion") &&
        validarRegex("proveedor-editar-telefono", "entero") &&
        validarEmailNoObligatorio("proveedor-editar-email")
    ) {
        var parametros ="rtn="+rtnProveedor+"&"+
                        "direccion="+$('#proveedor-editar-direccion').val()+"&"+
                        "telefono="+parseInt($('#proveedor-editar-telefono').val())+"&"+
                        "email="+$('#proveedor-editar-email').val()+"&"+
                        "estado="+parseInt(obtenerValorCheckbox('proveedor-editar-estado'))+"&"+
                        "accion=editar";
        console.log(parametros);
        $("#btn-modal-editar-proveedor").attr("disabled",true);
        $.ajax({
            url:"ajax/proveedores.php",
            data:parametros,
            method:"GET",
            dataType:"json",
            success:function(respuesta){
                console.log(respuesta);
                alert(respuesta.mensaje);
                if (respuesta.codigo == 0) {
                    $("#btn-modal-editar-proveedor").attr("disabled",false);
                } else {
                    switch (parseInt(obtenerValorCheckbox("proveedor-editar-estado"))) {
                        case 0:
                            $("#inv-estado-proveedor"+rtnProveedor).html("INACTIVO");
                            $("#inv-estado-proveedor"+rtnProveedor).removeClass("green-text");
                            $("#inv-estado-proveedor"+rtnProveedor).addClass("red-text");
                            break;
                        case 1:
                            $("#inv-estado-proveedor"+rtnProveedor).html("ACTIVO");
                            $("#inv-estado-proveedor"+rtnProveedor).removeClass("red-text");
                            $("#inv-estado-proveedor"+rtnProveedor).addClass("green-text");
                            break;
                    }
                    $("#inv-direccion-proveedor"+rtnProveedor).html($('#proveedor-editar-direccion').val());
                    $("#inv-telefono-proveedor"+rtnProveedor).html( parseInt($('#proveedor-editar-telefono').val()));
                    $("#inv-email-proveedor"+rtnProveedor).html(    $('#proveedor-editar-email').val());
                    cerrarModal("form-editar-proveedor");
                    $("#btn-modal-editar-proveedor").attr("disabled",false);
                }
            },
            error:function(error){
                console.log(error);
                $("#btn-modal-editar-proveedor").attr("disabled",false);
            }
        });
    } else {
        alert("No es posible registrar al proveedor: hay campos vacíos o algún tipo de dato no es válido.");
    }
}
/**
 * Mostrar lista de proveedores
 */
function mostrarProveedores() {
    console.log("Proveedores: Lista de proveedores");
    $.ajax({
        url:"ajax/proveedores.php",
        data:"accion=listaProveedores",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            $("#lista-proveedores").html("");
            let _PROVEEDOR_ESTADO = [2];
            switch (respuesta.estado) {
                case 0:
                    _PROVEEDOR_ESTADO[0] = "INACTIVO";
                    _PROVEEDOR_ESTADO[1] = "red-text";
                    break;
                case 1:
                    _PROVEEDOR_ESTADO[0] = "ACTIVO";
                    _PROVEEDOR_ESTADO[1] = "green-text";
                    break;
            }
            respuesta.forEach(proveedor => {
                $("#lista-proveedores").append(`
                    <li class="collection-item avatar flex-div scroll-item grid-display">
                        <div>
                            <div class="bold-text col s12 m6" id="inv-nombre-proveedor${proveedor.rtnProveedor}">${proveedor.nombreProveedor}</div>
                            <div class="grey-text col s12 m6">RTN: <span id="inv-rtn-proveedor${proveedor.rtnProveedor}" class="black-text">${proveedor.rtnProveedor}</span></div>
                            <div class="grey-text col s12 m6">Estado: <span id="inv-estado-proveedor${proveedor.rtnProveedor}" class="bold-text _PROVEEDOR_ESTADO[1]">_PROVEEDOR_ESTADO[0]</span></div>
                            <div class="grey-text col s12 m6">Tipo de proveedor: <span id="inv-tipo-proveedor${proveedor.rtnProveedor}" class="black-text">${proveedor.tipoProveedor}</span></div>
                            <div class="grey-text col s12 m6">Teléfono: <span id="inv-telefono-proveedor${proveedor.rtnProveedor}" class="black-text">${proveedor.telefono}</span></div>
                            <div class="grey-text col s12 m6">Correo electrónico: <span id="inv-email-proveedor${proveedor.rtnProveedor}" class="black-text">${proveedor.email}</span></div>
                            <div class="grey-text col s12">Dirección: <span id="inv-direccion-proveedor${proveedor.rtnProveedor}" class="black-text">${proveedor.direccion}</span></div>
                            <div class="col s12">
                            <button class="modal-trigger link-style" onclick="abrirModal_proveedorEditar('${proveedor.rtnProveedor}')">Editar</button>
                            </div>
                        </div>
                    </li>
                `);
            });
        },
        error:function(error){
            console.log(error);
        }
    });
}
/* ********************************************************* */
/* ********************************************************* */
/* ********************************************************* */
/* ------ HISTORIAL DE VENTAS ------ */
// HISTORIAL DE VENTAS: GENERAR FACTURA PARA SER DESCARGADA
function descargarFactura(idFactura) {
    console.log("Factura a descargar:" + idFactura);
}
// HISTORIAL DE VENTAS: MOSTRAR LISTA DE FACTURAS
function mostrarFacturas() {
    console.log("Historial de ventas: Lista de facturas");
    $("#lista-facturas").html("");
}