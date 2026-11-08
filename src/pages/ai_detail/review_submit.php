<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_user_id = $_SESSION['user_id'] ?? 0;
$current_user_name = $_SESSION['user_name'] ?? 'Guest'; 

include_once __DIR__ . '/../../shared/api/db_config.php'; 

// 2. POST 요청 확인 및 데이터 유효성 검사
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['ai_id'], $_POST['content'])) {
    header('Location: /ai_detail?error=invalid_access');
    exit;
}

// 3. 데이터 정리
$ai_id = (int)$_POST['ai_id'];
$user_id = $_SESSION['user_id'] ?? 0;
$content = trim($_POST['content']);


// 4. 내용 길이 및 로그인 검증
if ($user_id <= 0 || empty($content)) {
    header('Location: /ai_detail?id=' . $ai_id . '&error=login_or_content_missing');
    exit;
}

// 3. 데이터 정리
$ai_id = (int)$_POST['ai_id'];
$user_id = $_SESSION['user_id'] ?? 0;
$content = trim($_POST['content']);

// 4. 내용 길이 및 로그인 검증
if ($user_id <= 0 || empty($content)) {
    header('Location: /ai_detail?id=' . $ai_id . '&error=login_or_content_missing');
    exit;
}

// 5. 데이터베이스 저장 로직
try {
    if (!isset($conn) || !$conn) {
        throw new Exception("DB 연결 실패.");
    }
    
    // 🔴 1. DB 저장을 시도하기 전에 $user_id를 정수형으로 강제 변환
    $user_id_int = (int)$user_id; 
    $current_time = date('Y-m-d H:i:s');
    
    // SQL 삽입 쿼리 준비
    $stmt = $conn->prepare("INSERT INTO ai_reviews (ai_id, user_id, content, created_at) VALUES (:ai_id, :user_id, :content, :created_at)");
    
    $stmt->bindParam(':ai_id', $ai_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':created_at', $current_time, PDO::PARAM_STR);
    
    $stmt->execute();
    
    // 성공 후, 사용자를 상세 페이지로 리다이렉트
    header('Location: /ai_detail?id=' . $ai_id . '&success=review_posted#reviews');
    exit;

} catch (Exception $e) {
    // 🔴 2. DB 오류 발생 시, 오류 메시지를 화면에 출력하고 종료합니다.
    echo "<h1>DB 저장 오류 발생 (Fatal Error)</h1>";
    echo "<p>ErrorCode: db_fail</p>";
    echo "<p>문제 ID: " . htmlspecialchars($user_id) . "</p>";
    echo "<p><strong>DB Exception Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>🚨 위의 메시지를 알려주세요. 외래 키 위반 메시지일 가능성이 높습니다.</p>";
    
    // error_log("Review Submission Error: " . $e->getMessage()); // 로그 기록은 유지
    // header('Location: /ai_detail?id=' . $ai_id . '&error=db_fail'); // 리다이렉트 대신 화면 출력
    exit;
}
?>