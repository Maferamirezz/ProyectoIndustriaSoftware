<?php
  include("_seguridad.php");
  if ($_SESSION["gama_areatrabajo"] == "Inventario") {
    header("Location: inventario.php");
  } elseif ($_SESSION["gama_areatrabajo"] == "Ventas") {
    header("Location: ventas.php");
  }
  ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Clientes</title>
  <link href="img/logo.svg" rel="icon">
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/common.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/modulo.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/cliente.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <div class="row margin-zero common-bg">
    <nav role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo valign-wrapper"><img src="img/logo.svg" id="nav-logo-svg"></a>
        <ul class="right hide-on-med-and-down">
          <li><a class="waves-effect" href="panel.php">Atrás</a></li>
          <li><a class="waves-effect" href="cliente.php">Actualizar</a></li>
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
            <h4 class="row center">CLIENTES</h4>
          </div>
        </div>
        <hr>
        <div class="row">
          
          <!--REGISTRAR NUEVO CLIENTE / EDITAR CLIENTE-->
          <div id="inv1" class="col s12">
            <br>
            <div class="justify-text col s12">
              <h5>Nuevo Cliente</h5>
              <p>Aqui se registraran los nuevos clientes que la empresa adquiera.</p>
            </div>
            <div class="col s12">
              <h6 class="bold-text">¿Cómo registrar un nuevo cliente?</h6>
              <blockquote>
               1. Ingresar los siguientes datos en el espacio correspondiente:.<br>
                   <ol>
                  <li>- Nombre<br></li>                  
                  <li>- Tipo de cliente</li>
                  <li>- Telefono</li>
                  <li>- Dirreccion</li>                  
                </ol>                                             
              </blockquote>
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger" data-target="modal-cliente-registrar"><i class="material-icons left">add</i>Agregar Cliente</button>
              </p>
            </div>                         
            <!-- 1. Ventana modal para registrar nuevo cliente -->
            <div class="modal" id="modal-cliente-registrar">
              <div class="modal-content">
                <h4>Nuevo Cliente</h4>
                <p class="no-margin-padding-bottom">Registro al sistema de un nuevo cliente</p>

              </div>
              <form id="form-registrar-cliente" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 input-field margin-zero padding-zero">
                  <p class="grey-text no-margin-padding-top">No. Identidad o RTN para empresa(sin guiones)</p>
                  <input class="regexEntero validate" required id="cliente-txt-id" type="number" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Nombre</p>
                  <input class="validate" required id="cliente-txt-pnombre" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero" id="adm-tipo-cliente>
                  <p class="grey-text">Tipo de Cliente</p>
                  <select class="input-field visible" required id="cliente-txt-tipo">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Comerciante Individual</option>
                    <option value="2">Empresa</option>
                  </select>
                  <span class="helper-text" id="cliente-span-tipo"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" required id="cliente-txt-telefono" type="number" min="0" " ">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div> 
                <div class="col s12 m6 right-pad-input input-field margin-zero" id="adm-correo-cliente">
                  <p class="grey-text">Correo Electronico</p>
                  <input class="validate" required id="cliente-txt-correo" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div> 
                            
                <div class="col s12 input-field margin-zero padding-zero">
                  <p class="grey-text">Dirección</p>
                  <input class="validate" required id="cliente-txt-direccion" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-cliente">Guardar</button>
                <button class="waves-effect waves-red btn-flat"onclick="cerrarModal('form-registrar-cliente')">Cancelar</button>
              </div>
            </div>
            <!-- 2. Lista de clientes con opcion a editar-->
            <div class="row margin-zero">
              <div class="col s12">
                <h6 class="bold-text">Lista de clientes registrados</h6>
                <blockquote>Clientes registrados de <i>Finca E Inversiones GAMA</i>.</blockquote>
              </div>
              <!-- Ventana modal para editar cliente -->
              <div class="modal" id="modal-cliente-editar">
                <div class="modal-content">
                  <h4>Editar cliente <h5 id="adm-titulo-cliente-editar">RTN del cliente:</h5></h4>
                  <p class="no-margin-padding-bottom">Ingrese los nuevos datos.</p><p class="no-margin-padding-bottom"></p>
                </div>
                <form id="form-editar-cliente" class="modal-content no-margin-padding-top flex-div form-reset">
                  <div class="col s12 padding-zero">
                    <p class="grey-text no-margin-padding-top">Estado del cliente</p>
                    <p class="switch" id="div-estado-cliente"></p>
                  </div>
                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" required id="cliente-editar-telefono" type="number" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>                 
                  
                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Nombre de cliente</p>
                    <input class="regexAlfanumerico validate" required id="cliente-editar-username" type="text">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>

                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Correo Electronico:</p>
                    <input class="regexAlfanumerico validate" required id="cliente-editar-correo" type="text">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  
                  <div class="col s12 input-field margin-zero padding-zero">
                    <p class="grey-text">Tipo de cliente</p>
                    <select class="input-field visible validate" required id="cliente-editar-tipo">
                      <option value="" disabled="" selected="">Elegir</option>
                      <option value="1">Comerciante Individual</option>
                      <option value="2">Empresa</option>
                    </select>
                    <span class="helper-text" id="cliente-span-editar-tipo"></span>
                  </div>
                  <div class="col s12 input-field margin-zero padding-zero">
                    <p class="grey-text">Dirección</p>
                    <input class="validate" required id="cliente-editar-direccion" type="text">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="waves-effect waves-green btn-flat" id="btn-modal-editar-cliente" onclick="editarcliente('1')">Guardar</button>
                  <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-editar-cliente')">Cancelar</button>
                </div>
              </div>
            </div>
            <div class="col s12">
              <ul id="lista-clientes" class="collection">
                <li class="collection-item flex-div scroll-item grid-display">
                  <div class="flex-display">
                    <h6  style="width: 23.19px !important;height: 23.19px;" id="adm-estado-cliente0702197910028"></h6>
                    <h6 id="adm-nombre-cliente0702197910028">Dixy Flores Valladares</h6>
                  </div>
                  <div class="row">
                    <div class="col s12 salto-de-linea"> RTN: <span class="grey-text" id="adm-id-cliente0702197910028">070219791002822</span></div>
                    <div class="col s12 m6 salto-de-linea">Tipo de Cliente: <span id="adm-tipo-cliente0702197910028" class="grey-text">Comerciante Individual</span></div> 
                    <div class="col s12 m6 salto-de-linea">Teléfono: <span id="adm-telefono-cliente0702197910028" class="grey-text">9810-8800</span></div>
                    <div class="col s12 m6 salto-de-linea">Correo Electronico: <span id="adm-username-cliente0702197910028" class="grey-text">dixif24@gmail.com</span></div>                    
                    <div class="col s12 salto-de-linea ">Dirección: <span id="adm-direccion-cliente0702197910028" class="grey-text">Barrio La Playa, La Ceiba San Juan Puerto Rico </span></div><div class="col s12">
                    <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_clienteEditar('0702197910028')"><i class="material-icons left">edit</i>Editar</button></div>
                  </div>
                </li>
               <li class="collection-item flex-div scroll-item grid-display">
                  <div class="flex-display">
                    <h6  style="width: 23.19px !important;height: 23.19px;" id="adm-estado-cliente0702197910028"></h6>
                    <h6 id="adm-nombre-cliente0702197910028">HORTIFRUTI S.A</h6>
                  </div>
                  <div class="row">
                    <div class="col s12 salto-de-linea"> RTN: <span class="grey-text" id="adm-id-cliente0702197910028">08011979100282852</span></div>
                    <div class="col s12 m6 salto-de-linea">Tipo de Cliente: <span id="adm-tipo-cliente0702197910028" class="grey-text">Empresa</span></div> 
                    <div class="col s12 m6 salto-de-linea">Teléfono: <span id="adm-telefono-cliente0702197910028" class="grey-text">2235-1825</span></div>
                    <div class="col s12 m6 salto-de-linea">Correo Electronico: <span id="adm-username-cliente0702197910028" class="grey-text">hortifrutihonduras@hotmail.com</span></div>                  
                    <div class="col s12 salto-de-linea ">Dirección: <span id="adm-direccion-cliente0702197910028" class="grey-text">Col. La Cañada, Anillo Periferico parte Sur, al Par de Maquila Monzini , Tegucigalpa , Honduras </span></div><div class="col s12">
                    <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_clienteEditar('0702197910028')"><i class="material-icons left">edit</i>Editar</button></div>
                  </div>
                </li
              </ul>
            </div>
          </div>
          

        </div>
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
  <script src="js/controlador-cliente.js"></script>
  <script src="js/funciones-validacion.js"></script>
  <script src="js/common.js"></script>
  <div class="sidenav-overlay" style="display: none; opacity: 0;"></div>
  <div class="drag-target"></div>
</body>
</html>
