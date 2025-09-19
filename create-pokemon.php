
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pokedex</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

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
        require_once("session-utils.php");
        $databaseInstance = new Database();
        $pokemonUtils = new PokemonUtils($databaseInstance);
        $sessionUtils = new SessionUtils();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            // Verificar campos requeridos
            if (
                isset($_POST["name"]) &&
                isset($_POST["pokemon_id"]) &&
                isset($_POST["type1"]) &&
                isset($_POST["description"])
            ) {
                // Variables de formulario
                $name        = trim($_POST["name"]);
                $pokemon_id  = (int) $_POST["pokemon_id"];
                $type1       = trim($_POST["type1"]);
                $type2       = isset($_POST["type2"]) ? trim($_POST["type2"]) : null;
                $description = trim($_POST["description"]);

                $formData = [
                    "name"        => $name,
                    "pokemon_id"  => $pokemon_id,
                    "type1"       => $type1,
                    "type2"       => $type2,
                    "description" => $description,
                    "errors" => [],
                ];

                if( $type1 == $type2 ) {
                    $formData['errors']['duplicatedTypeError'] = 'Un pokemon no puede tener dos tipos iguales'; 
                    $sessionUtils->setSessionValue("createPokemonFormData", $formData);
                    header('Location: create.php');
                    exit();
                }

                $pokemon = $pokemonUtils->fetchPokemon($pokemon_id);
                if( $pokemon ) {
                    $formData['errors']['duplicatedPokemon'] = 'Ese Pokemon ya existe'; 
                    $sessionUtils->setSessionValue("createPokemonFormData", $formData);
                    header('Location: create.php');
                    exit();
                }

                // Manejo de la imagen
                $imagePath = null;
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
                            $formData['errors']['imageUploadError'] = "Error al mover la imagen al directorio de destino." . $destPath . " $fileTmpPath"; 
                            $sessionUtils->setSessionValue("createPokemonFormData", $formData);
                            header('Location: create.php');
                            exit();
                        }
                    } else {
                        $formData['errors']['invalidImageFormat'] = "Formato de imagen no permitido. Usa WEBP."; 
                        $sessionUtils->setSessionValue("createPokemonFormData", $formData);
                        header('Location: create.php');
                        exit();
                    }
                }


                $data = [
                    "nombre"        => $name,
                    "numero_identificador"  => $pokemon_id,
                    "tipo_1_id"       => $type1,
                    "tipo_2_id"       => $type2,
                    "descripcion" => $description,
                    "imagen"       => $baseNewFileName
                ];

                $createResult = $pokemonUtils->createPokemon($data);

                if( $createResult ) {
                    echo '<p>Pokemon creado con éxito</p>';
                } else {
                    $formData['errors']['errorCreatingPokemon'] = "Error al crear Pokemon"; 
                    $sessionUtils->setSessionValue("createPokemonFormData", $formData);
                    header('Location: create.php');
                    exit();
                }

                echo '<a href="index.php" class="btn btn-secondary">Back to List</a>';

            } else {
                $formData['errors']['invalidForm'] = "Faltan campos obligatorios en el formulario"; 
                $sessionUtils->setSessionValue("createPokemonFormData", $formData);
                header('Location: create.php');
                exit();
            }
        } else {
            $formData['errors']['invalidMethod'] = "Debe usar POST para usar esta acción."; 
            $sessionUtils->setSessionValue("createPokemonFormData", $formData);
            header('Location: create.php');
            exit();
        }
        ?>
        </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

