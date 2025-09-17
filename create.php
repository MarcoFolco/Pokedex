<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Pokémon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?php
    require_once("database.php");
    require_once("pokemon-utils.php");
    $databaseInstance = new Database();
    $pokemonUtils = new PokemonUtils($databaseInstance);
    $pokemonTypes = $pokemonUtils->fetchAllPokemonTypes();
  ?>

  <?php
    include_once("nav.php");
  ?>

  <!-- Contenido principal -->
  <main class="container my-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-4">Agregar nuevo Pokémon</h3>
        <form method="POST" action="save-pokemon.php" enctype="multipart/form-data" class="row g-3">

          <!-- Nombre -->
          <div class="col-md-6">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <!-- ID -->
          <div class="col-md-6">
            <label for="pokemon_id" class="form-label">ID</label>
            <input type="number" name="pokemon_id" id="pokemon_id" class="form-control" required>
          </div>

          <!-- Imagen -->
          <div class="col-12">
            <label for="image" class="form-label">Imagen</label>
            <input type="file" name="image" id="image" class="form-control">
          </div>

          <!-- Tipos -->
          <div class="col-md-6">
            <label for="type1" class="form-label">Tipo 1</label>
            <select name="type1" id="type1" class="form-select" required>
              <option value="">-- Selecciona un tipo --</option>
              <?php
                foreach ($pokemonTypes as $pokemonType)
                  echo '<option value="' . $pokemonType['id'] .'">'. $pokemonType['nombre'] . '</option>';
              ?>
            </select>
          </div>

          <div class="col-md-6">
            <label for="type2" class="form-label">Tipo 2 (opcional)</label>
            <select name="type2" id="type2" class="form-select">
              <option value="">-- Selecciona un tipo --</option>
              <?php
                foreach ($pokemonTypes as $pokemonType)
                  echo '<option value="' . $pokemonType['id'] .'">'. $pokemonType['nombre'] . '</option>';
              ?>
            </select>
          </div>

          <!-- Descripción -->
          <div class="col-12">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
          </div>

          <!-- Acciones -->
          <div class="col-12 d-flex justify-content-between">
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar Pokémon</button>
          </div>

        </form>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
