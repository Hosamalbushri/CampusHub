<?php

/**
 * Mock university API for local development (standalone, outside Laravel).
 *
 * Run from this directory:
 *   php -S 127.0.0.1:8090 router.php
 *
 * In .env (CRM):
 *   STUDENT_UNIVERSITY_API_FAKE=false
 *   STUDENT_UNIVERSITY_API_BASE_URL=http://127.0.0.1:8090
 *   STUDENT_UNIVERSITY_API_VERIFY_PATH=students/verify
 *
 * Expected POST JSON body (matches default student.php request_body_keys):
 *   { "card_number": "<university card>", "password": "<password>" }
 *
 * Success response (matches default response_map):
 *   { "success": true, "data": { "full_name", "student_id", "major", "level" } }
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli-server') {
    fwrite(STDERR, "Run with: php -S 127.0.0.1:8090 router.php\n");
    exit(1);
}

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = rtrim($path, '/') ?: '/';

$isVerify = str_ends_with($path, '/students/verify') || $path === '/students/verify';

if (! $isVerify) {
    http_response_code(404);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'not_found', 'hint' => 'POST /students/verify']);

    return true;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'method_not_allowed']);

    return true;
}

$raw = file_get_contents('php://input') ?: '';
$input = json_decode($raw, true);

if (! is_array($input)) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'message' => 'invalid_json']);

    return true;
}

$card = isset($input['card_number']) ? (string) $input['card_number'] : '';
$password = isset($input['password']) ? (string) $input['password'] : '';

// Same rule as FakeUniversityStudentApiClient: short password => reject
if ($card === '' || strlen($password) < 4) {
    http_response_code(401);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'message' => 'invalid_credentials',
    ]);

    return true;
}

// Optional demo accounts (password must be >= 4 chars)
$demo = [
    'demo' => [
        'full_name'  => 'طالب تجريبي',
        'student_id' => 'DEMO-001',
        'major'      => 'علوم الحاسوب',
        'level'      => '3',
    ],
];

$profile = null;
if (isset($demo[$card])) {
    $profile = $demo[$card];
}

if ($profile === null) {
    $profile = [
        'full_name'  => 'Mock Student ('.$card.')',
        'student_id' => $card !== '' ? $card : 'UNKNOWN',
        'major'      => 'Computer Science',
        'level'      => '2',
    ];
}

header('Content-Type: application/json; charset=utf-8');
http_response_code(200);
echo json_encode([
    'success' => true,
    'data'    => [
        'full_name'  => $profile['full_name'],
        'student_id' => $profile['student_id'],
        'major'      => $profile['major'],
        'level'      => $profile['level'],
    ],
], JSON_UNESCAPED_UNICODE);

return true;
