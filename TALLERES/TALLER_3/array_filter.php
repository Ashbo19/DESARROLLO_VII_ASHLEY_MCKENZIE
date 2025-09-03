
<?php
// Ejemplo básico de array_filter()
$numeros = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10,12,13,14,15,16,17,18,19,20];
$pares = array_filter($numeros, function($n) {
    return $n % 2 == 0;
});

echo "Números originales: " . implode(", ", $numeros) . "</br>";
echo "Números pares: " . implode(", ", $pares) . "</br>";

// Ejemplo con una función nombrada
function esPrimo($n) {
    if ($n < 2) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}

$primos = array_filter($numeros, 'esPrimo');
echo "Números primos: " . implode(", ", $primos) . "</br>";

// Ejercicio: Filtra un array de strings para obtener solo las palabras que comienzan con una vocal
$palabras = ["auto", "casa", "elefante", "iglú", "oso", "uva", "zapato", "camello", "iguana"];
$empiezaConVocal = array_filter($palabras, function($palabra) {
    return in_array(strtolower($palabra[0]), ['a', 'e', 'i', 'o', 'u']);
});

echo "</br>Palabras originales: " . implode(", ", $palabras) . "</br>";
echo "Palabras que empiezan con vocal: " . implode(", ", $empiezaConVocal) . "</br>";

// Bonus: Filtrar un array asociativo
$personas = [
    ["nombre" => "Angie", "edad" => 22],
    ["nombre" => "Ashley", "edad" => 23],
    ["nombre" => "Virgi", "edad" => 17],
    ["nombre" => "Dante", "edad" => 2]
];

$mayoresDe25 = array_filter($personas, function($persona) {
    return $persona['edad'] > 25;
});

echo "</br>Personas mayores de 25 años:</br>";
foreach ($mayoresDe25 as $persona) {
    echo "- {$persona['nombre']} ({$persona['edad']} años)</br>";
}

// Extra: Uso de array_filter() con ARRAY_FILTER_USE_BOTH
$frutas = ["manzana" => 3, "banana" => 1, "naranja" => 2,"aguacate"=> 7];
$frutasConMasDe3 = array_filter($frutas, function($cantidad, $nombre) {
    return $cantidad > 3 && strlen($nombre) > 5;
}, ARRAY_FILTER_USE_BOTH);

echo "</br>Frutas con más de 3 unidades y nombre largo:</br>";
print_r($frutasConMasDe3);

// Desafío: Crear una función de filtrado personalizada
function filtrarPor($array, $campo, $valor) {
    return array_filter($array, function($item) use ($campo, $valor) {
        return isset($item[$campo]) && $item[$campo] == $valor;
    });
}

$estudiantes = [
    ["nombre" => "Eyleen", "curso" => "C", "nota" => 55],
    ["nombre" => "Angel", "curso" => "C", "nota" => 91],
    ["nombre" => "Sol", "curso" => "PHP", "nota" => 70],
    ["nombre" => "Luz", "curso" => "Python", "nota" => 25]
];

$estudiantesPHP = filtrarPor($estudiantes, "curso", "C");
echo "</br>Estudiantes de PHP:</br>";
foreach ($estudiantesPHP as $estudiante) {
    echo "- {$estudiante['nombre']} (Nota: {$estudiante['nota']})</br>";
}
?>