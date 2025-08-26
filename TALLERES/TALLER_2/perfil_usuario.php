<?php
    $nombre_completo = "Ashley Mc kenzie";
    $edad = 23;
    $correo = "ashley.mckenzie@utp.ac.pa";
    $telefono = 63058245;


    //Punto 3: constante llamada ocupacion
    define("OCUPACION", "Estudiante");

    echo "TALLER 2<br>";
    echo "<br>Mi nombre es: $nombre_completo<br>";
    echo "Mi edad es: $edad<br>";
    echo "Mi correo es: $correo<br>";
    echo "Mi telefono es: $telefono<br>";

    //usando print
    print "<br>Mi nombre es $nombre_completo, tengo $edad años, mi correo es $correo y mi numero es $telefono<br>";

    //usando printf
    printf("<br>Me llamo %s y tengo %d años, mi correo es: %s, mi numero es: %d y mi ocupacion es: %s <br>", $nombre_completo, $edad, $correo, $telefono, OCUPACION);

    // Usando var_dump (útil para debugging)
    echo "<br>";
    var_dump($nombre_completo);
    echo "<br>";
    var_dump($edad);
    echo "<br>";
    var_dump($correo);
    echo "<br>";
    var_dump($telefono);
    echo "<br>";
    var_dump(OCUPACION);
    echo "<br>";
?>