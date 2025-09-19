<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Pokémon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <?php
    include_once("nav.php");
  ?>

  <!-- Contenido principal -->
  <main class="container my-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <?php
          include_once('session-utils.php');
          $sessionUtils = new SessionUtils();
          if(!$sessionUtils->isUserAdmin())
            exit('<p>No tienes permisos para ver esta página.</p><a href="index.php" class="btn btn-secondary">Volver al inicio</a>')
        ?>
        <?php
          require_once("database.php");
          require_once("pokemon-utils.php");
          $databaseInstance = new Database();
          $pokemonUtils = new PokemonUtils($databaseInstance);
          $pokemonTypes = $pokemonUtils->fetchAllPokemonTypes();
          if( isset($_GET['id']) ) {
            $numero_identificador = $_GET['id'];
            $pokemon = $pokemonUtils->fetchPokemon($numero_identificador);
            if(!$pokemon) {
                exit('<p>No hay un Pokemon con ese numero de identificador</p><a href="index.php" class="btn btn-secondary">Volver al listado</a>');
            }
          }
          $formData = $sessionUtils->getSessionValue('editPokemonFormData');
          if(!$formData) {
            $formData = [
                          "id"          => $pokemon['id'],
                          "name"        => $pokemon['nombre'],
                          "pokemon_id"  => $pokemon['numero_identificador'],
                          "type1"       => $pokemon['tipo_1_id'],
                          "type2"       => $pokemon['tipo_2_id'],
                          "description" => $pokemon['descripcion'],
                          "errors" => [],
                      ];
          }
        ?>
        <h3 class="card-title mb-4">Editar Pokémon</h3>
        <?php
          foreach($formData['errors'] as $error)
            echo '<div class="alert alert-danger mt-3">'. $error . '</div>';
          $formData['errors'] = [];
        ?>
        <form method="POST" action="edit-pokemon.php" enctype="multipart/form-data" class="row g-3">

          <input type="hidden" name="id" value="<?php echo $formData['id']; ?>">

          <!-- Nombre -->
          <div class="col-md-6">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" 
                   value="<?php echo $formData['name']; ?>" required>
          </div>

          <!-- Numero identificador -->
          <div class="col-md-6">
            <label for="pokemon_id" class="form-label">ID</label>
            <input type="number" name="pokemon_id" id="pokemon_id" class="form-control"
                   value="<?php echo $formData['pokemon_id']; ?>" required>
          </div>

          <!-- Imagen -->
          <div class="col-12">
            <label for="image" class="form-label">Imagen</label>
            <input type="file" name="image" id="image" class="form-control">
            <div class="mt-2">
              <picture>
                <img src="assets/imgs/pokemon_avatars/<?php echo $pokemon['imagen']; ?>.webp" alt="Imagen actual" width="120" class="rounded">
              </picture>
            </div>
          </div>

          <input type="hidden" name="existingImageName" value="<?php echo $pokemon['imagen'] ?>">

          <!-- Tipos -->
          <div class="col-md-6">
            <label for="type1" class="form-label">Tipo 1</label>
            <select name="type1" id="type1" class="form-select" required>
              <option value="">-- Selecciona un tipo --</option>
              <?php
                foreach ($pokemonTypes as $pokemonType){
                  echo '<option value="' . $pokemonType['id'] . ($pokemonType['id'] == $formData['type1'] ? '" selected>' : '">') . $pokemonType['nombre'] . '</option>';
                }
              ?>
              <!-- agregar todos los tipos -->
            </select>
          </div>

          <div class="col-md-6">
            <label for="type2" class="form-label">Tipo 2</label>
            <select name="type2" id="type2" class="form-select" required>
              <option value="">-- Selecciona un tipo --</option>
              <?php
                foreach ($pokemonTypes as $pokemonType){
                  echo '<option value="' . $pokemonType['id'] . ($pokemonType['id'] == $formData['type2'] ? '" selected>' : '">') . $pokemonType['nombre'] . '</option>';
                }
              ?>
              <!-- agregar todos los tipos -->
            </select>
          </div>

          <!-- Descripción -->
          <div class="col-12">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="4" required><?php echo $formData['description']; ?></textarea>
          </div>

          <!-- Acciones -->
          <div class="col-12 d-flex justify-content-between">
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar Pokémon</button>
          </div>

        </form>
        <?php
          $sessionUtils->unsetSessionValue('editPokemonFormData');
        ?>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
