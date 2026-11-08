<?php
// user_delete.php - 사용자 삭제 처리

// 1. DB 연결 설정 포함
include __DIR__ . '/../../shared/api/db_config.php';

// 결과 메시지 초기화
$status = 'error';
$message = '잘못된 요청입니다.';

// 요청이 POST 방식인지, 그리고 user_id가 전송되었는지 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    
    // 2. 입력값 검증 및 정수형 변환
    $user_id = filter_var($_POST['user_id'], FILTER_VALIDATE_INT);

    if ($user_id === false || $user_id === null) {
        $message = '유효하지 않은 사용자 ID입니다.';
    } else {
        try {
            // 3. SQL DELETE 쿼리 준비 및 실행
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $conn->prepare($sql);
            
            // 파라미터 바인딩
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // 삭제된 행의 수가 1개 이상인지 확인
            if ($stmt->rowCount() > 0) {
                $status = 'success';
                $message = '사용자가 성공적으로 삭제되었습니다.';
            } else {
                $message = '해당 ID의 사용자를 찾을 수 없거나 이미 삭제되었습니다.';
            }

        } catch (PDOException $e) {
            // DB 오류 처리
            error_log("User Deletion Error: " . $e->getMessage());
            $message = '데이터베이스 오류가 발생했습니다.';
        }
    }
}

// 4. 사용자 관리 페이지로 리다이렉션
// 성공/실패 여부를 URL 파라미터로 전달하여 사용자에게 알림
header("Location: /user_management?status=" . $status . "&message=" . urlencode($message));
exit;
?>