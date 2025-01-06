<?php
function moyenne($salaries) {
    return array_sum($salaries) / count($salaries);
}

function mediane($salaries) {
    sort($salaries); 
    $n = count($salaries);
    
    if ($n % 2 == 0) {
        
        $milieu1 = $salaries[$n / 2 - 1];
        $milieu2 = $salaries[$n / 2];
        return ($milieu1 + $milieu2) / 2;
    } else {
        
        return $salaries[floor($n / 2)];
    }
}
?>