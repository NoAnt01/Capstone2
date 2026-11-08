<?php
header('Content-Type: application/json');

/* 오류확인 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* 출력 버퍼 시작 -> 공백/HTML 방지 */
ob_start();

include __DIR__ . '/../../shared/api/db_config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => '로그인 필요']);
    ob_end_flush();
    exit;
}

$email_agree = (isset($_POST['email_agree']) && $_POST['email_agree'] == 1) ? 1 : 0;

$stmt = $conn->prepare("UPDATE users SET email_agree = ? WHERE user_id = ?");
$success = $stmt->execute([$email_agree, $user_id]);

echo json_encode([
    'success' => $success,
    'email_agree' => $email_agree
]);

/* 출력 버퍼 비우고 종료 */
ob_end_flush();
exit;
