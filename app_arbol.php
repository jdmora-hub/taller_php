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

    <form action="app_arbol.php" method="POST">
        <div class="formulario-grupo">
            <label for="preorden">Recorrido Preorden:</label>
            <input type="text" id="preorden" name="preorden" class="formulario-control" 
                   value="<?php echo $cadenaPre; ?>">
        </div>

        <div class="formulario-grupo">
            <label for="inorden">Recorrido Inorden:</label>
            <input type="text" id="inorden" name="inorden" class="formulario-control" 
                   value="<?php echo $cadenaIn; ?>">
        </div>

        <div class="formulario-grupo">
            <label for="postorden">Recorrido Postorden:</label>
            <input type="text" id="postorden" name="postorden" class="formulario-control" 
                   value="<?php echo $cadenaPost; ?>">
        </div>

        <button type="submit" class="boton-submit">Reconstruir Árbol</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($advertencia !== ""): ?>
        <div class="mensaje-advertencia">
            <p><strong>Aviso:</strong> <?php echo $advertencia; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($arbolRenderizado !== "" && $error === ""): ?>
        <div class="panel-resultado">
            <h4>Estructura del Árbol Binario Reconstruido:</h4>
            <pre class="codigo-arbol"><?php echo $arbolRenderizado; ?></pre>
        </div>
    <?php endif; ?>
</section>