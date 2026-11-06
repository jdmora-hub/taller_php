<?php
$pagina_actual = 'arbol';
require_once 'header.php';
require_once 'ArbolBinario.php';

$error = "";
$cadenaPre = "";
$cadenaIn = "";
$cadenaPost = "";
$arbolRenderizado = "";
$advertencia = "";

function parsearRecorrido(string $cadena): array {
    $longitud = strlen($cadena);
    $elementoActual = "";
    $elementos = [];

    for ($i = 0; $i < $longitud; $i++) {
        $char = $cadena[$i];
        if ($char === ',' || $char === ' ' || $char === "\n" || $char === "\t") {
            if ($elementoActual !== "") {
                array_push($elementos, $elementoActual);
                $elementoActual = "";
            }
        } else {
            $elementoActual .= $char;
        }
    }

    if ($elementoActual !== "") {
        array_push($elementos, $elementoActual);
    }

    return $elementos;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cadenaPre = $_POST["preorden"] ?? "";
    $cadenaIn = $_POST["inorden"] ?? "";
    $cadenaPost = $_POST["postorden"] ?? "";

    $arrPre = parsearRecorrido($cadenaPre);
    $arrIn = parsearRecorrido($cadenaIn);
    $arrPost = parsearRecorrido($cadenaPost);

    $conteoRecorridos = 0;
    if (!empty($arrPre)) $conteoRecorridos++;
    if (!empty($arrIn)) $conteoRecorridos++;
    if (!empty($arrPost)) $conteoRecorridos++;

    if ($conteoRecorridos < 2) {
        $error = "Debe ingresar como mínimo dos recorridos para poder construir el Árbol Binario.";
    } else {
        $arbol = new ArbolBinario($arrPre, $arrIn, $arrPost);
        $exito = $arbol->reconstruirArbol();

        if (!$exito) {
            $error = "No se pudo construir el árbol, verifique que los elementos ingresados en los recorridos sean consistentes.";
        } else {
            $arbolRenderizado = $arbol->imprimirEstructura();
            $advertencia = $arbol->getAdvertenciaAmbiguedad();
        }
    }
}
?>

<section class="contenedor-app">
    <div class="app-encabezado">
        <h2>6. Reconstrucción de Árbol Binario</h2>
        <p>Ingrese al menos dos recorridos para generar la estructura jerárquica del Árbol Binario.</p>
    </div>

    <div style="background-color: #fffbeeb; border-left: 4px solid #f59e0b; padding: 12px; margin-bottom: 20px; font-size: 14px; color: #7da0e1;">
        Nota: Para reconstruir de forma única un árbol binario es importante incluir el recorrido Inorden
    </div>

    <form action="app_arbol.php" method="POST">
        <div class="formulario-grupo">
            <label for="preorden">Recorrido Preorden:</label>
            <input type="text" id="preorden" name="preorden" class="formulario-control" 
                   placeholder="Ejemplo: A, B, D, E, C" value="<?php echo htmlspecialchars($cadenaPre); ?>">
        </div>

        <div class="formulario-grupo">
            <label for="inorden">Recorrido Inorden:</label>
            <input type="text" id="inorden" name="inorden" class="formulario-control" 
                   placeholder="Ejemplo: D, B, E, A, C" value="<?php echo htmlspecialchars($cadenaIn); ?>">
        </div>

        <div class="formulario-grupo">
            <label for="postorden">Recorrido Postorden:</label>
            <input type="text" id="postorden" name="postorden" class="formulario-control" 
                   placeholder="Ejemplo: D, E, B, C, A" value="<?php echo htmlspecialchars($cadenaPost); ?>">
        </div>

        <button type="submit" class="boton-submit">Reconstruir Árbol</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($advertencia !== ""): ?>
        <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px; margin-top: 15px; font-size: 14px; color: #92400e;">
            <p><strong>Aviso:</strong> <?php echo htmlspecialchars($advertencia); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($arbolRenderizado !== "" && $error === ""): ?>
        <div class="panel-resultado">
            <h4>Estructura del Árbol Binario Reconstruido:</h4>
            <pre style="background-color: #0646ae; color: #38bdf8; padding: 15px; border-radius: 4px; font-family: monospace; font-size: 15px; overflow-x: auto;"><?php echo htmlspecialchars($arbolRenderizado); ?></pre>
        </div>
    <?php endif; ?>
</section>
