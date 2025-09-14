<?php

class PokemonUtils {

    private $databaseInstance;

    public function __construct($databaseInstance) {
        $this->databaseInstance = $databaseInstance;
    }

    public function searchPokemon($value) {
        $query = 'SELECT * FROM pokemon WHERE nombre LIKE "%' . $value . '%" OR tipo_1 LIKE "%' . $value . '%" OR tipo_2 LIKE "%' . $value . '%"';
        $result = $this->databaseInstance->query($query);
        return $result;
    }

    public function createPokemon($pokemonValues) {
        $query = 'INSERT INTO pokemon(numero_identificador, nombre, imagen, tipo_1, tipo_2, descripcion)' .
        'VALUES(' . $pokemonValues['numero_identificador'] . ',' . $pokemonValues['nombre'] . ',' .
        $pokemonValues['tipo_1'] . ',' . $pokemonValues['tipo_2'] . ',' . $pokemonValues['descripcion'] . ')';
        $this->databaseInstance->query($query);
    }

    public function fetchAllPokemons() {
        $query = 'SELECT * FROM pokemon';
        $result = $this->databaseInstance->query($query);
        return $result;
    }

    public function fetchPokemon($numero_identificador) {
        $query = 'SELECT * FROM pokemon WHERE numero_identificador = ' . $numero_identificador;
        $result = $this->databaseInstance->query($query);
        return $result;
    }

    public function printPokemonCard($pokemon) {
        if( $pokemon ) {
            $pokemonHtmlStr = 
                '<div class="col">' .
                  '<div class="card shadow-sm h-100">' .
                    '<picture>' .
                      '<img src="assets/imgs/' . $pokemon['imagen'] . '.webp" class="card-img-top" alt="Pokemon Name">' .
                    '</picture>' .
                    '<div class="card-body">' .
                      '<h5 class="card-title">' . $pokemon['nombre'] . '</h5>' .
                      '<p class="card-text text-muted">ID: ' . $pokemon['numero_identificador'] . '</p>' .
                      '<div class="d-flex align-items-center gap-2 mb-3">' . 'Tipos: ' .
                        '<img src="assets/imgs/pokemon_types/' . $pokemon['tipo_1'] . '.png" alt="Electric Type" width="30" height="30">'; 
            if( isset($pokemon['tipo_2']) && $pokemon['tipo_2'] ) {
                $pokemonHtmlStr = $pokemonHtmlStr .
                '<img src="path/to/' . $pokemon['tipo_2'] . '.png" alt="Flying Type" width="30" height="30">';
            }
            $pokemonHtmlStr = $pokemonHtmlStr .
                      '</div>' .
                      '<div class="d-flex justify-content-between">' .
                        '<a href="details.php?id=' . $pokemon['numero_identificador'] . '" class="btn btn-outline-primary btn-sm">Details</a>' . 
                        '<div class="btn-group">' .
                          '<a href="edit.php?id=' . 25 . '" class="btn btn-outline-warning btn-sm">Edit</a>' .
                          '<a href="delete.php?id=' . 25 . '" class="btn btn-outline-danger btn-sm">Delete</a>' . 
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