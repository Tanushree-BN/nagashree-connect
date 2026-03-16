<?php
require_once __DIR__ . '/../functions/helpers.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$action = $_POST['action'] ?? '';
$pdo = get_db_connection();

try {
    switch ($action) {
        case 'create_message': {
            if ($pdo) {
                $stmt = $pdo->prepare('INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([
                    trim($_POST['name'] ?? ''),
                    trim($_POST['email'] ?? ''),
                    trim($_POST['phone'] ?? ''),
                    trim($_POST['subject'] ?? 'General Enquiry'),
                    trim($_POST['message'] ?? ''),
                ]);
            } else {
                $messages = storage_read('messages');
                $messages[] = [
                    'id' => (int) round(microtime(true) * 1000),
                    'name' => trim($_POST['name'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'phone' => trim($_POST['phone'] ?? ''),
                    'subject' => trim($_POST['subject'] ?? 'General Enquiry'),
                    'message' => trim($_POST['message'] ?? ''),
                    'seen' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                if (!storage_write('messages', $messages)) {
                    throw new RuntimeException('Unable to store message');
                }
            }
            echo json_encode(['success' => true]);
            break;
        }

        case 'create_admission': {
            if ($pdo) {
                $stmt = $pdo->prepare('INSERT INTO admissions (student_name, parent_name, dob, gender, class_applying, phone, email, address, previous_school, previous_grade, aadhaar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([
                    trim($_POST['studentName'] ?? ''),
                    trim($_POST['parentName'] ?? ''),
                    trim($_POST['dob'] ?? ''),
                    trim($_POST['gender'] ?? ''),
                    trim($_POST['classApplying'] ?? ''),
                    trim($_POST['phone'] ?? ''),
                    trim($_POST['email'] ?? ''),
                    trim($_POST['address'] ?? ''),
                    trim($_POST['previousSchool'] ?? ''),
                    trim($_POST['previousGrade'] ?? ''),
                    trim($_POST['aadhaar'] ?? ''),
                ]);
            } else {
                $admissions = storage_read('admissions');
                $admissions[] = [
                    'id' => (int) round(microtime(true) * 1000),
                    'student_name' => trim($_POST['studentName'] ?? ''),
                    'parent_name' => trim($_POST['parentName'] ?? ''),
                    'dob' => trim($_POST['dob'] ?? ''),
                    'gender' => trim($_POST['gender'] ?? ''),
                    'class_applying' => trim($_POST['classApplying'] ?? ''),
                    'phone' => trim($_POST['phone'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'address' => trim($_POST['address'] ?? ''),
                    'previous_school' => trim($_POST['previousSchool'] ?? ''),
                    'previous_grade' => trim($_POST['previousGrade'] ?? ''),
                    'aadhaar' => trim($_POST['aadhaar'] ?? ''),
                    'seen' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                if (!storage_write('admissions', $admissions)) {
                    throw new RuntimeException('Unable to store admission');
                }
            }
            echo json_encode(['success' => true]);
            break;
        }

        case 'add_gallery':
        case 'update_gallery':
        case 'delete_gallery':
        case 'add_faculty':
        case 'update_faculty':
        case 'delete_faculty':
        case 'mark_message_seen':
        case 'delete_message':
        case 'mark_admission_seen':
        case 'delete_admission': {
            if (!is_admin_logged_in()) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                exit;
            }

            if ($action === 'add_gallery') {
                $countStmt = $pdo->query('SELECT COUNT(*) AS total FROM gallery_images');
                $galleryCount = (int) ($countStmt->fetch()['total'] ?? 0);
                if ($galleryCount >= MAX_GALLERY_IMAGES) {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Gallery limit reached. Maximum ' . MAX_GALLERY_IMAGES . ' images allowed.',
                    ]);
                    exit;
                }

                $stmt = $pdo->prepare('INSERT INTO gallery_images (src, alt_text, category, title) VALUES (?, ?, ?, ?)');
                $stmt->execute([
                    trim($_POST['src'] ?? ''),
                    trim($_POST['alt'] ?? ''),
                    trim($_POST['category'] ?? 'events'),
                    trim($_POST['title'] ?? ''),
                ]);
            }

            if ($action === 'update_gallery') {
                $stmt = $pdo->prepare('UPDATE gallery_images SET src = ?, alt_text = ?, category = ?, title = ? WHERE id = ?');
                $stmt->execute([
                    trim($_POST['src'] ?? ''),
                    trim($_POST['alt'] ?? ''),
                    trim($_POST['category'] ?? 'events'),
                    trim($_POST['title'] ?? ''),
                    (int) ($_POST['id'] ?? 0),
                ]);
            }

            if ($action === 'delete_gallery') {
                $stmt = $pdo->prepare('DELETE FROM gallery_images WHERE id = ?');
                $stmt->execute([(int) ($_POST['id'] ?? 0)]);
            }

            if ($action === 'add_faculty') {
                $stmt = $pdo->prepare('INSERT INTO faculties (name, role, subject, experience, image) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([
                    trim($_POST['name'] ?? ''),
                    trim($_POST['role'] ?? ''),
                    trim($_POST['subject'] ?? ''),
                    trim($_POST['experience'] ?? ''),
                    trim($_POST['image'] ?? ''),
                ]);
            }

            if ($action === 'update_faculty') {
                $stmt = $pdo->prepare('UPDATE faculties SET name = ?, role = ?, subject = ?, experience = ?, image = ? WHERE id = ?');
                $stmt->execute([
                    trim($_POST['name'] ?? ''),
                    trim($_POST['role'] ?? ''),
                    trim($_POST['subject'] ?? ''),
                    trim($_POST['experience'] ?? ''),
                    trim($_POST['image'] ?? ''),
                    (int) ($_POST['id'] ?? 0),
                ]);
            }

            if ($action === 'delete_faculty') {
                $stmt = $pdo->prepare('DELETE FROM faculties WHERE id = ?');
                $stmt->execute([(int) ($_POST['id'] ?? 0)]);
            }

            if ($action === 'mark_message_seen') {
                if ($pdo) {
                    $stmt = $pdo->prepare('UPDATE contact_messages SET seen = 1 WHERE id = ?');
                    $stmt->execute([(int) ($_POST['id'] ?? 0)]);
                } else {
                    $messages = storage_read('messages');
                    $id = (int) ($_POST['id'] ?? 0);
                    foreach ($messages as &$message) {
                        if ((int) ($message['id'] ?? 0) === $id) {
                            $message['seen'] = 1;
                        }
                    }
                    unset($message);
                    storage_write('messages', $messages);
                }
            }

            if ($action === 'delete_message') {
                if ($pdo) {
                    $stmt = $pdo->prepare('DELETE FROM contact_messages WHERE id = ?');
                    $stmt->execute([(int) ($_POST['id'] ?? 0)]);
                } else {
                    $id = (int) ($_POST['id'] ?? 0);
                    $messages = array_values(array_filter(storage_read('messages'), static function ($message) use ($id) {
                        return (int) ($message['id'] ?? 0) !== $id;
                    }));
                    storage_write('messages', $messages);
                }
            }

            if ($action === 'mark_admission_seen') {
                if ($pdo) {
                    $stmt = $pdo->prepare('UPDATE admissions SET seen = 1 WHERE id = ?');
                    $stmt->execute([(int) ($_POST['id'] ?? 0)]);
                } else {
                    $admissions = storage_read('admissions');
                    $id = (int) ($_POST['id'] ?? 0);
                    foreach ($admissions as &$admission) {
                        if ((int) ($admission['id'] ?? 0) === $id) {
                            $admission['seen'] = 1;
                        }
                    }
                    unset($admission);
                    storage_write('admissions', $admissions);
                }
            }

            if ($action === 'delete_admission') {
                if ($pdo) {
                    $stmt = $pdo->prepare('DELETE FROM admissions WHERE id = ?');
                    $stmt->execute([(int) ($_POST['id'] ?? 0)]);
                } else {
                    $id = (int) ($_POST['id'] ?? 0);
                    $admissions = array_values(array_filter(storage_read('admissions'), static function ($admission) use ($id) {
                        return (int) ($admission['id'] ?? 0) !== $id;
                    }));
                    storage_write('admissions', $admissions);
                }
            }

            echo json_encode(['success' => true]);
            break;
        }

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unsupported action']);
    }
} catch (Throwable $throwable) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
