<?php
  include("_seguridad.php");
  if ($_SESSION["gama_areatrabajo"] == "Inventario") {
    header("Location: inventario.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Ventas</title>
  <link href="img/logo.svg" rel="icon">
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/common.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/modulo.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/ventas.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <div class="row margin-zero common-bg">
    <nav role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo valign-wrapper"><img src="img/logo.svg" id="nav-logo-svg"></a>
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
            <h4 class="row center">VENTAS</h4>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col s12 no-left-float">
            <ul class="tabs let-scroll">
              <li class="tab"><a href="#inv1">Nueva factura</a></li>
              <li class="tab"><a href="#inv2">Productos</a></li>
              <li class="tab"><a href="#inv3">Clientes</a></li>
            </ul>
          </div>
          <!--REGISTRAR NUEVA FACTURA-->
          <div id="inv1" class="col s12">
            <br>
            <div class="justify-text col s12">
              <h5>FACTURA</h5>
              <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Reiciendis, sed.</p>
            </div>
            <div class="col s12">
              <h6 class="bold-text">¿Cómo registrar una nueva venta?</h6>
              <blockquote>
                <b>1.</b> Ingresar los datos de la factura (ID, cliente, fecha).<br>
                <b>2.</b> Dar click al botón <i>"Nuevo item"</i> para ingresar un producto a la factura.<br>
                <b>3.</b> Si no hay más ventas que agregar, es decir se ha completado la factura, dar click al botón <i>"Registrar factura"</i>.
              </blockquote>
            </div>
            <div class="col s12">
              <h6 class="bold-text">Condiciones</h6>
              <blockquote>
                <b>•</b> El único formato válido para el ID factura es de la siguiente forma: 000-000-00-0000000. Se debe escribir así tal cual está, incluyendo los guiones.<br>
                <b>•</b> Solamente puede borrar el ÚLTIMO elemento que ha agregado, para ello dar click al botón <i>"Borrar item"</i>.
              </blockquote>
            </div>
            <div class="col s12">
              <h6>1. Datos de la factura</h6>
              <form id="form-header-factura" class="row no-margin-padding-bottom">
                <div class="col s12 m6 l4 input-field margin-zero">
                  <p class="grey-text">ID factura</p>
                  <input class="validate" required="" id="factura-txt-id" type="text" pattern="[\d]{3}-[\d]{3}-[\d]{2}-[\d]{8}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null: event.charCode >= 48 && event.charCode <= 57 || event.charCode == 45">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 l4 input-field margin-zero">
                  <p class="grey-text">Cliente</p>
                  <select class="visible" required="" id="factura-txt-cliente">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="U8R48Q39">Juan Carlos Bodoque</option>
                    <option value="544W12SD">Tío Pelado</option>
                    <option value="WRE879UT">Calcetín con rombos man</option>
                  </select>
                  <span class="helper-text" id="factura-span-cliente"></span>
                </div>
                <div class="col s12 m6 l4 input-field margin-zero">
                  <p class="grey-text">Fecha</p>
                  <input class="validate" required="" id="factura-txt-fecha" type="date">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
              </form>
            </div>
            <div class="col s12">
              <div class="row no-margin-padding-bottom">
                <h6 class="col s12">2. Ingresar un producto a la factura</h6>
              </div>
              <div class="row no-margin-padding-bottom">
                <p class="col s12 m6">
                    <button class="btn green-blue-gradient waves-effect modal-trigger" id="btn-nuevo-item"><i class="material-icons left">add</i>Nuevo item</button>
                </p>
                <p class="col s12 m6">
                    <button class="btn green-blue-gradient waves-effect right" id="btn-borrar-item"><i class="material-icons left">delete</i>Borrar último item</button>
                </p>
              </div>
            </div>
            <!-- 1. Ventana modal para registrar nuevo item en la factura -->
            <div class="modal" id="modal-factura-registrar" tabindex="0" style="z-index: 1003; display: none; opacity: 0; top: 4%; transform: scaleX(0.8) scaleY(0.8);">
              <div class="modal-content">
                <h4>Añadir nuevo item a la factura</h4>
                <p class="no-margin-padding-bottom">Seleccione los datos del producto vendido</p>
              </div>
              <form id="form-registrar-item" class="modal-content no-margin-padding-top flex-div">
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Producto</p>
                  <select class="visible" required="" id="factura-txt-producto">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Item 1</option>
                    <option value="2">Item 2</option>
                    <option value="3">Item 3</option>
                  </select>
                  <span class="helper-text" id="factura-span-producto"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Cantidad</p>
                  <select class="visible" required="" id="factura-txt-cantidad" disabled="true">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                  <span class="helper-text" id="factura-span-cantidad"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-item">Guardar</button>
                <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-registrar-item')">Cancelar</button>
              </div>
            </div>
            <!-- Lista de items agregados a la factura -->
            <div class="col s12">
              <div class="flex-div scroll-item">
                <table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Descripción</th>
                      <th>Precio unitario</th>
                      <th>Cantidad</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody id="lista-items">
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="right">
                <table class="table-without-border">
                  <tbody>
                    <tr>
                      <td class="bold-text">SUBTOTAL</td><td id="vnt-subtotal-factura">Lps. 0.00</td>
                    </tr>
                    <tr>
                      <td class="bold-text">IMPORTE EXENTO</td><td id="vnt-totalExento-factura">Lps. 0.00</td>
                    </tr>
                    <tr>
                      <td class="bold-text">IMPORTE GRAVADO 15%</td><td id="vnt-gravado15-factura">Lps. 0.00</td>
                    </tr>
                    <tr>
                      <td class="bold-text">IMPORTE GRAVADO 18%</td><td id="vnt-gravado18-factura">Lps. 0.00</td>
                    </tr>
                    <tr>
                      <td class="bold-text">ISV 15%</td><td id="vnt-totalImpuesto15-factura">Lps. 0.00</td>
                    </tr>
                    <tr>
                        <td class="bold-text">ISV 18%</td><td id="vnt-totalImpuesto18-factura">Lps. 0.00</td>
                    </tr>
                    <tr>
                        <td class="bold-text">DESCUENTOS Y REBAJAS</td><td id="vnt-totalDescuento-factura">Lps. 0.00</td>
                    </tr>
                    <tr>
                        <td class="bold-text">TOTAL</td><td id="vnt-total-factura">Lps. 0.00</td>
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>
            <div class="col s12">
              <h6>3. Registrar factura</h6>
              <div class="row no-margin-padding-bottom">
                <p class="col s12 m6">
                    <button class="btn purple-orange-gradient waves-effect" id="btn-factura"><i class="material-icons left">save</i>Registrar factura</button>
                </p>
                <p class="col s12 m6">
                    <button class="btn purple-orange-gradient waves-effect right" id="btn-reset-factura"><i class="material-icons left">refresh</i>Reset formulario</button>
                </p>
              </div>
            </div>
          </div>
          <!--REGISTRAR/EDITAR PRODUCTO-->
          <div id="inv2" class="col s12">
            <br>
            <div class="justify-text col s12">
              <h5>PRODUCTOS</h5>
              <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil, fugiat. Qui deleniti dolore repellat. Numquam.</p>
            </div>
            <div class="col s12">
              <h6 class="bold-text">Registrar un nuevo producto</h6>
              <blockquote>
                Agrega un producto al catálogo de ventas ingresando sus datos. El estado de cada nuevo producto se guarda como <span>DISPONIBLE</span>, así que puedes registrar su venta en una factura.
              </blockquote>
              <h6 class="bold-text">Condiciones</h6>
              <blockquote>
                <b>•</b> Marca las casillas de los impuestos a aplicar, asimismo ingresa el porcentaje (%) del descuento a aplicar (un número del 1 al 100, 0 si no tendrá descuento).<br>
                <b>•</b> Los productos con estado <span class="red-text">INACTIVO</span> no pueden incluirse en las facturas.<br>
                <b>•</b> Si la cantidad disponible de un producto cambia a cero (0) su estado pasa a <span class="red-text">INACTIVO</span>.<br>
                <b>•</b> Aunque la cantidad disponible de un producto cambie a cualquier número mayor que cero (0), es necesario cambiar manualmente su estado. Click al botón <i>Editar datos</i>.
              </blockquote>
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger" data-target="modal-producto-registrar" onclick="abrirModal_productoRegistrar()"><i class="material-icons left">add</i>Nuevo producto</button>
              </p>
            </div>
            <!-- 1. Ventana modal para registrar nuevo producto -->
            <div class="modal" id="modal-producto-registrar">
              <div class="modal-content">
                <h4>Registrar nuevo producto</h4>
                <p class="no-margin-padding-bottom">Ingresar los datos de un nuevo producto destinado a la venta</p>
              </div>
              <form id="form-registrar-producto" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Nombre del producto</p>
                  <input class="validate" required id="producto-txt-nombre" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Cantidad disponible</p>
                  <input class="validate regexEntero" required id="producto-txt-cantidad" type="number" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero margin-zero">
                  <p class="grey-text">Tipo de producto</p>
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
                  <input class="validate regexDecimal" required id="producto-txt-precioCosto" type="number" step="any" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Descuentos (porcentaje del 0 al 100)</p>
                  <input class="validate regexEntero" required id="producto-txt-descuento" type="number" min="0" max="100">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero grey-text">Impuestos</div>
                <div class="col s12 m6 right-pad-input input-field">
                  <label class="display-contents" id="label-txt-impuesto15"></label>
                </div>
                <div class="col s12 m6 left-pad-input input-field">
                  <label class="display-contents" id="label-txt-impuesto18"></label>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-producto">Guardar</button>
                <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-registrar-producto')">Cancelar</button>
              </div>
            </div>
            <!-- 2. Lista de productos con opcion a editar datos-->
            <div class="row margin-zero">
              <div class="col s12">
                <h6 class="bold-text">Lista de productos registrados</h6>
                <blockquote>
                  Visualiza la lista de productos que <i>Finca E Inversiones GAMA</i> tiene a la venta. El usuario autorizado podrá efectuar cambios en la información de los elementos de esta lista.
                </blockquote>
              </div>
              <!-- Ventana modal para editar DATOS del producto -->
              <div class="modal" id="modal-producto-editarDatos">
                <div class="modal-content">
                  <h4>Editar producto <h5 id="inv-titulo-producto-editarDatos">Tomate</h5></h4>
                  <p class="no-margin-padding-bottom">Ingrese los nuevos datos. Si sólo cambia uno el resto permanece sin cambios.</p>
                </div>
                <form id="form-editarDatos-producto" class="modal-content no-margin-padding-top flex-div form-reset">
                  <div class="col s12 padding-zero">
                    <p class="grey-text no-margin-padding-top">Estado del producto</p>
                    <p class="switch" id="div-estado-producto"></p>
                  </div>
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
              <!-- Ventana modal para editar CANTIDAD disponible del producto -->
              <div class="modal" id="modal-producto-editarCantidad">
                <div class="modal-content">
                  <h4>Editar producto <h5 id="inv-titulo-producto-editarCantidad">Benito Martínez</h5></h4>
                  <p class="no-margin-padding-bottom">Ingrese los nuevos datos. Si sólo cambia uno el resto permanece sin cambios.</p>
                </div>
                <form id="form-editarCantidad-producto" class="modal-content no-margin-padding-top flex-div form-reset">
                  <div class="col s12 input-field padding-zero margin-zero">
                    <p class="grey-text">Cantidad disponible</p>
                    <input class="validate regexEntero" required id="producto-editar-cantidad" type="number" min="0">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="waves-effect waves-green btn-flat" id="btn-modal-editarCantidad-producto" onclick="editarCantidadProducto('33')">Guardar</button>
                  <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-editarCantidad-producto')">Cancelar</button>
                </div>
              </div>
            </div>
            <!-- Lista de productos -->
            <div class="col s12">
              <ul class="collection" id="lista-productos">
                <li class="collection-item avatar flex-div scroll-item grid-display">
                  <div>
                    <div class="col s12"><img src="img/producto2.jpg" alt="" class="circle"></div>
                    <div class="bold-text col s12 m6" id="vnt-nombre-producto13524">Zacate de limon</div>
                    <div class="grey-text col s12 m6">Tipo de producto: <span id="vnt-tipo-producto13524" class="black-text">Hierba</span></div>
                    <div class="grey-text col s12 m6">Estado: <span id="vnt-estado-producto13524" class="bold-text green-text">ACTIVO</span></div>  
                    <div class="grey-text col s12 m6">Cantidad disponible: <span id="vnt-cantidad-producto13524" class="black-text green-text">255 </span></div>
                    <div class="grey-text col s12 m6">Precio costo: <span id="vnt-precioCosto-producto13524" class="black-text">Lps. 45.47</span></div>
                    <div class="grey-text col s12 m6">15% ISV: <span id="vnt-impuesto15-producto13524" class="black-text">Lps. 6.82</span></div>
                    <div class="grey-text col s12 m6">18% ISV: <span id="vnt-impuesto18-producto13524" class="black-text">Lps. 0</span></div>
                    <div class="grey-text col s12 m6">Descuento: <span id="vnt-descuento-producto13524" class="black-text">Lps. 36.61</span></div>
                    <div class="grey-text col s12 m6">Precio venta: <span id="vnt-precioVenta-producto13524" class="black-text">Lps. 15.68</span></div>
                    <div class="col s12">
                      <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_productoEditarDatos('13524')">Editar datos</button>
                    </div>
                    <div class="col s12">
                      <button class="modal-trigger link-style link-style-no-absolute" onclick="abrirModal_productoEditarCantidad('13524')">Editar cantidad disponible</button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <!--CLIENTES-->
          <div id="inv3" class="col s12">
            <br>
            <div class="justify-text col s12">
              <h5>CLIENTES</h5>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab rerum at repudiandae veniam praesentium commodi!</p>
            </div>
            <!-- Lista de facturas con opcion a descargar la respectiva información completa en formato PDF-->
            <div class="col s12">
              <ul class="collection" id="lista-logs">
                <li class="collection-item flex-div">
                    <div class="bold-text col s12" id="adm-nombre-log1">Walter Samuel Rivera Ham</div>
                    <div class="grey-text col s12 m6 salto-de-linea">Nombre de usuario: <span id="adm-username-log1" class="black-text" style="font-family: monospace;">LiderShino2556</span></div>
                    <div class="grey-text col s12 m6">Último inicio de sesión: <span id="adm-fechaSesion-log1" class="black-text" style="font-family: monospace;">12/05/19 GTM-6 02:00PM</span></div>
                </li>
                <li class="collection-item flex-div">
                    <div class="bold-text col s12" id="adm-nombre-log2">Walter Samuel Rivera Ham</div>
                    <div class="grey-text col s12 m6">Nombre de usuario: <span id="adm-username-log2" class="black-text" style="font-family: monospace;">LiderShino2556</span></div>
                    <div class="grey-text col s12 m6">Último inicio de sesión: <span id="adm-fechaSesion-log2" class="black-text" style="font-family: monospace;">12/05/19 GTM-6 04:27PM</span></div>
                </li>
                <li class="collection-item flex-div">
                  <div class="bold-text col s12" id="adm-nombre-log31">Walter Samuel Rivera Ham</div>
                  <div class="grey-text col s12 m6">Nombre de usuario: <span id="adm-username-log3" class="black-text" style="font-family: monospace;">LiderShino2556</span></div>
                  <div class="grey-text col s12 m6">Úlltimo inicio de sesión: <span id="adm-fechaSesion-log3" class="black-text" style="font-family: monospace;">12/05/19 GTM-6 06:30PM</span></div>
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
  <script src="js/controlador-ventas.js"></script>
  <script src="js/funciones-validacion.js"></script>
  <script src="js/common.js"></script>
  <div class="sidenav-overlay" style="display: none; opacity: 0;"></div>
  <div class="drag-target"></div>
</body>
</html>
