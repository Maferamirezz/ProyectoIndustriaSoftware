/**
 * @fileoverview Archivo de funciones comunes: ventanas modales, bloqueos de teclado
 * @version         2.0
 * @author          Maria Ramirez, Gerardo Alvarenga, Juan Enriquez, Walter Rivera
 * @copyright       GAMA
 */
$(document).ready(function(){
    console.log("Se ha cargado 'common.js' en el DOM ♥");
    
    $('.tabs').tabs();
    $('.modal').modal({ 
        onCloseEnd: function () {
            console.log("Limpiar ventana modal abierta");
            $(".form-reset").trigger("reset");
            $("select").removeClass("valid-select");
            $("select").removeClass("invalid-select");
            $(".helper-text").html("");
            $("input[type=checkbox]").removeAttr("checked");
        }
    });
    $('.collapsible').collapsible();
});
/* ------------------------------------------ */
/**
 * Al cerrar la ventana modal abierta se limpiará su formulario.
 * @param {String} nombreFormulario 
 */
function cerrarModal(nombreFormulario) {
    console.log("Ventana modal a cerrar: "+nombreFormulario);
    document.getElementById(nombreFormulario).reset();
    $('.modal.open').modal('close');
}
/* ----------------------------------------- */
/* ------ BLOQUEAR EL TECLADO PARA QUE SOLO CIERTOS CARACTERES PUEDAN SER USADOS ------ */
$(".regexEntero").keypress(
    /**
     * Bloquear el teclado para que sólo se puedan escribir los dígitos del 0 - 9.
     */
    function(){
    return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null: event.charCode >= 48 && event.charCode <= 57;
});
$(".regexDecimal").keypress(
    /**
     * Bloquear el teclado para que sólo se puedan escribir los dígitos del 0 - 9 y usar el punto o la coma decimal.
     */
    function(){
    return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null: event.charCode >= 48 && event.charCode <= 57 || event.charCode == 44 || event.charCode == 46;
});  
$(".regexAlfanumerico").keypress(
    /**
     * Bloquear el teclado para que sólo se puedan escribir caracteres alfanuméricos los dígitos del 0 - 9.
     */
    function(){
    return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null: event.charCode >= 48 && event.charCode <= 57 || event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122;
});