<!-- ==== php ==== -->
<?php
// ==== DB 연결 ==== 
include __DIR__ . '/../../shared/api/db_config.php';

// ==== 문의 테이블(inquiries) 조회 ====
$sql = "SELECT * FROM inquiries ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();

$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ==== 상단 카드(문의 수) 카운트 ====
$totalCount = count($inquiries);
$answeredCount = 0;
$unansweredCount = 0;
foreach ($inquiries as $inq) {
    if ($inq['replied_at']) {
        $answeredCount++;
    } else {
        $unansweredCount++;
    }
}

// =======================================================
//              CSS 로드 (파일 경로: admin.css)
// =======================================================
$style1 = file_get_contents(__DIR__ . '/admin.css');
$style2 = file_get_contents(__DIR__ . '/inquiry_admin.css');
$style = '<style>' . $style1 . $style2 . '</style>';
if ($style === false) {
    $style = '/* Error: Failed to load admin.css */';
}

// ==== JS 로드 ====
$inquiry_admin_script = file_get_contents(__DIR__ . '/inquiry_admin.js');
?>


<!-- ==== html ==== -->
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        <?php echo $style; ?>
    </style>
</head>

<body>
    <div class="container">
        <?php require_once 'dashbord.php'; ?>

        <main class="main-content">

            <div class="header-section">
                <h2>문의 답변</h2>
            </div>

            <!-- ==== 상단 카드(전체 문의, 미답변, 답변 완료) ====  -->
            <section class="stats-cards">
                <div class="card stat-card" data-filter="all">
                    <div class="icon-box blue"><i class="fa-solid fa-pen"></i></div>
                    <div class="stat-info">
                        <p class="title">전체 문의</p>
                        <p class="value"><?= $totalCount ?>개</p>
                    </div>
                </div>
                <div class="card stat-card" data-filter="unanswered">
                    <div class="icon-box red"><i class="fa-solid fa-exclamation"></i></i></div>
                    <div class="stat-info">
                        <p class="title">미답변</p>
                        <p class="value"><?= $unansweredCount ?>개</p>
                    </div>
                </div>
                <div class="card stat-card" data-filter="answered">
                    <div class="icon-box green"><i class="fas fa-check"></i></div>
                    <div class="stat-info">
                        <p class="title">답변 완료</p>
                        <p class="value"><?= $answeredCount ?>개</p>
                    </div>
                </div>
            </section>

            <!-- ==== 문의들 ====  -->
            <section class="list-management">
                <div class="list-header">
                    <h3>문의 목록</h3>
                </div>

                <!--        // 추후 정렬, ID 검색, 미답변 목록, 답변 완료 목록 등
                <div class="filter-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="AI 이름, 카테고리, 설명 검색...">
                    </div>
                    <select class="category-select">
                        <option value="all">전체 카테고리</option>
                        <option value="text">텍스트 생성</option>
                        <option value="image">이미지 생성</option>
                        <option value="voice">음성 인식</option>
                        <option value="vision">비전 분석</option>
                    </select>
                </div>
-->
                <div class="card table-card">
                    <table>
                        <thead>
                            <tr>
                                <th class="col-id">문의번호</th>
                                <th class="col-user">닉네임</th>
                                <th class="col-title">제목</th>
                                <th class="col-content">내용</th>
                                <th class="col-reply">답변</th>
                                <th class="col-created">작성일</th>
                                <th class="col-replied">답변일</th>
                                <th class="col-actions">작업</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inquiries as $inq): ?>
                                <tr class="<?= $inq['replied_at'] ? 'answered' : '' ?>">
                                    <td class="col-id"><?= $inq['id'] ?></td>
                                    <td class="col-user">
                                        <span class="ellipsis"><?= htmlspecialchars($inq['user_id']) ?></span>
                                    </td>
                                    <td class="col-title">
                                        <span class="ellipsis-long" data-fulltext="<?= htmlspecialchars($inq['title']) ?>">
                                            <?= htmlspecialchars($inq['title']) ?>
                                        </span>
                                    </td>
                                    <td class="col-content">
                                        <span class="ellipsis-long"
                                            data-fulltext="<?= htmlspecialchars($inq['content']) ?>">
                                            <?= nl2br(htmlspecialchars($inq['content'])) ?>
                                        </span>
                                    </td>
                                    <td class="col-reply">
                                        <span class="ellipsis-long" data-fulltext="<?= htmlspecialchars($inq['reply']) ?>">
                                            <?= nl2br(htmlspecialchars($inq['reply'])) ?>
                                        </span>
                                    </td>
                                    <td class="col-created">
                                        <?= date("Y-m-d H:i", strtotime($inq['created_at'])) ?>
                                    </td>
                                    <td class="col-replied">
                                        <?= $inq['replied_at'] ? date("Y-m-d H:i", strtotime($inq['replied_at'])) : "-" ?>
                                    </td>
                                    <td class="col-actions action-icons">
                                        <i class="fas fa-edit edit-icon"></i>
                                        <i class="fas fa-trash-alt delete-icon"></i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- 읽기 전용 모달 -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <!-- "닉네임"님의 문의 내용 -->
            <h2 id="viewModalUser"></h2>
            <!-- 문의 제목 -->
            <h3 id="viewModalTitle"></h3>
            <!-- 문의 내용 -->
            <div id="viewModalContent" class="modal-content-text"></div>
            <!-- 문의 답변 -->
            <h3 class="modal-subtitle">문의 답변</h3>
            <div id="viewModalReply" class="modal-content-text"></div>
        </div>
    </div>

    <!-- 답변 작성용 모달 -->
    <div id="replyModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <!-- "닉네임"님의 문의 내용 -->
            <h2 id="replyModalUser"></h2>
            <!-- 문의 제목 -->
            <p id="modalTitle" class="modal-title"></p>
            <!-- 문의 내용 -->
            <p id="modalContent" class="modal-content-text"></p>

            <h3 class="modal-subtitle">답변 작성</h3>
            <textarea id="replyText" rows="5" placeholder="답변 내용을 입력하세요"></textarea>
            <div class="modal-button-group">
                <button id="saveReply">저장</button>
            </div>
        </div>
    </div>

</body>

</html>

<script>
    <?php echo $inquiry_admin_script; // js와 연결하는 코드 ?>
</script>