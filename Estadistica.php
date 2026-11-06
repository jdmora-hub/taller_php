<?php
class Estadistica {
    private array $datos;

    public function __construct(array $datos = []) {
        $this->datos = $datos;
    }

    public function getDatos(): array {
        return $this->datos;
    }

    public function setDatos(array $datos): void {
        $this->datos = $datos;
    }

    public function calcularPromedio(): float {
        $cantidad = count($this->datos);
        if ($cantidad === 0) {
            return 0.0;
        }

        $suma = 0.0;
        foreach ($this->datos as $valor) {
            $suma += (float)$valor;
        }

        return $suma / $cantidad;
    }

    public function obtenerDatosOrdenados(): array {
        $arreglo = $this->datos;
        $n = count($arreglo);

        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arreglo[$j] > $arreglo[$j + 1]) {
                    $temporal = $arreglo[$j];
                    $arreglo[$j] = $arreglo[$j + 1];
                    $arreglo[$j + 1] = $temporal;
                }
            }
        }

        return $arreglo;
    }

    public function calcularMediana(): float {
        $arreglo = $this->obtenerDatosOrdenados();
        $n = count($arreglo);

        if ($n === 0) {
            return 0.0;
        }
        if ($n % 2 !== 0) {
            $posicionCentral = (int)($n / 2);
            return (float)$arreglo[$posicionCentral];
        } else {
            $pos1 = ($n / 2) - 1;
            $pos2 = $n / 2;
            return ((float)$arreglo[$pos1] + (float)$arreglo[$pos2]) / 2.0;
        }
    }

    public function calcularModa(): array {
        $n = count($this->datos);
        if ($n === 0) {
            return [];
        }

        $frecuencias = [];
        foreach ($this->datos as $valor) {
            $clave = (string)$valor;
            $encontrado = false;

            foreach ($frecuencias as $k => $item) {
                if ($item['valor'] == $valor) {
                    $frecuencias[$k]['conteo']++;
                    $encontrado = true;
                    break;
                }
            }

            if (!$encontrado) {
                array_push($frecuencias, [
                    'valor' => $valor,
                    'conteo' => 1
                ]);
            }
        }

        $maxFrecuencia = 0;
        foreach ($frecuencias as $item) {
            if ($item['conteo'] > $maxFrecuencia) {
                $maxFrecuencia = $item['conteo'];
            }
        }

        if ($maxFrecuencia <= 1) {
            return [];
        }

        $modas = [];
        foreach ($frecuencias as $item) {
            if ($item['conteo'] === $maxFrecuencia) {
                array_push($modas, $item['valor']);
            }
        }

        return $modas;
    }
}