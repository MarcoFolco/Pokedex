<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Pokémon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?php
    require_once('session-utils.php');
    $sessionUtils = new SessionUtils();
    $sessionUtils->logoutUser();
  ?>

  <?php
    include_once('nav.php');
  ?>

  <!-- Contenido principal -->
  <main class="container my-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <p>
        Sesion finalizada con exito
        </p>
        <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
