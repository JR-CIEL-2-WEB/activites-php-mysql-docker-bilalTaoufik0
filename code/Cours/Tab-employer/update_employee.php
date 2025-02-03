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
    if (isset($data['id'], $data['name'], $data['address'], $data['salary'])) {
        // Mise à jour de l'employé
        $stmt = $pdo->prepare("UPDATE employer SET name = :name, address = :address WHERE id = :id");
        $stmt->execute([
            ':name' => $data['name'],
            ':address' => $data['address'],
            ':id' => $data['id']
        ]);

        // Mise à jour du salaire
        $stmt = $pdo->prepare("UPDATE salary SET salary = :salary WHERE employer_id = :id");
        $stmt->execute([
            ':salary' => $data['salary'],
            ':id' => $data['id']
        ]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Données manquantes']);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Erreur : " . $e->getMessage()]);
}
?>
