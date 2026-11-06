<?php
class NodoArbol {
    public string $valor;
    public ?NodoArbol $izquierdo;
    public ?NodoArbol $derecho;

    public function __construct(string $valor) {
        $this->valor = $valor;
        $this->izquierdo = null;
        $this->derecho = null;
    }
}