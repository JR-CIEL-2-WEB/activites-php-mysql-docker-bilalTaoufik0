<?php
include('functions.php');

$n = isset($_GET['n']) ? intval($_GET['n']) : 5;  
$m = isset($_GET['m']) ? intval($_GET['m']) : 5;  

multiplication_n_m($n, $m);
?>
