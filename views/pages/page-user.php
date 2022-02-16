<?php
include 'barAdmin.php'
?>

<main class="app-content">
  <div class="app-title" style="padding-top: 35px; padding-bottom:20px">
    <div>
      <h1><i class="fa fa-edit"></i> Alta de Usuario</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item active"><a href="index.php?pagina=page-inicio"><i class="fa fa-home fa-lg"></i></a></li>
      <li class="breadcrumb-item"><a href="index.php?pagina=page-user">Alta Usuario</a></li>
    </ul>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Información de usuario</h3>
        <div class="tile-body">
          <form class="form-horizontal" method="POST" onclick="validatePassword();">
            <div class="form-group row">
              <label for="Name" class="control-label col-md-2">Nombre(s)</label>
              <div class="col-md-8">
                <input class="form-control" type="text" name="Name" id="Name" placeholder="Ingresa nombre(s)">
              </div>
            </div>
            <div class="form-group row">
              <label for="lastName" class="control-label col-md-2">Apellido(s)</label>
              <div class="col-md-8">
                <input class="form-control" type="text" name="lastName" id="lastName" placeholder="Ingresa apellido(s)">
              </div>
            </div>
            <div class="form-group row">
              <label for="userName" class="control-label col-md-2">Nombre de usuario</label>
              <div class="col-md-8">
                <input class="form-control" type="text" name="userName" id="userName" placeholder="Ingresa nombre de usuario">
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="control-label col-md-2">Contraseña</label>
              <div class="col-md-8">
                <input class="form-control" type="password" name="password" id="password" placeholder="Ingresa contraseña">
              </div>
            </div>
            <div class="form-group row">
              <label for="confirm_password" class="control-label col-md-2">Confirmar contraseña</label>
              <div class="col-md-8">
                <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirma contraseña">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2" for="role">Rol</label>
              <div class="col-md-8">
                <select class="form-control" name="role" id="role" placeholder="Role">
                  <option>Admin</option>
                  <option>Comprador</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2" for="puesto">Puesto</label>
              <div class="col-md-8">
                <input class="form-control" type="text" name="puesto" id="puesto" placeholder="Ingresa puesto">
              </div>
            </div>
        </div>
        <div class="tile-footer">
          <div class="row justify-content-center">
            <div class="col-md-auto">
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Registrar</button>&nbsp;&nbsp;&nbsp;
              <script>
                document.write('<a class="btn btn-secondary" href="' + document.referrer +
                  '"><i class="fa fa-fw fa-lg fa-times-circle"></i>Atrás</a>');
              </script>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>
</main>

<script>
  var password = document.getElementById("password"),
    confirm_password = document.getElementById("confirm_password");

  function validatePassword() {
    if (password.value != confirm_password.value) {
      confirm_password.setCustomValidity("La contraseña es diferente.");
    } else {
      confirm_password.setCustomValidity('');
    }
  }

  password.onchange = validatePassword;
  confirm_password.onkeyup = validatePassword;
</script>

<?php
if (!empty($_POST)) {
  $registro =  new controladorFormularios;
  $registro->ctrRegistroUsuario();
}
?>