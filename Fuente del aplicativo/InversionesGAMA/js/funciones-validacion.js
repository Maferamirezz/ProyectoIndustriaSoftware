/**
 * @fileoverview Funciones de validación: campos vacíos, etiquetas específicas, formatos con expresiones regulares.
 * @version         2.0
 * @author          Maria Ramirez, Gerardo Alvarenga, Juan Enriquez, Walter Rivera
 * @copyright       GAMA
 */
/**
 * Validar si un campo requerido en un formulario está vacío.
 * @param {number} id
 * @return {boolean} true || false
 */
function validarCampoVacio(id){
    if(document.getElementById(id).value == ""){
        addInvalid(id);
        return false;
    } else {
        addValid(id);     
        return true;
    }
}
/**
 * Validar un campo que no es obligatorio en un formulario.
 * @param {Number} id 
 */
function validarCampoNoObligatorio(id){
    addValid(id);
    return true;
}
/**
 * Agregar la clase "valid" a un elemento y remover "invalid", indicando que está correcto.
 * @param {Number} id 
 */
function addValid(id) {
    document.getElementById(id).classList.remove("invalid");
    document.getElementById(id).classList.add("valid");    
}
/**
 * Agregar la clase "invalid" a un elemento y remover "valid", indicando que está incorrecto.
 * @param {Number} id 
 */
function addInvalid(id) {
        document.getElementById(id).classList.remove("valid");
        document.getElementById(id).classList.add("invalid");
}
/* ------ Validar select y validar change ------ */
/**
 * Validar si una lista seleccionable está vacía o tiene un valor válido.
 * @param {Number} id 
 * @param {String} idSpan 
 * @return {boolean} true|| false
 */
function validarSelectList(id, idSpan) {
    if (document.getElementById(id).value == "") {
        document.getElementById(id).classList.remove("valid-select");
        document.getElementById(id).classList.add("invalid-select");
        document.getElementById(idSpan).classList.remove("green-text");
        document.getElementById(idSpan).classList.add("red-text");
        $("#"+idSpan).html("Campo vacío o dato inválido");
        return false;
    } else {
        document.getElementById(id).classList.remove("invalid-select");
        document.getElementById(id).classList.add("valid-select");
        $("#"+idSpan).html("");
        return true;
    }
}
/**
 * Validar una lista seleccionable cuando su valor cambia a uno válido.
 * @param {Number} id 
 * @param {String} idSpan 
 */
function changeSelect(id, idSpan) {
    $("#"+id).change(function() {
        document.getElementById(id).classList.remove("invalid-select");
        document.getElementById(id).classList.add("valid-select");
        $("#"+idSpan).html("");
    });
}
/* ------ Change status checkbox y obtener valor ------ */
/**
 * Si el estado de una casilla de verificación cambia entre activo o inactivo, agregar y remover las clases respectivas para visualizar dicho estado.
 * @param {Number} id 
 * @param {String} idSpanActivo 
 * @param {String} idSpanInactivo 
 */
function changeCheckbox(id, idSpanActivo, idSpanInactivo) {
    $("#"+id).change(function () {
        if (this.checked == true) {
            $("#"+id).attr("checked", true);
            $("#"+idSpanActivo).css("color", "green");
            $("#"+idSpanInactivo).css("color", "grey");
            console.log("Activo: "+$("#"+id).val());
        } else {
            $("#"+id).removeAttr("checked");
            $("#"+idSpanInactivo).css("color", "red");
            $("#"+idSpanActivo).css("color", "grey");
            console.log("Inactivo: "+$("#"+id).val());
        }
    });
}
/**
 * Obtener el valor del estado de una casilla de verificación dependiendo si está marcada o no.
 * @param {Number} id
 * @return checkbox value
 * @return {boolean} true|| false
 */
function obtenerValorCheckbox(id) {
    if ($("#"+id).prop("checked") == true) {
        $("#"+id).val("1");
        console.log("Activo: "+$("#"+id).val());
    } else {
        $("#"+id).val("0");
        console.log("Inactivo: "+$("#"+id).val());
    }
    return $("#"+id).val();
}
/* ------ Validar campos especificos ------ */
/**
 * Validar un campo no obligatorio para un email. Si tiene un valor verificar que sea un email válido.
 * @param {String} email
 * @return {boolean} true|| false
 */
function validarEmailNoObligatorio(email) {
    if (document.getElementById(email).value == "") {
        addValid(email);
        console.log("Email vacio OK: "+email);
        return true;
    } else {
        return validarRegex(email,"email");
    }
}
/**
 * Validar que dos contraseñas coincidan entre si. En especial para un formulario de registro.
 * @param {String} contra1
 * @param {String} contra2
 * @return {boolean} true|| false
 */
function validarPasswordSignUp(contra1,contra2){
    if (validarRegex(contra1, "password") && validarRegex(contra2, "password")) {
        if (document.getElementById(contra1).value == document.getElementById(contra2).value) {
            addValid(contra1);
            addValid(contra2);
            return true;
        } else {
            addInvalid(contra1);
            addInvalid(contra2);
            alert("Las contraseñas no coinciden.");
            return false;
        }
    } else {
        return false;
    }
}
/* ------ Validar campos usando expresiones regulares ------ */
/**
 * Validar mediante expresiones regulares el formato de números enteros y decimales, contraseñas, email y username.
 * @param {Number} id
 * @param {String} tipo
 * @return {boolean} true || false
 */
function validarRegex(id, tipo) {
    var re = null;
    switch (tipo) {
        case "entero":
            re = /^[0-9]+$/;
            break;
        case "decimal":
            re = /^[0-9]+[,|\.]?[0-9]+$/;
            break;
        case "password":
            re = /^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*$/;
            break;
        case "username":
            re = /^^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
            break;
        case "email":
            re = /^(([^<>()%&[\]\.,;:\s@\"]+(\.[^<>()%&[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()%&[\]\.,;:\s@\"]+\.)+[^<>()%&[\]\.,;:\s@\"]{2,})$/;
            break;
        case "idFactura":
            re = /^[\d]{3}-[\d]{3}-[\d]{2}-[\d]{8}$/;
            break;
    }
    console.log(re);
    if ( re.test(document.getElementById(id).value) ) {
        console.log(tipo+" valido: " + document.getElementById(id).value);
        addValid(id);
        return true;
    } else {
        console.log(tipo+" invalido: " + document.getElementById(id).value);
        addInvalid(id);
        return false;
    }
}