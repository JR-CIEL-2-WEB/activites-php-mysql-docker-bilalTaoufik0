<?php
header("Content-Type: application/json");

$host = "mysql";
$dbname = "appdb";
$user = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $data = json_decode(file_get_contents('php://input'), true);

    // Validation des données
    if (isset($data['name'], $data['address'], $data['salary'])) {
        $stmt = $pdo->prepare("INSERT INTO employer (name, address) VALUES (:name, :address)");
        $stmt->execute([
            ':name' => $data['name'],
            ':address' => $data['address']
        ]);
        $employerId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO salary (employer_id, salary) VALUES (:employer_id, :salary)");
        $stmt->execute([
            ':employer_id' => $employerId,
            ':salary' => $data['salary']
        ]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Données manquantes']);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Erreur : " . $e->getMessage()]);
}
?>
