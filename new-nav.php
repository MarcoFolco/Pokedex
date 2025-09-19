<!-- Navbar -->
<?php
    require_once('session-utils.php');
    $sessionUtils = new SessionUtils();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">Pokedex</a>
        <div class="ms-auto">
        <?php
            if( $sessionUtils->isUserLoggedIn() ) {
                $alias = $sessionUtils->getSessionValue('alias');
                echo "<div class='d-flex gap-3 align-items-center justify-content-center'><a href='logout.php'>Cerrar sesion</a><span>$alias</span>" .
                     '<img src="assets/imgs/user-avatar.png" alt="User Avatar" class="rounded-circle" width="40" height="40"></div>';
            } else {
                echo '<a href="login.php">Iniciar sesion</a>';
            }
        ?>
        </div>
    </div>
</nav>