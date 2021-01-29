<!DOCTYPE HTML>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Prueba de desarrollo</title>
  </head>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style>
    body {
        background-color: aliceblue;
    }
  </style>
  <body>

    <div class="container">
      <div style="float: right;"><a href="/logout">Cerrar sesi&oacute;n</a></div>
      <h3>Info</h3>
      <div class="form-group row">
        <label class="col-sm-2">Correo electr&oacute;nico</label>
        <div class="col-sm-10">
          <span class=""><?=$user->getEmail();?></span>
        </div>
        <label class="col-sm-2">Nombre</label>
        <div class="col-sm-10">
          <span class=""><?=$user->getName();?></span>
        </div>
        <label class="col-sm-2">Apellido</label>
        <div class="col-sm-10">
          <span class=""><?=$user->getLastName();?></span>
        </div>
        <label class="col-sm-2">Inicio de sesi&oacute;n actual</label>
        <div class="col-sm-10">
          <?=$user->getLoginTimeStamp();?>
        </div>
        <label class="col-sm-2">Inicio de sesi&oacute;n anterior</label>
        <div class="col-sm-10">
          <?=$user->getPrevLoginTimeStamp();?>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>