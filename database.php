<?php
class Database {

    private $conexion;

    public function __construct($host="localhost", $username="root", $password="", $database="pokedex") {
        $this->conexion = new mysqli($host, $username, $password, $database);
    }

    public function selectQuery($value="") {
        $result = $this->conexion->query($value);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // CUD = Create - Update - Delete
    public function cudQuery($value="") {
        $result = $this->conexion->query($value);
        return $result;
    }

    public function __destruct() {
        $this->conexion->close();
    }

}
?>