<?php
require_once 'multiplication.php';

function multiplication_n_m($n, $m) {
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    for ($i = 1; $i <= $n; $i++) {
        echo "<tr>";
        for ($j = 1; $j <= $m; $j++) {
            
            echo "<td>" . str_pad($i * $j, 4, " ", STR_PAD_LEFT) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>
