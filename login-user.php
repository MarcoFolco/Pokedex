<?php
    $errors = [];
    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        if( isset($_POST['username']) && isset($_POST['password']) ) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $data = [
                'username' => $username,
                'password' => $password
            ];
            require_once('database.php');
            require_once('login-utils.php');
            require_once('session-utils.php');
            $databaseInstance = new Database();
            $loginUtils = new LoginUtils($databaseInstance);
            $sessionUtils = new SessionUtils();
            $loggedIn = $loginUtils->loginUser($data);
            if( $loggedIn ) {
                $sessionUtils->unsetSessionValue('loginUsername');
                $sessionUtils->unsetSessionValue('loginPassword');
                $sessionUtils->unsetSessionValue('loginErrors');
                header('Location: index.php');
            }
            else {
                $_SESSION['loginUsername'] = $username;
                $sessionUtils->setSessionValue('loginUsername', $username);
                $sessionUtils->setSessionValue('loginPassword', $password);
                $errors['credentials'] = 'Credenciales invalidas';
                $sessionUtils->setSessionValue('loginErrors', $errors);
                header('Location: login.php');
            }
        }
    } else {
        $errors['invalidRequest'] = 'Debe user POST como metodo para loguearse';
        $sessionUtils->setSessionValue('loginErrors', $errors);
        header('Location: login.php');
    }
?>