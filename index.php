<?php
$pagina_actual = 'inicio';
require_once 'header.php';
?>

<section class="contenedor-app contenedor-menu-inicio">
    <div class="app-encabezado">
        <h2>Menú de Aplicaciones</h2>
        <p class="subtitulo-menu">Seleccione una opción para ingresar:</p>
    </div>

    <div class="lista-aplicaciones">
        
        <div class="tarjeta-opcion">
            <h3>1. Acrónimo</h3>
            <a href="app_acronimo.php" class="boton-enlace">Ir a Acrónimo</a>
        </div>

        <div class="tarjeta-opcion">
            <h3>2. Fibonacci / Factorial</h3>
            <a href="app_fibonacci.php" class="boton-enlace">Ir a Secuencias</a>
        </div>

        <div class="tarjeta-opcion">
            <h3>3. Estadística</h3>
            <a href="app_estadistica.php" class="boton-enlace">Ir a Estadística</a>
        </div>

        <div class="tarjeta-opcion">
            <h3>4. Conjuntos</h3>
            <a href="app_conjuntos.php" class="boton-enlace">Ir a Conjuntos</a>
        </div>

        <div class="tarjeta-opcion">
            <h3>5. Binario</h3>
            <a href="app_binario.php" class="boton-enlace">Ir a Binario</a>
        </div>

        <div class="tarjeta-opcion">
            <h3>6. Árbol Binario</h3>
            <a href="app_arbol.php" class="boton-enlace">Ir a Árbol Binario</a>
        </div>

        <div class="tarjeta-opcion">
            <h3>7. Calculadora</h3>
            <a href="app_calculadora.php" class="boton-enlace">Ir a Calculadora</a>
        </div>

    </div>
</section>
