<?php
session_start();
// signin.php
// =========
// php
// =========
// DB연결 실패시 오류 메세지 뿌려줌
error_reporting(E_ALL);   // 모든 오류 표시
ini_set('display_errors', 1); // 화면에 오류 출력

// ==== DB 연결 ====
// DB 설정 파일 인클루드
include __DIR__ . '/../../shared/api/db_config.php';

// ==== CSS 불러오기 ====
$style = '<style>' . file_get_contents(__DIR__ . '/style.css') . '</style>';
?>

<!--======-->
<!--html-->
<!--======-->
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아이픽 로그인</title>
    <?= $style ?>
</head>

<body>
    <div class="signin-container">
        <h2>로그인</h2>

        <!-- 로그인 폼 -->
        <form action="signin" method="post" class="signin-form">
            <input class="input-user_id" name="user_id" type="text" placeholder="아이디를 입력하세요." required>
            <input class="input-password" name="password" type="password" placeholder="비밀번호를 입력하세요." required>
            <button class="btn-signin" type="submit">로그인</button>
        </form>

        <div class="other-container">
            <button class="btn-signup" type="button" onclick="location.href='/agree'">회원가입</button>
        </div>
    </div>
</body>

</html>