<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
</head>
<body>
    <?php
        require_once("database.php");
        require_once("pokemon-utils.php");
        $database = new Database();
        $utils = new PokemonUtils($database);

        $value = $_POST["value"];

        $result = $utils->searchPokemon($value);

        foreach ($result as $row) {
            echo "Pokemon - ". $row["id"] ." / ". $row['nombre'];
        }
    ?>
</body>
</html>