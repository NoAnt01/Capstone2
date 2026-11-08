<?php
// ai_edit_process.php
header('Content-Type: application/json');

// 1. DB 연결
include __DIR__ . '/../../shared/api/db_config.php';

// 2. POST 요청 확인
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => '잘못된 접근입니다.']);
    exit;
}

// 3. 입력 데이터 정리 (기존 4개 필드 + ID)
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$name = trim($_POST['name'] ?? '');
$min_price = filter_var($_POST['min_price'], FILTER_VALIDATE_INT);
$max_price = filter_var($_POST['max_price'], FILTER_VALIDATE_INT);
$description = trim($_POST['description'] ?? '');

// 4. 필수 데이터 유효성 검사
if (!$id || empty($name)) {
    echo json_encode(['success' => false, 'message' => '필수 정보(ID, 이름)가 누락되었습니다.']);
    exit;
}

try {
    // 5. SQL 업데이트 실행
    // 조회수(views), 좋아요(likes), 등록일(release_date) 등은 건드리지 않습니다.
    // last_update(수정일)만 현재 시간(NOW())으로 자동 갱신합니다.
    
    $sql = "UPDATE ai_programs 
            SET name = :name, 
                min_price = :min_price, 
                max_price = :max_price, 
                description = :description,
                last_update = NOW()
            WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':min_price', $min_price, PDO::PARAM_INT);
    $stmt->bindParam(':max_price', $max_price, PDO::PARAM_INT);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => '성공적으로 수정되었습니다.']);

} catch (PDOException $e) {
    // 에러 발생 시 메시지 반환
    echo json_encode(['success' => false, 'message' => 'DB 오류: ' . $e->getMessage()]);
}
?>