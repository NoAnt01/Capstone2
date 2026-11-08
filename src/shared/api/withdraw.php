<?php
header('Content-Type: application/json');
include __DIR__ . '/../../shared/api/db_config.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
    exit;
}

// DB에서 회원 삭제
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$success = $stmt->execute([$user_id]);

if ($success) {
    session_destroy();
}

echo json_encode([
    'success' => $success,
    'message' => $success ? '회원 탈퇴가 완료되었습니다.' : '회원 탈퇴 실패'
]);
