<?php

    class SessionUtils {

        public function __construct() {
            if(session_status() == PHP_SESSION_NONE)
                session_start();
        }

        public function isUserLoggedIn() {
            if( isset($_SESSION['username']) && $_SESSION['username'] ) {
                return true;
            }
            return false;
        }

        public function isUserAdmin() {
            if( isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin' ) {
                return true;
            }
            return false;
        }

        public function saveUserLoggedIn($username, $rol, $alias) {
            if( isset($username) && isset($rol) ) {
                $_SESSION['username'] = $username;
                $_SESSION['rol'] = $rol;
                $_SESSION['alias'] = $alias;
                return true;
            }
            return false;
        }

        public function logoutUser() {
            session_destroy();
        }

        public function getSessionValue($property) {
            if(isset($_SESSION[$property])) {
                return $_SESSION[$property];
            }
            return null;
        }

        public function setSessionValue($property, $value) {
            if(isset($property) && isset($value)) {
                $_SESSION[$property] = $value;
                return true;
            }
            return false;
        }

        public function unsetSessionValue($property) {
            if(isset($property)) {
                unset($_SESSION[$property]);
                return true;
            }
            return false;
        }
    }

?>