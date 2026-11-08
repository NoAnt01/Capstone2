<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_user_id = $_SESSION['user_id'] ?? 0;

include_once __DIR__ . '/../../shared/api/db_config.php';
include_once __DIR__ . '/../../shared/componets/cardUI_query.php';
include_once __DIR__ . '/../../shared/componets/themes_func.php';

$style1 = file_get_contents(__DIR__ . '/../../shared/componets/ai_rec_cardUI.css');
$style2 = file_get_contents(__DIR__ . '/ai_theme.css');
$style = '<style>' . $style1 . $style2 . '</style>';

$unique_themes = [];


// 테마 전체 목록 조회
$sql_themes = "SELECT theme_name FROM ai_themes ORDER BY theme_name ASC";
try {
    $ret3 = $conn->prepare($sql_themes);
    $ret3->execute();
    $unique_themes = $ret3->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Query Error (unique_themes): " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?></title>
<?= $style ?>
</head>
<body>

    <h1><?= htmlspecialchars($page_title) ?></h1>
    <p class="comp-description">내게 딱 맞는 <span style="color: #007BFF;">AI 추천 !</span></p>

    <div class="filter-controls">
        <input type="text" id="aiSearch" placeholder="AI 이름, 요약 또는 테마로 검색" class="search-input">

        <ul class="filter-tabs">
            <li class="tab active" data-filter="all">전체</li>
            <?php foreach($unique_themes as $theme): ?>
                <?php $filter_value = 'theme-' . str_replace([' ','/'], '-', strtolower($theme['theme_name'])); ?>
                <li class="tab" data-filter="<?= $filter_value ?>"><?= htmlspecialchars($theme['theme_name']) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="comp-card-grid"><?php 
        foreach ($ai_list as $ai):
            $current_ai_id = $ai['id'];
            $themes_html = get_themes_html($current_ai_id, $group_themes);
            $data_filter_tags = get_filter_tags_string($current_ai_id, $group_themes);
            include __DIR__ . '/../../shared/componets/ai_rec_cardUI.php';
        endforeach; 
    ?></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const filterTabs = document.querySelectorAll('.filter-tabs .tab');
        const aiCards = document.querySelectorAll('.ai-card');
        const searchInput = document.getElementById('aiSearch'); // 검색 입력창 요소 가져오기
        
        // --- 1. 통합 필터링 함수 정의 (테마 + 검색) ---
        function applyCombinedFilter() {
            // 현재 활성화된 모든 테마 필터 값 목록을 수집합니다.
            const activeFilters = [];
            document.querySelectorAll('.filter-tabs .tab.active').forEach(activeTab => {
                const filterValue = activeTab.getAttribute('data-filter');
                if (filterValue !== 'all') {
                    activeFilters.push(filterValue);
                }
            });

            // 검색어 준비: 공백 제거 및 소문자 변환
            const searchTerm = searchInput.value.toLowerCase().trim();

            // 필터링 적용
            aiCards.forEach(card => {
                const tags = card.getAttribute('data-filter-tags') || '';
                const cardTags = tags.split(' ');
                
                // 1. 카드 텍스트 정보 수집 (이름, 요약, 태그 문자열)
                // 현재 카드 내부에 텍스트가 어디 있는지 직접 접근해야 하므로 DOM을 탐색합니다.
                const cardName = card.querySelector('.ai-name')?.textContent.toLowerCase() || '';
                const cardSummary = card.querySelector('.summary')?.textContent.toLowerCase() || '';
                const cardK_Name = card.getAttribute('data-k-name')?.toLowerCase() || '';
                const allCardText = (cardName + ' ' + cardK_Name + ' ' + cardSummary + ' ' + tags).toLowerCase();
                
                let shouldShow = true; // 기본적으로는 보여줌

                // --- A. 테마 필터 (AND 조건) 검사 ---
                if (activeFilters.length > 0) {
                    // 선택된 모든 필터(AND 조건)를 카드가 가지고 있지 않다면 숨김
                    const passesThemeFilter = activeFilters.every(filter => cardTags.includes(filter));
                    if (!passesThemeFilter) {
                        shouldShow = false;
                    }
                }
                
                // --- B. 검색어 필터 검사 ---
                if (shouldShow && searchTerm.length > 0) {
                    // 원본 검색어가 통합된 텍스트 필드에 포함되는지 검사
                    if (!allCardText.includes(searchTerm)) {
                        shouldShow = false;
                    }
                }

                // --- C. 최종 반영 ---
                if (shouldShow) {
                    card.classList.remove('hidden-card');
                } else {
                    card.classList.add('hidden-card');
                }
            });
        }
        
        // --- 2. 이벤트 리스너 연결 ---
        
        // 테마 탭 클릭 시 통합 필터링 적용
        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // 기존 활성화/비활성화 로직 (유지)
                const isAllTab = this.getAttribute('data-filter') === 'all';
                if (isAllTab) {
                    document.querySelectorAll('.filter-tabs .tab.active').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                } else {
                    document.querySelector('.filter-tabs .tab[data-filter="all"]').classList.remove('active');
                    this.classList.toggle('active');
                }
                
                applyCombinedFilter(); // 탭 클릭 후 통합 필터링 실행
            });
        });
        
        // 검색 입력 시 통합 필터링 적용
        searchInput.addEventListener('keyup', applyCombinedFilter);
        
        // 초기 로드 시 한 번 실행 (검색창에 값이 있거나 탭이 활성화되어 있을 경우 대비)
        applyCombinedFilter(); 
    });
    const DETAIL_PAGE_PATH = '/ai_detail'; 
    
    // 조회수 증가 함수
    function handleCardDetailClick(aiId) {
        fetch('/api/view_inc.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + aiId 
        })
        .then(response => {
        })
        .catch(error => {
            console.error("조회수 증가 API 오류:", error);
        });
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php include __DIR__ .'/../../shared/componets/ai_card_func.php'; ?>
</body>
</html>