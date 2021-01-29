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
      <h3>Iniciar sesi&oacute;n</h3>
      <form method="POST">
        <div class="form-group">
            <label for="email">Correo electr&oacute;nico</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Correo electr&oacute;nico">
        </div>
        <div class="form-group">
            <label for="password">Contrase&ntilde;a</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Contrase&nacute;a">
        </div>

        <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>

      <?php if(isset($error)): ?>
          <script>
            alert("<?php echo $error ;?>");
          </script>
      <?php endif; ?>

  </body>
</html>
