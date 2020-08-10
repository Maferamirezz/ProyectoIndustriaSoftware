/**
 * Abrir en una ventana modal para la edicion de un producto
 * @param {Number} idproducto 
 */
function abrirModal_producto_Editar(idproducto) {
    // console.log("Archivo de jornada laboral a mostrar: "+urlJornada);
    // $("#imagen-jornada-laboral").html('<img class="total-width" src=" '+ urlJornada +' ">');    
    // $('#a-modal-descargar-jornada').attr("href", urlJornada);  
    $('#modal-producto-editarDatos').modal('open');
}

/**
 * Abrir en una ventana modal para la edicion de un proveedor.
 * @param {Number} idproveedor
 */
function abrirModal_proveedorEditar(idproveedor) {
    // console.log("Archivo de jornada laboral a mostrar: "+urlJornada);
    // $("#imagen-jornada-laboral").html('<img class="total-width" src=" '+ urlJornada +' ">');    
    // $('#a-modal-descargar-jornada').attr("href", urlJornada);  
    $('#modal-proveedor-editar').modal('open');

}

/**
 * Abrir en una ventana modal para la edicion de un cliente.
 * @param {Number} idcliente
 */
function abrirModal_clienteEditar(idcliente) {
    // console.log("Archivo de jornada laboral a mostrar: "+urlJornada);
    // $("#imagen-jornada-laboral").html('<img class="total-width" src=" '+ urlJornada +' ">');    
    // $('#a-modal-descargar-jornada').attr("href", urlJornada);  
    $('#modal-cliente-editar').modal('open');

}

