/**
 * @fileoverview Archivo de funciones comunes: ventanas modales, bloqueos de teclado
 * @version         2.0
 * @author          Maria Ramirez, Gerardo Alvarenga, Juan Enriquez, Walter Rivera
 * @copyright       GAMA
 */
$(document).ready(function(){
    console.log("Se ha cargado 'common2.js' en el DOM ♥");
    mostrarProdutos();
    mostrarClientes();
});


/**
 * Mostrar lista de productos.
 */
 function mostrarProdutos() {
     $.ajax({
         url:"ajax/gestionProducto.php?accion1=mostrar",
         //data:"accion=listaInsumos",
         method:"POST",
         DataType:"json",
         success:function(respuestaMostrarProducto){
          //   console.log(respuestaMostrarInsumo);
             $("#tabla-producto-body").html("");
             $("#tabla-producto-body").append(respuestaMostrarProducto);       
             $("#label-txt-impuesto15").html('<input class="filled-in" id="producto-txt-impuesto15" type="checkbox" value="0.15"><span>15% ISV</span>');
            $("#label-txt-impuesto18").html('<input class="filled-in" id="producto-txt-impuesto18" type="checkbox" value="0.18"><span>18% ISV</span>');                       
         },
         error:function(error){                   
             alert("ERROR AL CARGAR LOS DATOS: ");                     
         }
     });
 }

 //Carga la pantalla de nuevo producto

 $('#btn-modal-nuevo-producto').click(
    function(){    
    $('#modal-producto-registrar').modal('open');
     $.ajax({
         url:"ajax/gestionProducto.php?accion1=llenarTipoProducto",
         data:"'modal_id':modal-producto-registrar",
         method:"POST",
         dataType:"text",      
         success:function(respuestaMostraTipoProducto){
            console.log('Ingresa Aqui');
              $("#producto-txt-tipo").html("");
              $("#producto-txt-tipo").append(respuestaMostraTipoProducto); 
              console.log(respuestaMostraTipoProducto);    
           },       
    error:function(error){
             console.log(error);
        }
 });
});


// PRODUCTO: REGISTRAR NUEVO ELEMENTO
$("#btn-producto").click(
    /**
    * Registrar un nuevo producto
    */
   function(){
       if (
           validarCampoVacio("producto-txt-nombre") &&
           validarRegex("producto-txt-cantidad", "entero") &&
           validarRegex("producto-txt-precioCosto", "decimal") &&
           validarCampoVacio("producto-txt-descuento") &&
           validarSelectList("producto-txt-tipo", "producto-span-tipo")
        ) {
            let _ISV_15 = 0;
            let _ISV_18 = 0;
            let _PRECIO_VENTA = parseFloat($("#producto-txt-precioCosto").val());
            let _DESCUENTO_APLICADO = 0;
            let selected_ISV_15 = 0;
            let selected_ISV_18 = 0;
            if ($("#producto-txt-impuesto15").prop("checked") == true) {
               _ISV_15 = parseFloat(($("#producto-txt-precioCosto").val() * $("#producto-txt-impuesto15").val()).toFixed(2)); // Se almacena como float
               selected_ISV_15 = 1
            }
            if ($("#producto-txt-impuesto18").prop("checked") == true) {
                _ISV_18 = parseFloat(($("#producto-txt-precioCosto").val() * $("#producto-txt-impuesto18").val()).toFixed(2)); // Se almacena como float
                selected_ISV_18 = 1
            }
            _PRECIO_VENTA += _ISV_15 + _ISV_18; // Suma de los impuestos al precio costo
            _PRECIO_VENTA = parseFloat(_PRECIO_VENTA.toFixed(2));
                 
            if ($("#producto-txt-descuento").val() > 0) {
                _DESCUENTO_APLICADO = parseFloat(($("#producto-txt-precioCosto").val() * ($("#producto-txt-descuento").val()/100)).toFixed(2)); // Se almacena como float
                _PRECIO_VENTA -= _DESCUENTO_APLICADO; // Resta del descuento aplicado al producto
                _PRECIO_VENTA = parseFloat(_PRECIO_VENTA.toFixed(2)); // Se almacena como float
            }
            console.log({"15%":_ISV_15,"18%":_ISV_18,"precio de venta final":_PRECIO_VENTA,"descuento aplicado":_DESCUENTO_APLICADO});
            var parametros ="nombre="+$("#producto-txt-nombre").val()+"&"+
                            "estado="+1+"&"+
                            "tipo="+parseInt($("#producto-txt-tipo").val())+"&"+
                            "cantidadDisponible="+parseInt($("#producto-txt-cantidad").val())+"&"+
                            "precioCosto="+parseFloat(parseFloat($("#producto-txt-precioCosto").val()).toFixed(2))+"&"+
                            "impuesto15="+selected_ISV_15+"&"+
                            "impuesto18="+selected_ISV_18+"&"+
                            "descuento="+parseFloat(_DESCUENTO_APLICADO.toFixed(2))+"&"+
                            "precioVenta="+parseFloat(_PRECIO_VENTA.toFixed(2))+"&"+
                            "accion=registrar";
            console.log(parametros);
            // console.log({
            //     "nombre":$("#producto-txt-nombre").val(),
            //     "cantidadDisponible":parseInt($("#producto-txt-cantidad").val()),
            //     "tipo":parseInt($("#producto-txt-tipo").val()),
            //     "precioCosto":parseFloat(parseFloat($("#producto-txt-precioCosto").val()).toFixed(2)),
            //     "impuesto15":_ISV_15,
            //     "impuesto18":_ISV_18,
            //     "descuento":parseFloat(_DESCUENTO_APLICADO.toFixed(2)),
            //     "precioVenta":parseFloat(_PRECIO_VENTA.toFixed(2)),
            //     "estado":1,
            //     "accion":"registrar"
            // });
            
            $("#btn-producto").attr("disabled",true);
            $.ajax({
                url:"ajax/gestionProducto.php?accion1=guardar",
                data:parametros,
                method:"POST",
                dataType:"JSON",
                success:function(respuestaProducto){                   
                    console.log(respuestaProducto);
                    console.log('OBTUVO RESULTADOS DE CLASE PRODUCTO ');                    
                    if(respuestaProducto.codigo==1){
                        //alert("¡Producto registrado!");                      
                        $("#btn-producto").attr("disabled",false);
                        cerrarModal("form-registrar-producto");
                        alert(respuestaProducto.mensaje);
                        mostrarProdutos();
                    }
                    else{
                        //alert("ERROR: Ya existe un producto con el mismo nombre.");
                        alert("ERROR AL INSERTAR :");
                        $("#btn-producto").attr("disabled",false);
                    }
                },
                error:function(error){
                    alert("ERROR: ".error);
                    $("#btn-producto").attr("disabled",false);
                }
            });
        } else {
            alert("No es posible registrar el producto: hay campos vacíos o algún tipo de dato no es válido.");
        }
    }
);

/** Abrir ventana modal para editar los datos del producto seleccionado.
 * @param {Number} idProducto
 */
function abrirModal_productoEditarDatos(idProducto) {
    console.log("Id producto a editar: "+idProducto);   
   // $('#modal-producto-editarDatos').modal('open');
    $.ajax({
        url:"ajax/gestionProducto.php",
        data:"idProducto="+idProducto+"&accion1=mostrarDatosEditar",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            if (respuesta.impuesto15 == 1) {
            
                    $("#div-estado-producto").html('<label><span class="bold-text" id="producto-inactivo">Inactivo</span><input type="checkbox" id="producto-editar-estado" class="filled-in"><span class="bold-text lever" id="producto-span-editar-estado"></span><span class="bold-text" id="producto-activo">Activo</span></label>');
                    $("#producto-editar-estado").attr("checked", true);
                    $("#producto-activo").css("color", "#4caf50");
                    $("#producto-inactivo").css("color", "grey");
                    changeCheckbox("producto-editar-estado", "producto-activo", "producto-inactivo");
            }
             else{
                    $("#div-estado-producto").html('<label><span class="bold-text" id="producto-inactivo">Inactivo</span><input type="checkbox" id="producto-editar-estado" class="filled-in"><span class="bold-text lever" id="producto-span-editar-estado"></span><span class="bold-text" id="producto-activo">Activo</span></label>');
                    $("#producto-editar-estado").removeAttr("checked");
                    $("#producto-inactivo").css("color", "red");
                    $("#producto-activo").css("color", "grey");
                    changeCheckbox("producto-editar-estado", "producto-activo", "producto-inactivo");
            }
            
            $('#inv-titulo-producto-editarDatos').html(respuesta.nombreProducto+" - "+ idProducto);
            $('input[id=producto-editar-precioCosto]').val(respuesta.precioCosto);
            $('input[id=producto-editar-descuento]').val(respuesta.descuento);
            $('input[id=producto-editar-cantidad]').val(respuesta.cantidad);
            if (respuesta.impuesto15 != 0) {
                $("#label-editar-impuesto15").html('<input class="filled-in" id="producto-editar-impuesto15" type="checkbox" value="0.15" checked="true"><span>15% ISV</span>');
            } else {
                $("#label-editar-impuesto15").html('<input class="filled-in" id="producto-editar-impuesto15" type="checkbox" value="0.15"><span>15% ISV</span>');
            }
            if (respuesta.impuesto18 != 0) {
                $("#label-editar-impuesto18").html('<input class="filled-in" id="producto-editar-impuesto18" type="checkbox" value="0.18" checked="true"><span>18% ISV</span>');       
            } else {
                $("#label-editar-impuesto18").html('<input class="filled-in" id="producto-editar-impuesto18" type="checkbox" value="0.18"><span>18% ISV</span>');
            }
            $('#btn-modal-editarDatos-producto').attr("onclick", "editarDatosProducto('"+idProducto+"')");
            $('#modal-producto-editarDatos').modal('open');
        },
        error:function(error){
            console.log(error);
        }
    });
}


/**
 * Editar datos de un producto en la BD.
 * @param {Number} idProducto 
 */
function editarDatosProducto(idProducto) {
    if (
        validarRegex("producto-editar-precioCosto", "decimal") &&
        validarRegex("producto-editar-descuento", "entero")
    ) {
        let _imp15 = 0;
        let _imp18 = 0;
        let _descAplicado = 0;
        let selected_ISV_15 = 0;
        let selected_ISV_18 = 0;
        let _precioCosto = parseFloat(parseFloat($('#producto-editar-precioCosto').val()).toFixed(2));
        let _cantidad = parseFloat(parseFloat($('#producto-editar-cantidad').val()).toFixed(2));
        if ($("#producto-editar-impuesto15").prop("checked") == true) {
            _imp15 = parseFloat(($("#producto-editar-precioCosto").val() * $("#producto-editar-impuesto15").val()).toFixed(2)); // Se almacena como float
            let selected_ISV_15 = 1;
        }
        if ($("#producto-editar-impuesto18").prop("checked") == true) {
            _imp18 = parseFloat(($("#producto-editar-precioCosto").val() * $("#producto-editar-impuesto18").val()).toFixed(2)); // Se almacena como float
            let selected_ISV_18 = 1;
        }
        if ($("#producto-editar-descuento").val() > 0) {
            _descAplicado = parseFloat(($("#producto-editar-precioCosto").val() * ($("#producto-editar-descuento").val()/100)).toFixed(2)); // Se almacena como float
        }
        var parametros ="idProducto="+idProducto+"&"+
                        "precioCosto="+_precioCosto+"&"+
                        "cantidad="+_cantidad+"&"+
                        "descuento="+_descAplicado+"&"+
                        "impuesto15="+selected_ISV_15+"&"+
                        "impuesto18="+ selected_ISV_18+"&"+
                        "precioVenta="+parseFloat(parseFloat(_precioCosto + _imp15 + _imp18 - _descAplicado).toFixed(2))+"&"+
                        "estado="+obtenerValorCheckbox('producto-editar-estado');
        console.log(parametros);
        $("#btn-modal-editarDatos-producto").attr("disabled",true);
        $.ajax({
            url:"ajax/gestionProducto.php?accion1=editarDatos",
            data:parametros,
            method:"POST",
            dataType:"json",
            success:function(respuesta){
                console.log(respuesta);
                alert(respuesta.mensaje);
                mostrarProdutos();
                $("#btn-modal-editarDatos-producto").attr("disabled",false);
                cerrarModal("form-editarDatos-producto");
            },
            error:function(error){
                console.log(error);
                $("#btn-modal-editarDatos-producto").attr("disabled",false);
            }
        });
    } else {
        alert("No es posible editar los datos del producto: hay campos vacíos o algún tipo de dato no es válido.");
    }
}

// /** Abrir ventana modal para editar los datos del producto seleccionado.
//  * @param {Number} idProducto
//  */
function abrirModal_productoEliminar(idProducto) {
    console.log("Setea producto a eliminar: "+idProducto);
     $('#modal-producto-eliminar').modal('open');
    $('#btn-eliminar-producto').attr("onclick", "eliminarProducto('"+idProducto+"')");
 }




/** Abrir ventana modal para editar los datos del producto seleccionado.
 * @param {Number} idProducto
 */
function eliminarProducto(idProducto) {
    console.log("Id producto a eliminar: "+idProducto); 
    var parametros ="idProducto="+idProducto;
     $.ajax({
         url:"ajax/gestionProducto.php?accion1=eliminarProducto",
         data:parametros,
         method:"POST",
         dataType:"json",      
         success:function(respuestaEliminarProducto){
              console.log(respuestaEliminarProducto); 
              alert(respuestaEliminarProducto.mensaje);
              mostrarProdutos();   
              cerrarModal("form-eliminar-producto");
           },       
    error:function(error){
             console.log(error);
        }
 });
};

//*********************************************************************************************************** */
//*****************************************************CLIENTE*********************************************** */
//*********************************************************************************************************** */
//*********************************************************************************************************** */

$('#btn-modal-nuevo-cliente').click(
    function(){ 
    console.log("Id cliente a editar: ");    
    $('#modal-cliente-registrar').modal('open');
    $("#btn-guardar-cliente").attr("disabled",false);
     $.ajax({
         url:"ajax/gestionCliente.php?accion1=llenarTipoCliente",
         //data:"'modal_id' : modal-insumo-registrar",
         method:"POST",
         dataType:"text",      
         success:function(respuestaMostraTipoCliente){
            console.log(respuestaMostraTipoCliente);
              $("#cliente-txt-tipo").html("");
              $("#cliente-txt-tipo").append(respuestaMostraTipoCliente); 
              console.log(respuestaMostraTipoCliente);    
           },       
           error:function(error){
            console.log(error);
       }
   });
   });

/**
 * Mostrar lista de clientes.
 */
function mostrarClientes() {
    $.ajax({
        url:"ajax/gestionCliente.php?accion1=mostrar",
        method:"POST",
        DataType:"json",
        success:function(respuestaMostrarCliente){
         //   console.log(respuestaMostrarInsumo);
            $("#tabla-cliente-body").html("");
            $("#tabla-cliente-body").append(respuestaMostrarCliente);       
        },
        error:function(error){                   
            alert("ERROR AL CARGAR LOS DATOS: ");                     
        }
    });
}

// /** Abrir ventana modal para editar los datos del cliente seleccionado.
//  * @param {Number} idcliente
//  */
function abrirModal_clienteEliminar(idCliente) {
    console.log("Setea cliente a eliminar: "+idCliente);
     $('#modal-cliente-eliminar').modal('open');
    $('#btn-eliminar-cliente').attr("onclick", "eliminarcliente('"+idCliente+"')");
 }

/** Abrir ventana modal para editar los datos del cliente seleccionado.
 * @param {Number} idCliente
 */
function eliminarcliente(idCliente) {
    console.log("Id cliente a eliminar: "+idCliente); 
    var parametros ="idCliente="+idCliente;
     $.ajax({
         url:"ajax/gestionCliente.php?accion1=eliminarCliente",
         data:parametros,
         method:"POST",
         dataType:"json",      
         success:function(respuestaEliminarcliente){
              console.log(respuestaEliminarcliente); 
              alert(respuestaEliminarcliente.mensaje);
              mostrarClientes();   
              cerrarModal("form-eliminar-cliente");
           },       
    error:function(error){
             console.log(error);
        }
 });
};


// PRODUCTO: REGISTRAR NUEVO ELEMENTO
$("#btn-guardar-cliente").click(
    /**
    * Registrar un nuevo cliente
    */
   function(){
       if (
           validarCampoVacio("cliente-txt-nombre") &&
           validarCampoVacio("cliente-txt-direccion") &&
           validarRegex("cliente-txt-telefono", "entero")
        ) {
        
            var parametros ="nombre="+$("#cliente-txt-nombre").val()+"&"+
                            "direccion="+$("#cliente-txt-direccion").val()+"&"+
                            "tipo="+parseInt($("#cliente-txt-tipo").val())+"&"+
                            "telefono="+parseInt($("#cliente-txt-telefono").val())+"&"+
                            "estado="+1+"&"+
                            "accion1=registrar";
            console.log(parametros);            
            $("#btn-guardar-cliente").attr("disabled",true);
            $.ajax({
                url:"ajax/gestionCliente.php?accion1=guardar",
                data:parametros,
                method:"POST",
                dataType:"json",
                success:function(respuestaCliente){ 
                    console.log('OBTUVO RESULTADOS DE CLASE CLIENTE ');                             
                    console.log(respuestaCliente);                            
                    if(respuestaCliente.codigo==1){
                        //alert("¡Producto registrado!");   
                        alert(respuestaCliente.mensaje); 
                        mostrarClientes();               
                        cerrarModal("form-registrar-cliente");
                        $("#btn-guardar-cliente").attr("disabled",false);           
                       
                    }
                    else{
                        //alert("ERROR: Ya existe un producto con el mismo nombre.");
                        alert("ERROR AL INSERTAR CLIENTE :");
                        $("#btn-producto").attr("disabled",false);
                    }
                },
                error:function(error){
                    alert("ERROR: ".error);
                    $("#btn-guardar-cliente").attr("disabled",false);
                }
            });
        } else {
            alert("No es posible registrar el producto: hay campos vacíos o algún tipo de dato no es válido.");
        }
    }
);

/** Abrir ventana modal para editar los datos del cliente seleccionado.
 * @param {Number} idCliente
 */
function abrirModal_clienteEditar (idCliente) {
    console.log("Id Cliente a editar: "+idCliente);   
   // $('#modal-producto-editarDatos').modal('open');
    $.ajax({
        url:"ajax/gestionCliente.php",
        data:"idCliente="+idCliente+"&accion1=mostrarDatosEditar",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);      
            
            $('#inv-titulo-producto-editarDatos').html(respuesta.nombreCliente);
            $('input[id=cliente-editar-nombre]').val(respuesta.nombreCliente);
            $('input[id=cliente-editar-direccion]').val(respuesta.direccion);
            $('input[id=cliente-editar-telefono]').val(respuesta.telefono);
            $('input[id=cliente-editar-estado]').val(respuesta.estado);
            $('input[id=cliente-editar-tipo]').val(respuesta.tipo);           
            $('#btn-modal-editar-cliente').attr("onclick", "editarDatosCliente('"+idCliente+"')");
            $('#modal-cliente-editar').modal('open');
        },
        error:function(error){
            console.log(error);
        }
    });
}

/**
 * Editar datos de un cliente en la BD.
 * @param {Number} idCliente
 */
function editarDatosCliente(idCliente) {
    if (
        validarRegex("cliente-editar-telefono", "entero")
    ) {
        
        var parametros ="idCliente="+idCliente+"&"+
                        "nombreCliente="+$("#cliente-editar-nombre").val()+"&"+
                        "direccion="+$("#cliente-editar-direccion").val()+"&"+
                        "telefono="+$("#cliente-editar-telefono").val()+"&"+
                        "estado="+ $("#cliente-editar-tipo").val()+"&"+
                        "tipo="+$("#cliente-editar-tipo").val();
        console.log(parametros);
        $("#btn-modal-editar-cliente").attr("disabled",true);
        $.ajax({
            url:"ajax/gestionCliente.php?accion1=editarDatos",
            data:parametros,
            method:"POST",
            dataType:"json",
            success:function(respuesta){
                console.log(respuesta);
                alert(respuesta.mensaje);
                mostrarClientes();
                $("#btn-modal-editar-cliente").attr("disabled",false);
                cerrarModal("form-editar-cliente");
            },
            error:function(error){
                console.log(error);
                $("#btn-modal-editar-cliente").attr("disabled",false);
            }
        });
    } else {
        alert("No es posible editar los datos del cliente: hay campos vacíos o algún tipo de dato no es válido.");
    }
}




