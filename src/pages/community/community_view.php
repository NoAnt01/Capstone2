<?php
require_once __DIR__ . '/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo "잘못된 접근입니다.";
    return;
}

// 조회수 증가
$updateSql = "UPDATE community_posts SET views = views + 1 WHERE id = :id";
$updateStmt = $pdo->prepare($updateSql);
$updateStmt->execute([':id' => $id]);

// 글 조회
$sql = "
    SELECT id, board, title, content, author, created_at, views, comment_count, is_notice
    FROM community_posts
    WHERE id = :id
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    http_response_code(404);
    echo "게시글을 찾을 수 없습니다.";
    return;
}

function esc($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

// CSS 로드
$css_file_path = __DIR__ . '/community.css';
if (file_exists($css_file_path)) {
    $style = file_get_contents($css_file_path);
} else {
    $style = "/* ERROR: community.css 파일을 찾을 수 없습니다. */";
}
?>

<style>
<?= $style ?>
/* 상세뷰 전용 */
.post-view {
    padding: 16px 8px;
}
.post-view-header {
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 12px;
    padding-bottom: 8px;
}
.post-view-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 4px;
}
.post-view-meta {
    font-size: 12px;
    color: #6b7280;
}
.post-view-content {
    font-size: 14px;
    line-height: 1.7;
    margin-top: 16px;
    white-space: pre-wrap;
}
.post-view-actions {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}
.btn-secondary {
    border: 1px solid #d1d5db;
    background-color: #fff;
    color: #374151;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 13px;
    cursor: pointer;
}
.btn-secondary:hover {
    background-color: #f3f4f6;
}
</style>

<div id="wrapper">
    <header id="community-header">
        <div class="user-menu">
            <a href="#">내정보</a>
        </div>
    </header>

    <main id="main-container">
        <aside id="sidebar">
            <div class="menu-box">
                <h4>📝 게시판 목록</h4>
                <ul>
                    <li class="menu-item" onclick="location.href='/community'">전체글 보기</li>
                    <li class="menu-item <?= $post['is_notice'] ? 'active' : '' ?>">⭐ 중요 공지</li>
                </ul>
            </div>
            <div class="menu-box">
                <h4>💡 AI 게시판</h4>
                <ul>
                    <li class="menu-item">ChatGPT</li>
                    <li class="menu-item">Gemini</li>
                    <li class="menu-item">Claude</li>
                    <li class="menu-item">Midjourney</li>
                </ul>
            </div>
            <div class="menu-box">
                <h4>🙋‍♀️ 자유 토론</h4>
                <ul>
                    <li class="menu-item">자유 잡담</li>
                    <li class="menu-item">Q&A 및 도움말</li>
                </ul>
            </div>
        </aside>

        <section id="content-area">
            <div class="board-header">
                <h2><?= esc($post['board']) ?></h2>
                <div class="actions">
                    <button class="write-btn" onclick="location.href='/community_write'">글쓰기</button>
                </div>
            </div>

            <div class="post-view">
                <div class="post-view-header">
                    <div class="post-view-title">
                        <?= esc($post['title']) ?>
                        <?php if ($post['is_notice']): ?>
                            <span class="notice-tag" style="margin-left:4px;">공지</span>
                        <?php endif; ?>
                    </div>
                    <div class="post-view-meta">
                        작성자: <?= esc($post['author']) ?> ·
                        작성일: <?= date('Y.m.d H:i', strtotime($post['created_at'])) ?> ·
                        조회: <?= number_format((int)$post['views']) ?> ·
                        댓글: <?= (int)$post['comment_count'] ?>
                    </div>
                </div>

                <div class="post-view-content">
                    <?= nl2br(esc($post['content'])) ?>
                </div>

                <div class="post-view-actions">
                    <button class="btn-secondary" onclick="location.href='/community'">목록</button>
                </div>
            </div>
        </section>
    </main>
</div>
