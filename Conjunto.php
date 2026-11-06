<?php
class Conjunto {
    private array $conjuntoA;
    private array $conjuntoB;

    public function __construct(array $a = [], array $b = []) {
        $this->conjuntoA = $this->eliminarDuplicados($a);
        $this->conjuntoB = $this->eliminarDuplicados($b);
    }

    public function getConjuntoA(): array {
        return $this->conjuntoA;
    }

    public function setConjuntoA(array $a): void {
        $this->conjuntoA = $this->eliminarDuplicados($a);
    }

    public function getConjuntoB(): array {
        return $this->conjuntoB;
    }

    public function setConjuntoB(array $b): void {
        $this->conjuntoB = $this->eliminarDuplicados($b);
    }

    private function existeEnArreglo($valor, array $arreglo): bool {
        foreach ($arreglo as $item) {
            if ($item === $valor) {
                return true;
            }
        }
        return false;
    }

    private function eliminarDuplicados(array $arreglo): array {
        $resultado = [];
        foreach ($arreglo as $item) {
            if (!$this->existeEnArreglo($item, $resultado)) {
                array_push($resultado, $item);
            }
        }
        return $resultado;
    }

    public function calcularUnion(): array {
        $union = $this->conjuntoA;

        foreach ($this->conjuntoB as $item) {
            if (!$this->existeEnArreglo($item, $union)) {
                array_push($union, $item);
            }
        }

        return $union;
    }

    public function calcularInterseccion(): array {
        $interseccion = [];

        foreach ($this->conjuntoA as $item) {
            if ($this->existeEnArreglo($item, $this->conjuntoB)) {
                array_push($interseccion, $item);
            }
        }

        return $interseccion;
    }

    public function calcularDiferenciaAB(): array {
        $diferencia = [];

        foreach ($this->conjuntoA as $item) {
            if (!$this->existeEnArreglo($item, $this->conjuntoB)) {
                array_push($diferencia, $item);
            }
        }

        return $diferencia;
    }

    public function calcularDiferenciaBA(): array {
        $diferencia = [];

        foreach ($this->conjuntoB as $item) {
            if (!$this->existeEnArreglo($item, $this->conjuntoA)) {
                array_push($diferencia, $item);
            }
        }

        return $diferencia;
    }
}