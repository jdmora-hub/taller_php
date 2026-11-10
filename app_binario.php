<?php
$pagina_actual = 'binario';
require_once 'header.php';
require_once 'Conversor.php';

$error = "";
$resultadoBinario = "";
$numeroIngresado = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numeroIngresado = $_POST["numero_decimal"] ?? "";

    if ($numeroIngresado === "" || !is_numeric($numeroIngresado)) {
        $error = "Por favor, ingrese un número entero válido.";
    } else {
        $num = (int)$numeroIngresado;

        if ($num < 0) {
            $error = "El conversor solo acepta números enteros mayores o iguales a cero (enteros no negativos).";
        } else {
            $conversor = new Conversor($num);
            $resultadoBinario = $conversor->convertirABinario();
        }
    }
}
?>

<section class="contenedor-app">
    <div class="app-encabezado">
        <h2>5. Conversión a Binario</h2>
        <p>Ingrese un número entero positivo para pasarlo a binario.</p>
    </div>

    <form action="app_binario.php" method="POST">
        <div class="formulario-grupo">
            <label for="numero_decimal">Número decimal</label>
            <input type="number" id="numero_decimal" name="numero_decimal" class="formulario-control" 
                   value="<?php echo $numeroIngresado; ?>" required min="0">
        </div>

        <button type="submit" class="boton-submit">Convertir a Binario</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($resultadoBinario !== "" && $error === ""): ?>
        <div class="panel-resultado">
            <h4>Resultado de la Conversión:</h4>
            <p><strong>Número Decimal:</strong> <?php echo (int)$numeroIngresado; ?></p>
            <p><strong>Representación Binaria :</strong><?php echo $resultadoBinario; ?><sub>2</sub></p>
        </div>
    <?php endif; ?>
</section>
