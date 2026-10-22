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
    <title>Taller php</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="componentes.css">
</head>
<body>

    <header>
        <h1>Taller de Php</h1>
        <p>Juan David Mora</p>
        
        <?php if ($pagina_actual !== 'inicio'): ?>
        
        <?php endif; ?>
    </header>
    <p style="text-align: center; margin-top: 10px;">
       <a href="index.php" class="boton-enlace" style="padding: 5px 10px; font-size: 13px;">Menú Principal</a>
    </p>

    <main>