<?php
class Calculadora {
    private float $operando1;
    private float $operando2;
    private string $operacion;

    public function __construct(float $op1 = 0.0, float $op2 = 0.0, string $operacion = "+") {
        $this->operando1 = $op1;
        $this->operando2 = $op2;
        $this->operacion = $operacion;
    }

    public function getOperando1(): float {
        return $this->operando1;
    }

    public function setOperando1(float $op1): void {
        $this->operando1 = $op1;
    }

    public function getOperando2(): float {
        return $this->operando2;
    }

    public function setOperando2(float $op2): void {
        $this->operando2 = $op2;
    }

    public function getOperacion(): string {
        return $this->operacion;
    }

    public function setOperacion(string $operacion): void {
        $this->operacion = $operacion;
    }

    public function calcular(): float {
        switch ($this->operacion) {
            case '+':
                return $this->operando1 + $this->operando2;

            case '-':
                return $this->operando1 - $this->operando2;

            case '*':
                return $this->operando1 * $this->operando2;

            case '/':
                if ($this->operando2 == 0.0) {
                    throw new Exception("No es posible dividir entre cero.");
                }
                return $this->operando1 / $this->operando2;

            case '%':
                return ($this->operando1 * $this->operando2) / 100.0;

            default:
                throw new Exception("Operación no válida.");
        }
    }

    public function obtenerRepresentacionTexto(float $resultado): string {
        $simbolo = $this->operacion;
        if ($simbolo === '%') {
            return "{$this->operando2}% de {$this->operando1} = " . round($resultado, 4);
        }
        return "{$this->operando1} {$simbolo} {$this->operando2} = " . round($resultado, 4);
    }
}