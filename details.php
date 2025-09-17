<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pokemon Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <?php
  include_once("nav.php");
  ?>

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
        if($pokemon) {
          include_once('details-found.php');
          exit();
        }
      }
      echo '<p>No hay un Pokemon con ese numero identificador</p>';
    ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
