<!-- 문의 페이지 -->

<!-- ==== php ==== -->
<?php
// 오류 확인
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// ==== CSS, JS 불러오기 ====
$style = '<style>' . file_get_contents(__DIR__ . '/inquiry.css') . '</style>';
$inquiry_script = file_get_contents(__DIR__ . '/inquiry.js');

// ==== DB 연결 ==== 
include __DIR__ . '/../../shared/api/db_config.php';

// 로그인 체크
if (!isset($_SESSION['user_id'])) {
    die("로그인 후 이용해주세요.");
}

$user_id = $_SESSION['user_id'];

// DB 조회
$sql = "SELECT * FROM inquiries WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$inquiries = $stmt->fetchAll();

$perPage = 3; // 한 페이지에 표시할 문의 수
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($page - 1) * $perPage;

// 총 문의 수
$countStmt = $conn->prepare("SELECT COUNT(*) FROM inquiries WHERE user_id = ?");
$countStmt->execute([$user_id]);
$totalCount = (int) $countStmt->fetchColumn();
$totalPages = ceil($totalCount / $perPage);

// 현재 페이지 문의 목록
$sql = "SELECT * FROM inquiries WHERE user_id = ? ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$inquiries = $stmt->fetchAll();
?>

<!-- ==== html ==== -->
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $style ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="inquiry-wrapper">
        <div class="inquiry-container">
            <h1>1:1 문의하기</h1>


            <!-- 기존 문의 목록 -->
            <section class="inquiry-list">
                <h2>나의 문의 내역</h2>

                <?php foreach ($inquiries as $q): ?>
                    <div class="inquiry-item">
                        <button class="delete-btn" data-id="<?= $q['id'] ?>"><i class="fas fa-trash"></i></button>
                        <div class="question">
                            <strong><?= htmlspecialchars($q['title']) ?></strong>
                            <?php if ($q['reply']): ?>
                                <span class="answer-badge">답변완료</span>
                            <?php endif; ?>

                            <p><?= nl2br(htmlspecialchars($q['content'])) ?></p>
                            <span class="date"><?= date('Y-m-d H:i', strtotime($q['created_at'])) ?></span>
                        </div>

                        <?php if ($q['reply']): ?>
                            <div class="answer hidden">
                                <strong>관리자 답변</strong>
                                <span class="date"><?= date('Y-m-d H:i', strtotime($q['replied_at'])) ?></span>
                                <p><?= nl2br(htmlspecialchars($q['reply'])) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <!-- 페이지 버튼 -->
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>


            </section>

            <!-- 새 문의 작성 -->
            <section class="write-section">
                <h2>새 문의 작성</h2>

                <form action="/inquiry_write" method="POST" class="write-form">
                    <input type="text" name="title" placeholder="제목을 입력하세요" required>

                    <textarea name="content" placeholder="문의 내용을 입력하세요" required></textarea>

                    <button type="submit" class="send-btn">문의 보내기</button>
                </form>
            </section>

        </div>
    </div>

</body>

</html>

<script>
    <?php echo $inquiry_script; // JS와 연결 ?>
</script>