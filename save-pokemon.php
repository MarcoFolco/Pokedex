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

        $pokemon = $pokemonUtils->fetchPokemon($pokemon_id);
        if( count($pokemon) > 0 ) {
            exit("Ese Pokemon ya existe");
        }

        // Manejo de la imagen
        $imagePath = null;
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $uploadDir = "assets/imgs/";  // Carpeta destino
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Crear carpeta si no existe
            }

            $fileTmpPath = $_FILES["image"]["tmp_name"];
            $fileName    = basename($_FILES["image"]["name"]);
            $fileExt     = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Crear nombre único para evitar colisiones
            $newFileName = uniqid("pokemon_", true) . "." . $fileExt;
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
            "nombre"        => $name,
            "numero_identificador"  => $pokemon_id,
            "tipo_1"       => $type1,
            "tipo_2"       => $type2,
            "descripcion" => $description,
            "imagen"       => $imagePath
        ];

        $pokemonUtils->createPokemon($data);

        echo '<p>Pokemon guardado</p>';
        echo '<a href="index.php" class="btn btn-secondary">Back to List</a>';

    } else {
        exit("Faltan campos obligatorios en el formulario.");
    }
} else {
    exit("Acceso inválido.");
}
