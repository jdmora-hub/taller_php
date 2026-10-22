<?php
class Conversor {
    private int $numeroDecimal;

    public function __construct(int $numeroDecimal = 0) {
        $this->numeroDecimal = $numeroDecimal;
    }

    public function getNumeroDecimal(): int {
        return $this->numeroDecimal;
    }

    public function setNumeroDecimal(int $numeroDecimal): void {
        $this->numeroDecimal = $numeroDecimal;
    }

    /**
     * Convierte el número decimal a binario mediante divisiones sucesivas entre 2.
     * No utiliza decbin().
     */
    public function convertirABinario(): string {
        $numero = $this->numeroDecimal;

        if ($numero === 0) {
            return "0";
        }

        $residuos = [];

        while ($numero > 0) {
            $residuo = $numero % 2;
            array_push($residuos, $residuo);
            $numero = (int)($numero / 2);
        }

        // Invertir el arreglo de residuos manualmente para construir el número binario
        $binario = "";
        $totalResiduos = count($residuos);

        for ($i = $totalResiduos - 1; $i >= 0; $i--) {
            $binario .= $residuos[$i];
        }

        return $binario;
    }

    /**
     * Genera un arreglo con el paso a paso del procedimiento de conversión
     * para facilitar la explicación académica en la sustentación.
     */
    public function obtenerPasoAPaso(): array {
        $numero = $this->numeroDecimal;
        $pasos = [];

        if ($numero === 0) {
            return [
                [
                    'cociente' => 0,
                    'dividendo' => 0,
                    'residuo' => 0
                ]
            ];
        }

        while ($numero > 0) {
            $cociente = (int)($numero / 2);
            $residuo = $numero % 2;

            array_push($pasos, [
                'dividendo' => $numero,
                'cociente' => $cociente,
                'residuo' => $residuo
            ]);

            $numero = $cociente;
        }

        return $pasos;
    }
}