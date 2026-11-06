<?php
$pagina_actual = 'calculadora';
require_once 'header.php';
require_once 'Calculadora.php';

$error = "";
$resultado = null;
$op1 = "";
$op2 = "";
$operacion = "+";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["calcular"])) {
    $op1 = $_POST["operando1"] ?? "";
    $op2 = $_POST["operando2"] ?? "";
    $operacion = $_POST["operacion"] ?? "+";

    if ($op1 === "" || !is_numeric($op1) || $op2 === "" || !is_numeric($op2)) {
        $error = "Por favor, ingrese valores numéricos válidos en ambos campos de entrada.";
    } else {
        $v1 = (float)$op1;
        $v2 = (float)$op2;

        try {
            $calc = new Calculadora($v1, $v2, $operacion);
            $resultado = $calc->calcular();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<section class="contenedor-app">
    <div class="app-encabezado">
        <h2>7. Calculadora</h2>
        <p>Realice operaciones aritméticas de suma, resta, multiplicación, división o porcentaje.</p>
    </div>

    <form action="app_calculadora.php" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; align-items: end;">
            <div class="formulario-grupo">
                <label for="operando1">Primer Número:</label>
                <input type="number" step="any" id="operando1" name="operando1" class="formulario-control" 
                       placeholder="Ej: 15.5" value="<?php echo htmlspecialchars((string)$op1); ?>" required>
            </div>

            <div class="formulario-grupo">
                <label for="operacion">Operación:</label>
                <select id="operacion" name="operacion" class="formulario-control">
                    <option value="+" <?php echo ($operacion === '+') ? 'selected' : ''; ?>>Suma (+)</option>
                    <option value="-" <?php echo ($operacion === '-') ? 'selected' : ''; ?>>Resta (-)</option>
                    <option value="*" <?php echo ($operacion === '*') ? 'selected' : ''; ?>>Multiplicación (*)</option>
                    <option value="/" <?php echo ($operacion === '/') ? 'selected' : ''; ?>>División (/)</option>
                    <option value="%" <?php echo ($operacion === '%') ? 'selected' : ''; ?>>Porcentaje (%)</option>
                </select>
            </div>

            <div class="formulario-grupo">
                <label for="operando2">Segundo Número:</label>
                <input type="number" step="any" id="operando2" name="operando2" class="formulario-control" 
                       placeholder="Ej: 4.2" value="<?php echo htmlspecialchars((string)$op2); ?>" required>
            </div>
        </div>

        <button type="submit" name="calcular" class="boton-submit" style="margin-top: 15px;">Calcular Operación</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($resultado !== null && $error === ""): ?>
        <div class="panel-resultado">
            <h4>Resultado Obtenido:</h4>
            <p style="font-size: 22px; color: #2563eb; font-weight: bold;">
                <?php echo htmlspecialchars((string)round($resultado, 4)); ?>
            </p>
        </div>
    <?php endif; ?>
</section>
