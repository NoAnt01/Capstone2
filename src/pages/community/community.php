<?php
require_once __DIR__ . '/db.php';

// ---------- 검색 & 페이지네이션 ----------
$searchField = $_GET['field'] ?? 'all';       // all / title / content
$keyword     = trim($_GET['q'] ?? '');
$page        = max(1, (int)($_GET['page'] ?? 1));
$perPage     = 20;
$offset      = ($page - 1) * $perPage;

$where  = '1';
$params = [];

if ($keyword !== '') {
    if ($searchField === 'title') {
        $where = 'title LIKE :kw';
    } elseif ($searchField === 'content') {
        $where = 'content LIKE :kw';
    } else {
        $where = '(title LIKE :kw OR content LIKE :kw)';
    }
    $params[':kw'] = '%' . $keyword . '%';
}

// 전체(공지 제외) 글 수
$countSql  = "SELECT COUNT(*) FROM community_posts WHERE is_notice = 0 AND $where";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$total = (int)$countStmt->fetchColumn();
$totalPages = max(1, (int)ceil($total / $perPage));

// 공지글
$noticeSql = "
    SELECT id, board, title, author, created_at, views, comment_count
    FROM community_posts
    WHERE is_notice = 1 AND $where
    ORDER BY id DESC
";
$noticeStmt = $pdo->prepare($noticeSql);
$noticeStmt->execute($params);
$noticePosts = $noticeStmt->fetchAll(PDO::FETCH_ASSOC);

// 일반글
$listSql = "
    SELECT id, board, title, author, created_at, views, comment_count
    FROM community_posts
    WHERE is_notice = 0 AND $where
    ORDER BY id DESC
    LIMIT :limit OFFSET :offset
";
$listStmt = $pdo->prepare($listSql);
foreach ($params as $key => $val) {
    $listStmt->bindValue($key, $val, PDO::PARAM_STR);
}
$listStmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
$listStmt->bindValue(':offset', $offset,  PDO::PARAM_INT);
$listStmt->execute();
$posts = $listStmt->fetchAll(PDO::FETCH_ASSOC);

// 번호
$listNumber = $total - ($page - 1) * $perPage;

// XSS 방지
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
                    <li class="menu-item active" onclick="location.href='/community'">전체글 보기</li>
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
                <h2>전체글 보기</h2>
                <div class="actions">
                    <!-- 검색 폼 -->
                    <form method="get"
                          action="/community"
                          style="display:flex; gap:8px; align-items:center;">
                        <select name="field">
                            <option value="all"     <?= $searchField === 'all' ? 'selected' : '' ?>>전체</option>
                            <option value="title"   <?= $searchField === 'title' ? 'selected' : '' ?>>제목</option>
                            <option value="content" <?= $searchField === 'content' ? 'selected' : '' ?>>내용</option>
                        </select>
                        <input type="text"
                               name="q"
                               value="<?= esc($keyword) ?>"
                               placeholder="검색어를 입력하세요"
                               style="padding:7px 10px;border:1px solid #d1d5db;border-radius:999px;font-size:13px;">
                        <button type="submit" class="write-btn" style="box-shadow:none;">검색</button>
                    </form>

                    <!-- 글쓰기 버튼 -->
                    <button class="write-btn" onclick="location.href='/community_write'">글쓰기</button>
                </div>
            </div>

            <table class="post-list">
                <thead>
                <tr>
                    <th class="col-num">번호</th>
                    <th class="col-board">게시판</th>
                    <th class="col-title">제목</th>
                    <th class="col-author">작성자</th>
                    <th class="col-date">날짜</th>
                    <th class="col-views">조회</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($noticePosts) && empty($posts)): ?>
                    <tr>
                        <td colspan="6">등록된 게시글이 없습니다.</td>
                    </tr>
                <?php else: ?>
                    <!-- 공지 -->
                    <?php foreach ($noticePosts as $post): ?>
                        <tr>
                            <td><span class="notice-tag">공지</span></td>
                            <td><?= esc($post['board']) ?></td>
                            <td>
                                <a href="/community_view?id=<?= (int)$post['id'] ?>" class="post-title">
                                    <?= esc($post['title']) ?>
                                    <?php if ((int)$post['comment_count'] > 0): ?>
                                        [<?= (int)$post['comment_count'] ?>]
                                    <?php endif; ?>
                                </a>
                            </td>
                            <td><?= esc($post['author']) ?></td>
                            <td><?= date('Y.m.d', strtotime($post['created_at'])) ?></td>
                            <td><?= number_format((int)$post['views']) ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- 일반글 -->
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= $listNumber-- ?></td>
                            <td><?= esc($post['board']) ?></td>
                            <td>
                                <a href="/community_view?id=<?= (int)$post['id'] ?>" class="post-title">
                                    <?= esc($post['title']) ?>
                                    <?php if ((int)$post['comment_count'] > 0): ?>
                                        [<?= (int)$post['comment_count'] ?>]
                                    <?php endif; ?>
                                </a>
                            </td>
                            <td><?= esc($post['author']) ?></td>
                            <td><?= date('Y.m.d', strtotime($post['created_at'])) ?></td>
                            <td><?= number_format((int)$post['views']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

            <!-- 페이지네이션 -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="/community?page=<?= $page - 1 ?>&field=<?= urlencode($searchField) ?>&q=<?= urlencode($keyword) ?>">&lt;</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="/community?page=<?= $i ?>&field=<?= urlencode($searchField) ?>&q=<?= urlencode($keyword) ?>"
                       class="<?= $i === $page ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="/community?page=<?= $page + 1 ?>&field=<?= urlencode($searchField) ?>&q=<?= urlencode($keyword) ?>">&gt;</a>
                <?php endif; ?>
            </div>

            <!-- 하단 통합검색 -->
            <section id="community-search-section">
                <form class="search-bar" method="get" action="/community">
                    <input type="hidden" name="field" value="all">
                    <input type="text"
                           name="q"
                           placeholder="통합검색"
                           value="<?= esc($keyword) ?>">
                    <button type="submit"><span class="material-icons">search</span></button>
                </form>
            </section>

        </section>
    </main>
</div>
