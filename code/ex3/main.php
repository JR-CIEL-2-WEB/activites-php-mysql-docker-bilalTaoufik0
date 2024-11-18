<?php
require_once 'triangle.php';

if (isset($_GET['n'])) {
    $n = (int)$_GET['n'];
    if ($n > 0) {
        triangle($n);
    } else {
        echo "Veuillez entrer un nombre entier positif.";
    }
} else {
    echo "Aucun paramètre 'n' spécifié dans l'URL.";
}
?>
