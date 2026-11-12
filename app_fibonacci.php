<?php
$pagina_actual = 'fibonacci';
require_once 'header.php';
require_once 'Secuencia.php';

$error = "";
$resultadoFibonacci = [];
$resultadoFactorial = null;
$numeroIngresado = "";
$operacionSeleccionada = "fibonacci";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numeroIngresado = $_POST["numero"] ?? "";
    $operacionSeleccionada = $_POST["operacion"] ?? "fibonacci";

    if ($numeroIngresado === "" || !is_numeric($numeroIngresado)) {
        $error = "Por favor, ingrese un número entero válido.";
    } else {
        $num = (int)$numeroIngresado;

        if ($num < 0) {
            $error = "El número debe ser mayor o igual a cero.";
        } elseif ($operacionSeleccionada === "factorial" && $num > 170) {
            $error = "El número ingresado supera el límite de precisión numérica para el cálculo del factorial (máximo 170).";
        } elseif ($operacionSeleccionada === "fibonacci" && ($num < 1 || $num > 100)) {
            $error = "Para la serie de Fibonacci, ingrese un número de términos entre 1 y 100.";
        } else {
            $secuencia = new Secuencia($num, $operacionSeleccionada);

            if ($operacionSeleccionada === "fibonacci") {
                $resultadoFibonacci = $secuencia->calcularFibonacci();
            } else {
                $resultadoFactorial = $secuencia->calcularFactorial();
            }
        }
    }
}
?>

<section class="contenedor-app">
    <div class="app-encabezado">
        <h2>2. Serie de Fibonacci o Factorial</h2>
        <p>Seleccione la operación deseada e ingrese un valor entero para obtener la secuencia de Fibonacci o el factorial correspondiente.</p>
    </div>

    <form action="app_fibonacci.php" method="POST">
        <div class="formulario-grupo">
            <label for="numero">Número entero:</label>
            <input type="number" id="numero" name="numero" class="formulario-control" 
                   value="<?php echo $numeroIngresado; ?>" required min="0" max="170">
        </div>

        <div class="formulario-grupo">
            <label for="operacion">Operación a realizar:</label>
            <select id="operacion" name="operacion" class="formulario-control">
                <option value="fibonacci" <?php echo ($operacionSeleccionada === 'fibonacci') ? 'selected' : ''; ?>>Serie de Fibonacci</option>
                <option value="factorial" <?php echo ($operacionSeleccionada === 'factorial') ? 'selected' : ''; ?>>Factorial</option>
            </select>
        </div>

        <button type="submit" class="boton-submit">Calcular</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($resultadoFibonacci)): ?>
        <div class="panel-resultado">
            <h4>Serie de Fibonacci</h4>
            <p class="texto-serie">
                <?php 
                $elementosTexto = [];
                foreach ($resultadoFibonacci as $val) {
                    $elementosTexto[] = (string)$val;
                }
                echo implode(", ", $elementosTexto); 
                ?>
            </p>
        </div>
    <?php endif; ?>

    <?php if ($resultadoFactorial !== null && $error === ""): ?>
        <div class="panel-resultado">
            <h4>Resultado del Factorial</h4>
            <p><strong><?php echo number_format($resultadoFactorial, 0, '', ''); ?></strong></p>
        </div>
    <?php endif; ?>
</section>