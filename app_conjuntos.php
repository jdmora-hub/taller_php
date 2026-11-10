<?php
$pagina_actual = 'conjuntos';
require_once 'header.php';
require_once 'Conjunto.php';

$error = "";
$cadenaA = "";
$cadenaB = "";
$union = null;
$interseccion = null;
$difAB = null;
$difBA = null;
$conjuntoA_limpio = [];
$conjuntoB_limpio = [];

function extraerEnteros(string $cadena): array {
    $longitud = strlen($cadena);
    $numeroActual = "";
    $numeros = [];

    for ($i = 0; $i < $longitud; $i++) {
        $char = $cadena[$i];

        if ($char === ',' || $char === ' ' || $char === "\n" || $char === "\t") {
            if ($numeroActual !== "" && is_numeric($numeroActual)) {
                array_push($numeros, (int)$numeroActual);
                $numeroActual = "";
            }
        } else {
            $numeroActual .= $char;
        }
    }

    if ($numeroActual !== "" && is_numeric($numeroActual)) {
        array_push($numeros, (int)$numeroActual);
    }

    return $numeros;
}

function formatoConjunto(array $arreglo): string {
    if (empty($arreglo)) {
        return "{ ∅ }";
    }
    return "{ " . implode(", ", $arreglo) . " }";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cadenaA = $_POST["conjunto_a"] ?? "";
    $cadenaB = $_POST["conjunto_b"] ?? "";

    $datosA = extraerEnteros($cadenaA);
    $datosB = extraerEnteros($cadenaB);

    if (empty($datosA) && empty($datosB)) {
        $error = "Debe ingresar al menos un número entero en el Conjunto A o en el Conjunto B.";
    } else {
        $objConjunto = new Conjunto($datosA, $datosB);

        $conjuntoA_limpio = $objConjunto->getConjuntoA();
        $conjuntoB_limpio = $objConjunto->getConjuntoB();

        $union = $objConjunto->calcularUnion();
        $interseccion = $objConjunto->calcularInterseccion();
        $difAB = $objConjunto->calcularDiferenciaAB();
        $difBA = $objConjunto->calcularDiferenciaBA();
    }
}
?>

<section class="contenedor-app">
    <div class="app-encabezado">
        <h2>4. Operaciones entre Conjuntos</h2>
        <p>Ingrese los elementos enteros de dos conjuntos A y B para calcular su Unión, Intersección y Diferencias</p>
    </div>

    <form action="app_conjuntos.php" method="POST">
        <div class="grid-formulario">
            <div class="formulario-grupo">
                <label for="conjunto_a">Conjunto A (enteros separados por comas o espacios):</label>
                <input type="text" id="conjunto_a" name="conjunto_a" class="formulario-control"  
                       value="<?php echo $cadenaA; ?>">
            </div>

            <div class="formulario-grupo">
                <label for="conjunto_b">Conjunto B (enteros separados por comas o espacios):</label>
                <input type="text" id="conjunto_b" name="conjunto_b" class="formulario-control" 
                       value="<?php echo $cadenaB; ?>">
            </div>
        </div>

        <button type="submit" class="boton-submit">Calcular Operaciones</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($union !== null && $error === ""): ?>
        <div class="panel-resultado">
            <h4>Conjuntos Evaluados (sin elementos repetidos):</h4>
            <p><strong>A:</strong> <?php echo formatoConjunto($conjuntoA_limpio); ?></p>
            <p><strong>B:</strong> <?php echo formatoConjunto($conjuntoB_limpio); ?></p>
            
            <hr class="separador-resultado">
            
            <h4>Resultados Operacionales:</h4>
            <p><strong>1. Unión (A ∪ B):</strong> <span class="texto-destacado"><?php echo formatoConjunto($union); ?></span></p>
            <p><strong>2. Intersección (A ∩ B):</strong> <span class="texto-destacado"><?php echo formatoConjunto($interseccion); ?></span></p>
            <p><strong>3. Diferencia (A - B):</strong> <span class="texto-destacado"><?php echo formatoConjunto($difAB); ?></span></p>
            <p><strong>4. Diferencia (B - A):</strong> <span class="texto-destacado"><?php echo formatoConjunto($difBA); ?></span></p>
        </div>
    <?php endif; ?>
</section>