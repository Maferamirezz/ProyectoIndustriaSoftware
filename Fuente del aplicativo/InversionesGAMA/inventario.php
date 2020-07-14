<?php
  include("_seguridad.php");
  if ($_SESSION["gama_areatrabajo"] == "Ventas") {
    header("Location: ventas.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Inventario</title>
  <link href="img/logo.svg" rel="icon">
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/common.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/modulo.css" type="text/css" rel="stylesheet" media="screen,projection"/>
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
          <li><a class="waves-effect" href="inventario.php">Actualizar</a></li>
          <li><a class="waves-effect" href="_logout.php">Salir</a></li>
        </ul>
        <ul id="nav-mobile" class="sidenav" style="transform: translateX(-105%);">
          <?php
            if ($_SESSION["gama_areatrabajo"] == "Administración") {
              echo '<li><a class="waves-effect" href="panel.php">Atrás</a></li>';
            }
          ?>
          <li><a class="waves-effect" href="inventario.php">Actualizar</a></li>
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
            <h4 class="row center">Inventario</h4>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col s12 no-left-float">
            <ul class="tabs let-scroll">
              <li class="tab"><a href="#inv1">Insumos</a></li>
              <li class="tab"><a href="#inv2">Proveedores</a></li>
              <li class="tab"><a href="#inv3">Historial de ventas</a></li>
            </ul>
          </div>
          <!--REGISTRAR NUEVO INSUMO / EDITAR CANTIDAD INSUMO-->
          <div id="inv1" class="col s12">
            <br>
            <div class="justify-text col s12">
              <h5>INSUMOS</h5>
              <p>El inventario es una lista  de los elementos que componen el patrimonio de una empresa. Se considera como insumos
                la materia prima, equipo y mobiliario que permiten crear productos finales para la venta.</p>
            </div>
            <div class="col s12">
              <h6 class="bold-text">Registrar la adquisición de un nuevo insumo</h6>
              <blockquote>Ingrese un insumo que la empresa jamás había comprado ni registrado. La idea es sólo tener un catálogo para
                revisar la cantidad disponible de estos. Si registrará un insumo ya existente, hágalo si el proveedor es distinto
                (p.e. 50 unidades de Fertilizante del proveedor A, 50 unidades de Fertilizante del proveedor B).</blockquote>
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger" data-target="modal-insumo-registrar"><i class="material-icons left">add</i>Nuevo insumo</button>
              </p>
            </div>
            <!-- 1. Ventana modal para registrar nuevo insumo -->
            <div class="modal" id="modal-insumo-registrar">
              <div class="modal-content">
                <h4>Nueva compra de insumo</h4>
                <p class="no-margin-padding-bottom">Registrar por primera vez la compra de alguna materia prima</p>
              </div>
              <form id="form-registrar-insumo" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Nombre del insumo</p>
                  <input class="validate" required="" id="insumo-txt-nombre" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Fecha de compra</p>
                  <input class="validate" required="" id="insumo-txt-fecha" type="date">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Proveedor</p>
                  <select class="visible" required="" id="insumo-txt-proveedor">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Indufesa</option>
                    <option value="2">Plantas tropicales</option>
                    <option value="3">Bomohsa</option>
                  </select>
                  <span class="helper-text" id="insumo-span-proveedor"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Tipo de inventario</p>
                  <select class="visible" required="" id="insumo-txt-tipo">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Indufesa</option>
                    <option value="2">Plantas tropicales</option>
                    <option value="3">Bomohsa</option>
                  </select>
                  <span class="helper-text" id="insumo-span-tipo"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Cantidad</p>
                  <input class="regexEntero validate" pattern="[0-9]+" required="" id="insumo-txt-cantidad" type="number" min="0">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Precio unitario</p>
                  <input class="regexDecimal validate" pattern="[0-9]+[,|\.]?[0-9]+" required="" id="insumo-txt-precio" type="number" min="0" step="any">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-insumo">Guardar</button>
                <button class="waves-effect waves-red btn-flat"onclick="cerrarModal('form-registrar-insumo')">Cancelar</button>
              </div>
            </div>
            <!-- 2. Lista de insumos con opcion a editar cantidad y precio-->
            <div class="row margin-zero">
              <div class="col s12">
                <h6 class="bold-text">Lista de insumos registrados</h6>
                <blockquote>Aquí podrá visualizar los insumos que usa <i>Finca E Inversiones GAMA</i>. Si el precio o la cantidad
                  disponible de un insumo cambia se recomienda registrarlo en el sistema y garantizar que los datos estén al día.</blockquote>
              </div>
              <!-- Ventana modal para editar insumo -->
              <div class="modal" id="modal-insumo-editar">
                <div class="modal-content">
                  <h4>Editar insumo <h5 id="inv-titulo-insumo-editar">FERTILIZANTE 000AAA111</h5></h4>
                  <p class="no-margin-padding-bottom">Ingrese los nuevos datos. Si sólo cambia uno el otro permanece sin cambios.</p>
                </div>
                <form id="form-editar-insumo" class="modal-content no-margin-padding-top flex-div form-reset">
                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Cantidad</p>
                    <input class="regexEntero validate" pattern="[0-9]+" required id="insumo-editar-cantidad" type="number" min="0">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 left-pad-input input-field margin-zero">
                    <p class="grey-text">Precio unitario</p>
                    <input class="regexDecimal validate" pattern="[0-9]+[,|\.]?[0-9]+" required id="insumo-editar-precio" type="number" min="0" step="any">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="waves-effect waves-green btn-flat" id="btn-modal-editar-insumo" onclick="editarInsumo('1')">Guardar</button>
                  <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-editar-insumo')">Cancelar</button>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="card">
                  <div class="card-content">
                    <div class="card-title">
                      <img id="insumo_img0001" src="img/producto.jpg" alt="angel" class="circle inv-img">
                    </div>
                    <div id="insumo_nombre0001" class="card-title margin-zero">Jalapeño</div>
                    <div id="insumo_descripcion0001" class="grey-text">Lorem ipsum</div>
                    <hr>
                    <div class="green-text">Cantidad: <span id="insumo_cantidad0001">1520</span></div>
                    <div>Precio: <span id="insumo_precio0001" class="grey-text">Lps. 12.35</span></div>
                    <div>Tipo: <span id="insumo_tipo0001" class="grey-text">materia prima/bien de consumo</span></div>
                    <br>
                    <div class="center">
                      <button class="btn green-blue-gradient waves-effect modal-trigger" data-target="modal-insumo-editar" onclick="inv_editar(0001)"><i class="material-icons left">edit</i>Cantidad</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col s12">
              <ul class="collection" id="lista-insumos">
                <li class="collection-item avatar flex-div scroll-item grid-display">
                  <div>
                    <div class="col s12"><img src="img/producto2.jpg" alt="" class="circle"></div>
                    <div class="col s12 m6" style="font-weight: bold;" id="inv-producto-insumo000AAA111">Jalapeño</div>
                    <div class="col s12 m6" style="font-family: monospace;" id="inv-fecha-insumo000AAA111">05/04/2020 GTM-6 17:02:24</div>
                    <div class="grey-text col s12 m6">Cantidad: <span id="inv-cantidad-insumo000AAA111" class="bold-text green-text">9999</span></div>
                    <div class="grey-text col s12 m6">Precio: <span id="inv-precio-insumo000AAA111" class="black-text">Lps. 99.99</span></div>
                    <div class="grey-text col s12">Proveedor: <span class="black-text" id="inv-proveedor-insumo000AAA111">Granjas El Pollón</span></div>
                    <div class="grey-text col s12">Tipo: <span class="black-text" id="inv-tipo-insumo000AAA111">Bien de consumo</span></div>
                    <div class="grey-text col s12">Registrado por: <span class="black-text" id="inv-nombreEmpleado-insumo000AAA111">Luis Garcia Morales</span></div>
                    <div class="col s12">
                      <button class="modal-trigger link-style" onclick="abrirModal_insumoEditar('000AAA111')">Editar</button>
                    </div>
                  </div>
                </li>
                <li class="collection-item avatar flex-div scroll-item grid-display">
                  <div>
                    <div class="col s12"><img src="img/producto2.jpg" alt="" class="circle"></div>
                    <div class="col s12 m6" style="font-weight: bold;" id="inv-producto-insumo222EEE222">Jalapeño</div>
                    <div class="col s12 m6" style="font-family: monospace;" id="inv-fecha-insumo222EEE222">05/04/2020 GTM-6 17:02:24</div>
                    <div class="grey-text col s12 m6">Cantidad: <span id="inv-cantidad-insumo222EEE222" class="bold-text green-text">9999</span></div>
                    <div class="grey-text col s12 m6">Precio: <span id="inv-precio-insumo222EEE222" class="black-text">Lps. 99.99</span></div>
                    <div class="grey-text col s12">Proveedor: <span class="black-text" id="inv-proveedor-insumo222EEE222">Granjas El Pollón</span></div>
                    <div class="grey-text col s12">Tipo: <span class="black-text" id="inv-tipo-insumo222EEE222">Bien de consumo</span></div>
                    <div class="grey-text col s12">Registrado por: <span class="black-text" id="inv-nombreEmpleado-insumo222EEE222">Luis Garcia Morales</span></div>
                    <div class="col s12">
                      <button class="modal-trigger link-style" onclick="abrirModal_insumoEditar('222EEE222')">Editar</button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <!--REGISTRAR/EDITAR PROVEEDOR-->
          <div id="inv2" class="col s12">
            <br>
            <div class="justify-text col s12">
              <h5>PROVEEDORES</h5>
              <p>Encargados de surtir y distribuir determinados artículos que una empresa necesita para realizar su principal actividad de producción.</p>
            </div>
            <div class="col s12">
              <h6 class="bold-text">Registrar un nuevo proveedor de insumos</h6>
              <blockquote>
                Ingresar los datos de un nuevo proveedor de materias primas. Esta información será útil al momento de registrar e identificar un nuevo insumo.
              </blockquote>
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger" data-target="modal-proveedor-registrar"><i class="material-icons left">add</i>Nuevo proveedor</button>
              </p>
            </div>
            <!-- 1. Ventana modal para registrar nuevo proveedor -->
            <div class="modal" id="modal-proveedor-registrar">
              <div class="modal-content">
                <h4>Registrar nuevo proveedor</h4>
                <p class="no-margin-padding-bottom">Ingresar los datos de una persona o empresa que provee insumos</p>
              </div>
              <form id="form-registrar-proveedor" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">RTN (sin guiones)</p>
                  <input class="regexEntero validate" pattern="[0-9]+" required id="proveedor-txt-rtn" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Nombre</p>
                  <input class="validate" required id="proveedor-txt-nombre" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Tipo de proveedor</p>
                  <select id="proveedor-txt-tipo" required="" class="visible validate">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Persona</option>
                    <option value="2">Empresa</option>
                  </select>
                  <span class="helper-text" id="proveedor-span-tipo"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Dirección</p>
                  <input class="validate" id="proveedor-txt-direccion" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" pattern="[0-9]+" required id="proveedor-txt-telefono" type="tel">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Correo electrónico</p>
                  <input class="validate" pattern='(([^<>()%&[\]\.,;:\s@\"]+(\.[^<>()%&[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()%&[\]\.,;:\s@\"]+\.)+[^<>()%&[\]\.,;:\s@\"]{2,})' id="proveedor-txt-email" type="email">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-proveedor">Guardar</button>
                <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-registrar-proveedor')">Cancelar</button>
              </div>
            </div>
            <!-- 2. Lista de proveedores con opcion a editar datos-->
            <div class="row margin-zero">
              <div class="col s12">
                <h6 class="bold-text">Lista de proveedores registrados</h6>
                <blockquote>
                  Aquí podrá visualizar los proveedores de materias primas para <i>Finca E Inversiones GAMA</i>. De ser necesario,
                  el usuario autorizado podrá realizar cambios a la información de un proveedor.
                </blockquote>
              </div>
              <!-- Ventana modal para editar proveedor -->
              <div class="modal" id="modal-proveedor-editar">
                <div class="modal-content">
                  <h4>Editar proveedor <h5 id="inv-titulo-proveedor-editar">Benito Martínez</h5></h4>
                  <p class="no-margin-padding-bottom">Ingrese los nuevos datos. Si sólo cambia uno el otro permanece sin cambios.</p>
                </div>
                <form id="form-editar-proveedor" class="modal-content no-margin-padding-top flex-div form-reset">
                  <div class="col s12 padding-zero">
                    <p class="grey-text">Estado del proveedor</p>
                    <p class="switch" id="div-estado-proveedor"></p>
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <!-- <div class="col s12 input-field margin-zero padding-zero">
                    <p class="grey-text no-margin-padding-top">Nombre</p>
                    <input class="validate" required id="proveedor-editar-nombre" type="text">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Tipo de proveedor</p>
                    <select class="visible validate" id="proveedor-editar-tipo">
                      <option value="" disabled="" selected="">Elegir</option>
                      <option value="1">Persona</option>
                      <option value="2">Empresa</option>
                    </select>
                    <span class="helper-text" id="proveedor-span-editar-tipo"></span>
                  </div> -->
                  <div class="col s12 input-field padding-zero margin-zero">
                    <p class="grey-text">Dirección</p>
                    <input class="validate" id="proveedor-editar-direccion" type="text">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 right-pad-input input-field margin-zero">
                    <p class="grey-text">Teléfono</p>
                    <input class="regexEntero validate" pattern="[0-9]+" required id="proveedor-editar-telefono" type="tel">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                  <div class="col s12 m6 left-pad-input input-field margin-zero">
                    <p class="grey-text">Correo electrónico</p>
                    <input class="validate" pattern='(([^<>()%&[\]\.,;:\s@\"]+(\.[^<>()%&[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()%&[\]\.,;:\s@\"]+\.)+[^<>()%&[\]\.,;:\s@\"]{2,})' id="proveedor-editar-email" type="email">
                    <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="waves-effect waves-green btn-flat" id="btn-modal-editar-proveedor" onclick="editarProveedor('33')">Guardar</button>
                  <button class="waves-effect waves-red btn-flat" onclick="cerrarModal('form-editar-proveedor')">Cancelar</button>
                </div>
              </div>
            </div>
            <div class="col s12">
              <ul class="collection" id="lista-proveedores">
                <li class="collection-item avatar flex-div scroll-item grid-display">
                  <div>
                    <div class="col s12"><img src="img/producto2.jpg" alt="" class="circle"></div>
                    <div class="bold-text col s12 m6" id="inv-nombre-proveedor2556">Juanin Juan Jarris</div>
                    <div class="grey-text col s12 m6">RTN: <span id="inv-rtn-proveedor2556" class="black-text">2556</span></div>
                    <div class="grey-text col s12 m6">Estado: <span id="inv-estado-proveedor2556" class="bold-text red-text">INACTIVO</span></div>
                    <div class="grey-text col s12 m6">Tipo de proveedor: <span id="inv-tipo-proveedor2556" class="black-text">Persona</span></div>
                    <div class="grey-text col s12 m6">Teléfono: <span id="inv-telefono-proveedor2556" class="black-text">22020090</span></div>
                    <div class="grey-text col s12 m6">Correo electrónico: <span id="inv-email-proveedor2556" class="black-text">example@assa.adas</span></div>
                    <div class="grey-text col s12">Dirección: <span id="inv-direccion-proveedor2556" class="black-text">Avenida Gutenberg, dos cuadras adelante del hospital general</span></div>
                    <div class="col s12">
                      <button class="modal-trigger link-style" onclick="abrirModal_proveedorEditar('2556')">Editar</button>
                    </div>
                  </div>
                </li>
                <li class="collection-item avatar flex-div scroll-item grid-display">
                  <div>
                    <div class="col s12"><img src="img/producto2.jpg" alt="" class="circle"></div>
                    <div class="bold-text col s12 m6" id="inv-nombre-proveedor0702">Supermercado Lucía</div>
                    <div class="grey-text col s12 m6">RTN: <span id="inv-rtn-proveedor0702" class="black-text">0702</span></div>
                    <div class="grey-text col s12 m6">Estado: <span id="inv-estado-proveedor0702" class="bold-text red-text">INACTIVO</span></div>
                    <div class="grey-text col s12 m6">Tipo de proveedor: <span id="inv-tipo-proveedor0702" class="black-text">Empresa</span></div>
                    <div class="grey-text col s12 m6">Teléfono: <span id="inv-telefono-proveedor0702" class="black-text">33110000</span></div>
                    <div class="grey-text col s12 m6">Correo electrónico: <span id="inv-email-proveedor0702" class="black-text">ejemplo@dominio.com</span></div>
                    <div class="grey-text col s12">Dirección: <span id="inv-direccion-proveedor0702" class="black-text">Calle México, frente al edificio Azul</span></div>
                    <div class="col s12">
                      <button class="modal-trigger link-style" onclick="abrirModal_proveedorEditar('0702')">Editar</button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <!--HISTORIAL DE VENTAS-->
          <div id="inv3" class="col s12">
            <br>
            <div class="justify-text col s12">
              <h5>HISTORIAL DE VENTAS</h5>
              <p>Colección detallada de todos los comprobantes de venta que se han registrado en el sistema, ordenada cronológicamente del más reciente al más antiguo.</p>
            </div>
            <!-- Lista de facturas con opcion a descargar la respectiva información completa en formato PDF-->
            <div class="col s12">
              <ul class="collection" id="lista-facturas">
                <li class="collection-item flex-div scroll-item grid-display">
                  <div>
                    <div class="bold-text col s12 m6" id="inv-id-factura4567">Factura N. 20200505</div>
                    <div class="grey-text col s12 m6" style="font-family:monospace">Fecha: <span id="inv-fecha-factura4567" class="black-text">05/05/019</span></div>
                    <div class="grey-text col s12 m6">Total: <span id="inv-total-factura4567" class="black-text">Lps. 900</span></div>
                    <div class="col s12 m6">
                      <button class="link-style link-style-no-absolute padding-zero" onclick="descargarFactura('4567')">Ver más</button>
                    </div>
                  </div>
                </li>
                <li class="collection-item flex-div scroll-item grid-display">
                  <div>
                    <div class="bold-text col s12 m6" id="inv-id-factura9876">Factura N. 20200505</div>
                    <div class="grey-text col s12 m6" style="font-family:monospace">Fecha: <span id="inv-fecha-factura9876" class="black-text">05/05/019</span></div>
                    <div class="grey-text col s12 m6">Total: <span id="inv-total-factura9876" class="black-text">Lps. 900</span></div>
                    <div class="col s12 m6">
                      <button class="link-style link-style-no-absolute padding-zero" onclick="descargarFactura('9876')">Ver más</button>
                    </div>
                  </div>
                </li>
                <li class="collection-item flex-div scroll-item grid-display">
                  <div>
                    <div class="bold-text col s12 m6" id="inv-id-factura1230">Factura N. 20200505</div>
                    <div class="grey-text col s12 m6" style="font-family:monospace">Fecha: <span id="inv-fecha-factura1230" class="black-text">05/05/019</span></div>
                    <div class="grey-text col s12 m6">Total: <span id="inv-total-factura1230" class="black-text">Lps. 900</span></div>
                    <div class="col s12 m6">
                      <button class="link-style link-style-no-absolute padding-zero" onclick="descargarFactura('1230')">Ver más</button>
                    </div>
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
  <script src="js/controlador-inventario.js"></script>
  <script src="js/funciones-validacion.js"></script>
  <script src="js/common.js"></script>
  <div class="sidenav-overlay" style="display: none; opacity: 0;"></div>
  <div class="drag-target"></div>
</body>
</html>
