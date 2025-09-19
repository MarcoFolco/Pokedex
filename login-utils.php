<?php

class LoginUtils {

    private $databaseInstance;
    private $sessionUtils;

    public function __construct($databaseInstance) {
        $this->databaseInstance = $databaseInstance;
        require_once('session-utils.php');
        $this->sessionUtils = new SessionUtils();
    }

    public function loginUser($data) {
        $query = 'SELECT u.*, ru.nombre as rol FROM usuario u ' .
                 'LEFT JOIN rol_usuario ru ON u.rol_id = ru.id ' .
                 'WHERE nombre_usuario = "' . $data['username'] . '" AND contrasenia = "' . $data['password'] . '"';
        $result = $this->databaseInstance->selectQuery($query);
        if(sizeof($result) > 0) {
            $user = $result[0];
            $username = $user['nombre_usuario'];
            $rol = $user['rol'];
            $alias = $user['alias'];
            $this->sessionUtils->saveUserLoggedIn($username, $rol, $alias);
            return true;
        }
        return false;
    }
}
?>