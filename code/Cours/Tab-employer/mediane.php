<?php
include 'config.php';

$query = 'SELECT salaire FROM employes';
$stmt = $pdo->query($query);
$salaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($salaires) > 0) {
    $salaires = array_column($salaires, 'salaire');
    sort($salaires);
    
    $count = count($salaires);
    $mid = floor($count / 2);
    
    if ($count % 2 == 0) {
        $mediane = ($salaires[$mid - 1] + $salaires[$mid]) / 2;
    } else {
        $mediane = $salaires[$mid];
    }
    
    echo '<h2>Médiane des salaires : ' . $mediane . '</h2>';
} else {
    echo 'Aucun salaire trouvé.';
}
?>
