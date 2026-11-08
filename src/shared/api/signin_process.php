<?php
session_start();
include __DIR__ . '/db_config.php'; // DB 연결

$user_id = $_POST['user_id'] ?? '';
$password = $_POST['password'] ?? '';

if ($user_id && $password) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 디버깅
    //echo "<pre>";
    //var_dump($user_id);                   // POST로 넘어온 아이디
    //var_dump($password);                  // POST로 넘어온 비밀번호
    //var_dump($user['password']);          // DB에서 가져온 해시
    //var_dump(password_verify($password, $user['password'])); // password_verify 결과
    //echo "</pre>";
    //exit;

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['nickname'] = $user['nickname'];
        $_SESSION['role'] = $user['role'];

        header("Location: /"); // 로그인 성공시 메인페이지
        exit;
    } else {
        // 아이디 또는 비밀번호 틀릴시
        echo "<script>alert('아이디 또는 비밀번호가 틀렸습니다.'); history.back();</script>";
        exit;
    }
}

