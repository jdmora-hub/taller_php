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
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="formulario-grupo">
                <label for="conjunto_a">Conjunto A (enteros separados por comas o espacios):</label>
                <input type="text" id="conjunto_a" name="conjunto_a" class="formulario-control" 
                       placeholder="Ejemplo: 1, 2, 3, 4, 5" 
                       value="<?php echo htmlspecialchars($cadenaA); ?>">
            </div>

            <div class="formulario-grupo">
                <label for="conjunto_b">Conjunto B (enteros separados por comas o espacios):</label>
                <input type="text" id="conjunto_b" name="conjunto_b" class="formulario-control" 
                       placeholder="Ejemplo: 4, 5, 6, 7, 8" 
                       value="<?php echo htmlspecialchars($cadenaB); ?>">
            </div>
        </div>

        <button type="submit" class="boton-submit" style="margin-top: 10px;">Calcular Operaciones</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($union !== null && $error === ""): ?>
        <div class="panel-resultado">
            <h4>Conjuntos Evaluados (sin elementos repetidos):</h4>
            <p><strong>A:</strong> <?php echo htmlspecialchars(formatoConjunto($conjuntoA_limpio)); ?></p>
            <p><strong>B:</strong> <?php echo htmlspecialchars(formatoConjunto($conjuntoB_limpio)); ?></p>
            
            <hr style="margin: 15px 0; border: 0; border-top: 1px solid #cbd5e1;">
            
            <h4>Resultados Operacionales:</h4>
            <p><strong>1. Unión (A u B):</strong> <span style="color: #2563eb; font-weight: bold;"><?php echo htmlspecialchars(formatoConjunto($union)); ?></span></p>
            <p><strong>2. Intersección (A \ B):</strong> <span style="color: #2563eb; font-weight: bold;"><?php echo htmlspecialchars(formatoConjunto($interseccion)); ?></span></p>
            <p><strong>3. Diferencia (A - B):</strong> <span style="color: #2563eb; font-weight: bold;"><?php echo htmlspecialchars(formatoConjunto($difAB)); ?></span></p>
            <p><strong>4. Diferencia (B - A):</strong> <span style="color: #2563eb; font-weight: bold;"><?php echo htmlspecialchars(formatoConjunto($difBA)); ?></span></p>
        </div>
    <?php endif; ?>
</section>
