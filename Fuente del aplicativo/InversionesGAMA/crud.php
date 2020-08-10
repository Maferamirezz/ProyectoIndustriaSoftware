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
              <li class="tab"><a href="#inv2">PROVEEDORES</a></li>
              <li class="tab"><a href="#inv3">CLIENTES</a></li>
            </ul>
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
                  data-target="modal-producto-registrar" onclick="abrirModal_productoRegistrar()"><i
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
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
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
                <h4>Editar Producto</h4>
                <!-- <p class="no-margin-padding-bottom">Ingresar los datos de un nuevo producto destinado a la venta</p> -->
              </div>
              <form id="form-editar-insumo" class="modal-content no-margin-padding-top flex-div form-reset">
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
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                  <span class="helper-text" id="producto-span-tipo"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-modal-editar-insumo"
                  onclick="editarInsumo('1')">Guardar</button>
                <button class="waves-effect waves-red btn-flat"
                  onclick="cerrarModal('form-editar-insumo')">Cancelar</button>
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
                <table class="responsive-table">
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
                  <tbody>
                    <?php foreach($emps as $key => $emp) :?>
                    <tr id="<?php echo $producto ['idproducto']; ?>">
                      <td><?php echo $prod ['idproducto']?> </td>
                      <td><?php echo $prod ['nombreproducto']?></td>
                      <td><?php echo $prod ['cantidaddisponible']?></td>
                      <td><?php echo $prod ['preciocosto']?></td>
                      <td><?php echo $liprodbro ['impuesto15']?></td>
                      <td><?php echo $prod ['impuesto18']?></td>
                      <td><?php echo $prod ['descuento']?></td>
                      <td><?php echo $prod ['precioventa']?></td>
                      <td><?php echo $prod ['estado']?></td>
                      <td><?php echo $prod ['tipoproducto_idtipoproducto']?></td>
                      <td>
                        <div>
                          <button class="modal-trigge waves-light  waves-effect" style="background-color:lightseagreen;"
                            onclick="abrirModal_producto_Editar('1')">Editar</button>
                        </div>
                      </td>
                      <td>
                        <div><button class="modal-trigge waves-light  waves-effect" style="background-color:indianred;"
                            onclick="javascript:return confirm('¿Seguro de eliminar este registro?');">Eliminar</button>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach;?>

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
                            onclick="javascript:return confirm('¿Seguro de eliminar este registro?');">Eliminar</button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- <ul class="collection" id="lista-productos">
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
              </ul> -->
            </div>
          </div>

          <!--REGISTRAR/EDITAR PROVEEDOR-->
          <div id="inv2" class="col s12">
            <br>
            <div class="justify-text col s12">
            </div>
            <div class="col s12">
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger"
                  data-target="modal-proveedor-registrar"><i class="material-icons left">add</i>Nuevo proveedor</button>
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
                  <input class="regexEntero validate" pattern="[0-9]+" required id="proveedor-txt-telefono" type="tel"
                    maxlength="20">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Correo electrónico</p>
                  <input class="validate"
                    pattern='(([^<>()%&[\]\.,;:\s@\"]+(\.[^<>()%&[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()%&[\]\.,;:\s@\"]+\.)+[^<>()%&[\]\.,;:\s@\"]{2,})'
                    id="proveedor-txt-email" type="email">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero ">
                  <p class="grey-text">Estado</p>
                  <select class="visible" required="" id="producto-txt-tipo">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                  <span class="helper-text" id="producto-span-tipo"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-proveedor">Guardar</button>
                <button class="waves-effect waves-red btn-flat"
                  onclick="cerrarModal('form-registrar-proveedor')">Cancelar</button>
              </div>
            </div>
            <!-- Ventana modal para editar proveedor -->
            <div class="modal" id="modal-proveedor-editar">
              <div class="modal-content">
                <h4>Editar Poveedor <h5 id="inv-titulo-proveedor-editar"></h5>
                </h4>
              </div>
              <form id="form-editar-proveedor" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 padding-zero">
                  <p class="grey-text">Estado</p>
                  <p class="switch" id="div-estado-proveedor"></p>
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero margin-zero">
                  <p class="grey-text">Dirección</p>
                  <input class="validate" id="proveedor-editar-direccion" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" pattern="[0-9]+" required id="proveedor-editar-telefono"
                    type="tel">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Correo electrónico</p>
                  <input class="validate"
                    pattern='(([^<>()%&[\]\.,;:\s@\"]+(\.[^<>()%&[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()%&[\]\.,;:\s@\"]+\.)+[^<>()%&[\]\.,;:\s@\"]{2,})'
                    id="proveedor-editar-email" type="email">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 im6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Estado</p>
                  <select class="visible" required="" id="producto-txt-tipo">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                  <span class="helper-text" id="producto-span-tipo"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-modal-editar-proveedor"
                  onclick="editarProveedor('33')">Guardar</button>
                <button class="waves-effect waves-red btn-flat"
                  onclick="cerrarModal('form-editar-proveedor')">Cancelar</button>
              </div>
            </div>

            <!-- 2. Lista de proveedores con opcion a editar datos-->
            <div class="row margin-zero">
              <div class="col s12">
                <blockquote>
                  <h6 class="bold-text">Lista de proveedores registrados</h6>
                </blockquote>
              </div>

            </div>
            <!-- Lista de Proveedores  -->
            <div class="col s12">
              <div class="col s12">
                <div>
                  <table class="responsive-table">
                    <thead>
                      <tr">
                        <th style="text-align: center;">RTN</th>
                        <th style="text-align: center;">NOMBRE</th>
                        <th style="text-align: center;">TIPO DE PROVEEDOR</th>
                        <th style="text-align: center;">DIRECCION</th>
                        <th style="text-align: center;">TELEFONO</th>
                        <th style="text-align: center;">CORREO</th>
                        <th style="text-align: center;">ESTADO</th>
                        <th style="text-align: center;" colspan="2">OPCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($emps as $key => $emp) :?>
                      <tr id="<?php echo $producto ['idproducto']; ?>">
                        <td><?php echo $prod ['rtnproveedor']?> </td>
                        <td><?php echo $prod ['nombreproveedor']?></td>
                        <td><?php echo $prod ['tipoproveedor_idtipoproveedor']?></td>
                        <td><?php echo $prod ['direccion']?></td>
                        <td><?php echo $prod ['email']?></td>
                        <td><?php echo $liprodbro ['telefono']?></td>
                        <td><?php echo $prod ['estado']?></td>
                        <td>
                          <div><button class="modal-trigger waves-light  waves-effect"
                              style="background-color:lightseagreen;"
                              onclick="abrirModal_proveedorEditar('1')">Editar</button></div>
                        </td>
                        <td>
                          <div><button class="waves-light waves-effect" style="background-color:indianred;"
                              onclick="javascript:return confirm('¿Seguro de eliminar este registro?');">Eliminar</button>
                          </div>
                        </td>
                      </tr>
                      <?php endforeach;?>

                      <tr>
                        <td>0801199000034</td>
                        <td>Supermercados La Colonia</td>
                        <td>Principal</td>
                        <td>Barrio La leona</td>
                        <td>2760090</td>
                        <td>correo@gmail.com</td>
                        <td>ACTIVO</td>
                        <td>
                          <div><button class="modal-trigger waves-light  waves-effect"
                              style="background-color:lightseagreen;"
                              onclick="abrirModal_proveedorEditar('1')">Editar</button></div>
                        </td>
                        <td>
                          <div><button class="waves-light waves-effect" style="background-color:indianred;"
                              onclick="javascript:return confirm('¿Seguro de eliminar este registro?');">Eliminar</button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!--REGISTRAR/EDITAR CLIENTE-->
          <div id="inv3" class="col s12">
            <br>
            <div class="justify-text col s12">
            </div>
            <div class="col s12">
              <p>
                <button class="btn purple-orange-gradient waves-effect modal-trigger"
                  data-target="modal-cliente-registrar"><i class="material-icons left">add</i>Nuevo proveedor</button>
              </p>
            </div>
            <!-- 1. Ventana modal para registrar nuevo cliente -->
            <div class="modal" id="modal-cliente-registrar">
              <div class="modal-content">
                <h4>Registrar Nuevo Cliente</h4>
              </div>
              <form id="form-registrar-cliente" class="modal-content no-margin-padding-top flex-div form-reset">
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Nombre</p>
                  <input class="validate" required id="proveedor-txt-nombre" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Dirección</p>
                  <input class="validate" id="proveedor-txt-direccion" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>                
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Tipo de Cliente</p>
                  <select id="proveedor-txt-tipo" required="" class="visible validate">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Persona</option>
                    <option value="2">Empresa</option>
                  </select>
                  <span class="helper-text" id="proveedor-span-tipo"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" pattern="[0-9]+" required id="proveedor-txt-telefono" type="tel"
                    maxlength="20">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero ">
                  <p class="grey-text">Estado</p>
                  <select class="visible" required="" id="producto-txt-tipo">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
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
                  <input class="validate" required id="proveedor-txt-nombre" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 m6 left-pad-input input-field margin-zero">
                  <p class="grey-text">Dirección</p>
                  <input class="validate" id="proveedor-txt-direccion" type="text">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>                
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Tipo de Cliente</p>
                  <select id="proveedor-txt-tipo" required="" class="visible validate">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Principal</option>
                    <option value="2">Secundario</option>
                  </select>
                  <span class="helper-text" id="proveedor-span-tipo"></span>
                </div>
                <div class="col s12 m6 right-pad-input input-field margin-zero">
                  <p class="grey-text">Teléfono</p>
                  <input class="regexEntero validate" pattern="[0-9]+" required id="proveedor-txt-telefono" type="tel"
                    maxlength="20">
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <div class="col s12 input-field padding-zero ">
                  <p class="grey-text">Estado</p>
                  <select class="visible" required="" id="producto-txt-tipo">
                    <option value="" disabled="" selected="">Elegir</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                  <span class="helper-text" id="producto-span-tipo"></span>
                </div>
              </form>
              <div class="modal-footer">
                <button class="waves-effect waves-green btn-flat" id="btn-modal-editar-cliente"
                  onclick="editarCliente('33')">Guardar</button>
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
                  <table class="responsive-table">
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
                    <tbody>
                      <?php foreach($clients as $key => $cliente) :?>
                      <tr id="<?php echo $producto ['idproducto']; ?>">
                        <td><?php echo $cliente ['nombrecliente']?> </td>
                        <td><?php echo $cliente ['tipocliente_idtipocliente   ']?></td>
                        <td><?php echo $cliente ['direccion']?></td>
                        <td><?php echo $cliente ['telefono']?></td>
                        <td><?php echo $cliente ['estado']?></td>
                        <td>
                          <div><button class="modal-trigger waves-light  waves-effect"
                              style="background-color:lightseagreen;"
                              onclick="abrirModal_clienteEditar('1')">Editar</button></div>
                        </td>
                        <td>
                          <div><button class="waves-light waves-effect" style="background-color:indianred;"
                              onclick="javascript:return confirm('¿Seguro de eliminar este registro?');">Eliminar</button>
                          </div>
                        </td>
                      </tr>
                      <?php endforeach;?>

                      <tr>
                        <td>CLIENTE 1</td>
                        <td>TIPO 1</td>
                        <td>Barrio La leona</td>
                        <td>2760090</td>
                        <td>ACTIVO</td>
                        <td>
                          <div><button class="modal-trigger waves-light  waves-effect"
                              style="background-color:lightseagreen;"
                              onclick="abrirModal_clienteEditar('1')">Editar</button></div>
                        </td>
                        <td>
                          <div><button class="waves-light waves-effect" style="background-color:indianred;"
                              onclick="javascript:return confirm('¿Seguro de eliminar este registro?');">Eliminar</button>
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
  <script src="js/funciones-validacion.js"></script>
  <script src="js/controlador-CRUD.js"></script>
  <script src="js/controlador-ventas.js"></script>
  <script src="js/common.js"></script>
  <div class="sidenav-overlay" style="display: none; opacity: 0;"></div>
  <div class="drag-target"></div>
</body>

</html>