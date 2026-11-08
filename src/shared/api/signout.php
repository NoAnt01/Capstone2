<?php
// ==== 로그아웃 처리 ====
// 세션 시작
session_start();

// 세션 초기화 및 제거
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 세션 완전 종료
session_destroy();

// 리다이렉트
header("Location: /");
exit;