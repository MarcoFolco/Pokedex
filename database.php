<?php
class Database {

    private $conexion;

    public function __construct($host="localhost", $username="root", $password="", $database="pokedex") {
        $this->conexion = new mysqli($host, $username, $password, $database);
    }

    public function query($value="") {
        $result = $this->conexion->query($value);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct() {
        $this->conexion->close();
    }

}
?>