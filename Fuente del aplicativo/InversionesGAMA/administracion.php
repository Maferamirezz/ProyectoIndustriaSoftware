<?php
  include("_seguridad.php");
  if ($_SESSION["gama_areatrabajo"] == "Inventario") {
    header("Location: inventario.php");
  } elseif ($_SESSION["gama_areatrabajo"] == "Ventas") {
    header("Location: ventas.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Administración</title>
  <link href="img/logo.svg" rel="icon">
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/common.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/modulo.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/administracion.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <div class="row margin-zero common-bg">
    <nav role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo valign-wrapper"><img src="img/logo.svg" id="nav-logo-svg"></a>
        <ul class="right hide-on-med-and-down">
          <li><a class="waves-effect" href="panel.php">Atrás</a></li>
          <li><a class="waves-effect" href="administracion.php">Actualizar</a></li>
          <li><a class="waves-effect" href="_logout.php">Salir</a></li>
        </ul>
        <ul id="nav-mobile" class="sidenav" style="transform: translateX(-105%);">
          <li><a class="waves-effect" href="panel.php">Atrás</a></li>
          <li><a class="waves-effect" href="#">Actualizar</a></li>
          <li><a class="waves-effect" href="_logout.php">Salir</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>
    </nav>
    <div class="container principal-container col s12">
      <div class="col s10 white z-depth-5 principal-div">
        <div class="row margin-zero">
          <div class="col s12 center">
            <img src="img/logo.svg" id="logo-svg">
            <h5 class="margin-zero gama-title">Finca E Inversiones GAMA</h5>
            <h4 class="row center">Administración</h4>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col s12 no-left-float">
            <ul class="tabs let-scroll">
              <li class="tab"><a href="#inv1">Usuarios</a></li>
              <li class="tab"><a href="#inv2">Jornada Laboral</a></li>
              <li class="tab"><a href="#inv3">Logs</a></li>
            </ul>
          </div>
          <!--REGISTRAR NUEVO USUARIO / EDITAR USUARIO-->
          <div id="inv1" class="col s12">
            <br>
            <div class="justify-text col s12">
              <h5>Usuarios</h5>
              <p>Un usuario es una persona que utiliza un sistema de información. A través de un proceso de identificación se le otorga
                a una persona autorización para acceder al sistema y gozar de determinados permisos.</p>
            </div>
            <div class="col s12">
              <h6 class="bold-text">Registrar un nuevo usuario en el sistema</h6>
              <blockquote>
                Lo más importante del proceso de identificación es la asignación del cargo o rol, ya que este dato establece
                el alcance y permisos que tendrá el usuario.
                <ol>
                  <li>Administrador: conocido como súper usuario.</li>
                  <li>Socio: conocido como súper usuario.</li>
                  <li>Gerente de ventas: conocido como súper usuario.</li>
                  <li>Encargado de inventario: conocido como súper usuario.</li>
                </ol>
              </blockquote>
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger" data-target="modal-usuario-registrar"><i class="material-icons left">add</i>Nuevo usuario</button>
              </p>
            </div>
            <!-- 1. Ventana modal para registrar nuevo usuario -->
            <div class="modal" id="modal-usuario-registrar">
              <div class="modal-content">
                <h4>Nuevo usuario</h4>
                <p class="no-margin-padding-bottom">Registrar en el sistema a una persona para otorgarle acceso y permisos</p>
                <p class="no-margin-padding-bottom">
                  <b>Condiciones:</b>
                  <div>Nombre de usuario: <span class="grey-text">Mínimo 8 caracteres, combinando números, mayúsculas y minúsculas.</span></div>
                  <div>Contraseña: <span class="grey-text">Mínimo 8 caracteres, combinando números, mayúsculas, minúsculas y caracteres especiales (@#$%&)</span></div>
                </p>
              </div>
              <form id="form-registrar-usuario" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 input-field margin-zero padding-zero">
                  <p class="grey-text no-margin-padding-top">No. Identidad (sin guiones)</p>
                  <input class="regexEntero validate" required id="usuario-txt-id" type="number" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Primer nombre</p>
                  <input class="validate" required id="usuario-txt-pnombre" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Segundo nombre</p>
                  <input class="validate" required id="usuario-txt-snombre" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Primer apellido</p>
                  <input class="validate" required id="usuario-txt-papellido" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Segundo apellido</p>
                  <input class="validate" required id="usuario-txt-sapellido" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Género</p>
                  <select class="input-field visible" required id="usuario-txt-genero">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Masculino</option>
                    <option value="2">Femenino</option>
                  </select>
                  <span class="helper-text" id="usuario-span-genero"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" required id="usuario-txt-telefono" type="number" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Área de trabajo</p>
                  <select class="input-field visible" required id="usuario-txt-area">
                      <option value="" disabled="" selected="">Elegir</option>
                      <option value="1">Ventas</option>
                      <option value="2">Inventario</option>
                      <option value="3">Administración</option>
                    </select>
                    <span class="helper-text" id="usuario-span-area"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">No. Contrato</p>
                  <input class="validate" required id="usuario-txt-contrato" type="number" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field margin-zero padding-zero">
                  <p class="grey-text">Nombre de usuario</p>
                  <input class="regexAlfanumerico validate" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}" required id="usuario-txt-username" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Contraseña</p>
                  <input class="validate" pattern=".*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*" required id="usuario-txt-password1" type="password">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Confirmar contraseña</p>
                  <input class="validate" pattern=".*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*" required id="usuario-txt-password2" type="password">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field margin-zero padding-zero">
                  <p class="grey-text">Tipo de usuario</p>
                  <select class="input-field visible validate" required id="usuario-txt-tipo">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Empleado</option>
                    <option value="2">Socio</option>
                  </select>
                  <span class="helper-text" id="usuario-span-tipo"></span>
                </div>
                <div class="col s12 input-field margin-zero padding-zero">
                  <p class="grey-text">Dirección</p>
                  <input class="validate" required id="usuario-txt-direccion" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-usuario">Guardar</button>
                <button class="waves-effect waves-red btn-flat"onclick="cerrarModal('form-registrar-usuario')">Cancelar</button>
              </div>
            </div>
            <!-- 2. Lista de usuarios con opcion a editar-->
            <div class="row margin-zero">
              <div class="col s12">
                <h6 class="bold-text">Lista de usuarios registrados</h6>
                <blockquote>Aquí podrá visualizar los usuarios que tienen acceso al sistema de <i>Finca E Inversiones GAMA</i>. Si la información
                  de alguno de ellos cambia se recomienda registrarlo en el sistema para tener un mejor manejo de los usuarios.</blockquote>
              </div>
              <!-- Ventana modal para editar usuario -->
              <div class="modal" id="modal-usuario-editar">
                <div class="modal-content">
                  <h4>Editar usuario <h5 id="adm-titulo-usuario-editar">Juan Alberto Pérez Lagos 0801198578492</h5></h4>
                  <p class="no-margin-padding-bottom">Ingrese los nuevos datos. Si sólo cambia uno los otros permanecen sin cambios.</p><p class="no-margin-padding-bottom">
                    <b>Condiciones:</b>
                    <div>Nombre de usuario: <span class="grey-text">Mínimo 8 caracteres, combinando números, mayúsculas y minúsculas.</span></div>
                    <div>Contraseña: <span class="grey-text">Mínimo 8 caracteres, combinando números, mayúsculas, minúsculas y caracteres especiales (@#$%&)</span></div>
                  </p>
                </div>
                <form id="form-editar-usuario" class="modal-content no-margin-padding-top flex-div form-reset">
                  <div class="col s12 padding-zero">
                    <p class="grey-text no-margin-padding-top">Estado del usuario</p>
                    <p class="switch" id="div-estado-usuario"></p>
                  </div>
                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" required id="usuario-editar-telefono" type="number" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 left-pad-input input-field margin-zero">
                    <p class="grey-text">No. Contrato</p>
                    <input class="validate" required id="usuario-editar-contrato" type="number" min="0">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 input-field margin-zero padding-zero">
                    <p class="grey-text">Área de trabajo</p>
                    <select class="input-field visible validate" required id="usuario-editar-area">
                      <option value="" disabled="" selected="">Elegir</option>
                      <option value="1">Ventas</option>
                      <option value="2">Inventario</option>
                      <option value="3">Administración</option>
                    </select>
                    <span class="helper-text" id="usuario-span-editar-area"></span>
                  </div>
                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Nombre de usuario</p>
                    <input class="regexAlfanumerico validate" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}" required id="usuario-editar-username" type="text">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 left-pad-input input-field margin-zero">
                    <p class="grey-text">Contraseña anterior</p>
                    <input class="validate" pattern=".*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*" required id="usuario-editar-oldPassword" type="password">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Nueva contraseña</p>
                    <input class="validate" pattern=".*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*" required id="usuario-editar-password1" type="password">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 left-pad-input input-field margin-zero">
                    <p class="grey-text">Confirmar nueva contraseña</p>
                    <input class="validate" pattern=".*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*" required id="usuario-editar-password2" type="password">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 input-field margin-zero padding-zero">
                    <p class="grey-text">Tipo de usuario</p>
                    <select class="input-field visible validate" required id="usuario-editar-tipo">
                      <option value="" disabled="" selected="">Elegir</option>
                      <option value="1">Empleado</option>
                      <option value="2">Socio</option>
                    </select>
                    <span class="helper-text" id="usuario-span-editar-tipo"></span>
                  </div>
                  <div class="col s12 input-field margin-zero padding-zero">
                    <p class="grey-text">Dirección</p>
                    <input class="validate" required id="usuario-editar-direccion" type="text">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="waves-effect waves-green btn-flat" id="btn-modal-editar-usuario" onclick="editarUsuario('1')">Guardar</button>
                  <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-editar-usuario')">Cancelar</button>
                </div>
              </div>
            </div>
            <div class="col s12">
              <ul id="lista-usuarios" class="collection">
                <li class="collection-item flex-div scroll-item grid-display">
                  <div class="flex-display">
                    <h6 class="btn-floating pulse red" style="width: 23.19px !important;height: 23.19px;" id="adm-estado-usuario0702197910028"></h6>
                    <h6 id="adm-nombre-usuario0702197910028">Pedro Picapiedra</h6>
                  </div>
                  <div class="row">
                    <div class="col s12 salto-de-linea"> ID: <span class="grey-text" id="adm-id-usuario0702197910028">0702197910028</span></div>
                    <div class="col s12 m6 salto-de-linea">Rol: <span id="adm-tipo-usuario0702197910028" class="grey-text">Empleado</span></div>
                    <div class="col s12 m6 salto-de-linea">Área de trabajo: <span id="adm-area-usuario0702197910028" class="grey-text">Inventario</span></div>
                    <div class="col s12 m6 salto-de-linea">No. Contrato: <span id="adm-contrato-usuario0702197910028" class="grey-text">123456</span></div>
                    <div class="col s12 m6 salto-de-linea">Teléfono: <span id="adm-telefono-usuario0702197910028" class="grey-text">33008800</span></div>
                    <div class="col s12 m6 salto-de-linea">Nombre de usuario: <span id="adm-username-usuario0702197910028" class="grey-text">JuanAPL</span></div>
                    <div class="col s12 m6 salto-de-linea">Contraseña: <span id="adm-password-usuario0702197910028" class="grey-text">asadasd3423.34$</span></div>
                    <div class="col s12 salto-de-linea ">Dirección: <span id="adm-direccion-usuario0702197910028" class="grey-text">Barrio La Playa, La Ceiba San Juan Puerto Rico Las </span></div><div class="col s12">
                    <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_usuarioEditar('0702197910028')"><i class="material-icons left">edit</i>Editar</button></div>
                  </div>
                </li>
                <li class="collection-item flex-div scroll-item grid-display">
                  <div class="flex-display">
                    <h6 class="btn-floating pulse red" style="width: 23.19px !important;height: 23.19px;" id="adm-estado-usuario0702199500010"></h6>
                    <h6 id="adm-nombre-usuario0702199500010">Juan Carlos Ortiz Barahona</h6>
                  </div>
                  <div class="row">
                    <div class="col s12 salto-de-linea"> ID: <span class="grey-text" id="adm-id-usuario0702199500010">0702199500010</span></div>
                    <div class="col s12 m6 salto-de-linea">Rol: <span id="adm-tipo-usuario0702199500010" class="grey-text">Empleado</span></div>
                    <div class="col s12 m6 salto-de-linea">Área de trabajo: <span id="adm-area-usuario0702199500010" class="grey-text">Inventario</span></div>
                    <div class="col s12 m6 salto-de-linea">No. Contrato: <span id="adm-contrato-usuario0702199500010" class="grey-text">123456</span></div>
                    <div class="col s12 m6 salto-de-linea">Teléfono: <span id="adm-telefono-usuario0702199500010" class="grey-text">33008800</span></div>
                    <div class="col s12 m6 salto-de-linea">Nombre de usuario: <span id="adm-username-usuario0702199500010" class="grey-text">JuanAPL</span></div>
                    <div class="col s12 m6 salto-de-linea">Contraseña: <span id="adm-password-usuario0702199500010" class="grey-text">asadasd3423.34$</span></div>
                    <div class="col s12 salto-de-linea">Dirección: <span id="adm-direccion-usuario0702199500010" class="grey-text">Barrio La Playa, La Ceiba San Juan Puerto Rico Las </span></div><div class="col s12">
                    <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_usuarioEditar('0702199500010')"><i class="material-icons left">edit</i>Editar</button></div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <!--REGISTRAR/VER JORNADA LABORAL-->
          <div id="inv2" class="col s12">
            <br>
            <div class="justify-text col s12">
              <h5>Jornada Laboral</h5>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro asperiores veritatis est sint consectetur dignissimos.</p>
            </div>
            <div class="col s12">
              <h6 class="bold-text">Registrar una nueva jornada laboral</h6>
              <blockquote>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, laborum corporis, accusantium delectus nobis doloremque nulla, temporibus commodi quas maiores dolorum. Rerum?
              </blockquote>
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger" data-target="modal-jornada-registrar"><i class="material-icons left">add</i>Nueva jornada</button>
              </p>
            </div>
            <!-- 1. Ventana modal para registrar nueva jornada laboral -->
            <div class="modal" id="modal-jornada-registrar">
              <div class="modal-content">
                <h4>Registrar nueva jornada laboral</h4>
                <p class="no-margin-padding-bottom">Ingresar las fechas en las cuales está comprendido el archivo a subir de la jornada laboral.</p>
              </div>
              <form id="form-registrar-jornada" class="modal-content no-margin-padding-top form-reset">
                <div class="row no-margin-padding-bottom">
                  <div class="col s12 m6 input-field no-margin-padding-top">
                    <p class="grey-text">Fecha inicio</p>
                    <input type="date" id="jornada-txt-fechaInicio" class="validate" required="">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 input-field no-margin-padding-top">
                    <p class="grey-text">Fecha fin</p>
                    <input type="date" id="jornada-txt-fechaFinal" class="validate" required="">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                </div>
                <div class="row margin-zero">
                  <p class="grey-text no-margin-padding-top">Archivo</p>
                  <div class="file-field input-field margin-zero">
                    <div class="btn">
                      <span>File</span>
                      <input type="file" required="" id="jornada-txt-archivo">
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate" type="text">
                      <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                    </div>
                  </div>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-jornada">Guardar</button>
                <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-registrar-jornada')">Cancelar</button>
              </div>
            </div>
            <!-- 2. Lista de jornadas laborales con link al archivo-->
            <div class="row margin-zero">
              <div class="col s12">
                <h6 class="bold-text">Lista de jornadas laborales registradas</h6>
                <blockquote>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti voluptatum consectetur similique veniam laboriosam, obcaecati facere ullam quasi adipisci.
                </blockquote>
              </div>
              <!-- Ventana modal para mostrar imagen de archivo de la jornada laboral -->
              <div class="modal" id="modal-jornada-archivo">
                <div class="modal-content" id="imagen-jornada-laboral"></div>
                <div class="modal-footer">
                  <a href="#" download="ReporteJornadaLaboral" class="waves-effect waves-blue btn-flat" id="a-modal-descargar-jornada">Descargar</a>
                  <button class="waves-effect waves-red btn-flat modal-close">Cancelar</button>
                </div>
              </div>
            </div>
            <div class="col s12">
              <ul class="collection" id="lista-jornadas">
                <li class="collection-item flex-div">
                  <div class="bold-text col s12" id="adm-nombre-jornada215">Jornada 215</div>
                  <div class="grey-text col s12 m6">Fecha inicio: <span id="adm-fechaInicio-jornada215" class="black-text" style="font-family: monospace;">12/05/19</span></div>
                  <div class="grey-text col s12 m6">Fecha final: <span id="adm-fechaFin-jornada215" class="black-text" style="font-family: monospace;">11/06/19</span></div>
                  <div class="col s12">
                    <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_jornadaArchivo('img/bg_color.jpg')">Ver archivo</button>
                  </div>
                </li>
                <li class="collection-item flex-div">
                  <div class="bold-text col s12" id="adm-nombre-jornada444">Jornada 444</div>
                  <div class="grey-text col s12 m6">Fecha inicio: <span id="adm-fechaInicio-jornada444" class="black-text" style="font-family: monospace;">20/09/19</span></div>
                  <div class="grey-text col s12 m6">Fecha final: <span id="adm-fechaFin-jornada444" class="black-text" style="font-family: monospace;">04/01/20</span></div>
                  <div class="col s12">
                    <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_jornadaArchivo('img/bg_dark.jpg')">Ver archivo</button>
                  </div>
                </li>
              </ul>
            </div>
          </div>



          
          <!--VER REGISTRO DE INGRESOS AL SISTEMA-->
          <div id="inv3" class="col s12">
              <br>
              <div class="justify-text col s12">
                <h5>Logs</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro asperiores veritatis est sint consectetur dignissimos.</p>
              </div>
              <!-- 1. Lista de usuarios con fecha y hora de ingreso al sistema -->
              <div class="row margin-zero">
                <div class="col s12">
                  <h6 class="bold-text">Lista de ingresos al sistema</h6>
                  <blockquote>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti voluptatum consectetur similique veniam laboriosam, obcaecati facere ullam quasi adipisci.
                  </blockquote>
                </div>
                <!-- Ventana modal para mostrar imagen de archivo de la jornada laboral -->
                <div class="modal" id="modal-jornada-archivo">
                  <div class="modal-content" id="imagen-jornada-laboral"></div>
                  <div class="modal-footer">
                    <a href="#" download="ReporteJornadaLaboral" class="waves-effect waves-blue btn-flat" id="a-modal-descargar-jornada">Descargar</a>
                    <button class="waves-effect waves-red btn-flat modal-close">Cancelar</button>
                  </div>
                </div>
              </div>
              <div class="col s12">
                <ul class="collection" id="lista-jornadas">
                  <li class="collection-item flex-div">
                    <div class="bold-text col s12" id="adm-nombre-jornada215">Jornada 215</div>
                    <div class="grey-text col s12 m6">Fecha inicio: <span id="adm-fechaInicio-jornada215" class="black-text" style="font-family: monospace;">12/05/19</span></div>
                    <div class="grey-text col s12 m6">Fecha final: <span id="adm-fechaFin-jornada215" class="black-text" style="font-family: monospace;">11/06/19</span></div>
                    <div class="col s12">
                      <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_jornadaArchivo('img/bg_color.jpg')">Ver archivo</button>
                    </div>
                  </li>
                  <li class="collection-item flex-div">
                    <div class="bold-text col s12" id="adm-nombre-jornada444">Jornada 444</div>
                    <div class="grey-text col s12 m6">Fecha inicio: <span id="adm-fechaInicio-jornada444" class="black-text" style="font-family: monospace;">20/09/19</span></div>
                    <div class="grey-text col s12 m6">Fecha final: <span id="adm-fechaFin-jornada444" class="black-text" style="font-family: monospace;">04/01/20</span></div>
                    <div class="col s12">
                      <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_jornadaArchivo('img/bg_dark.jpg')">Ver archivo</button>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
        </div>
      </div>
    </div>
    <footer class="col s12 page-footer">
      <div class="footer-copyright">
        <div class="container">
          Made by <a class="white-text text-lighten-8" href="http://materializecss.com">Materialize</a>
        </div>
      </div>
    </footer>
  </div>
  <!--  Scripts-->
  <!--script src="https://code.jquery.com/jquery-2.1.1.min.js"></script-->
  <script src="js/jquery.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <!-- CUSTOM JS -->
  <script src="js/controlador-administracion.js"></script>
  <script src="js/funciones-validacion.js"></script>
  <script src="js/common.js"></script>
  <div class="sidenav-overlay" style="display: none; opacity: 0;"></div>
  <div class="drag-target"></div>
</body>
</html>
