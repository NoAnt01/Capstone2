<!-- video_lecture.php -->
<!--======-->
<!-- php -->
<!--======-->
<?php
// DB연결 실패시 오류 메세지 뿌려줌
//error_reporting(E_ALL);   // 모든 오류 표시
//ini_set('display_errors', 1); // 화면에 오류 출력

// ==== DB 연결 ====
// DB 설정 파일 인클루드
include __DIR__ . '/../../shared/api/db_config.php';

// ==== 페이지 ====
// 몇 개씩 보여줄지
$perPage = 12;

// 현재 페이지 번호 가져오기
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}

// 검색어 + 카테고리 처리
$search = "";
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$where = [];
$params = [];

if (!empty($_GET['q'])) {
    $search = trim($_GET['q']);
    $where[] = "title LIKE :search";
    $params[':search'] = "%$search%";
}

if ($category !== 'all') {
    $where[] = "category = :category";
    $params[':category'] = $category;
}

$whereSql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

// 총 강의 수 계산
$totalSql = "SELECT COUNT(*) as cnt FROM lectures $whereSql";
$stmt = $conn->prepare($totalSql);
$stmt->execute($params);
$totalRow = $stmt->fetch(PDO::FETCH_ASSOC);
$totalCount = $totalRow['cnt'];

// 총 페이지 수
$totalPages = ceil($totalCount / $perPage);

// 만약 현재 카테고리 결과 수($totalCount)가 perPage보다 작으면,
// 페이지네이션을 무시하고 한 페이지에 전부 출력되도록 perPage를 강제로 바꿈
if ($totalCount <= $perPage) {
    $perPage = $totalCount;
    $totalPages = 1;
}

// LIMIT 계산
$start = ($page - 1) * $perPage;

// 실제 강의 가져오기
$sql = "SELECT * FROM lectures $whereSql ORDER BY created_at DESC LIMIT :start, :perPage";
$stmt = $conn->prepare($sql);

// WHERE 절 파라미터 바인딩 (:search, :category 등)
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

// LIMIT 파라미터 정수형 바인딩
$stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
$stmt->bindValue(':perPage', (int) $perPage, PDO::PARAM_INT);

$stmt->execute();
$result = $stmt;

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
    <!-- php에서 읽어온 css 적용 -->
    <?= $style ?>
</head>

<body>
    <h1><span style="color: #007BFF;">추천</span> 강의 목록</h1>

    <!-- ==== 검색창 ==== -->
    <div class="search-container">
        <form id="search-form" method="get" action="">
            <input type="text" name="q" class="search-input" placeholder="원하시는 강의를 입력해주세요."
                value="<?= htmlspecialchars($search) ?>"> <!-- value -> 검색 후에도 입력한 검색어 남도록 -->
        </form>
    </div>

    <!-- ==== 카테고리 필터 ==== -->
    <div class="category-container">
        <button class="category-btn active" data-category="all">전체</button>
        <button class="category-btn" data-category="웹">웹</button>
        <button class="category-btn" data-category="AI 기초">AI 기초</button>
        <button class="category-btn" data-category="생성형 AI">생성형 AI</button>
        <button class="category-btn" data-category="머신러닝">머신러닝</button>
        <button class="category-btn" data-category="딥러닝">딥러닝</button>
        <button class="category-btn" data-category="기타">기타</button>
    </div>




    <!-- ==== 강의 카드 목록 ==== -->
    <!-- DB에서 불러온 강의 데이터 반복 출력 -->
    <div class="lecture-container">
        <?php if ($result && $result->rowCount() > 0): ?>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="lecture-card" data-category="<?= htmlspecialchars($row['category']) ?>">
                    <div class="thumbnail-container">
                        <?php
                        $imgData = $row['thumbnail']; // DB에 저장된 URL 그대로 사용
                        ?>
                        <img src="<?= htmlspecialchars($imgData) ?>" alt="강의 이미지" class="lecture-thumbnail">
                    </div>

                    <div class="lecture-content">
                        <h3 class="lecture-title"><?= htmlspecialchars($row['title']) ?></h3>
                        <p>
                            <span class="meta-label">강사:</span>
                            <span class="meta-value"><?= htmlspecialchars($row['instructor']) ?></span>
                            <span class="separator"> | </span>
                            <span class="meta-label">플랫폼:</span>
                            <span class="meta-value"><?= htmlspecialchars($row['platform']) ?></span>
                        </p>

                        <p><span class="meta-label">언어:</span> <span
                                class="meta-value"><?= htmlspecialchars($row['language']) ?></span></p>
                        <p><span class="meta-label">카테고리:</span> <span
                                class="meta-value"><?= htmlspecialchars($row['category']) ?></span></p>
                        <p class="meta-price"><?= htmlspecialchars($row['price']) ?></p>
                        <a href="<?= htmlspecialchars($row['link']) ?>" class="lecture-link" target="_blank">강의 보기</a>
                    </div>
                </div>
            <?php endwhile; ?>
            <!-- 데이터 없을 때 메세지 -->
        <?php else: ?>
            <p>등록된 강의가 없습니다.</p>
        <?php endif; ?>
    </div>

    <!-- ==== 페이지 버튼 ==== -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?q=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&page=<?= $page - 1 ?>">◀ 이전</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?q=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&page=<?= $i ?>"
                class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?q=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&page=<?= $page + 1 ?>">다음 ▶</a>
        <?php endif; ?>
    </div>



    <!-- ==== 자바 스크립트 ==== -->
    <!-- ==== 자바 스크립트 ==== -->
    <script>
        const searchInput = document.querySelector('.search-input');
        const lectureCards = document.querySelectorAll('.lecture-card');
        const categoryButtons = document.querySelectorAll('.category-btn');
        const searchForm = document.getElementById('search-form');

        let selectedCategory = 'all'; // 기본 카테고리 전체

        // 페이지 로드 시 전체 버튼 활성화
        const defaultButton = document.querySelector('.category-btn[data-category="all"]');
        if (defaultButton) {
            defaultButton.classList.add('active');
        }

        // 디바운스 타이머
        let debounceTimeout;

        // ===== 카드 필터링 함수 (검색 + 카테고리 연동) =====
        function filterCards() {
            const query = searchInput.value.toLowerCase();

            lectureCards.forEach(card => {
                const title = card.querySelector('.lecture-title').textContent.toLowerCase();
                const cardCategory = card.getAttribute('data-category');

                if ((title.includes(query) || query === '') &&
                    (selectedCategory === 'all' || cardCategory === selectedCategory)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // ===== 검색어 입력 이벤트 (디바운스 적용) =====
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                filterCards();
            }, 300); // 300ms 지연 후 실행
        });

        // ===== 카테고리 버튼 클릭 이벤트 =====
        categoryButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault(); // 새로고침 방지

                // 모든 버튼 비활성화 → 클릭한 버튼만 활성화
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                // 선택된 카테고리 갱신 후 필터 적용
                selectedCategory = button.getAttribute('data-category');
                filterCards();
            });
        });
    </script>


</body>

</html>

<!-- ==== DB 연결 종료 ==== -->
<?php $conn = null; ?>