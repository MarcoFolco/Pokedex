<div class="card shadow-sm">
    <div class="row g-0">
    <div class="col-md-4 text-center p-4">
        <picture>
        <?php
            echo '<img src="assets/imgs/pokemon_avatars/' . $pokemon['imagen'] . '" class="img-fluid rounded" alt="Pokemon Name">'
        ?>
        </picture>
        <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
        <?php
            echo 'Tipos: ' . '<img src="assets/imgs/pokemon_types/' . $pokemon['tipo1'] . '.png" alt="Tipo '. $pokemon['tipo1'] . '" width="40" height="40">';
            if( isset($pokemon['tipo2']) && $pokemon['tipo2'] ) {
                echo
                '<img src="assets/imgs/pokemon_types/' . $pokemon['tipo2'] . '.png" alt="Tipo '. $pokemon['tipo2'] . '" width="30" height="30">';
            }
        ?>
        <!-- Optional second type -->
        <!-- <img src="path/to/flying.png" alt="Flying Type" width="40" height="40"> -->
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-body">
        <?php
            echo 
            '<h3 class="card-title">'. $pokemon['nombre'] . '</h3>' .
            '<p class="text-muted">ID: ' . $pokemon['numero_identificador'] . '</p>' .
            '<p class="card-text">Descripción: ' . $pokemon['descripcion'] . '</p>';
        ?>
        <a href="index.php" class="btn btn-secondary">Volver al listado</a>
        </div>
    </div>
    </div>
</div>