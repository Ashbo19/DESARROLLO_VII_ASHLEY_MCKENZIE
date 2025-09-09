<?php

include 'operaciones_cadenas.php';
echo "<h2> Problema 1</h2>";
$frases = [
    "tres por tres es nueve",
    "programacion en php en desarrollo 7",
    "tres veces tres es igual a nueve",
    "cuatro mas cuatro es cuatro ?"
];

foreach ($frases as $frase) {
    $capitalizada = capitalizar_palabras($frase);
    $repetidas = contar_palabras_repetidas($frase);

    echo "<br>$frase</br>";
    echo "<br>$capitalizada</br>";
    echo "<br>";

    foreach ($repetidas as $palabra => $cantidad) {
        echo "$palabra = $cantidad<br>";
    }
}

?>