<?php
$pagina_actual = 'acronimo';
require_once 'header.php';
require_once 'Acronimo.php';

$resultado = "";
$error = "";
$textoIngresado = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $textoIngresado = $_POST["frase"] ?? "";

    if (trim($textoIngresado) === "") {
        $error = "Por favor, ingrese una frase o texto para generar el acrónimo.";
    } else {
        $procesadorAcronimo = new Acronimo($textoIngresado);
        $resultado = $procesadorAcronimo->generarAcronimo();

        if ($resultado === "") {
            $error = "El texto ingresado no contiene letras ni números válidos para generar un acrónimo.";
        }
    }
}
?>

<section class="contenedor-app">
    <div class="app-encabezado">
        <h2>1. Generador de Acrónimos</h2>
        <p>Ingrese una frase para generar su acrónimo.</p>
    </div>

    <form action="app_acronimo.php" method="POST">
        <div class="formulario-grupo">
            <label for="frase">Frase o Nombre Completo:</label>
            <input type="text" id="frase" name="frase" class="formulario-control" 
                   value="<?php echo $textoIngresado; ?>" required>
        </div>

        <button type="submit" class="boton-submit">Generar Acrónimo</button>
    </form>

    <?php if ($error !== ""): ?>
        <div class="mensaje-error">
            <p><strong>Error:</strong> <?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($resultado !== "" && $error === ""): ?>
        <div class="panel-resultado">
            <h4>Resultado Obtenido:</h4>
            <p><strong>Frase original:</strong> <?php echo $textoIngresado; ?></p>
            <p><strong>Acrónimo generado:</strong> <?php echo $resultado; ?></p>
        </div>
    <?php endif; ?>
</section>