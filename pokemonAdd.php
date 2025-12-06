<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $image = $_POST['image'];
    $health = $_POST['health'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $number = $_POST['number'];

    if ($name && $image && $health && $height && $weight && $number) {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("INSERT INTO pokemons (name, url, health, height, weight, number) VALUES (:name, :image, :health, :height, :weight, :number)");
        $stmt->execute([
            ':name' => $name,
            ':image' => $image,
            ':health' => $health,
            ':height' => $height,
            ':weight' => $weight,
            ':number' => $number
        ]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Faltan datos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}