<?php
    $calificacion = 72;

    //comparacion con if-else
    if ($calificacion >= 90){
        echo "Tu calificación es A.<br>";
    }elseif ($calificacion >= 80 && $calificacion<=89){
        echo "Tu calificación es B.<br>";
    } elseif ($calificacion >= 70 && $calificacion<=79) {
        echo "Tu calificación es C.<br>";
    } elseif ($calificacion >= 60 && $calificacion<=69) {
        echo "Tu calificación es D.<br>";
    } else {
        echo "Tu calificación es F.<br>";
    }
    echo "<br>";

    // operador ternario
    $resultadoTernario = ($calificacion>=60) ? "Aprobado" : "Reprobado";
    echo "Resultado (ternario): $resultadoTernario<br><br>";

    //switch
    switch (true){
        case ($calificacion >= 90):
            echo"Excelente trabajo";
            break;
        case ($calificacion >= 80):
            echo"Buen trabajo";
            break;
        case ($calificacion >= 70):
            echo"Trabajo aceptable";
            break;
        case ($calificacion >= 60):
            echo"Necesitas mejorar";
            break;
        default:
        echo "Debes esforzarte mas";
    }
?>

