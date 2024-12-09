<?php
function tri_selection(array $t) {

    $n = count($t);
    for ($i = 0; $i < $n - 2; $i++) {
        $min = $i;

        for ($j = $i + 1; $j < $n - 1; $j++) {
            if ($t[$j] < $t[$min]) {
                $min = $j;
            }
        };
    } if ($min != $i) {
       $temp = $t[$min];
       $t[$min] = $t[$i];
         $t[$i] = $temp;
    }
}
?>