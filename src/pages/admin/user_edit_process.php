<?php
// user_edit_process.php - AJAX 요청 처리 (사용자 정보 업데이트)
header('Content-Type: application/json');
// 1. DB 연결 설정 포함
include __DIR__ . '/../../shared/api/db_config.php';

// POST 요청 확인
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => '잘못된 접근입니다.']);
    exit;
}

// 2. 입력 데이터 정리 및 필터링
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$user_id = trim($_POST['user_id'] ?? '');
$email = trim($_POST['email'] ?? '');
$nickname = trim($_POST['nickname'] ?? '');
$role = trim($_POST['role'] ?? '');
// 체크박스가 체크되지 않으면 POST 데이터에 포함되지 않으므로 isset으로 확인
$email_agree = isset($_POST['email_agree']) ? 1 : 0; 
$password = $_POST['password'] ?? ''; 

if (!$id || empty($user_id) || empty($email) || empty($nickname) || empty($role)) {
    echo json_encode(['success' => false, 'message' => '필수 정보가 누락되었거나 유효하지 않습니다.']);
    exit;
}

try {
    // 3. SQL UPDATE 쿼리 생성
    $sql = "UPDATE users SET user_id = :user_id, email = :email, nickname = :nickname, role = :role, email_agree = :email_agree";
    
    // 비밀번호가 입력되었다면 (변경하려는 경우), 비밀번호 업데이트 구문 추가
    if (!empty($password)) {
        // !!! 주의: 실제 환경에서는 반드시 password_hash()를 사용해야 합니다. !!!
        $hashed_password = $password; // 여기서는 임시
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
        $sql .= ", password = :password";
    }
    
    $sql .= " WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    
    // 4. 파라미터 바인딩
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':nickname', $nickname, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':email_agree', $email_agree, PDO::PARAM_INT);
    
    if (!empty($password)) {
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    }
    
    $stmt->execute();
    
    // 5. 성공 응답
    echo json_encode(['success' => true, 'message' => '사용자 정보가 업데이트되었습니다.']);

} catch (PDOException $e) {
    error_log("User Update DB Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => '데이터베이스 오류로 정보 수정에 실패했습니다.']);
}
?>