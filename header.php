<?php
if (!isset($pagina_actual)) {
    $pagina_actual = 'inicio';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Web - POO e Ingeniería de Sistemas</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="componentes.css">
</head>
<body>
    <?php if ($pagina_actual !== 'inicio'): ?>
        <div class="contenedor-volver">
            <a href="index.php" class="boton-volver"> Volver al Menú Principal</a>
        </div>
    <?php endif; ?>

    <main>