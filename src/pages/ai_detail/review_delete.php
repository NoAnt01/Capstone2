<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../shared/api/db_config.php'; 

$current_user_id = $_SESSION['user_id'] ?? null;
if (!$current_user_id) {
    header('Location: /ai_detail?error=login_required');
    exit;
}

$review_id = (int)($_GET['review_id'] ?? 0);
$ai_id_for_redirect = (int)($_GET['ai_id'] ?? 0); 

if ($review_id <= 0 || $ai_id_for_redirect <= 0) {
    header('Location: /ai_detail?error=invalid_id');
    exit;
}

try {
    if (!isset($conn) || !$conn) {
        throw new Exception("DB 연결 실패.");
    }

    $stmt = $conn->prepare("
        DELETE FROM ai_reviews 
        WHERE id = :review_id AND user_id = :user_id
    ");
    
    $stmt->bindParam(':review_id', $review_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $current_user_id, PDO::PARAM_STR); // 문자열 ID 바인딩
    
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header('Location: /ai_detail?id=' . $ai_id_for_redirect . '&success=review_deleted#reviews');
        exit;
    } else {
        header('Location: /ai_detail?id=' . $ai_id_for_redirect . '&error=permission_denied');
        exit;
    }

} catch (Exception $e) {
    error_log("Review Deletion Error: " . $e->getMessage());
    header('Location: /ai_detail?id=' . $ai_id_for_redirect . '&error=db_delete_fail');
    exit;
}
?>