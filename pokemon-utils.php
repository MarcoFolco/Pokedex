<?php

class PokemonUtils {

    private $databaseInstance;

    public function __construct($databaseInstance) {
        $this->databaseInstance = $databaseInstance;
    }

    /*
    * Busca un pokemon por Nombre, Tipo o Identificador
    * @Input -> $value: 
    */
    public function searchPokemon($value) {
        $query = 'SELECT * FROM pokemon WHERE nombre LIKE "' . $value . '" OR tipo_1 LIKE "' . $value . '" OR tipo_2 LIKE "' . $value . '"';
        $result = $this->databaseInstance->query($query);
        return $result;
    }
}
?>