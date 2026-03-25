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

function save_data_url_image(string $value, string $prefix = 'upload'): string
{
    if (!preg_match('/^data:image\/(jpeg|jpg|png|gif|webp);base64,(.+)$/i', $value, $matches)) {
        throw new RuntimeException('Invalid image format');
    }

    $extension = strtolower($matches[1]);
    if ($extension === 'jpeg') {
        $extension = 'jpg';
    }

    $binary = base64_decode($matches[2], true);
    if ($binary === false) {
        throw new RuntimeException('Invalid image data');
    }

    $uploadDirectory = __DIR__ . '/../assets/images/uploads';
    if (!is_dir($uploadDirectory) && !@mkdir($uploadDirectory, 0775, true)) {
        throw new RuntimeException('Unable to create upload directory');
    }

    $filename = sprintf('%s_%s_%s.%s', $prefix, date('Ymd_His'), bin2hex(random_bytes(4)), $extension);
    $filePath = $uploadDirectory . '/' . $filename;
    if (@file_put_contents($filePath, $binary) === false) {
        throw new RuntimeException('Unable to save image');
    }

    return app_url('/assets/images/uploads/' . $filename);
}

function normalize_image_path(?string $rawValue, string $prefix): string
{
    $value = trim((string) $rawValue);
    if ($value === '') {
        return '';
    }

    if (starts_with($value, 'data:image/')) {
        return save_data_url_image($value, $prefix);
    }

    return $value;
}

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
                $studentName = trim($_POST['studentName'] ?? '');
                $parentName = trim($_POST['parentName'] ?? '');
                $motherName = trim($_POST['motherName'] ?? '');
                $dob = trim($_POST['dob'] ?? '');
                $gender = trim($_POST['gender'] ?? '');
                $classApplying = trim($_POST['classApplying'] ?? '');
                $phone = trim($_POST['phone'] ?? '');
                $motherPhone = trim($_POST['motherPhone'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $address = trim($_POST['address'] ?? '');
                $previousSchool = trim($_POST['previousSchool'] ?? '');

                try {
                    $stmt = $pdo->prepare('INSERT INTO admissions (student_name, parent_name, mother_name, dob, gender, class_applying, phone, mother_phone, email, address, previous_school) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                    $stmt->execute([
                        $studentName,
                        $parentName,
                        $motherName,
                        $dob,
                        $gender,
                        $classApplying,
                        $phone,
                        $motherPhone,
                        $email,
                        $address,
                        $previousSchool,
                    ]);
                } catch (Throwable $throwable) {
                    $message = strtolower($throwable->getMessage());
                    $isMotherColumnIssue = str_contains($message, 'mother_name') || str_contains($message, 'mother_phone');
                    if (!$isMotherColumnIssue) {
                        throw $throwable;
                    }

                    $stmt = $pdo->prepare('INSERT INTO admissions (student_name, parent_name, dob, gender, class_applying, phone, email, address, previous_school) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
                    $stmt->execute([
                        $studentName,
                        $parentName,
                        $dob,
                        $gender,
                        $classApplying,
                        $phone,
                        $email,
                        $address,
                        $previousSchool,
                    ]);
                }
            } else {
                $admissions = storage_read('admissions');
                $admissions[] = [
                    'id' => (int) round(microtime(true) * 1000),
                    'student_name' => trim($_POST['studentName'] ?? ''),
                    'parent_name' => trim($_POST['parentName'] ?? ''),
                    'mother_name' => trim($_POST['motherName'] ?? ''),
                    'dob' => trim($_POST['dob'] ?? ''),
                    'gender' => trim($_POST['gender'] ?? ''),
                    'class_applying' => trim($_POST['classApplying'] ?? ''),
                    'phone' => trim($_POST['phone'] ?? ''),
                    'mother_phone' => trim($_POST['motherPhone'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'address' => trim($_POST['address'] ?? ''),
                    'previous_school' => trim($_POST['previousSchool'] ?? ''),
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
                $src = normalize_image_path($_POST['src'] ?? '', 'gallery');
                if ($src === '') {
                    throw new RuntimeException('Image is required');
                }
                $galleryCategory = 'general';

                if ($pdo) {
                    $countStmt = $pdo->query('SELECT COUNT(*) AS total FROM gallery_images');
                    $galleryCount = (int) ($countStmt->fetch()['total'] ?? 0);
                } else {
                    $galleryCount = count(get_gallery_images());
                }

                if ($galleryCount >= MAX_GALLERY_IMAGES) {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Gallery limit reached. Maximum ' . MAX_GALLERY_IMAGES . ' images allowed.',
                    ]);
                    exit;
                }

                if ($pdo) {
                    $stmt = $pdo->prepare('INSERT INTO gallery_images (src, alt_text, category, title) VALUES (?, ?, ?, ?)');
                    $stmt->execute([
                        $src,
                        trim($_POST['alt'] ?? ''),
                        $galleryCategory,
                        trim($_POST['title'] ?? ''),
                    ]);
                } else {
                    $gallery = storage_read('gallery_images');
                    $gallery[] = [
                        'id' => (int) round(microtime(true) * 1000),
                        'src' => $src,
                        'alt' => trim($_POST['alt'] ?? ''),
                        'category' => $galleryCategory,
                        'title' => trim($_POST['title'] ?? ''),
                    ];

                    if (!storage_write('gallery_images', $gallery)) {
                        throw new RuntimeException('Unable to store gallery image');
                    }
                }
            }

            if ($action === 'update_gallery') {
                $src = normalize_image_path($_POST['src'] ?? '', 'gallery');
                $galleryCategory = 'general';

                if ($pdo) {
                    $stmt = $pdo->prepare('UPDATE gallery_images SET src = ?, alt_text = ?, category = ?, title = ? WHERE id = ?');
                    $stmt->execute([
                        $src,
                        trim($_POST['alt'] ?? ''),
                        $galleryCategory,
                        trim($_POST['title'] ?? ''),
                        (int) ($_POST['id'] ?? 0),
                    ]);
                } else {
                    $id = (int) ($_POST['id'] ?? 0);
                    $gallery = storage_read('gallery_images');
                    $updated = false;
                    foreach ($gallery as &$item) {
                        if ((int) ($item['id'] ?? 0) === $id) {
                            $item['src'] = $src;
                            $item['alt'] = trim($_POST['alt'] ?? '');
                            $item['category'] = $galleryCategory;
                            $item['title'] = trim($_POST['title'] ?? '');
                            $updated = true;
                            break;
                        }
                    }
                    unset($item);

                    if (!$updated) {
                        $defaultItems = get_default_gallery_items();

                        // Editing a seeded default item: hide the original seed and store edited copy
                        if ($id >= 1 && $id <= count($defaultItems)) {
                            $seededSrc = (string) ($defaultItems[$id - 1]['src'] ?? '');
                            if ($seededSrc !== '') {
                                $hidden = storage_read('gallery_hidden_seeds');
                                if (!in_array($seededSrc, $hidden, true)) {
                                    $hidden[] = $seededSrc;
                                }

                                if (!storage_write('gallery_hidden_seeds', $hidden)) {
                                    throw new RuntimeException('Unable to update gallery image');
                                }
                            }

                            $gallery[] = [
                                'id' => (int) round(microtime(true) * 1000),
                                'src' => $src,
                                'alt' => trim($_POST['alt'] ?? ''),
                                'category' => $galleryCategory,
                                'title' => trim($_POST['title'] ?? ''),
                            ];
                        }
                    }

                    if (!storage_write('gallery_images', $gallery)) {
                        throw new RuntimeException('Unable to update gallery image');
                    }
                }
            }

            if ($action === 'delete_gallery') {
                if ($pdo) {
                    $stmt = $pdo->prepare('DELETE FROM gallery_images WHERE id = ?');
                    $stmt->execute([(int) ($_POST['id'] ?? 0)]);
                } else {
                    $id = (int) ($_POST['id'] ?? 0);
                    $defaultItems = get_default_gallery_items();
                    $seededSrc = null;

                    // Seeded items have IDs 1..N (index+1); timestamps are always much larger
                    if ($id >= 1 && $id <= count($defaultItems)) {
                        $seededSrc = $defaultItems[$id - 1]['src'] ?? null;
                    }

                    if ($seededSrc !== null) {
                        // Hide this seeded image so it no longer appears
                        $hidden = storage_read('gallery_hidden_seeds');
                        if (!in_array($seededSrc, $hidden, true)) {
                            $hidden[] = $seededSrc;
                        }

                        if (!storage_write('gallery_hidden_seeds', $hidden)) {
                            throw new RuntimeException('Unable to remove gallery image');
                        }
                    } else {
                        // Delete user-uploaded image from storage
                        $gallery = array_values(array_filter(storage_read('gallery_images'), static function ($item) use ($id) {
                            return (int) ($item['id'] ?? 0) !== $id;
                        }));

                        if (!storage_write('gallery_images', $gallery)) {
                            throw new RuntimeException('Unable to delete gallery image');
                        }
                    }
                }
            }

            if ($action === 'add_faculty') {
                $image = normalize_image_path($_POST['image'] ?? '', 'faculty');

                if ($pdo) {
                    $stmt = $pdo->prepare('INSERT INTO faculties (name, role, subject, experience, image) VALUES (?, ?, ?, ?, ?)');
                    $stmt->execute([
                        trim($_POST['name'] ?? ''),
                        trim($_POST['role'] ?? ''),
                        trim($_POST['subject'] ?? ''),
                        trim($_POST['experience'] ?? ''),
                        $image,
                    ]);
                } else {
                    $faculties = storage_read('faculties');
                    $faculties[] = [
                        'id' => (int) round(microtime(true) * 1000),
                        'name' => trim($_POST['name'] ?? ''),
                        'role' => trim($_POST['role'] ?? ''),
                        'subject' => trim($_POST['subject'] ?? ''),
                        'experience' => trim($_POST['experience'] ?? ''),
                        'image' => $image,
                    ];

                    if (!storage_write('faculties', $faculties)) {
                        throw new RuntimeException('Unable to store faculty');
                    }
                }
            }

            if ($action === 'update_faculty') {
                $image = normalize_image_path($_POST['image'] ?? '', 'faculty');

                if ($pdo) {
                    $stmt = $pdo->prepare('UPDATE faculties SET name = ?, role = ?, subject = ?, experience = ?, image = ? WHERE id = ?');
                    $stmt->execute([
                        trim($_POST['name'] ?? ''),
                        trim($_POST['role'] ?? ''),
                        trim($_POST['subject'] ?? ''),
                        trim($_POST['experience'] ?? ''),
                        $image,
                        (int) ($_POST['id'] ?? 0),
                    ]);
                } else {
                    $id = (int) ($_POST['id'] ?? 0);
                    $faculties = storage_read('faculties');
                    foreach ($faculties as &$faculty) {
                        if ((int) ($faculty['id'] ?? 0) === $id) {
                            $faculty['name'] = trim($_POST['name'] ?? '');
                            $faculty['role'] = trim($_POST['role'] ?? '');
                            $faculty['subject'] = trim($_POST['subject'] ?? '');
                            $faculty['experience'] = trim($_POST['experience'] ?? '');
                            $faculty['image'] = $image;
                        }
                    }
                    unset($faculty);

                    if (!storage_write('faculties', $faculties)) {
                        throw new RuntimeException('Unable to update faculty');
                    }
                }
            }

            if ($action === 'delete_faculty') {
                if ($pdo) {
                    $stmt = $pdo->prepare('DELETE FROM faculties WHERE id = ?');
                    $stmt->execute([(int) ($_POST['id'] ?? 0)]);
                } else {
                    $id = (int) ($_POST['id'] ?? 0);
                    $faculties = array_values(array_filter(storage_read('faculties'), static function ($faculty) use ($id) {
                        return (int) ($faculty['id'] ?? 0) !== $id;
                    }));

                    if (!storage_write('faculties', $faculties)) {
                        throw new RuntimeException('Unable to delete faculty');
                    }
                }
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
    $message = 'Server error';
    if (is_admin_logged_in() && trim($throwable->getMessage()) !== '') {
        $message = $throwable->getMessage();
    }
    echo json_encode(['success' => false, 'message' => $message]);
}
