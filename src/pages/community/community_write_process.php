<?php
// 저장 처리: POST /community_write 에서 호출
require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 폼 값 받기
$board   = trim($_POST['board']   ?? '');
$title   = trim($_POST['title']   ?? '');
$content = trim($_POST['content'] ?? '');
$isNotice = isset($_POST['is_notice']) ? 1 : 0;

// 로그인된 사용자 이름(프로젝트 상황에 맞게 필드명 조정)
$author =
    $_SESSION['user_nickname'] ??
    $_SESSION['user_name']     ??
    $_SESSION['user_id']       ??
    '익명';

if ($board === '' || $title === '' || $content === '') {
    header('Location: /community_write?error=1');
    exit;
}

$sql = "
    INSERT INTO community_posts (board, title, content, author, is_notice)
    VALUES (:board, :title, :content, :author, :is_notice)
";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':board'    => $board,
    ':title'    => $title,
    ':content'  => $content,
    ':author'   => $author,
    ':is_notice'=> $isNotice,
]);

$newId = $pdo->lastInsertId();

// 새 글 상세 페이지로 이동
header('Location: /community_view?id=' . $newId);
exit;
