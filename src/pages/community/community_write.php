<?php
require_once __DIR__ . '/db.php';

// CSS
$css_file_path = __DIR__ . '/community.css';
if (file_exists($css_file_path)) {
    $style = file_get_contents($css_file_path);
} else {
    $style = "/* ERROR: community.css 파일을 찾을 수 없습니다. */";
}

function esc($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

$error = isset($_GET['error']) ? (int)$_GET['error'] : 0;
?>

<style>
<?= $style ?>
/* 글쓰기 전용 간단 스타일 */
.write-form {
    padding: 16px 8px;
}
.write-form label {
    display: block;
    margin-top: 10px;
    font-size: 13px;
    font-weight: 600;
}
.write-form input[type="text"],
.write-form select,
.write-form textarea {
    width: 100%;
    padding: 8px;
    margin-top: 4px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 13px;
}
.write-form textarea {
    min-height: 200px;
    resize: vertical;
}
.write-form-actions {
    margin-top: 16px;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}
.error-msg {
    margin-top: 8px;
    font-size: 12px;
    color: #e11d48;
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
                    <li class="menu-item">⭐ 중요 공지</li>
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
                <h2>글쓰기</h2>
                <div class="actions">
                    <button class="write-btn" onclick="location.href='/community'">목록</button>
                </div>
            </div>

            <div class="write-form">
                <?php if ($error === 1): ?>
                    <div class="error-msg">게시판, 제목, 내용을 모두 입력해 주세요.</div>
                <?php endif; ?>

                <form method="post" action="/community_write">
                    <label for="board">게시판</label>
                    <select name="board" id="board" required>
                        <option value="자유 잡담">자유 잡담</option>
                        <option value="ChatGPT">ChatGPT</option>
                        <option value="Gemini">Gemini</option>
                        <option value="Claude">Claude</option>
                        <option value="Midjourney">Midjourney</option>
                    </select>

                    <label for="title">제목</label>
                    <input type="text" id="title" name="title" required>

                    <label for="content">내용</label>
                    <textarea id="content" name="content" required></textarea>

                    <label style="margin-top:10px;font-weight:500;">
                        <input type="checkbox" name="is_notice" value="1">
                        중요 공지로 등록
                    </label>

                    <div class="write-form-actions">
                        <button type="button" class="btn-secondary" onclick="location.href='/community'">취소</button>
                        <button type="submit" class="write-btn">등록</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>
