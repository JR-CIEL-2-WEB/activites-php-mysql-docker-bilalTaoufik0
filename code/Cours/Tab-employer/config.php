<?php
header("Content-Type: application/json");

// Connexion à la base de données
$host = "mysql"; 
$dbname = "appdb";
$user = "root"; 
$password = "root"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Requête pour récupérer les employés avec leurs salaires et adresses
    $stmt = $pdo->query("
        SELECT employer.id, employer.name, employer.address, salary.salary 
        FROM employer
        LEFT JOIN salary ON employer.id = salary.employer_id
        ORDER BY salary.salary ASC
    ");
    
    $employees = $stmt->fetchAll();

    // Calcul de la médiane des salaires
    $salaries = array_column($employees, "salary");
    $count = count($salaries);
    
    if ($count > 0) {
        $median = ($count % 2 == 0) 
            ? ($salaries[$count / 2 - 1] + $salaries[$count / 2]) / 2 
            : $salaries[floor($count / 2)];
    } else {
        $median = "Aucun salaire disponible.";
    }

    // Réponse JSON
    echo json_encode([
        "employees" => $employees,
        "median" => $median
    ]);

} catch (PDOException $e) {
    echo json_encode(["error" => "Erreur de connexion : " . $e->getMessage()]);
}
?>
