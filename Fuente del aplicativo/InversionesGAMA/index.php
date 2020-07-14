<?php
  //session_start();
  if (isset($_SESSION)) {
    if ($_SESSION["gama_areatrabajo"] == "Inventario") {
      header("Location: inventario.php");
    } elseif ($_SESSION["gama_areatrabajo"] == "Ventas") {
      header("Location: ventas.php");
    } elseif ($_SESSION["gama_areatrabajo"] == "Administración") {
      header("Location: panel.php");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Inversiones GAMA</title>
  <link href="img/logo.svg" rel="icon">
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/common.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/index.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <div class="row margin-zero login-bg">
    <nav role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo valign-wrapper"><img src="img/logo.svg" id="nav-logo-svg"></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="#">Navbar Link</a></li>
        </ul>

        <ul id="nav-mobile" class="sidenav" style="transform: translateX(-105%);">
          <li><a href="#">Navbar Link</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>
    </nav>
    <div class="col s12">
      <div class="container principal-container s12">
        <div class="col s12 login-principal-div flex-div">
          <div class="row principal-panel">
            <form class="z-depth-2 col white s12 login-principal-card" method="post">
              <div class="row margin-zero">
                <div class="col s12 center">
                  <img src="img/logo.svg" id="logo-svg">
                  <h5 class="margin-zero gama-title">Finca E Inversiones GAMA</h5>
                  <h5>¡Bienvenido!</h5>
                  <p>Ingresa tu nombre de usuario y contraseña</p>
                </div>
               </div>
              <div class="row margin-zero">
                <div class="input-field col s12">
                  <div class="grey-text">Nombre de usuario</div>
                  <input class="regexAlfanumerico validate" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}" type="text" name="text" id="login-txt-username" required>
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
              </div>
              <div class="row margin-zero">
                <div class="input-field col s12">
                  <div class="grey-text">Contraseña</div>
                  <input class="validate" pattern=".*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*" type="password" name="password" id="login-txt-password" required>
                  <span class="helper-text" data-error="Campo vacío o dato inválido"></span>
                </div>
                <label class="input-field right">
                  <div class="input-field">
                    <a class="pink-text" href="#!"><b>¿Olvidó su contraseña?</b></a>
                  </div>
                </label>
              </div>
              <br>
              <center>
                <div class="row">
                  <button type="button" id="btn-login" class="col s12 btn btn-large waves-effect purple-orange-gradient">Entrar</button>
                </div>
              </center>
            </form>
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
  <script src="js/controlador-login.js"></script>
  <script src="js/funciones-validacion.js"></script>
  <script src="js/common.js"></script>
  <div class="sidenav-overlay" style="display: none; opacity: 0;"></div>
  <div class="drag-target"></div>
</body>
</html>
