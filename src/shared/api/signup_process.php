<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// 이미 세션이 시작되어 있는지 확인
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==== DB 연결 ====
// DB 설정 파일 인클루드
include __DIR__ . '/../../shared/api/db_config.php';

// ==== 폼 데이터 가져오기 ====
$user_id  = $_POST['user_id'] ?? '';
$password = $_POST['password'] ?? '';
$email    = $_POST['email'] ?? '';
$nickname = $_POST['nickname'] ?? '';
$email_agree = isset($_POST['email_agree']) && $_POST['email_agree'] == 1 ? 1 : 0;

// ==== 필수 입력값 검증 ====
if (!$user_id || !$password || !$email || !$nickname) {
    echo "<script>
      alert('모든 필드를 입력해주세요.');
      history.back();
    </script>";
    exit;
}

// ==== 아이디 중복 검사 ====
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$count = $stmt->fetchColumn(); // COUNT 결과 가져오기

// ==== 닉네임 중복 검사 ====
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE nickname = :nickname");
$stmt->bindParam(':nickname', $nickname);
$stmt->execute();
$count_nick = $stmt->fetchColumn();

if ($count_nick > 0) {
    echo "<script>
      alert('이미 사용 중인 닉네임입니다.');
      history.back();
    </script>";
    exit;
}

if ($count > 0) {
    echo "<script>
      alert('이미 사용 중인 아이디입니다.');
      history.back();
    </script>";
    exit;
}

// ==== 비밀번호 해시 암호화 ====
$hashed_pw = password_hash($password, PASSWORD_BCRYPT);

// ==== 회원정보 DB 삽입====
$stmt = $conn->prepare("
    INSERT INTO users (user_id, password, email, nickname, email_agree, role, created_at) 
    VALUES (:user_id, :password, :email, :nickname, :email_agree, 'user', NOW())
");

$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':password', $hashed_pw);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':nickname', $nickname);
$stmt->bindParam(':email_agree', $email_agree, PDO::PARAM_INT);

if ($stmt->execute()) { //execute() 후 성공 여부 확인, 성공 시 알림 후 로그인 페이지로 이동
    echo "<script>
      alert('회원가입이 완료되었습니다!');
      window.location.href = '/signin';
    </script>";
} else {
    // 실패 시 - 에러 안내
    echo "<script>
      alert('회원가입 중 오류가 발생했습니다. 다시 시도해주세요.');
      history.back();
    </script>";
}

// ==== 종료 ====
$conn = null;