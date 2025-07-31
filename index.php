<?php

include_once 'conexion.php';

$sql = 'SELECT * FROM articulos';
$sentencia = $pdo->prepare($sql);
$sentencia->execute();

$resultado = $sentencia->fetchAll();

// var_dump($resultado);

$articulo_x_pag = 4;

$total_articulos = $sentencia->rowCount();

$paginas = $total_articulos / $articulo_x_pag;
$paginas = ceil($paginas);

if (!$_GET) {
    header('location:index.php?pagina=1');
}

if ($_GET['pagina'] > $paginas || $_GET['pagina'] < 1){
    header('location:index.php?pagina=1');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola mundo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="contenedor">
        <h1>Paginacion</h1>

        <?php 

        $iniciar = ($_GET['pagina'] - 1) * $articulo_x_pag;

        $sql_articulos = "SELECT * FROM articulos LIMIT $iniciar,$articulo_x_pag";
        $sentencia_articulos = $pdo->prepare($sql_articulos);
        $sentencia_articulos->execute();

        $resultado_articulo = $sentencia_articulos->fetchAll();
        ?>

        <?php foreach($resultado_articulo as $articulo): ?>
        
        <div class="opciones">
            <?php echo $articulo['titulo'] ?>
        </div>

        <?php endforeach; ?>

        <div class="btn">
            <nav>
                <a 
                class="btn-mov<?php echo $_GET['pagina']<=1 ? '-disabled' : ''; ?>" 
                href="index.php?pagina=<?php echo $_GET['pagina']-1 ?>"
                >Anterior</a>

                <?php for($i=1; $i<=$paginas; $i++): ?>

                <a 
                class="btn-num<?php echo $_GET['pagina'] == $i ? '-act' : ''; ?>" 
                href="index.php?pagina=<?php echo $i ?>"
                ><?php echo $i ?></a>

                <?php endfor; ?>

                <a 
                class="btn-mov<?php echo $_GET['pagina']>=$paginas ? '-disabled' : ''; ?>" 
                href="index.php?pagina=<?php echo $_GET['pagina']+1 ?>"
                >Siguiente</a>
            </nav>
        </div>
    </main>
</body>
</html>