<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../../shared/api/db_config.php';
header('Content-Type: application/json');

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "로그인이 필요합니다."]);
    exit;
}

$user_id = $_SESSION['user_id'];

// 관리자 권한 확인 (DB 조회)
$stmt = $conn->prepare("SELECT role FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['role'] !== 'admin') {
    echo json_encode(["success" => false, "message" => "관리자 권한이 필요합니다."]);
    exit;
}

// 답변 작성 처리
$id = $_POST['id'] ?? null;
$reply = $_POST['reply'] ?? null;

if (!$id || !$reply) {
    echo json_encode(["success" => false, "message" => "답변 내용을 입력해주세요."]);
    exit;
}

$sql = "UPDATE inquiries SET reply = ?, replied_at = NOW() WHERE id = ?";
$stmt = $conn->prepare($sql);

try {
    $stmt->execute([$reply, $id]);
    echo json_encode(["success" => true, "message" => "답변이 저장되었습니다."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
exit;
