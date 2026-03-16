<?php
require_once __DIR__ . '/../functions/helpers.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Username and password are required']);
    exit;
}

$pdo = get_db_connection();
if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Database unavailable']);
    exit;
}

$check = $pdo->prepare('SELECT id FROM admin_users WHERE username = ? LIMIT 1');
$check->execute([$username]);
if ($check->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Username already exists']);
    exit;
}

$insert = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)');
$insert->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);

echo json_encode(['success' => true, 'message' => 'Registered successfully']);
