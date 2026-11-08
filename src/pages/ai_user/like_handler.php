<?php
ob_start(); 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../shared/api/db_config.php'; 
header('Content-Type: application/json');

$ai_id = $_POST['ai_id'] ?? null; 
$user_id = $_POST['user_id'] ?? null;

$response = ['success' => false, 'action' => 'none', 'new_count' => 0, 'message' => ''];

if (!isset($conn)) {
    $response['message'] = "DB 연결 실패: 설정 확인 요망";
    ob_end_clean(); 
    echo json_encode($response);
    exit;
}

if (!$ai_id || !$user_id || !is_numeric($ai_id)) {
    $response['message'] = '좋아요를 하려면 로그인이 필요합니다.';
    ob_end_clean(); 
    echo json_encode($response);
    exit;
}

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction(); 

    $sql_check = "SELECT COUNT(*) FROM user_likes WHERE user_id = :user_id AND ai_id = :ai_id"; 
    $stmt_check = $conn->prepare($sql_check);
    
    $stmt_check->execute([':user_id' => $user_id, ':ai_id' => $ai_id]);
    
    $is_liked = $stmt_check->fetchColumn() > 0;
    $stmt_check = null; 

    if ($is_liked) {
        //좋아요 취소 (DELETE)
        $sql_action = "DELETE FROM user_likes WHERE user_id = :user_id AND ai_id = :ai_id"; 
        $action_done = 'unliked';
        $sql_update_count = "UPDATE ai_programs SET likes = likes - 1 WHERE id = :ai_id"; 
    } else {
        //좋아요 추가 (INSERT)
        $sql_action = "INSERT INTO user_likes (user_id, ai_id) VALUES (:user_id, :ai_id)";
        $action_done = 'liked';
        $sql_update_count = "UPDATE ai_programs SET likes = likes + 1 WHERE id = :ai_id";
    }
    
    // 좋아요 기록(user_likes) 수정
    $stmt_action = $conn->prepare($sql_action);
    $stmt_action->execute([':user_id' => $user_id, ':ai_id' => $ai_id]);
    $stmt_action = null; 

    // 총 좋아요 수(ai_programs) 업데이트 
    $stmt_update = $conn->prepare($sql_update_count);
    $stmt_update->execute([':ai_id' => $ai_id]);
    $stmt_update = null; 

    // 업데이트된 최종 좋아요 수 조회 
    $sql_fetch_count = "SELECT likes FROM ai_programs WHERE id = :ai_id";
    $stmt_fetch = $conn->prepare($sql_fetch_count);
    $stmt_fetch->execute([':ai_id' => $ai_id]);
    
    $new_count = $stmt_fetch->fetch(PDO::FETCH_ASSOC)['likes'];
    $stmt_fetch = null; 
    $conn->commit(); 

    $response['success'] = true;
    $response['action'] = $action_done;
    $response['new_count'] = $new_count;

} catch (PDOException $e) { 
    $conn->rollBack(); 
    $response['message'] = "DB 처리 실패: " . $e->getMessage(); 
}

ob_end_clean(); 
echo json_encode($response);
?>