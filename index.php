<?php
$pagina_actual = 'inicio';
require 'header.php';
?>

<section class="seccion-principal">
    <div class="app-encabezado">
        <h2>Aplicaciones</h2>
        <p>Seleccione una de las siguientes herramientas para ejecutar su respectiva aplicación:</p>
    </div>

    <div class="seccion-principal">
        <h3 class="seccion-titulo">Módulo 1:Cadenas y Bases</h3>
        <div class="grid-modulos">
            <article class="tarjeta-app">
                <div>
                    <h3>1. Acrónimo</h3>
                    <p>Convierte frases completas en sus acrónimos oficiales ignorando signos de puntuación y conservando las mayúsculas.</p>
                </div>
                <a href="app_acronimo.php" class="boton-enlace">Ir a Acrónimo</a>
            </article>

            <article class="tarjeta-app">
                <div>
                    <h3>2. Conversión a Binario</h3>
                    <p>Calcula la representación en código binario de cualquier número entero positivo ingresado.</p>
                </div>
                <a href="app_binario.php" class="boton-enlace">Ir a Binario</a>
            </article>
        </div>
    </div>

    <div class="seccion-principal">
        <h3 class="seccion-titulo">Módulo 2: Operaciones Matemáticas y Secuencias</h3>
        <div class="grid-modulos">
            <article class="tarjeta-app">
                <div>
                    <h3>3. Fibonacci o Factorial</h3>
                    <p>Genera la serie matemática de Fibonacci o calcula el factorial acumulado para un número dado.</p>
                </div>
                <a href="app_fibonacci.php" class="boton-enlace">Ir a Secuencias</a>
            </article>

            <article class="tarjeta-app">
                <div>
                    <h3>4. Calculadora con Historial</h3>
                    <p> operaciones aritméticas guardando el registro completo de la sesión.</p>
                </div>
                <a href="app_calculadora.php" class="boton-enlace">Ir a Calculadora</a>
            </article>
        </div>
    </div>

    <div class="seccion-principal">
        <h3 class="seccion-titulo">Módulo 3: Análisis de Datos y Estructuras</h3>
        <div class="grid-modulos">
            <article class="tarjeta-app">
                <div>
                    <h3>5. Estadística</h3>
                    <p>Cálculo de Medidas de Tendencia Central para conjuntos de datos reales.</p>
                </div>
                <a href="app_estadistica.php" class="boton-enlace">Ir a Estadística</a>
            </article>

            <article class="tarjeta-app">
                <div>
                    <h3>6. Teoría de Conjuntos</h3>
                    <p>Permite hacer la Unión, Intersección y Diferencias  entre dos conjuntos numéricos A y B.</p>
                </div>
                <a href="app_conjuntos.php" class="boton-enlace">Ir a Conjuntos</a>
            </article>
        </div>
    </div>

    <div class="seccion-principal">
        <h3 class="seccion-titulo">Módulo 4: Estructuras de Datos Avanzadas</h3>
        <div class="grid-modulos">
            <article class="tarjeta-app">
                <div>
                    <h3>7. Reconstrucción de Árbol Binario</h3>
                    <p>Construye y grafica en texto un Árbol Binario procesando sus recorridos en Preorden, Inorden y Postorden.</p>
                </div>
                <a href="app_arbol.php" class="boton-enlace">Ir a Árbol Binario</a>
            </article>
        </div>
    </div>
</section>
