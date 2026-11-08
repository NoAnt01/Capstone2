<?php
header('Content-Type: application/json');
include __DIR__ . '/../../shared/api/db_config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
    exit;
}

$new_nickname = trim($_POST['nickname'] ?? '');
$new_email = trim($_POST['email'] ?? '');

if ($new_nickname === '' || $new_email === '') {
    echo json_encode(['success' => false, 'message' => '닉네임과 이메일을 모두 입력해주세요.']);
    exit;
}

// 닉네임 검사 (10자 이하, 특수문자 제외)
if (!preg_match('/^[가-힣a-zA-Z0-9]{1,10}$/u', $new_nickname)) {
    echo json_encode(['success' => false, 'message' => '닉네임은 한글, 영어, 숫자만 사용 가능하며 최대 10자까지 가능합니다.']);
    exit;
}

// 이메일 검사 (@)
if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => '올바른 이메일 주소를 입력해주세요.']);
    exit;
}

// 닉네임 중복 확인 (자신 제외)
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE nickname = ? AND user_id != ?");
$checkStmt->execute([$new_nickname, $user_id]);
$isDuplicate = $checkStmt->fetchColumn();

if ($isDuplicate > 0) {
    echo json_encode(['success' => false, 'message' => '이미 사용 중인 닉네임입니다.']);
    exit;
}

// DB 업데이트
$stmt = $conn->prepare("UPDATE users SET nickname = ?, email = ? WHERE user_id = ?");
$success = $stmt->execute([$new_nickname, $new_email, $user_id]);

if ($success) {
    $_SESSION['nickname'] = $new_nickname;
    $_SESSION['email'] = $new_email;
}

echo json_encode([
    'success' => $success,
    'nickname' => $new_nickname,
    'email' => $new_email,
    'message' => $success ? '정보가 수정되었습니다.' : '업데이트 실패'
]);
