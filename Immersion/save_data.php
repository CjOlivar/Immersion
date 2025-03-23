<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);
if (!isset($data['name']) || !isset($data['age']) || !isset($data['gender']) || !isset($data['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}
if (!file_exists('data')) {
    mkdir('data', 0755, true);
}
$username = $_SESSION['username'];
$filename = "data/{$username}_profile.json";

if (file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT))) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Failed to save data']);
}
?>