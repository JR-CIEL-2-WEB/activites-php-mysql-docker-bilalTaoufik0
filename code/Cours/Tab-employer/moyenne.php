<?php
include 'config.php';

$query = 'SELECT salaire FROM employes';
$stmt = $pdo->query($query);
$salaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($salaires) > 0) {
    $salaires = array_column($salaires, 'salaire');
    $somme = array_sum($salaires);
    $moyenne = $somme / count($salaires);
    
    echo '<h2>Moyenne des salaires : ' . $moyenne . '</h2>';
} else {
    echo 'Aucun salaire trouvé.';
}
?>
