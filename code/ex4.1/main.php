<?php
include 'tri_selection.php';

$t = [1500, 4500, 2200, 1500, 1700, 1800, 2000, 3300, 4000];

echo "Avant le tri : <br><br> ";
print_r($t);

tri_selection($t);

echo "<br><br> Après le tri : <br><br>";
print_r($t);
?>
