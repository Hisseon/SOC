    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1></h1>
      </div>
      <div class="login-box" style="border-radius: 30px;">
        <form class="login-form" method="POST">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>INICIAR SESIÓN</h3>
          <div class="form-group">
            <label class="control-label">Usuario</label>
            <input class="form-control" type="text" placeholder="Usuario" autofocus name="ingresoUsuario">
          </div>
          <div class="form-group">
            <label class="control-label">Contraseña</label>
            <input class="form-control" type="password" placeholder="Contraseña" name="ingresoPassword">
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>Iniciar sesión</button>
          </div>
        </form>
      </div>
    </section>
<?php
$ingreso =  new controladorFormularios;
$ingreso -> ctrIngreso();
?>   

