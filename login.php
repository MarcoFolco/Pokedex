<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Pokémon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <?php
    include_once('new-nav.php');
  ?>

  <?php
    $sessionUtils = new SessionUtils();
    $username = $sessionUtils->getSessionValue('loginUsername');
    $password = $sessionUtils->getSessionValue('loginPassword');
  ?>

  <!-- Contenido principal -->
  <main class="container my-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-4">Iniciar Sesion</h3>
        <?php
            $errors = $sessionUtils->getSessionValue('loginErrors');
            if($errors) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger mt-3">' .
                         $error . '</div>';
                }
                $sessionUtils->unsetSessionValue('loginErrors');
            }
            
        ?>
        <form method="POST" action="login-user.php" class="row g-3">

          <!-- Nombre -->
          <div class="col-md-6 col-sm-12">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" name="username" id="username" class="form-control" <?php echo 'value="' . $username . '"'; $sessionUtils->unsetSessionValue('loginUsername'); ?> required>
          </div>

          <!-- Contrasenia -->
          <div class="col-md-6 col-sm-12">
            <label for="password" class="form-label">Contrasenia</label>
            <input type="password" name="password" id="password" class="form-control" <?php echo 'value="' . $password . '"'; $sessionUtils->unsetSessionValue('loginPassword'); ?> required>
          </div>

          <!-- Acciones -->
          <div class="col-12 d-flex justify-content-between">
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Iniciar sesion</button>
          </div>

        </form>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
