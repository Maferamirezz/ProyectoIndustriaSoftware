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
  <title>Panel principal</title>
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
          <li><a class="waves-effect" href="panel.php">Actualizar</a></li>
          <li><a class="waves-effect" href="_logout.php">Salir</a></li>
        </ul>

        <ul id="nav-mobile" class="sidenav" style="transform: translateX(-105%);">
          <li><a class="waves-effect" href="panel.php">Actualizar</a></li>
          <li><a class="waves-effect" href="_logout.php">Salir</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>
    </nav>
    <div class="container principal-container s12">
      <div class="col s10 white z-depth-5 principal-div" style="margin: 2em">
        <div class="row margin-zero">
          <div class="col s12 center">
            <img src="img/logo.svg" id="logo-svg">
            <h5 class="margin-zero gama-title">Finca E Inversiones GAMA</h5>
            <h4 class="row center">Menú Principal</h4>
          </div>
        </div>
        <div class="flex-div principal-container">
          <div class="row principal-panel col s12 m7 l7">
            <div class="row">
              <ul class="collapsible popout">
                <li>
                  <div class="collapsible-header" tabindex="0">
                    <i class="material-icons">place</i>
                    <h6>Ventas</h6>
                  </div>
                  <div class="collapsible-body">
                    <p>Gestión de salidas</p>
                    <br>
                    <center>
                      <div class="row">
                        <a href="ventas.html#ven1" class="btn btn-large col s12 waves-effect purple-orange-gradient">Nueva factura</a>
                      </div>
                    </center>
                    <br>
                    <center>
                      <div class="row">
                        <a href="ventas.html#ven2" class="btn btn-large col s12 waves-effect purple-orange-gradient">Clientes</a>
                      </div>
                    </center>
                    <br>
                    <center>
                      <div class="row">
                        <a href="ventas.html#ven3" class="btn btn-large col s12 waves-effect purple-orange-gradient">Productos</a>
                      </div>
                    </center>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header" tabindex="0">
                    <i class="material-icons">filter_drama</i>
                    <h6>Inventario</h6>
                  </div>
                  <div class="collapsible-body">
                    <p>Historial de ventas y gestión de entradas</p>
                    <br>
                    <center>
                      <div class="row">
                        <a href="inventario.html#inv1" class="btn btn-large col s12 waves-effect purple-orange-gradient">Insumo</a>
                      </div>
                    </center>
                    <br>
                    <center>
                      <div class="row">
                        <a href="inventario.html#inv2" class="btn btn-large col s12 waves-effect purple-orange-gradient">Proveedor</a>
                      </div>
                    </center>
                    <br>
                    <center>
                      <div class="row">
                        <a href="inventario.html#inv3" class="btn btn-large col s12 waves-effect purple-orange-gradient">Historial de ventas</a>
                      </div>
                    </center>
                  </div>
                </li>
                <li>
                  <div class="collapsible-header" tabindex="0">
                    <i class="material-icons">place</i>
                    <h6>Administración</h6>
                  </div>
                  <div class="collapsible-body">
                    <p>Gestión de personal y control de acceso al sistema</p>
                    <br>
                    <center>
                      <div class="row">
                        <a href="administracion.html#adm1" class="btn btn-large col s12 waves-effect purple-orange-gradient">Usuarios</a>
                      </div>
                    </center>
                    <br>
                    <center>
                      <div class="row">
                        <a href="administracion.html#adm2" class="btn btn-large col s12 waves-effect purple-orange-gradient">Jornada laboral</a>
                      </div>
                    </center>
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
  <script src="js/funciones-validacion.js"></script>
  <script src="js/common.js"></script>
  <div class="sidenav-overlay" style="display: none; opacity: 0;"></div>
  <div class="drag-target"></div>
</body>
</html>
