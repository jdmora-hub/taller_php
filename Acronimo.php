<?php
class Acronimo {
    private string $textoOriginal;

    public function __construct(string $texto = "") {
        $this->textoOriginal = $texto;
    }

    public function getTextoOriginal(): string {
        return $this->textoOriginal;
    }

    public function setTextoOriginal(string $texto): void {
        $this->textoOriginal = $texto;
    }

    public function generarAcronimo(): string {
        $texto = $this->textoOriginal;
        $longitud = strlen($texto);
        
        if ($longitud === 0) {
            return "";
        }

        $acronimo = "";
        $nuevaPalabra = true; 

        for ($i = 0; $i < $longitud; $i++) {
            $caracter = $texto[$i];

            if ($caracter === ' ' || $caracter === '-') {
                $nuevaPalabra = true;
                continue;
            }

            if ($this->esAlfanumerico($caracter)) {
                if ($nuevaPalabra) {
                    $acronimo .= $this->convertirAMayuscula($caracter);
                    $nuevaPalabra = false;
                }
            }
        }

        return $acronimo;
    }

    private function esAlfanumerico(string $char): bool {
        $ord = ord($char);
        return ($ord >= 65 && $ord <= 90) || 
               ($ord >= 97 && $ord <= 122) || 
               ($ord >= 48 && $ord <= 57);
    }

    private function convertirAMayuscula(string $char): string {
        $ord = ord($char);
        if ($ord >= 97 && $ord <= 122) {
            return chr($ord - 32);
        }
        return $char;
    }
}