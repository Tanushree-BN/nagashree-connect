<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/image-optimization.php';

define('SITE_NAME', 'Nagashree English School');

define('CONTACT_INFO', [
    'schoolName' => 'Nagashree English School',
    'address' => 'Shravanabelagola Road, Near Vinayaka Gas Godown, Channarayapatna, Hassan - 573116, Karnataka',
    'email' => 'nagashreeschoolcrp@gmail.com',
    'phones' => [
        'office' => '+91-9742278222',
        'principal' => '+91-9241776070',
        'admin' => '+91-9901181966',
    ],
    'socialLinks' => [
        'youtube' => 'https://www.youtube.com/@Nagashreeenglishschool',
        'facebook' => 'https://www.facebook.com/nagashreeenglishschoolcrp?mibextid=wwXIfr&rdid=mmPr2DQflqkq6BaP&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F17uc3LVVsT%2F%3Fmibextid%3DwwXIfr',
        'instagram' => 'https://www.instagram.com/nagashree_english_school?igsh=eHhra3JqaTV5eWhq&utm_source=qr',
    ],
    'mapEmbedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3880.0!2d76.38!3d12.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sNagashree+English+School!5e0!3m2!1sen!2sin!4v1',
]);

define('SCHOOL_DESCRIPTION', 'Nagashree English School is built on the foundation of our belief that by working on our inner and outer worlds, we would be successful not only by chance but by design. Nagashree English School envisions nurturing confidence and independence, giving our children holistic curricular support they need; to grow into flexible and resilient young adults, ready to succeed in an ever more competitive world! Our caring facilitators and helpers ensure a safe and secure childhood for every student. Our unique curriculum helps in having joyful classes with effective learning and our system of assessments help children develop skills without feeling stressed out about learning and our entire system resonates with positivity and enthusiasm of learning, exploring, and creating. We together find joy in teaching and learning.');

define('MAX_GALLERY_IMAGES', 50);

function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function starts_with(string $haystack, string $needle): bool
{
    return $needle === '' || strpos($haystack, $needle) === 0;
}

function ends_with(string $haystack, string $needle): bool
{
    if ($needle === '') {
        return true;
    }

    return substr($haystack, -strlen($needle)) === $needle;
}

function app_base_path(): string
{
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $scriptDirectory = rtrim(dirname($scriptName), '/');
    if ($scriptDirectory === '.' || $scriptDirectory === '/') {
        $scriptDirectory = '';
    }

    $scriptFilename = realpath($_SERVER['SCRIPT_FILENAME'] ?? '') ?: '';
    $appRoot = realpath(__DIR__ . '/..') ?: '';

    if ($scriptFilename !== '' && $appRoot !== '') {
        $normalizedScriptFilename = str_replace('\\', '/', $scriptFilename);
        $normalizedAppRoot = rtrim(str_replace('\\', '/', $appRoot), '/');

        if (starts_with($normalizedScriptFilename, $normalizedAppRoot)) {
            $relativeScriptPath = substr($normalizedScriptFilename, strlen($normalizedAppRoot));
            $relativeDirectory = rtrim(dirname(str_replace('\\', '/', $relativeScriptPath)), '/');

            if ($relativeDirectory === '.' || $relativeDirectory === '/') {
                $relativeDirectory = '';
            }

            if ($relativeDirectory !== '' && ends_with($scriptDirectory, $relativeDirectory)) {
                $scriptDirectory = substr($scriptDirectory, 0, strlen($scriptDirectory) - strlen($relativeDirectory));
                $scriptDirectory = rtrim($scriptDirectory, '/');
            }
        }
    }

    return $scriptDirectory;
}

function app_url(string $path = '/'): string
{
    $basePath = app_base_path();
    $normalizedPath = '/' . ltrim($path, '/');

    if ($path === '' || $path === '/') {
        return $basePath === '' ? '/' : $basePath . '/';
    }

    return ($basePath === '' ? '' : $basePath) . $normalizedPath;
}

function redirect_to(string $path): void
{
    header('Location: ' . app_url($path));
    exit;
}

function storage_dir(): string
{
    $directory = __DIR__ . '/../storage';
    if (!is_dir($directory)) {
        @mkdir($directory, 0775, true);
    }

    return $directory;
}

function storage_file_path(string $name): string
{
    return storage_dir() . '/' . $name . '.json';
}

function storage_read(string $name): array
{
    $file = storage_file_path($name);
    if (!is_file($file)) {
        return [];
    }

    $content = @file_get_contents($file);
    if ($content === false || trim($content) === '') {
        return [];
    }

    $decoded = json_decode($content, true);
    return is_array($decoded) ? $decoded : [];
}

function storage_write(string $name, array $data): bool
{
    $file = storage_file_path($name);
    return @file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

function is_admin_logged_in(): bool
{
    return isset($_SESSION['nagashree_admin']) && $_SESSION['nagashree_admin'] === true;
}

function require_admin_auth(): void
{
    if (!is_admin_logged_in()) {
        redirect_to('/admin/login');
    }
}

function get_default_gallery_items(): array
{
    return [
        ['src' => '/assets/images/bg1.JPG', 'alt' => 'Annual day celebration on school stage', 'category' => 'events', 'title' => 'Annual Day 2024'],
        ['src' => '/assets/images/RKP_0557 (1).JPG', 'alt' => 'Students performing cultural dance', 'category' => 'events', 'title' => 'Cultural Festival'],
        ['src' => '/assets/images/std30.JPG', 'alt' => 'Students studying in smart classroom', 'category' => 'classroom', 'title' => 'Smart Classroom'],
        ['src' => '/assets/images/std15.JPG', 'alt' => 'Science experiment in the laboratory', 'category' => 'classroom', 'title' => 'Science Lab Session'],
        ['src' => '/assets/images/sp1.JPG', 'alt' => 'Students playing cricket on school ground', 'category' => 'sports', 'title' => 'Cricket Match'],
        ['src' => '/assets/images/sp2.JPG', 'alt' => 'School annual sports day races', 'category' => 'sports', 'title' => 'Sports Day'],
        ['src' => '/assets/images/std10.JPG', 'alt' => 'Modern school library interior', 'category' => 'facilities', 'title' => 'Library'],
        ['src' => '/assets/images/std11.JPG', 'alt' => 'Computer lab with students coding', 'category' => 'facilities', 'title' => 'Computer Lab'],
        ['src' => '/assets/images/RKP_9681.JPG', 'alt' => 'Independence day flag hoisting ceremony', 'category' => 'events', 'title' => 'Independence Day'],
        ['src' => '/assets/images/std4.JPG', 'alt' => 'Yoga session on school grounds', 'category' => 'sports', 'title' => 'Yoga Day'],
        ['src' => '/assets/images/std29.JPG', 'alt' => 'Students in school assembly', 'category' => 'events', 'title' => 'Morning Assembly'],
        ['src' => '/assets/images/clg1.JPG', 'alt' => 'School bus fleet in campus', 'category' => 'facilities', 'title' => 'Transport Fleet'],
        ['src' => '/assets/images/std5.JPG', 'alt' => 'Students participating in school activity', 'category' => 'classroom', 'title' => 'Group Activity'],
        ['src' => '/assets/images/std6.JPG', 'alt' => 'Students playing outdoors', 'category' => 'sports', 'title' => 'Outdoor Games'],
        ['src' => '/assets/images/std21.JPG', 'alt' => 'Students walking in school corridor', 'category' => 'facilities', 'title' => 'School Corridors'],
        ['src' => '/assets/images/RKP_0685.JPG', 'alt' => 'Aerial view of students in assembly', 'category' => 'events', 'title' => 'School Assembly'],
        ['src' => '/assets/images/std2.jpg', 'alt' => 'Students engaged in classroom learning', 'category' => 'classroom', 'title' => 'Interactive Learning'],
        ['src' => '/assets/images/clg2.JPG', 'alt' => 'View of the school building', 'category' => 'facilities', 'title' => 'Campus View'],
    ];
}

function get_default_faculties(): array
{
    return [
        ['name' => 'Mrs. Savitha R.', 'role' => 'Principal', 'subject' => 'Administration & English', 'experience' => '20+ years', 'image' => null],
        ['name' => 'Mr. Ramesh Kumar', 'role' => 'Vice Principal', 'subject' => 'Mathematics', 'experience' => '18 years', 'image' => null],
        ['name' => 'Mrs. Lakshmi Devi', 'role' => 'Senior Teacher', 'subject' => 'Science', 'experience' => '15 years', 'image' => null],
        ['name' => 'Mr. Suresh Babu', 'role' => 'Senior Teacher', 'subject' => 'Social Studies', 'experience' => '14 years', 'image' => null],
        ['name' => 'Mrs. Anitha N.', 'role' => 'Teacher', 'subject' => 'English & Literature', 'experience' => '12 years', 'image' => null],
        ['name' => 'Mr. Prasad H.M.', 'role' => 'Teacher', 'subject' => 'Kannada', 'experience' => '10 years', 'image' => null],
        ['name' => 'Mrs. Deepa S.', 'role' => 'Teacher', 'subject' => 'Hindi', 'experience' => '11 years', 'image' => null],
        ['name' => 'Mr. Mahesh K.', 'role' => 'Physical Education', 'subject' => 'Sports & PE', 'experience' => '8 years', 'image' => null],
        ['name' => 'Mrs. Shwetha R.', 'role' => 'Teacher', 'subject' => 'Computer Science', 'experience' => '7 years', 'image' => null],
        ['name' => 'Mr. Naveen G.', 'role' => 'Teacher', 'subject' => 'Art & Craft', 'experience' => '9 years', 'image' => null],
        ['name' => 'Mrs. Kavitha M.', 'role' => 'Teacher', 'subject' => 'Music', 'experience' => '6 years', 'image' => null],
        ['name' => 'Mr. Arun Kumar', 'role' => 'Lab Assistant', 'subject' => 'Science Lab', 'experience' => '5 years', 'image' => null],
    ];
}

function bootstrap_database(): void
{
    $pdo = get_db_connection();
    if (!$pdo) {
        return;
    }

    $pdo->exec('CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS gallery_images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        src LONGTEXT NOT NULL,
        alt_text VARCHAR(255) NOT NULL,
        category VARCHAR(50) NOT NULL,
        title VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS faculties (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(150) NOT NULL,
        role VARCHAR(150) NOT NULL,
        subject VARCHAR(150) NOT NULL,
        experience VARCHAR(100) NOT NULL,
        image LONGTEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(150) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(30) NULL,
        subject VARCHAR(150) NOT NULL,
        message TEXT NOT NULL,
        seen TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS admissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_name VARCHAR(150) NOT NULL,
        parent_name VARCHAR(150) NOT NULL,
        mother_name VARCHAR(150) NULL,
        dob VARCHAR(30) NOT NULL,
        gender VARCHAR(30) NOT NULL,
        class_applying VARCHAR(50) NOT NULL,
        phone VARCHAR(30) NOT NULL,
        mother_phone VARCHAR(30) NULL,
        email VARCHAR(255) NULL,
        address TEXT NOT NULL,
        previous_school VARCHAR(255) NULL,
        seen TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )');

    $adminStmt = $pdo->query('SELECT COUNT(*) AS total FROM admin_users');
    $adminCount = (int) ($adminStmt->fetch()['total'] ?? 0);

    if ($adminCount === 0) {
        $insertAdmin = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)');
        $insertAdmin->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT)]);
    }

    $galleryStmt = $pdo->query('SELECT COUNT(*) AS total FROM gallery_images');
    $galleryCount = (int) ($galleryStmt->fetch()['total'] ?? 0);
    if ($galleryCount === 0) {
        $insertGallery = $pdo->prepare('INSERT INTO gallery_images (src, alt_text, category, title) VALUES (?, ?, ?, ?)');
        foreach (get_default_gallery_items() as $item) {
            $insertGallery->execute([$item['src'], $item['alt'], $item['category'], $item['title']]);
        }
    }

}

function get_gallery_images(): array
{
    $pdo = get_db_connection();
    if (!$pdo) {
        $hiddenSrcs = storage_read('gallery_hidden_seeds'); // array of src strings hidden by admin

        $defaults = array_values(array_filter(
            array_map(static function ($item, $index) {
                return [
                    'id' => $index + 1,
                    'src' => (string) ($item['src'] ?? ''),
                    'alt' => (string) ($item['alt'] ?? ''),
                    'category' => (string) ($item['category'] ?? 'events'),
                    'title' => (string) ($item['title'] ?? ''),
                ];
            }, get_default_gallery_items(), array_keys(get_default_gallery_items())),
            static function ($item) use ($hiddenSrcs) {
                return !in_array($item['src'], $hiddenSrcs, true);
            }
        ));

        $stored = storage_read('gallery_images');
        $normalizedStored = array_map(static function ($item) {
            return [
                'id' => (int) ($item['id'] ?? 0),
                'src' => (string) ($item['src'] ?? ''),
                'alt' => (string) ($item['alt'] ?? ''),
                'category' => (string) ($item['category'] ?? 'events'),
                'title' => (string) ($item['title'] ?? ''),
            ];
        }, $stored);

        $merged = [];
        foreach (array_merge($normalizedStored, $defaults) as $item) {
            $key = strtolower(trim($item['src'])) . '|' . strtolower(trim($item['title'])) . '|' . strtolower(trim($item['category'])) . '|' . strtolower(trim($item['alt']));
            if (isset($merged[$key])) {
                continue;
            }
            $merged[$key] = $item;
        }

        return array_slice(array_values($merged), 0, MAX_GALLERY_IMAGES);
    }

    $stmt = $pdo->query('SELECT id, src, alt_text, category, title FROM gallery_images ORDER BY id DESC');
    $mapped = array_map(static function ($row) {
        return [
            'id' => (int) $row['id'],
            'src' => $row['src'],
            'alt' => $row['alt_text'],
            'category' => $row['category'],
            'title' => $row['title'],
        ];
    }, $stmt->fetchAll());

    return array_slice($mapped, 0, MAX_GALLERY_IMAGES);
}

function get_faculties(): array
{
    $pdo = get_db_connection();
    if (!$pdo) {
        $stored = storage_read('faculties');
        if (!empty($stored)) {
            return array_map(static function ($item) {
                return [
                    'id' => (int) ($item['id'] ?? 0),
                    'name' => (string) ($item['name'] ?? ''),
                    'role' => (string) ($item['role'] ?? ''),
                    'subject' => (string) ($item['subject'] ?? ''),
                    'experience' => (string) ($item['experience'] ?? ''),
                    'image' => (string) ($item['image'] ?? ''),
                ];
            }, $stored);
        }

        return [];
    }

    $stmt = $pdo->query('SELECT id, name, role, subject, experience, image FROM faculties ORDER BY id DESC');
    return $stmt->fetchAll();
}

function get_messages(): array
{
    $pdo = get_db_connection();
    if (!$pdo) {
        return storage_read('messages');
    }

    return $pdo->query('SELECT * FROM contact_messages ORDER BY id DESC')->fetchAll();
}

function get_admissions(): array
{
    $pdo = get_db_connection();
    if (!$pdo) {
        return storage_read('admissions');
    }

    return $pdo->query('SELECT * FROM admissions ORDER BY id DESC')->fetchAll();
}

function get_gallery_categories(): array
{
    return ['all', 'events', 'classroom', 'sports', 'facilities'];
}

function get_features(): array
{
    return [
        [
            'icon' => 'graduation-cap',
            'title' => 'Certified Teachers',
            'description' => 'Certified teachers are educators who have completed required training, passed licensing exams, and met official standards set by an education authority. Their certification ensures they are qualified to teach specific subjects or grade levels.',
        ],
        [
            'icon' => 'sparkles',
            'title' => 'Special Education',
            'description' => 'Special education focuses on teaching students with learning, physical, emotional, or developmental disabilities. It provides individualized instruction and support to help each student succeed academically and socially.',
        ],
        [
            'icon' => 'book-open',
            'title' => 'Book & Library',
            'description' => 'Books are a valuable source of knowledge and entertainment for readers of all ages. Libraries store and organize books and other resources for easy access. They promote reading, research, and lifelong learning.',
        ],
        [
            'icon' => 'trophy',
            'title' => 'Sport Clubs',
            'description' => 'Sports clubs provide opportunities for people to participate in organized sports activities. They help develop physical fitness, teamwork, and sportsmanship. Sports clubs also encourage social interaction and a healthy lifestyle.',
        ],
    ];
}

function get_offerings(): array
{
    return [
        ['icon' => 'shield', 'title' => 'Safety First', 'description' => 'Safety first means taking precautions to prevent accidents and injuries. It encourages awareness, responsibility, and careful behavior in all activities.'],
        ['icon' => 'clock', 'title' => 'Regular Classes', 'description' => 'Regular classes provide structured learning in a standard classroom setting.'],
        ['icon' => 'graduation-cap', 'title' => 'Certified Teachers', 'description' => 'Certified teachers are professionally trained and licensed to teach.'],
        ['icon' => 'building', 'title' => 'Sufficient Classrooms', 'description' => 'Sufficient classrooms provide adequate space, seating, and learning facilities for students.'],
        ['icon' => 'lightbulb', 'title' => 'Creative Lessons', 'description' => 'Creative lessons use new ideas, activities, and methods to make learning engaging. They encourage students to think critically and express themselves freely.'],
        ['icon' => 'dumbbell', 'title' => 'Sports Facilities', 'description' => 'Sports facilities provide proper spaces and equipment for physical activities and games. They support fitness, teamwork, and skill development among students.'],
    ];
}

function get_stats(): array
{
    return [
        ['value' => 18, 'suffix' => '', 'label' => 'Certified Teachers'],
        ['value' => 401, 'suffix' => '', 'label' => 'Students'],
        ['value' => 30, 'suffix' => '', 'label' => 'Courses'],
        ['value' => 50, 'suffix' => '', 'label' => 'Awards Won'],
    ];
}

function get_facilities_list(): array
{
    return [
        [
            'id' => 'smart-classrooms',
            'title' => 'Smart Classrooms',
            'icon' => 'monitor',
            'shortDesc' => 'Technology-driven learning spaces with interactive digital boards.',
            'details' => [
                'Interactive smart boards in every classroom',
                'High-speed internet connectivity',
                'Digital learning resources and e-library access',
                'Audio-visual teaching aids',
                'Climate-controlled classrooms',
            ],
            'image' => '/assets/images/std1.jpg',
        ],
        [
            'id' => 'science-labs',
            'title' => 'Science Laboratories',
            'icon' => 'flask-conical',
            'shortDesc' => 'Well-equipped labs for Physics, Chemistry, and Biology.',
            'details' => [
                'Separate Physics, Chemistry, and Biology labs',
                'Modern equipment and apparatus',
                'Safety equipment and protocols',
                'Dedicated lab assistants',
                'Regular practical sessions',
            ],
            'image' => '/assets/images/std9.JPG',
        ],
        [
            'id' => 'library',
            'title' => 'Digital Library',
            'icon' => 'library',
            'shortDesc' => 'Vast collection of books and digital resources for all ages.',
            'details' => [
                'Over 10,000 books across genres',
                'Digital catalogue and search system',
                'E-books and online journal access',
                'Quiet reading zones',
                'Regular book fairs and reading programs',
            ],
            'image' => '/assets/images/std6.JPG',
        ],
        [
            'id' => 'computer-lab',
            'title' => 'Computer Lab',
            'icon' => 'laptop',
            'shortDesc' => 'Modern computer lab with latest hardware and software.',
            'details' => [
                '50+ computers with latest configuration',
                'High-speed broadband internet',
                'Licensed educational software',
                'Coding and robotics programs',
                'Dedicated IT instructors',
            ],
            'image' => '/assets/images/std36.JPG',
        ],
        [
            'id' => 'sports',
            'title' => 'Sports & Playground',
            'icon' => 'dumbbell',
            'shortDesc' => 'Expansive grounds for cricket, football, athletics, and more.',
            'details' => [
                'Large playground with multiple sports facilities',
                'Indoor games room (table tennis, chess, carrom)',
                'Trained sports coaches',
                'Annual sports day and inter-school tournaments',
                'Yoga and fitness programs',
            ],
            'image' => '/assets/images/sp1.JPG',
        ],
        [
            'id' => 'transport',
            'title' => 'Transport',
            'icon' => 'bus',
            'shortDesc' => 'Safe GPS-tracked buses covering all major routes.',
            'details' => [
                'Fleet of well-maintained school buses',
                'GPS tracking for parent monitoring',
                'Trained drivers and attendants',
                'Door-to-door pickup and drop facility',
                'Emergency contact system',
            ],
            'image' => '/assets/images/std22.JPG',
        ],
    ];
}

/**
 * Get paginated gallery images
 * Returns images with pagination support
 * @param int $page Page number (1-indexed)
 * @param int $limit Items per page
 * @return array [images => [...], total => int, page => int, pages => int]
 */
function get_gallery_images_paginated(int $page = 1, int $limit = 15): array
{
    if ($page < 1) $page = 1;
    if ($limit < 1) $limit = 15;

    $allImages = get_gallery_images();
    $total = count($allImages);
    $pages = (int) ceil($total / $limit);
    
    if ($page > $pages && $pages > 0) {
        $page = $pages;
    }

    $offset = ($page - 1) * $limit;
    $images = array_slice($allImages, $offset, $limit);

    return [
        'images' => $images,
        'total' => $total,
        'page' => $page,
        'pages' => $pages,
        'limit' => $limit,
    ];
}

/**
 * Get paginated faculties
 * Returns faculty members with pagination support
 * @param int $page Page number (1-indexed)
 * @param int $limit Items per page
 * @return array [faculties => [...], total => int, page => int, pages => int]
 */
function get_faculties_paginated(int $page = 1, int $limit = 12): array
{
    if ($page < 1) $page = 1;
    if ($limit < 1) $limit = 12;

    $allFaculties = get_faculties();
    $total = count($allFaculties);
    $pages = (int) ceil($total / $limit);
    
    if ($page > $pages && $pages > 0) {
        $page = $pages;
    }

    $offset = ($page - 1) * $limit;
    $faculties = array_slice($allFaculties, $offset, $limit);

    return [
        'faculties' => $faculties,
        'total' => $total,
        'page' => $page,
        'pages' => $pages,
        'limit' => $limit,
    ];
}

bootstrap_database();
