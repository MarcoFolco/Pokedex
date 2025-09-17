
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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        // Verificar campos requeridos
        if (
            isset($_POST["id"]) &&
            isset($_POST["name"]) &&
            isset($_POST["pokemon_id"]) &&
            isset($_POST["type1"]) &&
            isset($_POST["description"])
        ) {
            // Variables de formulario
            $id          = $_POST["id"];
            $name        = trim($_POST["name"]);
            $pokemon_id  = (int) $_POST["pokemon_id"];
            $type1       = trim($_POST["type1"]);
            $type2       = isset($_POST["type2"]) ? trim($_POST["type2"]) : null;
            $description = trim($_POST["description"]);

            if( $type1 == $type2 ) {
                exit('<div class="alert alert-danger" role="alert">Un pokemon no puede tener dos tipos iguales</div><a href="create.php" class="btn btn-secondary">Volver a vista de creación</a>');
            }

            // Manejo de la imagen, si es que se cambia
            $imagePath = null;
            $baseNewFileName = null;
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
                $uploadDir = "assets/imgs/pokemon_avatars/";  // Carpeta destino
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Crear carpeta si no existe
                }

                $fileTmpPath = $_FILES["image"]["tmp_name"];
                $fileName    = basename($_FILES["image"]["name"]);
                $fileExt     = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Crear nombre único para evitar colisiones
                $baseNewFileName = uniqid("pokemon_", true);
                $newFileName = $baseNewFileName .".". $fileExt;
                $destPath    = $uploadDir . $newFileName;

                // Validar extensión de imagen
                $allowedExts = ["webp"];
                if (in_array($fileExt, $allowedExts)) {
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $imagePath = $newFileName;
                    } else {
                        die("Error al mover la imagen al directorio de destino." . $destPath . " $fileTmpPath");
                    }
                } else {
                    die("Formato de imagen no permitido. Usa WEBP.");
                }
            }


            $data = [
                "id"            => $id,
                "nombre"        => $name,
                "numero_identificador"  => $pokemon_id,
                "tipo_1_id"       => $type1,
                "tipo_2_id"       => $type2,
                "descripcion" => $description,
                "imagen"       => $baseNewFileName
            ];

            $editResult = $pokemonUtils->editPokemon($data);

            if( $editResult ) {
                echo '<p>Pokemon editado con éxito</p>';
            } else {
                echo '<p>Error al editar Pokemon</p>';
            }

            echo '<a href="index.php" class="btn btn-secondary">Back to List</a>';

        } else {
            exit('<p>Faltan campos obligatorios en el formulario.</p><a href="create.php" class="btn btn-secondary">Volver a vista de creación</a>');
        }
    } else {
        exit('<p>Acceso inválido.</p><a href="create.php" class="btn btn-secondary">Volver a vista de creación</a>');
    }
    ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

