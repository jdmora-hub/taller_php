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

        $binario = "";
        $totalResiduos = count($residuos);

        for ($i = $totalResiduos - 1; $i >= 0; $i--) {
            $binario .= $residuos[$i];
        }

        return $binario;
    }
}