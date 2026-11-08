<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "로그인이 필요합니다."]);
    exit;
}

if (!isset($_POST['id'])) {
    echo json_encode(["success" => false, "message" => "삭제할 문의 ID가 없습니다."]);
    exit;
}

include __DIR__ . '/../../shared/api/db_config.php';

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'] ?? 'user'; // 기본은 user
$id = (int)$_POST['id'];

try {
    if ($user_role === 'admin') {
        // 관리자: 모든 문의 삭제 가능
        $sql = "DELETE FROM inquiries WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

    } else {
        // 일반 유저: 본인의 문의만 삭제 가능
        $sql = "DELETE FROM inquiries WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id, $user_id]);
    }

    echo json_encode(["success" => true]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
