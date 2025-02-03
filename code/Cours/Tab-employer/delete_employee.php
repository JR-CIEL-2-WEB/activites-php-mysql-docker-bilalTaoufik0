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
    if (isset($data['id'])) {
        $stmt = $pdo->prepare("DELETE FROM salary WHERE employer_id = :id");
        $stmt->execute([':id' => $data['id']]);

        $stmt = $pdo->prepare("DELETE FROM employer WHERE id = :id");
        $stmt->execute([':id' => $data['id']]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'ID manquant']);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Erreur : " . $e->getMessage()]);
}
?>
