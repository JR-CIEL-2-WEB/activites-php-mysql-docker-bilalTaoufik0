<?php
$host = '127.0.0.1';
$dbname = 'appdb'; // Remplacez par votre nom de base de données
$username = 'eleve';
$password = 'eleve';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
