<?php

class PokemonUtils {

    private $databaseInstance;
    private $sessionUtils;

    public function __construct($databaseInstance) {
        require_once('session-utils.php');
        $this->databaseInstance = $databaseInstance;
        $this->sessionUtils = new SessionUtils();
    }

    public function fetchAllPokemonTypes() {
      $query = 'SELECT * FROM tipo_pokemon';
      $result = $this->databaseInstance->selectQuery($query);
      return $result;
    }

    public function searchPokemon($value) {
        $query = 'SELECT p.*, t1.nombre AS tipo1, t2.nombre AS tipo2 FROM pokemon p '.
                 'LEFT JOIN tipo_pokemon t1 ON p.tipo_1_id = t1.id ' .
                 'LEFT JOIN tipo_pokemon t2 ON p.tipo_2_id = t2.id ' . 
                 'WHERE p.nombre LIKE "%' . $value . '%" OR t1.nombre LIKE "%' . $value . '%" OR t2.nombre LIKE "%' . $value . '%"';
        $result = $this->databaseInstance->selectQuery($query);
        return $result;
    }

    public function createPokemon($pokemonValues) {
        $query = 'INSERT INTO pokemon(numero_identificador, nombre, imagen, tipo_1_id, tipo_2_id, descripcion) ' .
        'VALUES(' . $pokemonValues['numero_identificador'] . ",'" . $pokemonValues['nombre'] . "','" . $pokemonValues['imagen'] . "'," .
        $pokemonValues['tipo_1_id'] . "," . $pokemonValues['tipo_2_id'] . ",'" . $pokemonValues['descripcion'] . "')";
        $result = $this->databaseInstance->cudQuery($query);
        return $result;
    }

    public function editPokemon($pokemonValues) {
        $query = '
            UPDATE pokemon 
            SET 
                nombre = "' . $pokemonValues['nombre'] . '",
                numero_identificador = "' . $pokemonValues['numero_identificador'] . '",
                tipo_1_id = "' . $pokemonValues['tipo_1_id'] . '",
                tipo_2_id = "' . $pokemonValues['tipo_2_id'] . '",
                descripcion = "' . $pokemonValues['descripcion'] . '"' .
                ($pokemonValues['imagen'] ? (', imagen = "' . $pokemonValues['imagen'] . '"') : '') . '
            WHERE id = ' . $pokemonValues['id'];
        $result = $this->databaseInstance->cudQuery($query);
        return $result;
    }

    public function deletePokemon($numero_identificador) {
      $query = "
          DELETE FROM pokemon
          WHERE numero_identificador = $numero_identificador";

      $result = $this->databaseInstance->cudQuery($query);
      return $result;
    }

    public function fetchAllPokemons() {
        $query = 'SELECT 
            p.*, 
            t1.nombre AS tipo1, 
            t2.nombre AS tipo2
            FROM pokemon p
            LEFT JOIN tipo_pokemon t1 ON p.tipo_1_id = t1.id
            LEFT JOIN tipo_pokemon t2 ON p.tipo_2_id = t2.id';
        $result = $this->databaseInstance->selectQuery($query);
        return $result;
    }

    public function fetchPokemon($numero_identificador) {
        $query = 'SELECT 
            p.*, 
            t1.nombre AS tipo1, 
            t2.nombre AS tipo2
            FROM pokemon p
            LEFT JOIN tipo_pokemon t1 ON p.tipo_1_id = t1.id
            LEFT JOIN tipo_pokemon t2 ON p.tipo_2_id = t2.id WHERE numero_identificador = ' . $numero_identificador;
        $result = $this->databaseInstance->selectQuery($query);
        if(sizeof($result) == 1) {
          $result = $result[0];
        } else {
          $result = null;
        }
        return $result;
    }

    public function printPokemonCard($pokemon) {
        if( $pokemon ) {
            $pokemonHtmlStr = 
                '<div class="col">' .
                  '<div class="card shadow-sm h-100">' .
                    '<picture>' .
                      '<img src="assets/imgs/pokemon_avatars/' . $pokemon['imagen'] . '.webp" class="card-img-top" alt="'. $pokemon['nombre'] . '">' .
                    '</picture>' .
                    '<div class="card-body">' .
                      '<h5 class="card-title">' . $pokemon['nombre'] . '</h5>' .
                      '<p class="card-text text-muted">Num. Identificador: ' . $pokemon['numero_identificador'] . '</p>' .
                      '<div class="d-flex align-items-center gap-2 mb-3">' . 'Tipos: ' .
                        '<img src="assets/imgs/pokemon_types/' . $pokemon['tipo1'] . '.png" alt="Tipo ' . $pokemon['tipo1'] . '" width="30" height="30">'; 
            if( isset($pokemon['tipo2']) && $pokemon['tipo2'] ) {
                $pokemonHtmlStr = $pokemonHtmlStr .
                '<img src="assets/imgs/pokemon_types/' . $pokemon['tipo2'] . '.png" alt="Tipo '. $pokemon['tipo2'] . '" width="30" height="30">';
            }
            $pokemonHtmlStr = $pokemonHtmlStr .
                      '</div>' .
                      '<div class="d-flex justify-content-between">' .
                        '<a href="details.php?id=' . $pokemon['numero_identificador'] . '" class="btn btn-outline-primary btn-sm">Details</a>' . 
                        '<div class="btn-group">' .
                          ($this->sessionUtils->isUserAdmin() ? ('<a href="edit.php?id=' . $pokemon['numero_identificador'] . '" class="btn btn-outline-warning btn-sm">Edit</a>') : '') .
                          ($this->sessionUtils->isUserAdmin() ? ('<a href="delete-pokemon.php?id=' . $pokemon['numero_identificador']  . '" class="btn btn-outline-danger btn-sm">Delete</a>') : '') . 
                        '</div>' .
                      '</div>' .
                    '</div>' .
                  '</div>' .
                '</div>';
            return $pokemonHtmlStr;
        }
        return '';
    }
}
?>