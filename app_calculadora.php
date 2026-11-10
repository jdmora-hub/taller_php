<?php
session_start();

$pagina_actual = 'calculadora';
require_once 'header.php';
require_once 'Calculadora.php';

if (empty($_SESSION["historial_calculadora"])) {
    $_SESSION["historial_calculadora"] = [];
}

$error = "";
$resultado = null;
$op1 = "";
$op2 = "";
$operacion = "+";

if (isset($_POST["limpiar_historial"])) {
    $_SESSION["historial_calculadora"] = [];
    header("Location: app_calculadora.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["calcular"])) {
    $op1 = $_POST["operando1"] ?? "";
    $op2 = $_POST["operando2"] ?? "";
    $operacion = $_POST["operacion"] ?? "+";

    if ($op1 === "" || !is_numeric($op1) || $op2 === "" || !is_numeric($op2)) {
        $error = "Por favor, ingrese números válidos.";
    } else {
        $v1 = (float)$op1;
        $v2 = (float)$op2;

        try {
            $calc = new Calculadora($v1, $v2, $operacion);
            $resultado = $calc->calcular();
            $registroTexto = $calc->obtenerRepresentacionTexto($resultado);

            array_push($_SESSION["historial_calculadora"], $registroTexto);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<section class="contenedor-app contenedor-calculadora">
    <div class="app-encabezado">
        <h2>7. Calculadora</h2>
        <p>Realice operaciones aritméticas básicas.</p>
    </div>

    <form action="app_calculadora.php" method="POST">
        <div class="formulario-grupo">
            <label for="operando1">Primer Número:</label>
            <input type="number" step="any" id="operando1" name="operando1" class="formulario-control" 
                   value="<?php echo $op1; ?>" required>
        </div>

        <div class="formulario-grupo">
            <label for="operacion">Operación:</label>
            <select id="operacion" name="operacion" class="formulario-control">
                <option value="+" <?php echo ($operacion === '+') ? 'selected' : ''; ?>>Suma </option>
                <option value="-" <?php echo ($operacion === '-') ? 'selected' : ''; ?>>Resta </option>
                <option value="*" <?php echo ($operacion === '*') ? 'selected' : ''; ?>>Multiplicación </option>
                <option value="/" <?php echo ($operacion === '/') ? 'selected' : ''; ?>>División </option>
                <option value="%" <?php echo ($operacion === '%') ? 'selected' : ''; ?>>Porcentaje </option>
            </select>
        </div>

        <div class="formulario-grupo">
            <label for="operando2">Segundo Número:</label>
            <input type="number" step="any" id="operando2" name="operando2" class="formulario-control" 
                   value="<?php echo $op2; ?>" required>
        </div>

        <button type="submit" name="calcular" class="boton-submit">Calcular</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($resultado !== null && $error === ""): ?>
        <div class="panel-resultado">
            <p><strong>Resultado:</strong> <?php echo round($resultado, 4); ?></p>
        </div>
    <?php endif; ?>

    <div class="seccion-historial">
        <h3>Historial de Operaciones</h3>
        
        <div class="caja-historial">
            <?php if (empty($_SESSION["historial_calculadora"])): ?>
                <p class="historial-vacio">El historial está vacío.</p>
            <?php else: ?>
                <ul class="lista-historial">
                    <?php foreach ($_SESSION["historial_calculadora"] as $item): ?>
                        <li>
                            <?php 
                            if (is_array($item)) {
                                echo $item['expresion'] ?? '';
                            } else {
                                echo $item;
                            }
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php if (!empty($_SESSION["historial_calculadora"])): ?>
            <form action="app_calculadora.php" method="POST">
                <button type="submit" name="limpiar_historial" class="boton-limpiar">Borrar Historial</button>
            </form>
        <?php endif; ?>
    </div>
</section>
