<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pokedex</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?php
    require_once("database.php");
    require_once("pokemon-utils.php");
    $databaseInstance = new Database();
    $pokemonUtils = new PokemonUtils($databaseInstance);
  ?>

  <?php
    include_once("nav.php");
  ?>

  <!-- Main content -->
  <main class="container my-4">

    <!-- Search bar -->
    <form class="row mb-4 g-2" method="GET" action="index.php">
      <div class="col-sm-10">
        <input type="text" name="search" class="form-control" placeholder="Search Pokémon by name or ID">
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-primary w-100">Search</button>
      </div>
    </form>

    <!-- Pokémon List -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <div class="col">
        <div class="card shadow-sm h-100 border-dashed">
          <div class="card-body text-center d-flex align-items-center justify-content-center">
            <a href="create.php" class="btn btn-success btn-lg w-100">
              + Create New Pokémon
            </a>
          </div>
        </div>
      </div>

      <?php
        if( isset($_GET['search']) && $_GET['search'] ) {
          $searchValue = $_GET['search'];
          $pokemons = $pokemonUtils->searchPokemon($searchValue);
        } else {
          $pokemons = $pokemonUtils->fetchAllPokemons();
        }
        if(count($pokemons)) {
          foreach ($pokemons as $pokemon) {
            $pokemonCardHTML = $pokemonUtils->printPokemonCard($pokemon);
            echo $pokemonCardHTML;
          }
        } else {
          echo "<p>No results</p>";
        }
      ?>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
