<?php
    //bucle for
    // Bucle for para iterar sobre un array
    $asterisco = ["*", "**", "***", "****", "*****"];
      echo "Triangulo rectangulo:<br>";
      for ($i = 0; $i < count($asterisco); $i++) {
      echo $asterisco[$i] . "<br>";
    }

    // bucle while
    $j = 0;
    echo "Números impares menores que 20 usando continue:<br>";
    while ($j < 20) {
      $j++;
      if ($j % 2 == 0) {
        continue;
      }
      echo "$j ";
    }
    echo "<br><br>";

    //bucle do-while
    $contador = 10;
        echo "Contando del 10 al 1 con do-while:<br>";
        do {
            if($contador !=5){
                echo "$contador ";
            }
            $contador--;
        } while ($contador >= 1);
    echo "<br><br>";
?>