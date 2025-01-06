<?php
include 'config.php';

$query = 'SELECT salaire FROM employes';
$stmt = $pdo->query($query);
$salaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($salaires) > 0) {
    $salaires = array_column($salaires, 'salaire');
    sort($salaires);
    echo '<h2>Salaires triés :</h2>';
    echo '<pre>' . print_r($salaires, true) . '</pre>';
} else {
    echo 'Aucun salaire trouvé.';
}
?>
