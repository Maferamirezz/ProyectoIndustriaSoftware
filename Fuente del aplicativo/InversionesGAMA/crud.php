<?php
  include("_seguridad.php");
  if ($_SESSION["gama_areatrabajo"] == "Inventario") {
    header("Location: inventario.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
  <title>CRUDS</title>
  <link href="img/logo.svg" rel="icon">
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="css/common.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="css/modulo.css" type="text/css" rel="stylesheet" media="screen,projection" />
</head>

<body>
  <div class="row margin-zero common-bg">
    <nav role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo valign-wrapper"><img
            src="img/logo.svg" id="nav-logo-svg"></a>
        <ul class="right hide-on-med-and-down">
          <?php
            if ($_SESSION["gama_areatrabajo"] == "Administración") {
              echo '<li><a class="waves-effect" href="panel.php">Atrás</a></li>';
            }
          ?>
          <li><a class="waves-effect" href="ventas.php">Actualizar</a></li>
          <li><a class="waves-effect" href="_logout.php">Salir</a></li>
        </ul>
        <ul id="nav-mobile" class="sidenav" style="transform: translateX(-105%);">
          <?php
            if ($_SESSION["gama_areatrabajo"] == "Administración") {
              echo '<li><a class="waves-effect" href="panel.php">Atrás</a></li>';
            }
          ?>
          <li><a class="waves-effect" href="ventas.php">Actualizar</a></li>
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
            <h4 class="row center">GESTIÓN DE DATOS</h4>
          </div>
        </div>
        <hr>
        <div class="row">
            <div class="col s12 no-left-float">
              <ul class="tabs let-scroll">
                <li class="tab"><a href="#inv1">PRODUCTOS</a></li>
                <!-- <li class="tab"><a href="#inv2">PROVEEDORES</a></li> -->
                <li class="tab"><a href="#inv2">CLIENTES</a></li>
              </ul>
            </div>
               <!-- Ventana modal confirmar eliminar un producto -->
              <div class="modal" id="modal-producto-eliminar">
                <div class="modal-content">
                  <h4>Eliminar producto.</h4>
                </div>
                <form id="form-eliminar-producto" class="modal-content no-margin-padding-top flex-div form-reset">
                  <div class="col s12 input-field padding-zero margin-zero">
                    <p class="grey-text">¿ESTA SEGURO QUE DESEA ELIMINAR EL PRODUCTO?</p>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="waves-effect waves-green btn-flat" id="btn-eliminar-producto">Aceptar</button>
                  <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-eliminar-producto')">Cancelar</button>
                </div>
              </div>            

          <!--REGISTRAR/EDITAR PRODUCTO-->
          <div id="inv1" class="col s12">
            <br>
            <div class="justify-text col s12">
              <!-- <h5>PRODUCTOS</h5> -->
            </div>
            <div class="col s12">
              <!-- <h6 class="bold-text">Registrar Producto</h6>              -->
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger"
                  data-target="modal-producto-registrar" 
                  id="btn-modal-nuevo-producto"><i
                    class="material-icons left">add</i>Nuevo producto</button>
              </p>
            </div>
            <!-- 1. Ventana modal para registrar nuevo producto -->
            <div class="modal" id="modal-producto-registrar">
              <div class="modal-content">
                <h4>Registrar Producto</h4>
                <p class="no-margin-padding-bottom">Ingresar los datos de un nuevo producto destinado a la venta</p>
              </div>
              <form id="form-registrar-producto" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Nombre Producto</p>
                  <input class="validate" required id="producto-txt-nombre" type="text" maxlength="25">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Cantidad Disponible</p>
                  <input class="validate regexEntero" required id="producto-txt-cantidad" type="number" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero margin-zero">
                  <p class="grey-text">Tipo de Producto</p>
                  <select class="visible" required="" id="producto-txt-tipo">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Fruta</option>
                    <option value="2">Verdura</option>
                    <option value="3">Legumbre</option>
                  </select>
                  <span class="helper-text" id="producto-span-tipo"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Precio costo</p>
                  <input class="validate regexDecimal" required id="producto-txt-precioCosto" type="number" step="any"
                    min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Descuento (%, 0 al 100)</p>
                  <input class="validate regexEntero" required id="producto-txt-descuento" type="number" min="0"
                    max="100">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero grey-text">Impuestos</div>
                <div class="col s12 m6 right-pad-input input-field">
                  <label class="display-contents" id="label-txt-impuesto15"></label>
                </div>
                <div class="col s12 m6 left-pad-input input-field">
                  <label class="display-contents" id="label-txt-impuesto18"></label>
                </div>

                <div class="col s12 input-field padding-zero ">
                  <p class="grey-text">Estado</p>
                  <select class="visible" required="" id="producto-txt-tipo">
                    <!-- <option value="" disabled="" selected="">Elegir</option> -->
                    <option value="1">Activo</option>
                    <!-- <option value="2">Inactivo</option> -->
                  </select>
                  <span class="helper-text" id="producto-span-tipo"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-producto">Guardar</button>
                <button class="waves-effect waves-red btn-flat"
                  onclick="cerrarModal('form-registrar-producto')">Cancelar</button>
              </div>
            </div>

            <!-- Ventana modal para editar producto -->
            <div class="modal" id="modal-producto-editarDatos">
            <div class="modal-content">
                  <h4>Editar producto <h5 id="inv-titulo-producto-editarDatos">Tomate</h5></h4>
                  <p class="no-margin-padding-bottom">Ingrese los nuevos datos. Si sólo cambia uno el resto permanece sin cambios.</p>
                </div>
                <form id="form-editarDatos-producto" class="modal-content no-margin-padding-top flex-div form-reset">
              
                 
                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Precio costo</p>
                    <input class="validate regexDecimal" required id="producto-editar-precioCosto" type="number" step="any" min="0">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 left-pad-input input-field margin-zero">
                    <p class="grey-text">Descuentos (porcentaje del 0 al 100)</p>
                    <input class="validate regexEntero" required id="producto-editar-descuento" type="number" min="0" max="100">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 input-field padding-zero margin-zero">
                    <p class="grey-text">Cantidad disponible</p>
                    <input class="validate regexEntero" required id="producto-editar-cantidad" type="number" min="0">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 padding-zero">
                    <p class="grey-text no-margin-padding-top">Estado del producto</p>
                    <p class="switch" id="div-estado-producto"></p>
                  </div>
                  <div class="col s12 input-field padding-zero grey-text">Impuestos</div>
                  <div class="col s12 m6 right-pad-input input-field">
                    <label class="display-contents" id="label-editar-impuesto15"></label>
                  </div>
                  <div class="col s12 m6 left-pad-input input-field">
                    <label class="display-contents" id="label-editar-impuesto18"></label>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="waves-effect waves-green btn-flat" id="btn-modal-editarDatos-producto" onclick="editarDatosProducto('33')">Guardar</button>
                  <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-editarDatos-producto')">Cancelar</button>
                </div>
              </div>
            <!-- 2. Lista de productos con opcion a editar datos-->
            <div class="row margin-zero">
              <div class="col s12">
                <blockquote>
                <h6 class="bold-text">Lista de productos registrados</h6>
              </blockquote>
                <!-- <blockquote>
                  Visualiza la lista de productos que <i>Finca E Inversiones GAMA</i> tiene a la venta. El usuario autorizado podrá efectuar cambios en la información de los elementos de esta lista.
                </blockquote> -->
              </div>

            </div>
            <div class="col s12">
              <div>
                <table class="responsive-table striped bordered" id="tabla-productos">
                  <thead>
                    <tr">
                      <th style="text-align: center;">ID</th>
                      <th style="text-align: center;">NOMBRE PRODUCTO</th>
                      <th style="text-align: center;">CANTIDAD DISPONIBLE</th>
                      <th style="text-align: center;">PRECIO COSTO </th>
                      <th style="text-align: center;">APLICA ISV 15%</th>
                      <th style="text-align: center;">APLICA ISV 18%</th>
                      <th style="text-align: center;">DESCUENTO (%)</th>
                      <th style="text-align: center;">PRECIO VENTA </th>
                      <th style="text-align: center;">TIPO PRODUCTO </th>
                      <th style="text-align: center;">ESTADO</th>
                      <th style="text-align: center;" colspan="2">OPCIONES</th>
                      </tr>
                  </thead>
                  <tbody id="tabla-producto-body">                  
                    <tr>
                      <td>1</td>
                      <td>MANZANAS</td>
                      <td>23</td>
                      <td>23</td>
                      <td>1</td>
                      <td>$0.87</td>
                      <td>1</td>
                      <td>10</td>
                      <td>90</td>
                      <td>ACTIVO</td>
                      <td>
                        <button class="modal-trigger waves-light  waves-effect" style="background-color:lightseagreen;"
                          onclick="abrirModal_productoEditarDatos ('1')">Editar</button>
                      </td>
                      <td>
                        <div><button class="modal-trigger waves-light  waves-effect" style="background-color:indianred;"
                             data-target="modal-producto-eliminar"   
                            onclick="abrirModal_productoEliminar('150')">Eliminar</button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!--REGISTRAR/EDITAR CLIENTE-->
          <div id="inv2" >
            <br>
            <div class="justify-text col s12"></div>
            <div class="col s12">
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger"
                  id="btn-modal-nuevo-cliente"><i class="material-icons left">add</i>Nuevo Cliente</button>
              </p>
            </div>

              <!-- Ventana modal confirmar eliminar un cliente -->
              <div class="modal" id="modal-cliente-eliminar">
                <div class="modal-content">
                  <h4>Eliminar Cliente.</h4>
                </div>
                <form id="form-eliminar-cliente" class="modal-content no-margin-padding-top flex-div form-reset">
                  <div class="col s12 input-field padding-zero margin-zero">
                    <p class="grey-text">¿ESTA SEGURO QUE DESEA ELIMINAR EL CLIENTE?</p>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="waves-effect waves-green btn-flat" id="btn-eliminar-cliente">Aceptar</button>
                  <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-eliminar-cliente')">Cancelar</button>
                </div>
              </div>
            
            <!-- 1. Ventana modal para registrar nuevo cliente -->
            <div class="modal" id="modal-cliente-registrar">
              <div class="modal-content">
                <h4>Registrar Nuevo Cliente</h4>
              </div>
              <form id="form-registrar-cliente" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Nombre</p>
                  <input class="validate" required id="cliente-txt-nombre" type="text"  maxlength="20">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Dirección</p>
                  <input class="validate" id="cliente-txt-direccion" type="text"  maxlength="150">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>                
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Tipo de Cliente</p>
                  <select id="cliente-txt-tipo" required="" class="visible validate">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Persona</option>
                    <option value="2">Empresa</option>
                  </select>
                  <span class="helper-text" id="cliente-span-tipo"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" pattern="[0-9]+" required id="cliente-txt-telefono" type="tel"
                    maxlength="20">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero ">
                  <p class="grey-text">Estado</p>
                  <select class="visible" required="" id="producto-txt-tipo">
                    <!-- <option value="" disabled="" selected="">Elegir</option> -->
                    <option value="1">Activo</option>
                    <!-- <option value="2">Inactivo</option> -->
                  </select>
                  <span class="helper-text" id="producto-span-tipo"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-guardar-cliente">Guardar</button>
                <button class="waves-effect waves-red btn-flat"
                  onclick="cerrarModal('form-registrar-cliente')">Cancelar</button>
              </div>
            </div>
            <!-- Ventana modal para editar proveedor -->
            <div class="modal" id="modal-cliente-editar">
              <div class="modal-content">
                <h4>Editar Cliente <h5 id="inv-titulo-proveedor-editar"></h5>
                </h4>
              </div>
              <form id="form-editar-cliente" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Nombre</p>
                  <input class="validate" required id="cliente-editar-nombre" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Dirección</p>
                  <input class="validate" id="cliente-editar-direccion" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>                
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Tipo de Cliente</p>
                  <select id="cliente-editar-tipo" required="" class="visible validate">
                    <!-- <option value="" disabled="" selected="">Elegir</option> -->
                    <option value="1">Natural</option>
                    <option value="2">Juridico</option>
                  </select>
                  <span class="helper-text" id="proveedor-span-tipo"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" pattern="[0-9]+" required id="cliente-editar-telefono" type="tel"
                    maxlength="20">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero ">
                  <p class="grey-text">Estado</p>
                  <select class="visible" required="" id="cliente-editar-estado">
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                  <span class="helper-text" id="producto-span-tipo"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-modal-editar-cliente"
                  onclick="editarDatosCliente('33')">Guardar</button>
                <button class="waves-effect waves-red btn-flat"
                  onclick="cerrarModal('form-editar-cliente')">Cancelar</button>
              </div>
            </div>

            <!-- 2. Lista de Clientes con opcion a editar datos-->
            <div class="row margin-zero">
              <div class="col s12">
                <blockquote>
                  <h6 class="bold-text">Lista de Clientes registrados</h6>
                </blockquote>
              </div>

            </div>
            <!-- Lista de Clientes  -->
            <div class="col s12">
              <div class="col s12">
                <div>
                  <table class="responsive-table striped bordered">
                    <thead>
                      <tr">
                        <th style="text-align: center;">NOMBRE</th>
                        <th style="text-align: center;">TIPO DE CLIENTE</th>
                        <th style="text-align: center;">DIRECCION</th>
                        <th style="text-align: center;">TELEFONO</th>
                        <th style="text-align: center;">ESTADO</th>
                        <th style="text-align: center;" colspan="2">OPCIONES</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-cliente-body">
                      <tr>
                        <td>CLIENTE 1</td>
                        <td>TIPO 1</td>
                        <td>Barrio La leona</td>
                        <td>2760090</td>
                        <td>ACTIVO</td>
                        <td>
                          <div><button class="modal-trigger waves-light  waves-effect"
                              style="background-color:lightseagreen;"
                              onclick="abrirModal_clienteEditar('1')">Editar</button>
                              </div>
                        </td>
                      <td>
                        <div><button class="modal-trigger waves-light  waves-effect" style="background-color:indianred;"
                             data-target="modal-cliente-eliminar"   
                            onclick="abrirModal_clienteEliminar('150')">Eliminar</button>
                        </div>
                      </td>
                      </tr>
                    </tbody>
                  </table>
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
   <!-- <script src="js/controlador-CRUD.js"></script> -->
  <script src="js/funciones-validacion.js"></script> 
  <!-- <script src="js/controlador-ventas.js"></script> -->
  <script src="js/common.js"></script> 
  <script src="js/common2.js"></script> 
  <div class="sidenav-overlay" style="display: none; opacity: 0;"></div>
  <div class="drag-target"></div>
</body>

</html>