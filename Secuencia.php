<?php
class Secuencia {
    private int $numero;
    private string $operacion;

    public function __construct(int $numero = 0, string $operacion = "fibonacci") {
        $this->numero = $numero;
        $this->operacion = $operacion;
    }

    // Getters y Setters
    public function getNumero(): int {
        return $this->numero;
    }

    public function setNumero(int $numero): void {
        $this->numero = $numero;
    }

    public function getOperacion(): string {
        return $this->operacion;
    }

    public function setOperacion(string $operacion): void {
        $this->operacion = $operacion;
    }

    /**
     * Genera un arreglo con la serie de Fibonacci hasta 'n' términos.
     * Ejemplo para n = 5: [0, 1, 1, 2, 3]
     */
    public function calcularFibonacci(): array {
        $n = $this->numero;
        
        if ($n <= 0) {
            return [];
        }

        if ($n === 1) {
            return [0];
        }

        $serie = [0, 1];

        for ($i = 2; $i < $n; $i++) {
            $siguiente = $serie[$i - 1] + $serie[$i - 2];
            array_push($serie, $siguiente);
        }

        return $serie;
    }

    /**
     * Calcula el Factorial de 'n' (n!).
     * Ejemplo para n = 5: 5 * 4 * 3 * 2 * 1 = 120
     */
    public function calcularFactorial(): float {
        $n = $this->numero;

        if ($n < 0) {
            return -1; // Indicar error para números negativos
        }

        if ($n === 0 || $n === 1) {
            return 1;
        }

        $resultado = 1.0;

        for ($i = 2; $i <= $n; $i++) {
            $resultado *= $i;
        }

        return $resultado;
    }
}