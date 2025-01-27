<?php
header('Content-Type: application/json');

$host = 'mysql'; // Assurez-vous que c'est l'adresse correcte de votre serveur MySQL
$dbname = 'appdb';
$user = 'root';
$password = 'root';

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les employés et leurs salaires
    $stmt = $pdo->query("SELECT e.id, e.name, e.adress, s.salary
                         FROM employer e
                         INNER JOIN salary s ON e.id = s.employe_id
                         ORDER BY s.salary");
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérification si des employés ont été trouvés
    if (count($employees) === 0) {
        echo json_encode(['error' => 'Aucun employé trouvé']);
        exit;
    }

    // Calcul de la médiane des salaires
    $salaries = array_column($employees, 'salary');
    $count = count($salaries);

    sort($salaries); // Tri des salaires pour calculer la médiane

    $median = ($count % 2 === 0) ?
        (($salaries[$count / 2 - 1] + $salaries[$count / 2]) / 2) :
        $salaries[floor($count / 2)];

    // Retour des données en JSON
    echo json_encode([
        'employer' => $employees,
        'median' => $median
    ]);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}
?>
