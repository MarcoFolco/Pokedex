<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pokemon Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="index.php">Pokedex</a>
      <div class="ms-auto">
        <img src="assets/imgs/user-avatar.png" alt="User Avatar" class="rounded-circle" width="40" height="40">
      </div>
    </div>
  </nav>

  <!-- Main content -->
  <main class="container my-4">
    <?php
      require_once("database.php");
      require_once("pokemon-utils.php");
      $databaseInstance = new Database();
      $pokemonUtils = new PokemonUtils($databaseInstance);
      if( isset($_GET['id']) ) {
        $numero_identificador = $_GET['id'];
        $pokemon = $pokemonUtils->fetchPokemon($numero_identificador);
        if(count($pokemon) == 1) {
          $pokemon = $pokemon[0];
          include_once('details-found.php');
          exit();
        } else if ( count($pokemon) > 1 ) {
          echo '<p>Se encontro mas de un pokemon con ese numero de identificador</p>';
          exit();
        }
      }
      echo '<p>No hay un Pokemon con ese numero identificador</p>';
    ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
