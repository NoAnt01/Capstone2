<?php
header('Content-Type: application/json');
include __DIR__ . '/../../shared/api/db_config.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$current_pw = $_POST['current_pw'] ?? '';
$new_pw = $_POST['new_pw'] ?? '';

if (!$current_pw || !$new_pw) {
    echo json_encode(['success' => false, 'message' => '모든 비밀번호를 입력해주세요.'], JSON_UNESCAPED_UNICODE);
    exit;
}

// 새 비밀번호 유효성 검사
if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*]).{10,16}$/', $new_pw)) {
    echo json_encode(['success' => false, 'message' => '새 비밀번호는 영문/숫자/특수문자 조합으로 10~16자여야 합니다.'], JSON_UNESCAPED_UNICODE);
    exit;
}

// DB에서 현재 비밀번호 해시 조회
$stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'message' => '회원 정보를 찾을 수 없습니다.'], JSON_UNESCAPED_UNICODE);
    exit;
}

// 현재 비밀번호 확인
if (!password_verify($current_pw, $user['password'])) {
    echo json_encode(['success' => false, 'message' => '현재 비밀번호가 일치하지 않습니다.'], JSON_UNESCAPED_UNICODE);
    exit;
}

// 새 비밀번호 해시 생성
$new_pw_hash = password_hash($new_pw, PASSWORD_DEFAULT);

// DB 업데이트
$updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
$success = $updateStmt->execute([$new_pw_hash, $user_id]);

echo json_encode([
    'success' => $success,
    'message' => $success ? '비밀번호가 변경되었습니다.' : '비밀번호 변경 실패'
], JSON_UNESCAPED_UNICODE);
