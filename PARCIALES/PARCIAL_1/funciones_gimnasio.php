<?php
function calcular_promocion($antiguedad_meses) {
    if ($antiguedad_meses >= 24) {
        return 20;
    } elseif ($antiguedad_meses >= 13) {
        return 12;
    } elseif ($antiguedad_meses >= 6) {
        return 8;
    } else {
        return 0;
    }
}

function calcular_seguro($cuota_base) {
    return $cuota_base * 0.05;
}

function calcular_cuota_final($cuota_base, $descuento_porcentaje, $seguro_medico) {
    $descuento = $cuota_base * ($descuento_porcentaje / 100);
    $cuota_final = ($cuota_base - $descuento) + $seguro_medico;
    return $cuota_final;
}
?>