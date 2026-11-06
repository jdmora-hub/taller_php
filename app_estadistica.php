<?php
$pagina_actual = 'estadistica';
require_once 'header.php';
require_once 'Estadistica.php';

$error = "";
$cadenaNumeros = "";
$promedio = null;
$mediana = null;
$modas = [];
$datosProcesados = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cadenaNumeros = $_POST["numeros"] ?? "";

    if (trim($cadenaNumeros) === "") {
        $error = "Por favor, ingrese al menos un número real.";
    } else {
        $longitud = strlen($cadenaNumeros);
        $numeroActual = "";
        $datos = [];

        for ($i = 0; $i < $longitud; $i++) {
            $char = $cadenaNumeros[$i];
            if ($char === ',' || $char === ' ' || $char === "\n" || $char === "\t") {
                if ($numeroActual !== "" && is_numeric($numeroActual)) {
                    array_push($datos, (float)$numeroActual);
                    $numeroActual = "";
                }
            } else {
                $numeroActual .= $char;
            }
        }

        if ($numeroActual !== "" && is_numeric($numeroActual)) {
            array_push($datos, (float)$numeroActual);
        }

        if (count($datos) === 0) {
            $error = "No se detectaron valores numéricos válidos. Asegúrese de separarlos por comas o espacios.";
        } else {
            $datosProcesados = $datos;
            $estadistica = new Estadistica($datos);

            $promedio = $estadistica->calcularPromedio();
            $mediana = $estadistica->calcularMediana();
            $modas = $estadistica->calcularModa();
        }
    }
}
?>

<section class="contenedor-app">
    <div class="app-encabezado">
        <h2>3. Medidas Estadísticas</h2>
        <p>Ingrese un conjunto de números reales separados por comas o espacios para calcular sus medidas de tendencia central.</p>
    </div>

    <form action="app_estadistica.php" method="POST">
        <div class="formulario-grupo">
            <label for="numeros">Valores numéricos:</label>

            <textarea id="numeros" name="numeros" class="formulario-control" rows="4" 
                      placeholder="Ejemplo: 4.5, 8.0, 3.2, 8.0, 10.5, 2.1" required><?php echo htmlspecialchars($cadenaNumeros); ?></textarea>
        </div>

        <button type="submit" class="boton-submit">Calcular Estadísticas</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($promedio !== null && $error === ""): ?>
        <div class="panel-resultado">
            <h4>Resultados del Análisis Estadístico:</h4>
            <p><strong>Total de datos procesados:</strong> <?php echo count($datosProcesados); ?></p>
            <p><strong>Datos ingresados:</strong> <?php echo htmlspecialchars(implode(", ", $datosProcesados)); ?></p>
            <hr style="margin: 10px 0; border: 0; border-top: 1px solid #cbd5e1;">
            
            <p><strong>1. Promedio / Media Aritmética:</strong> <span style="color: #2563eb; font-weight: bold;"><?php echo number_format($promedio, 2); ?></span></p>
            
            <p><strong>2. Mediana:</strong> <span style="color: #2563eb; font-weight: bold;"><?php echo number_format($mediana, 2); ?></span></p>
            
            <p><strong>3. Moda:</strong> 
                <span style="color: #2563eb; font-weight: bold;">
                    <?php 
                    if (empty($modas)) {
                        echo "Amodal (no hay valores repetidos)";
                    } else {
                        echo htmlspecialchars(implode(", ", $modas));
                    }
                    ?>
                </span>
            </p>
        </div>
    <?php endif; ?>
</section>
