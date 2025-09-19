
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
  <main class="container">
    <?php
    require_once("database.php");
    require_once("pokemon-utils.php");
    $databaseInstance = new Database();
    $pokemonUtils = new PokemonUtils($databaseInstance);
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        
        // Verificar campos requeridos
        if (
            isset($_GET["id"])
        ) {
            // Variables de formulario
            $numero_identificador          = $_GET["id"];

            // Obtener pokemon completo para borrar su imagen
            $pokemon = $pokemonUtils->fetchPokemon($numero_identificador);
            if( $pokemon ) {
                $imagen  = $pokemon["imagen"];
    
                $imagenDir = "assets/imgs/pokemon_avatars/$imagen.webp";
    
                // Eliminar imagen
                if (file_exists($imagenDir)) {
                    unlink($imagenDir);
                }
    
                $deleteResult = $pokemonUtils->deletePokemon($numero_identificador);
    
                if( $deleteResult ) {
                    echo '<p>Pokemon borrado con éxito</p>';
                } else {
                    echo '<p>Error al borrar Pokemon</p>';
                }
    
                echo '<a href="index.php" class="btn btn-secondary">Volver al listado</a>';
            } else {
                exit('<p>No existe un pokemon con ese número de identificador.</p><a href="index.php" class="btn btn-secondary">Volver al listado</a>');
            }

        } else {
            exit('<p>Faltan campos obligatorios para poder borrar este Pokemon.</p><a href="index.php" class="btn btn-secondary">Volver al listado</a>');
        }
    } else {
        exit('<p>Acceso inválido.</p><a href="index.php" class="btn btn-secondary">Volver al listado</a>');
    }
    ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

