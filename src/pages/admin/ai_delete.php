<?php
// ai_delete.php

// 1. DB 연결
include __DIR__ . '/../../shared/api/db_config.php';

// 2. 삭제 로직
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    if ($id) {
        try {
            // 외래키 제약조건이 있다면 매핑 테이블(ai_program_themes) 먼저 삭제 필요할 수 있음
            // (ON DELETE CASCADE가 설정되어 있다면 ai_programs만 삭제해도 됨)
            
            // 일단 메인 테이블 삭제 시도
            $sql = "DELETE FROM ai_programs WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // 에러 발생 시 (보통 외래키 문제) 경고창 띄우고 이동
            echo "<script>alert('삭제 실패: 다른 데이터와 연결되어 있어 삭제할 수 없습니다.'); location.href='/ai_management';</script>";
            exit;
        }
    }
}

// 3. 페이지 복귀 (라우터 경로 사용)
header("Location: /ai_management");
exit;
?>