<?php
include 'config.php'; 

function getMedianSalary($pdo) {
    $stmt = $pdo->query("SELECT salary FROM salary ORDER BY salary ASC");
    $salaries = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $count = count($salaries);
    if ($count == 0) {
        return null;
    }

    $middle = floor($count / 2);
    return ($count % 2 == 0) 
        ? ($salaries[$middle - 1] + $salaries[$middle]) / 2 
        : $salaries[$middle];
}

header("Content-Type: application/json");
echo json_encode(["median_salary" => getMedianSalary($pdo)]);
?>
