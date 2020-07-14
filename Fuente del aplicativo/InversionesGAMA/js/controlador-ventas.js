/**
 * @fileoverview Gestión de ventas: facturas, productos, clientes
 * @version         7.0
 * @author          Maria Ramirez, Gerardo Alvarenga, Juan Enriquez, Walter Rivera
 * @copyright       GAMA
 */
$(document).ready(function(){
    console.log("El DOM 'ventas.php' ha sido cargado ♥");
    mostrarProductos();
    //mostrarFacturas();
    changeSelect("factura-txt-cliente", "factura-span-cliente");
    $("#factura-txt-cliente").blur(function(){
        validarSelectList("factura-txt-cliente", "factura-span-cliente");
    });
    changeSelect("factura-txt-cantidad", "factura-span-cantidad");
    $("#factura-txt-cantidad").blur(function(){
        validarSelectList("factura-txt-cantidad", "factura-span-cantidad");
    });
    changeSelect("producto-txt-tipo", "producto-span-tipo");
    $("#producto-txt-tipo").blur(function(){
        validarSelectList("producto-txt-tipo", "producto-span-tipo");
    });
    $("#producto-txt-impuesto15").change(function () {
        if (this.checked == true) {
            $("#producto-txt-impuesto15").attr("checked", true);
            console.log("Activo: "+$("#producto-txt-impuesto15").val());
        } else {
            $("#producto-txt-impuesto15").removeAttr("checked");
            console.log("Inactivo: "+$("#producto-txt-impuesto15").val());
        }
    });
    $("#producto-txt-impuesto18").change(function () {
        if (this.checked == true) {
            $("#producto-txt-impuesto18").attr("checked", true);
            console.log("Activo: "+$("#producto-txt-impuesto18").val());
        } else {
            $("#producto-txt-impuesto18").removeAttr("checked");
            console.log("Inactivo: "+$("#producto-txt-impuesto18").val());
        }
    });
});

/* ------ VARIABLES TEMPORALES ------ */
/** Lista de productos agregados a la factura */
var items = [];
/** ID de productos agregados a la factura */
var idItem = [];
/** Nombre del producto agregado a la factura */
var producto_nombre;
/** Precio costo del producto agregado a la factura */
var producto_precioCosto;
/** ISV 15% del producto agregado a la factura */
var producto_impuesto15;
/** ISV 18% del producto agregado a la factura */
var producto_impuesto18;
/** Descuento del producto agregado a la factura */
var producto_descuento;
/** Precio del producto agregado a la factura */
var producto_precioVenta;
/** Resultado de multiplicar el precio de venta del producto con la cantidad elegida */
var producto_total_multiplicacion;
/** Suma del subtotal a pagar por la factura. */
var factura_subtotal;
/** Suma del precioCosto de los productos exentos de impuestos. */
var factura_exento;
/** Suma del precioCosto de los productos gravados con el 15% ISV. */
var factura_gravado15;
/** Suma del 15% ISV a pagar por la factura. */
var factura_imp15;
/** Suma del precioCosto de los productos gravados con el 18% ISV. */
var factura_gravado18;
/** Suma del 18% ISV a pagar por la factura. */
var factura_imp18;
/** Suma del descuento a aplicar en la factura. */
var factura_descuento;
/** Suma del total a pagar por la factura. */
var factura_total;

/* ------ FACTURA ------ */
$("#btn-nuevo-item").click(
    /**
     * Abrir ventana modal para registrar nuevo item.
     */
    function() {
        //console.log("ID: " + $("#factura-txt-id").val() + ", Cliente: " + $("#factura-txt-cliente").val() + ", Fecha: " + $("#factura-txt-fecha").val());
        if (
            validarCampoVacio("factura-txt-id") &&
            validarSelectList("factura-txt-cliente", "factura-span-cliente") &&
            validarCampoVacio("factura-txt-fecha")
        ) {
            //alert("Se puede añadir un item a la factura.");
            $("#factura-txt-id").attr("disabled", true);
            $("#factura-txt-cliente").attr("disabled", true);
            $("#factura-txt-fecha").attr("disabled", true);
            $("#factura-txt-cantidad").attr("disabled", true);
            $("#factura-txt-cantidad").html("");
            $('#modal-factura-registrar').modal('open');
        } else {
            alert("Primero debe llenar los datos de la factura antes de agregar un item.");
        }
});
$("#factura-txt-producto").change(
    /**
     * Traer datos del item que se pretende agregar a la factura.
     */
    function(){
        console.log("Item elegido para agregar: " + $("#factura-txt-producto").val());
        if (idItem.includes( parseInt($("#factura-txt-producto").val()) )) {
            alert("Por favor escoja un producto diferente");
            $("#factura-txt-producto").removeClass("valid-select");
            $("#factura-txt-producto").addClass("invalid-select");
            $("#factura-span-producto").addClass("red-text");
            $("#factura-span-producto").html("Campo vacío o dato inválido");
            $("#factura-txt-cantidad").removeClass("valid-select");
            $("#factura-txt-cantidad").html("");
            $("#factura-txt-cantidad").attr("disabled",true);
        } else {
            $("#factura-txt-producto").removeClass("invalid-select");
            $("#factura-txt-producto").addClass("valid-select");
            $("#factura-span-producto").html("");
            $("#factura-span-producto").html("");
            $.ajax({
                url:"ajax/factura.php",
                data:"idProducto="+parseInt($("#factura-txt-producto").val())+"&accion=infoItem",
                method:"GET",
                dataType:"json",
                success:function(respuesta){
                    console.log(respuesta);
                    producto_nombre = respuesta["nombreProducto"];
                    producto_precioCosto = parseFloat(respuesta["precioCosto"]); // Almacenado como float
                    producto_impuesto15 = parseFloat(respuesta["impuesto15"]); // Almacenado como float
                    producto_impuesto18 = parseFloat(respuesta["impuesto18"]); // Almacenado como float
                    producto_descuento = parseFloat(respuesta["descuento"]); // Almacenado como float
                    producto_precioVenta = parseFloat(respuesta["precioVenta"]); // Almacenado como float
                    for (let index = 1; index <= respuesta["cantidadDisponible"]; index++) {
                        $("#factura-txt-cantidad").append('<option value="'+index+'">'+index+'</option>');
                    }
                    $("#factura-txt-cantidad").attr("disabled", false);
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
});
$("#btn-item").click(
    /**
     * Registrar nuevo item dentro de la factura.
     */
    function(){
        $("#btn-item").attr("disabled", true);
        if (
            validarSelectList("factura-txt-producto", "factura-span-producto") &&
            validarSelectList("factura-txt-cantidad", "factura-span-cantidad")
        ) {
            //alert( "Datos item: "+parseInt($("#factura-txt-producto").val())+", "+parseInt($("#factura-txt-cantidad").val()) );
            producto_total_multiplicacion = producto_precioVenta * parseInt($("#factura-txt-cantidad").val());
            items.push(
                {
                    "idProducto" : parseInt($("#factura-txt-producto").val()), // Almacenado como int
                    "nombre": producto_nombre,
                    "precioCosto": producto_precioCosto,
                    "impuesto15": producto_impuesto15,
                    "impuesto18": producto_impuesto18,
                    "descuento": producto_descuento,
                    "precioVenta": producto_precioVenta, // Ya es float
                    "productoCantidad" : parseInt($("#factura-txt-cantidad").val()), // Almacenado como int
                    "total": parseFloat(producto_total_multiplicacion.toFixed(2)) // Almacenado como float
                }
            );
            idItem.push( parseInt($("#factura-txt-producto").val()) );
            console.log(items);
            console.log(idItem);
            $("#factura-txt-cantidad").html("");
            if (items.length > 1) {
                $("#lista-items").append("<tr><td>"+items[items.length - 1].idProducto+"</td><td>"+items[items.length - 1].nombre+"</td><td>Lps. "+items[items.length - 1].precioVenta+"</td><td>"+items[items.length - 1].productoCantidad+"</td><td>Lps. "+(items[items.length - 1].total).toFixed(2)+"</td></tr>");
            } else {
                $("#lista-items").html("<tr><td>"+items[items.length - 1].idProducto+"</td><td>"+items[items.length - 1].nombre+"</td><td>Lps. "+items[items.length - 1].precioVenta+"</td><td>"+items[items.length - 1].productoCantidad+"</td><td>Lps. "+(items[items.length - 1].total).toFixed(2)+"</td></tr>");
            }
            /* ------------ */
            let _subtotal = 0;
            let _isv15 = 0;
            let _isv18 = 0;
            let _totalDescuento = 0;
            let _totalTotal = 0;
            for (let index = 0; index < items.length; index++) {
                _subtotal += items[index].precioCosto * items[index].productoCantidad;
                _isv15 += items[index].impuesto15 * items[index].productoCantidad;
                _isv18 += items[index].impuesto18 * items[index].productoCantidad;
                _totalDescuento += items[index].descuento * items[index].productoCantidad;
                _totalTotal += items[index].total;
            }
            $("#vnt-subtotal-factura").html("Lps."+_subtotal.toFixed(2)); // Se imprime como string con 2 cifras decimales
            factura_subtotal = parseFloat(_subtotal.toFixed(2)); // Se almacena como float
            $("#vnt-totalImpuesto15-factura").html("Lps."+_isv15.toFixed(2)); // Se imprime como string con 2 cifras decimales
            factura_imp15 = parseFloat(_isv15.toFixed(2)); // Se almacena como float
            $("#vnt-totalImpuesto18-factura").html("Lps."+_isv18.toFixed(2)); // Se imprime como string con 2 cifras decimales
            factura_imp18 = parseFloat(_isv18.toFixed(2)); // Se almacena como float
            $("#vnt-totalDescuento-factura").html("Lps."+_totalDescuento.toFixed(2)); // Se imprime como string con 2 cifras decimales
            factura_descuento = parseFloat(_totalDescuento.toFixed(2)); // Se almacena como float
            $("#vnt-total-factura").html("Lps."+_totalTotal.toFixed(2)); // Se imprime como string con 2 cifras decimales
            factura_total = parseFloat(_totalTotal.toFixed(2)); // Se almacena como float
            /* ------------ */
            let _exento = 0;
            for (let index = 0; index < items.length; index++) {
                if (items[index].impuesto15 == 0 && items[index].impuesto18 == 0) {
                    _exento += items[index].precioCosto * items[index].productoCantidad;
                    console.log("Producto exento de impuestos");                                        
                }
            }
            $("#vnt-totalExento-factura").html("Lps."+_exento.toFixed(2)); // Se imprime como string con 2 cifras decimales
            factura_exento = parseFloat(_exento.toFixed(2)); // Se almacena como float
            console.log(factura_exento);
            
            /* ------------ */
            let _gravado15 = 0;
            for (let index = 0; index < items.length; index++) {
                if (items[index].impuesto15 != 0) {
                    _gravado15 += items[index].precioCosto * items[index].productoCantidad;
                    console.log("Producto gravado con 15%");                                        
                }
            }
            $("#vnt-gravado15-factura").html("Lps."+_gravado15.toFixed(2)); // Se imprime como string con 2 cifras decimales
            factura_gravado15 = parseFloat(_gravado15.toFixed(2)); // Se almacena como float
            /* ------------ */
            let _gravado18 = 0;
            for (let index = 0; index < items.length; index++) {
                if (items[index].impuesto18 != 0) {
                    _gravado18 += items[index].precioCosto * items[index].productoCantidad;
                    console.log("Producto gravado con 18%");                                        
                }
            }
            $("#vnt-gravado18-factura").html("Lps."+_gravado18.toFixed(2)); // Se imprime como string con 2 cifras decimales
            factura_gravado18 = parseFloat(_gravado18.toFixed(2)); // Se almacena como float
            /* ------------ */
            cerrarModal("form-registrar-item");
            $("#btn-item").attr("disabled", false);
            $("#factura-txt-producto").attr("disabled", false);
        } else {
            $("#btn-item").attr("disabled", false);
        }
});
$("#btn-borrar-item").click(
    /**
     * Eliminar un item del registro de ventas actual.
     */
    function () {
        if (items.length == 0) {
            alert("La factura ya está vacía. No es posible borrar ningún elemento.");
        } else {
            idItem.pop();
            let eliminado = items.pop(); // Se obtiene el ultimo item eliminado

            let resultado = factura_subtotal - eliminado.precioCosto; // Se resta del subtotal el precio Costo del producto a eliminar
            factura_subtotal = parseFloat(resultado.toFixed(2)); // Se almacena como float
            $("#vnt-subtotal-factura").html(factura_subtotal.toFixed(2)); // Se cambia en pantalla
            if (eliminado.impuesto15 == 0 && eliminado.impuesto18 == 0) {
                resultado = factura_exento - eliminado.precioCosto; // Se resta del total exento el precio Costo del producto a eliminar
                factura_exento = parseFloat(resultado.toFixed(2)); // Se almacena como float
                $("#vnt-totalExento-factura").html(factura_exento.toFixed(2)); // Se cambia en pantalla
            }
            if (eliminado.impuesto15 != 0) {
                resultado = factura_gravado15 - eliminado.precioCosto; // Se resta del total del importe gravado del 15% el precioCosto del producto a eliminar
                factura_gravado15 = parseFloat(resultado.toFixed(2)); // Se almacena como float
                $("#vnt-gravado15-factura").html(factura_gravado15.toFixed(2)); // Se cambia en pantalla
            }
            if (eliminado.impuesto18 != 0) {
                resultado = factura_gravado18 - eliminado.precioCosto; // Se resta del total del importe gravado del 18% el precioCosto del producto a eliminar
                factura_gravado18 = parseFloat(resultado.toFixed(2)); // Se almacena como float
                $("#vnt-gravado18-factura").html(factura_gravado18.toFixed(2)); // Se cambia en pantalla
            }
            if (eliminado.impuesto15 != 0) {
                resultado = factura_imp15 - eliminado.impuesto15; // Se resta del total del ISV 15% el impuesto del producto a eliminar
                factura_imp15 = parseFloat(resultado.toFixed(2)); // Se almacena como float
                $("#vnt-totalImpuesto15-factura").html(factura_imp15.toFixed(2)); // Se cambia en pantalla
            }
            if (eliminado.impuesto18 != 0) {
                resultado = factura_imp18 - eliminado.impuesto18; // Se resta del total del ISV 18% el impuesto del producto a eliminar
                factura_imp18 = parseFloat(resultado.toFixed(2)); // Se almacena como float
                $("#vnt-totalImpuesto18-factura").html(factura_imp18.toFixed(2)); // Se cambia en pantalla
            }
            if (eliminado.descuento != 0) {
                resultado = factura_descuento - eliminado.descuento; // Se resta del total del importe gravado del 15% el precioCosto del producto a eliminar
                factura_descuento = parseFloat(resultado.toFixed(2)); // Se almacena como float
                $("#vnt-totalDescuento-factura").html(factura_descuento.toFixed(2)); // Se cambia en pantalla
            }
            resultado = factura_total - eliminado.total; // Se resta del total el monto del producto a eliminar
            factura_total = parseFloat(resultado.toFixed(2)); // Se almacena como float
            $("#vnt-total-factura").html(factura_total.toFixed(2)); // Se cambia en pantalla

            $("#lista-items").html("");
            if (items.length == 0) {
                $("#lista-items").html("<tr><td></td><td></td><td></td><td></td><td></td></tr>");
            } else {
                for (let index = 0; index < items.length; index++) {
                    $("#lista-items").append("<tr><td>"+items[index].idProducto+"</td><td>"+items[index].nombre+"</td><td>Lps. "+items[index].precio+"</td><td>"+items[index].productoCantidad+"</td><td>Lps. "+(items[index].total).toFixed(2)+"</td></tr>");
                }
            }
        }
    }
);
$("#btn-factura").click(
    /** 
     * Registrar una factura o comprobante de ventas.
     */
    function(){
        $("#btn-factura").attr("disabled", true);
        if (
            validarCampoVacio("factura-txt-id") &&
            validarSelectList("factura-txt-cliente", "factura-span-cliente") &&
            validarCampoVacio("factura-txt-fecha") &&
            items.length != 0
        ) {
            var parametros ="idFactura="+$("#factura-txt-id").val()+"&"+
                            "idCliente="+$("#factura-txt-cliente").val()+"&"+
                            "fecha="+$("#factura-txt-fecha").val()+"&"+
                            "subtotal="+factura_subtotal+"&"+
                            "importeExento="+factura_exento+"&"+
                            "importeGravado15="+factura_gravado15+"&"+
                            "importeGravado18="+factura_gravado18+"&"+
                            "isvTotal15="+factura_imp15+"&"+
                            "isvTotal18="+factura_imp18+"&"+
                            "descuento="+factura_descuento+"&"+
                            "total="+factura_total+"&"+
                            "items="+items+"&"+
                            "accion=registrar";
            console.log(parametros);
            console.log({
                "idFactura":$("#factura-txt-id").val(),
                "idCliente":$("#factura-txt-cliente").val(),
                "fecha":$("#factura-txt-fecha").val(),
                "subtotal":factura_subtotal,
                "importeExento":factura_exento,
                "importeGravado15":factura_gravado15,
                "importeGravado18":factura_gravado18,
                "isvTotal15":factura_imp15,
                "isvTotal18":factura_imp18,
                "descuento":factura_descuento,
                "total":factura_total,
                "items":items,
                "accion":"registrar"
            });
            
            $.ajax({
                url:"ajax/factura.php",
                data:parametros,
                method:"GET",
                dataType:"json",
                success:function(respuesta){
                    console.log(respuesta);
                    if (respuesta.codigo == 0) {
                        alert("Ya existe una factura con ese código, favor ingresar uno nuevo.");
                    } else {
                        alert("¡Factura registrada!");
                        resetHeaderFactura();                        
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
            
        } else {
            alert("No es posible registrar la factura. Hay campos vacíos o datos inválidos.");
        $("#btn-factura").attr("disabled", false);
        }
    }
);
$("#btn-reset-factura").click(
    /**
     * Botón para reiniciar el formulario de registro de facturas.
     */
    function() {
        resetHeaderFactura();
    }
);
/**
 * Limpiar el formulario para registrar una factura, tanto encabezado como los items.
 */
function resetHeaderFactura() {
    $("#form-header-factura").trigger("reset");
    $("select").removeClass("valid-select");
    $("select").removeClass("invalid-select");
    $(".helper-text").html("");
    $("#btn-factura").attr("disabled", false);
    $("#factura-txt-id").attr("disabled", false);
    $("#factura-txt-cliente").attr("disabled", false);
    $("#factura-txt-fecha").attr("disabled", false);
    if (items.length != 0) {
        $("#lista-items").html("<tr><td></td><td></td><td></td><td></td><td></td></tr>");
        $("#vnt-total-factura").html("0.00");
        $("#vnt-subtotal-factura").html("0.00");
        $("#vnt-totalExento-factura").html("0.00");
        $("#vnt-gravado15-factura").html("0.00");
        $("#vnt-gravado18-factura").html("0.00");
        $("#vnt-totalImpuesto15-factura").html("0.00");
        $("#vnt-totalImpuesto18-factura").html("0.00");
        $("#vnt-totalDescuento-factura").html("0.00");
        $("#vnt-total-factura").html("0.00");
        items = [];
        idItem = [];
    }
}
/* ********************************************************* */
/* ********************************************************* */
/* ********************************************************* */
/* ------ PRODUCTO ------ */
/**
 * Al abrir la ventana modal para registrar un producto se sobreescribirán los checkbox, a modo de resetearlos
 */
function abrirModal_productoRegistrar() {
    $("#label-txt-impuesto15").html('<input class="filled-in" id="producto-txt-impuesto15" type="checkbox" value="0.15"><span>15% ISV</span>');
    $("#label-txt-impuesto18").html('<input class="filled-in" id="producto-txt-impuesto18" type="checkbox" value="0.18"><span>18% ISV</span>');
}
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
            if ($("#producto-txt-impuesto15").prop("checked") == true) {
                _ISV_15 = parseFloat(($("#producto-txt-precioCosto").val() * $("#producto-txt-impuesto15").val()).toFixed(2)); // Se almacena como float
            }
            if ($("#producto-txt-impuesto18").prop("checked") == true) {
                _ISV_18 = parseFloat(($("#producto-txt-precioCosto").val() * $("#producto-txt-impuesto18").val()).toFixed(2)); // Se almacena como float
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
                            "impuesto15="+_ISV_15+"&"+
                            "impuesto18="+_ISV_18+"&"+
                            "descuento="+parseFloat(_DESCUENTO_APLICADO.toFixed(2))+"&"+
                            "precioVenta="+parseFloat(_PRECIO_VENTA.toFixed(2))+"&"+
                            "accion=registrar";
            console.log(parametros);
            console.log({
                "nombre":$("#producto-txt-nombre").val(),
                "cantidadDisponible":parseInt($("#producto-txt-cantidad").val()),
                "tipo":parseInt($("#producto-txt-tipo").val()),
                "precioCosto":parseFloat(parseFloat($("#producto-txt-precioCosto").val()).toFixed(2)),
                "impuesto15":_ISV_15,
                "impuesto18":_ISV_18,
                "descuento":parseFloat(_DESCUENTO_APLICADO.toFixed(2)),
                "precioVenta":parseFloat(_PRECIO_VENTA.toFixed(2)),
                "estado":1,
                "accion":"registrar"
            });
            
            $("#btn-producto").attr("disabled",true);
            $.ajax({
                url:"ajax/producto.php",
                data:parametros,
                method:"GET",
                dataType:"json",
                success:function(respuesta){
                    console.log(respuesta);
                    alert(respuesta.mensaje);
                    if(respuesta.codigo==1){
                        //alert("¡Producto registrado!");
                        mostrarProductos();
                        $("#btn-producto").attr("disabled",false);
                        cerrarModal("form-registrar-producto");
                    }
                    else{
                        //alert("ERROR: Ya existe un producto con el mismo nombre.");
                        $("#btn-producto").attr("disabled",false);
                    }
                },
                error:function(error){
                    console.log(error);
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
    $.ajax({
        url:"ajax/producto.php",
        data:"idProducto="+idProducto+"&accion=abrirModalEditarDatos",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            switch (respuesta.estado) {
                case 1:
                    $("#div-estado-producto").html('<label><span class="bold-text" id="producto-inactivo">Inactivo</span><input type="checkbox" id="producto-editar-estado" class="filled-in"><span class="bold-text lever" id="producto-span-editar-estado"></span><span class="bold-text" id="producto-activo">Activo</span></label>');
                    $("#producto-editar-estado").attr("checked", true);
                    $("#producto-activo").css("color", "#4caf50");
                    $("#producto-inactivo").css("color", "grey");
                    changeCheckbox("producto-editar-estado", "producto-activo", "producto-inactivo");
                    break;
                case 0:
                    $("#div-estado-producto").html('<label><span class="bold-text" id="producto-inactivo">Inactivo</span><input type="checkbox" id="producto-editar-estado" class="filled-in"><span class="bold-text lever" id="producto-span-editar-estado"></span><span class="bold-text" id="producto-activo">Activo</span></label>');
                    $("#producto-editar-estado").removeAttr("checked");
                    $("#producto-inactivo").css("color", "red");
                    $("#producto-activo").css("color", "grey");
                    changeCheckbox("producto-editar-estado", "producto-activo", "producto-inactivo");
                    break;
            }
            $('#inv-titulo-producto-editarDatos').html(respuesta.nombreProducto+" - "+ idProducto);
            $('input[id=producto-editar-precioCosto]').val(respuesta.precioCosto);
            $('input[id=producto-editar-descuento]').val(respuesta.descuento);
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
 * Abrir ventana modal para editar la cantidad disponible del producto seleccionado.
 * @param {Number} idProducto
 */
function abrirModal_productoEditarCantidad(idProducto) {
    console.log("Id producto a editar: "+idProducto);
    $.ajax({
        url:"ajax/producto.php",
        data:"idProducto="+idProducto+"&accion=abrirModalEditarDatos",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            $('#inv-titulo-producto-editarCantidad').html(respuesta.nombreProducto+" - "+ idProducto);
            $('input[id=producto-editar-cantidad]').val(respuesta.cantidadDisponible);
            $('#btn-modal-editarCantidad-producto').attr("onclick", "editarCantidadProducto('"+idProducto+"')");
            $('#modal-producto-editarCantidad').modal('open');
        },
        error:function(error){
            console.log(error);
        }
    });
}
/**
 * Editar datos de un producto.
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
        let _precioCosto = parseFloat(parseFloat($('#producto-editar-precioCosto').val()).toFixed(2));
        if ($("#producto-editar-impuesto15").prop("checked") == true) {
            _imp15 = parseFloat(($("#producto-editar-precioCosto").val() * $("#producto-editar-impuesto15").val()).toFixed(2)); // Se almacena como float
        }
        if ($("#producto-editar-impuesto18").prop("checked") == true) {
            _imp18 = parseFloat(($("#producto-editar-precioCosto").val() * $("#producto-editar-impuesto18").val()).toFixed(2)); // Se almacena como float
        }
        if ($("#producto-editar-descuento").val() > 0) {
            _descAplicado = parseFloat(($("#producto-editar-precioCosto").val() * ($("#producto-editar-descuento").val()/100)).toFixed(2)); // Se almacena como float
        }
        var parametros ="idProducto="+idProducto+"&"+
                        "precioCosto="+_precioCosto+"&"+
                        "descuento="+_descAplicado+"&"+
                        "impuesto15="+_imp15+"&"+
                        "impuesto18="+_imp18+"&"+
                        "precioVenta="+parseFloat(parseFloat(_precioCosto + _imp15 + _imp18 - _descAplicado).toFixed(2))+"&"+
                        "estado="+obtenerValorCheckbox('producto-editar-estado')+"&"+
                        "accion=editarDatos";
        console.log(parametros);
        $("#btn-modal-editarDatos-producto").attr("disabled",true);
        $.ajax({
            url:"ajax/producto.php",
            data:parametros,
            method:"GET",
            dataType:"json",
            success:function(respuesta){
                console.log(respuesta);
                alert(respuesta.mensaje);
                if (respuesta.codigo == 0) {
                    $("#btn-modal-editarDatos-producto").attr("disabled", false);
                } else {
                    $("#vnt-precioCosto-producto"+idProducto).html("Lps. "+_precioCosto);
                    $("#vnt-descuento-producto"+idProducto).html("Lps. "+_descAplicado);
                    $("#vnt-impuesto15-producto"+idProducto).html("Lps. "+_imp15);
                    $("#vnt-impuesto18-producto"+idProducto).html("Lps. "+_imp18);
                    $("#vnt-precioVenta-producto"+idProducto).html("Lps. "+parseFloat(_precioCosto + _imp15 + _imp18 - _descAplicado).toFixed(2));
                    switch (parseInt(obtenerValorCheckbox('producto-editar-estado'))) {
                        case 0:
                            $("#vnt-estado-producto"+idProducto).html("INACTIVO");
                            $("#vnt-estado-producto"+idProducto).removeClass("green-text");
                            $("#vnt-estado-producto"+idProducto).addClass("red-text");
                            break;
                        case 1:
                            $("#vnt-estado-producto"+idProducto).html("ACTIVO");
                            $("#vnt-estado-producto"+idProducto).removeClass("red-text");
                            $("#vnt-estado-producto"+idProducto).addClass("green-text");
                            break;
                    }
                    cerrarModal("form-editarDatos-producto");
                    $("#btn-modal-editarDatos-producto").attr("disabled",false);
                }
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
/**
 * Editar cantidad disponible de un producto.
 * @param {Number} idProducto 
 */
function editarCantidadProducto(idProducto) {
    if (
        validarRegex("producto-editar-cantidad", "entero")
    ) {
        let _estado = 1;
        if (parseInt($('#producto-editar-cantidad').val()) == 0) {
            _estado = 0;
        }
        var parametros ="idProducto="+parseInt(idProducto)+"&"+
                        "cantidadDisponible="+parseInt($('#producto-editar-cantidad').val())+"&"+
                        "estado="+_estado+"&"+
                        "accion=editarCantidad";
        console.log(parametros);
        $("#btn-modal-editarCantidad-producto").attr("disabled",true);
        $.ajax({
            url:"ajax/producto.php",
            data:parametros,
            method:"GET",
            dataType:"json",
            success:function(respuesta){
                console.log(respuesta);
                alert(respuesta.mensaje);
                $("#vnt-cantidad-producto"+idProducto).html(parseInt($('#producto-editar-cantidad').val()));
                if (_estado == 0) {
                    $("#vnt-estado-producto"+idProducto).removeClass("green-text");
                    $("#vnt-estado-producto"+idProducto).addClass("red-text");
                    $("#vnt-estado-producto"+idProducto).html("INACTIVO");
                }
                cerrarModal("form-editarCantidad-producto");
                $("#btn-modal-editarCantidad-producto").attr("disabled",false);
            },
            error:function(error){
                console.log(error);
                $("#btn-modal-editarCantidad-producto").attr("disabled",false);
            }
        });
    } else {
        alert("No es posible registrar al proveedor: hay campos vacíos o algún tipo de dato no es válido.");
    }
}
/**
 * Mostrar lista de productos.
 */
function mostrarProductos() {
    console.log("Productos: Lista de productos");
    $.ajax({
        url:"ajax/producto.php",
        data:"accion=listaProductos",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            $("#lista-productos").html("");
            let _PRODUCTO_ESTADO = [];
            respuesta.forEach(producto => {
                switch (parseInt(producto.estado)) {
                    case 0:
                        _PRODUCTO_ESTADO[0] = "INACTIVO";
                        _PRODUCTO_ESTADO[1] = "red-text";
                        break;
                    case 1:
                        _PRODUCTO_ESTADO[0] = "ACTIVO";
                        _PRODUCTO_ESTADO[1] = "green-text";
                        break;
                }
                $("#lista-productos").append(`
                    <li class="collection-item avatar flex-div scroll-item grid-display">
                        <div>
                        <div class="col s12"><img src="img/producto2.jpg" alt="" class="circle"></div>
                        <div class="bold-text col s12 m6" id="vnt-nombre-producto${producto.idProducto}">${producto.nombreProducto}</div>
                        <div class="grey-text col s12 m6">Tipo de producto: <span id="vnt-tipo-producto${producto.idProducto}" class="black-text">${producto.tipoProducto}</span></div>
                        <div class="grey-text col s12 m6">Estado: <span id="vnt-estado-producto${producto.idProducto}" class="bold-text ${_PRODUCTO_ESTADO[1]}">${_PRODUCTO_ESTADO[0]}</span></div>  
                        <div class="grey-text col s12 m6">Cantidad disponible: <span id="vnt-cantidad-producto${producto.idProducto}" class="black-text green-text">${producto.cantidadDisponible}</span></div>
                        <div class="grey-text col s12 m6">Precio costo: <span id="vnt-precioCosto-producto${producto.idProducto}" class="black-text">Lps. ${producto.precioCosto}</span></div>
                        <div class="grey-text col s12 m6">15% ISV: <span id="vnt-impuesto15-producto${producto.idProducto}" class="black-text">Lps. ${producto.impuesto15}</span></div>
                        <div class="grey-text col s12 m6">18% ISV: <span id="vnt-impuesto18-producto${producto.idProducto}" class="black-text">Lps. ${producto.impuesto18}</span></div>
                        <div class="grey-text col s12 m6">Descuento: <span id="vnt-descuento-producto${producto.idProducto}" class="black-text">Lps. ${producto.descuento}</span></div>
                        <div class="grey-text col s12 m6">Precio venta: <span id="vnt-precioVenta-producto${producto.idProducto}" class="black-text">Lps. ${producto.precioVenta}</span></div>
                        <div class="col s12">
                            <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_productoEditarDatos('${producto.idProducto}')">Editar datos</button>
                        </div>
                        <div class="col s12">
                            <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_productoEditarCantidad('${producto.idProducto}')">Editar cantidad disponible</button>
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
/* ------ CLIENTES ------ */
/**
 * Mostrar lista de clientes.
 */
function mostrarClientes() {
    console.log("Clientes: Lista de clientes");
}