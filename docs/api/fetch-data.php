<?php
require_once __DIR__ . '/../functions/helpers.php';
header('Content-Type: application/json');

$entity = $_GET['entity'] ?? '';

switch ($entity) {
    case 'gallery':
        echo json_encode(['success' => true, 'data' => get_gallery_images()]);
        break;

    case 'faculties':
        echo json_encode(['success' => true, 'data' => get_faculties()]);
        break;

    case 'messages':
        if (!is_admin_logged_in()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        echo json_encode(['success' => true, 'data' => get_messages()]);
        break;

    case 'admissions':
        if (!is_admin_logged_in()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        echo json_encode(['success' => true, 'data' => get_admissions()]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Unsupported entity']);
}
