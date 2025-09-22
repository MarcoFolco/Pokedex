
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
    <div class="card shadow-sm">
      <div class="card-body">
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
                isset($_POST["description"]) &&
                isset($_POST["existingImageName"])
            ) {
                // Variables de formulario
                $id          = $_POST["id"];
                $name        = trim($_POST["name"]);
                $pokemon_id  = (int) $_POST["pokemon_id"];
                $initial_pokemon_id = (int) $_POST["initial_pokemon_id"];
                $type1       = trim($_POST["type1"]);
                $type2       = isset($_POST["type2"]) ? trim($_POST["type2"]) : null;
                $description = trim($_POST["description"]);
                $existingImageName = $_POST["existingImageName"];

                $formData = [
                        "id"        => $id,
                        "name"        => $name,
                        "pokemon_id"  => $pokemon_id,
                        "initial_pokemon_id" => $initial_pokemon_id,
                        "type1"       => $type1,
                        "type2"       => $type2,
                        "description" => $description,
                        "errors" => [],
                    ];

                if( $type1 == $type2 ) {
                    $formData['errors']['duplicatedTypeError'] = 'Un pokemon no puede tener dos tipos iguales'; 
                    $sessionUtils->setSessionValue("editPokemonFormData", $formData);
                    header('Location: edit.php?id=' . $formData['initial_pokemon_id']);
                    exit();
                }

                // Manejo de la imagen, si es que se cambia
                $imagePath = null;
                $newFileName = null;
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
                    $allowedExts = ["webp", "jpg", "jpeg", "png"];
                    if (in_array($fileExt, $allowedExts)) {
                        if (move_uploaded_file($fileTmpPath, $destPath)) {
                            $imagePath = $newFileName;
                            $currentImgPath = $uploadDir . $existingImageName . '';
                            if(file_exists($currentImgPath)) {
                                unlink($currentImgPath);
                            }
                        } else {
                            $formData['errors']['imageUploadError'] = "Error al mover la imagen al directorio de destino." . $destPath . " $fileTmpPath"; 
                            $sessionUtils->setSessionValue("editPokemonFormData", $formData);
                            header('Location: edit.php?id=' . $formData['initial_pokemon_id']);
                            exit();
                        }
                    } else {
                        $formData['errors']['invalidImageFormat'] = "Formato de imagen no permitido. Usa WEBP."; 
                        $sessionUtils->setSessionValue("editPokemonFormData", $formData);
                        header('Location: edit.php?id=' . $formData['initial_pokemon_id']);
                        exit();
                    }
                }


                $data = [
                    "id"            => $id,
                    "nombre"        => $name,
                    "numero_identificador"  => $pokemon_id,
                    "tipo_1_id"       => $type1,
                    "tipo_2_id"       => $type2,
                    "descripcion" => $description,
                    "imagen"       => $newFileName
                ];

                $editResult = $pokemonUtils->editPokemon($data);

                if( $editResult ) {
                    echo '<p>Pokemon editado con éxito</p>';
                } else {
                    $formData['errors']['errorEditingPokemon'] = "Error al editar Pokemon"; 
                    $sessionUtils->setSessionValue("editPokemonFormData", $formData);
                    header('Location: edit.php?id=' . $formData['initial_pokemon_id']);
                    exit();
                }

                echo '<a href="index.php" class="btn btn-secondary">Volver al listado</a>';

            } else {
                $formData['errors']['invalidForm'] = "Faltan campos obligatorios en el formulario."; 
                $sessionUtils->setSessionValue("editPokemonFormData", $formData);
                header('Location: edit.php?id=' . $formData['initial_pokemon_id']);
                exit();
            }
        } else {
            $formData['errors']['invalidMethod'] = "Debe usar POST para usar esta acción."; 
            $sessionUtils->setSessionValue("editPokemonFormData", $formData);
            header('Location: edit.php?id=' . $formData['initial_pokemon_id']);
            exit();
        }
        ?>
        </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

