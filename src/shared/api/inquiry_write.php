<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../../shared/api/db_config.php';

// JSON 반환
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "로그인이 필요합니다."]);
    exit;
}

$user_id = $_SESSION['user_id'];
$title = $_POST['title'] ?? null;
$content = $_POST['content'] ?? null;

if (!$title || !$content) {
    echo json_encode(["success" => false, "message" => "제목과 내용을 입력해주세요."]);
    exit;
}

$sql = "INSERT INTO inquiries (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);

try {
    $stmt->execute([$user_id, $title, $content]);
    echo json_encode(["success" => true, "message" => "문의가 작성되었습니다."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

exit;
