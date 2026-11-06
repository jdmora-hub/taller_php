<?php
require_once 'NodoArbol.php';
class ArbolBinario {
    private ?NodoArbol $raiz;
    private array $preorden;
    private array $inorden;
    private array $postorden;
    private string $advertenciaAmbiguedad;

    public function __construct(array $preorden = [], array $inorden = [], array $postorden = []) {
        $this->raiz = null;
        $this->preorden = $preorden;
        $this->inorden = $inorden;
        $this->postorden = $postorden;
        $this->advertenciaAmbiguedad = "";
    }

    public function getAdvertenciaAmbiguedad(): string {
        return $this->advertenciaAmbiguedad;
    }

    public function reconstruirArbol(): bool {
        $tienePre = !empty($this->preorden);
        $tieneIn = !empty($this->inorden);
        $tienePost = !empty($this->postorden);

        if ($tienePre && $tieneIn && $tienePost) {
            $this->raiz = $this->construirDesdePreordenInorden($this->preorden, $this->inorden);
            return true;
        }

        if ($tienePre && $tieneIn) {
            $this->raiz = $this->construirDesdePreordenInorden($this->preorden, $this->inorden);
            return true;
        }

        if ($tieneIn && $tienePost) {
            $this->raiz = $this->construirDesdeInordenPostorden($this->inorden, $this->postorden);
            return true;
        }

        if ($tienePre && $tienePost && !$tieneIn) {
            $this->advertenciaAmbiguedad = "Atención: La combinación Preorden + Postorden no garantiza un árbol binario único a menos que sea un árbol estrictamente lleno. Se construirá una representación asumida.";
            $this->raiz = $this->construirDesdePreordenPostorden($this->preorden, $this->postorden);
            return true;
        }

        return false;
    }

    private function construirDesdePreordenInorden(array $pre, array $in): ?NodoArbol {
        if (empty($pre) || empty($in)) {
            return null;
        }

        $raizValor = $pre[0];
        $nodoRaiz = new NodoArbol($raizValor);

        $indiceRaiz = -1;
        $totalIn = count($in);
        for ($i = 0; $i < $totalIn; $i++) {
            if ($in[$i] === $raizValor) {
                $indiceRaiz = $i;
                break;
            }
        }

        if ($indiceRaiz === -1) {
            return null;
        }

        $inIzquierdo = [];
        for ($i = 0; $i < $indiceRaiz; $i++) {
            array_push($inIzquierdo, $in[$i]);
        }

        $inDerecho = [];
        for ($i = $indiceRaiz + 1; $i < $totalIn; $i++) {
            array_push($inDerecho, $in[$i]);
        }

        $tamIzquierdo = count($inIzquierdo);
        $preIzquierdo = [];
        for ($i = 1; $i <= $tamIzquierdo; $i++) {
            if (isset($pre[$i])) {
                array_push($preIzquierdo, $pre[$i]);
            }
        }

        $preDerecho = [];
        $totalPre = count($pre);
        for ($i = $tamIzquierdo + 1; $i < $totalPre; $i++) {
            array_push($preDerecho, $pre[$i]);
        }

        $nodoRaiz->izquierdo = $this->construirDesdePreordenInorden($preIzquierdo, $inIzquierdo);
        $nodoRaiz->derecho = $this->construirDesdePreordenInorden($preDerecho, $inDerecho);

        return $nodoRaiz;
    }

    private function construirDesdeInordenPostorden(array $in, array $post): ?NodoArbol {
        if (empty($in) || empty($post)) {
            return null;
        }

        $totalPost = count($post);
        $raizValor = $post[$totalPost - 1];
        $nodoRaiz = new NodoArbol($raizValor);

        $indiceRaiz = -1;
        $totalIn = count($in);
        for ($i = 0; $i < $totalIn; $i++) {
            if ($in[$i] === $raizValor) {
                $indiceRaiz = $i;
                break;
            }
        }

        if ($indiceRaiz === -1) {
            return null;
        }

        $inIzquierdo = [];
        for ($i = 0; $i < $indiceRaiz; $i++) {
            array_push($inIzquierdo, $in[$i]);
        }

        $inDerecho = [];
        for ($i = $indiceRaiz + 1; $i < $totalIn; $i++) {
            array_push($inDerecho, $in[$i]);
        }

        $tamIzquierdo = count($inIzquierdo);
        $postIzquierdo = [];
        for ($i = 0; $i < $tamIzquierdo; $i++) {
            if (isset($post[$i])) {
                array_push($postIzquierdo, $post[$i]);
            }
        }

        $postDerecho = [];
        for ($i = $tamIzquierdo; $i < $totalPost - 1; $i++) {
            array_push($postDerecho, $post[$i]);
        }

        $nodoRaiz->izquierdo = $this->construirDesdeInordenPostorden($inIzquierdo, $postIzquierdo);
        $nodoRaiz->derecho = $this->construirDesdeInordenPostorden($inDerecho, $postDerecho);

        return $nodoRaiz;
    }

    private function construirDesdePreordenPostorden(array $pre, array $post): ?NodoArbol {
        if (empty($pre) || empty($post)) {
            return null;
        }

        $raizValor = $pre[0];
        $nodoRaiz = new NodoArbol($raizValor);

        if (count($pre) === 1) {
            return $nodoRaiz;
        }

        $hijoIzquierdoValor = $pre[1];
        $indiceSubArbolIzquierdo = -1;
        $totalPost = count($post);

        for ($i = 0; $i < $totalPost; $i++) {
            if ($post[$i] === $hijoIzquierdoValor) {
                $indiceSubArbolIzquierdo = $i;
                break;
            }
        }

        if ($indiceSubArbolIzquierdo === -1) {
            return $nodoRaiz;
        }

        $preIzquierdo = [];
        for ($i = 1; $i <= $indiceSubArbolIzquierdo + 1; $i++) {
            if (isset($pre[$i])) {
                array_push($preIzquierdo, $pre[$i]);
            }
        }

        $preDerecho = [];
        $totalPre = count($pre);
        for ($i = $indiceSubArbolIzquierdo + 2; $i < $totalPre; $i++) {
            array_push($preDerecho, $pre[$i]);
        }

        $postIzquierdo = [];
        for ($i = 0; $i <= $indiceSubArbolIzquierdo; $i++) {
            array_push($postIzquierdo, $post[$i]);
        }

        $postDerecho = [];
        for ($i = $indiceSubArbolIzquierdo + 1; $i < $totalPost - 1; $i++) {
            array_push($postDerecho, $post[$i]);
        }

        $nodoRaiz->izquierdo = $this->construirDesdePreordenPostorden($preIzquierdo, $postIzquierdo);
        $nodoRaiz->derecho = $this->construirDesdePreordenPostorden($preDerecho, $postDerecho);

        return $nodoRaiz;
    }

    public function imprimirEstructura(?NodoArbol $nodo = null, string $prefijo = "", bool $esUltimo = true): string {
        if ($nodo === null && $prefijo === "") {
            $nodo = $this->raiz;
        }

        if ($nodo === null) {
            return "Árbol Vacío";
        }

        $salida = $prefijo . ($esUltimo ? "└── " : "├── ") . $nodo->valor . "\n";

        $hijos = [];
        if ($nodo->izquierdo !== null) array_push($hijos, ['nodo' => $nodo->izquierdo, 'tipo' => 'IZQ']);
        if ($nodo->derecho !== null) array_push($hijos, ['nodo' => $nodo->derecho, 'tipo' => 'DER']);

        $cantHijos = count($hijos);
        for ($i = 0; $i < $cantHijos; $i++) {
            $nuevoPrefijo = $prefijo . ($esUltimo ? "    " : "│   ");
            $ultimoHijo = ($i === $cantHijos - 1);
            $salida .= $this->imprimirEstructura($hijos[$i]['nodo'], $nuevoPrefijo, $ultimoHijo);
        }

        return $salida;
    }
}