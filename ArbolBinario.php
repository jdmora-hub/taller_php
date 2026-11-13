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
            $this->advertenciaAmbiguedad = "Atención: La combinación Preorden + Postorden no garantiza un árbol binario único a menos que sea un árbol estrictamente lleno";
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

    public function generarSVG(): string {
        if ($this->raiz === null) {
            return "";
        }

        $altura = $this->obtenerAltura($this->raiz);
        $altoNivel = 80;
        $radio = 20;
        $anchoTotal = pow(2, $altura) * 45;
        if ($anchoTotal < 320) {
            $anchoTotal = 320;
        }
        $altoTotal = ($altura * $altoNivel) + 40;

        $svgElementos = $this->dibujarNodoSVG($this->raiz, $anchoTotal / 2, 40, $anchoTotal / 4, $altoNivel, $radio);

        return '<svg width="' . $anchoTotal . '" height="' . $altoTotal . '" viewBox="0 0 ' . $anchoTotal . ' ' . $altoTotal . '">' 
               . $svgElementos . 
               '</svg>';
    }

    private function obtenerAltura(?NodoArbol $nodo): int {
        if ($nodo === null) {
            return 0;
        }
        $izq = $this->obtenerAltura($nodo->izquierdo);
        $der = $this->obtenerAltura($nodo->derecho);
        return 1 + ($izq > $der ? $izq : $der);
    }

    private function dibujarNodoSVG(?NodoArbol $nodo, float $x, float $y, float $separacionX, float $altoNivel, int $radio): string {
        if ($nodo === null) {
            return "";
        }

        $html = "";
        $siguienteY = $y + $altoNivel;

        // 1. Dibujar primero las líneas (palitos) hacia los hijos para que queden detrás de las bolitas
        if ($nodo->izquierdo !== null) {
            $hijoIzqX = $x - $separacionX;
            $html .= '<line x1="' . $x . '" y1="' . $y . '" x2="' . $hijoIzqX . '" y2="' . $siguienteY . '" class="arbol-linea" />';
            $html .= $this->dibujarNodoSVG($nodo->izquierdo, $hijoIzqX, $siguienteY, $separacionX / 2, $altoNivel, $radio);
        }

        if ($nodo->derecho !== null) {
            $hijoDerX = $x + $separacionX;
            $html .= '<line x1="' . $x . '" y1="' . $y . '" x2="' . $hijoDerX . '" y2="' . $siguienteY . '" class="arbol-linea" />';
            $html .= $this->dibujarNodoSVG($nodo->derecho, $hijoDerX, $siguienteY, $separacionX / 2, $altoNivel, $radio);
        }

        // 2. Dibujar la bolita (círculo) y el texto del nodo encima
        $html .= '<circle cx="' . $x . '" cy="' . $y . '" r="' . $radio . '" class="arbol-nodo" />';
        $html .= '<text x="' . $x . '" y="' . $y . '" dy="5" text-anchor="middle" class="arbol-texto">' . $nodo->valor . '</text>';

        return $html;
    }
}