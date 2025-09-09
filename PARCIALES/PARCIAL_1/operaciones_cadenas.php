<?php
// operaciones_cadenas.php
// funcion contador_palabras_repetidas($texto)

function contar_palabras_repetidas($texto) {
    $palabras = explode(" ", strtolower(trim($texto)));
    $contador = [];

    foreach ($palabras as $palabra) {
        if ($palabra !== "") {
            if (isset($contador[$palabra])) {
                $contador[$palabra]++;
            } else {
                $contador[$palabra] = 1;
            }
        }
    }

    return $contador;
}

function capitalizar_palabras($texto) {
    $palabras = explode(" ", strtolower(trim($texto)));
    $resultado = [];

    foreach ($palabras as $palabra) {
        if ($palabra !== "") {
            $primera = strtoupper(substr($palabra, 0, 1));
            $resto = substr($palabra, 1);
            $resultado[] = $primera . $resto;
        }
    }

    return implode(" ", $resultado);
}
?>
