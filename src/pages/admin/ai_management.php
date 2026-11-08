<?php
// 1. DB 연결
include __DIR__ . '/../../shared/api/db_config.php';

$sql = 
"SELECT 
    p.id, 
    p.name, 
    p.min_price, 
    p.max_price, 
    p.description,
    GROUP_CONCAT(t.theme_name SEPARATOR ',') AS theme_names
FROM 
    ai_programs p
LEFT JOIN 
    ai_program_themes map ON p.id = map.program_id
LEFT JOIN 
    ai_themes t ON map.theme_id = t.theme_id
GROUP BY 
    p.id
ORDER BY 
    p.id asc";
$stmt = $conn->prepare($sql);
$stmt->execute();
$ai_programs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// A. AI 개수 
$total_count = count($ai_programs);

// B. 분야 개수
$sql_theme_count = "SELECT COUNT(*) FROM ai_themes";
$stmt_theme = $conn->prepare($sql_theme_count);
$stmt_theme->execute();
$total_themes = $stmt_theme->fetchColumn();

// C. AI별 평균 가격
if ($total_count > 0) {
    $sum_max_price = array_sum(array_column($ai_programs, 'max_price'));
    
    $avg_max_price = round($sum_max_price / $total_count);
} else {
    $avg_max_price = 0;
}

$style1 = @file_get_contents(__DIR__ . '/admin.css');
$style2 = @file_get_contents(__DIR__ . '/managements.css');
$style = '<style>' . $style1 . $style2 . '</style>';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI 관리 페이지</title>
    
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
                <h2>AI 서비스 관리</h2>
            </div>

            <section class="stats-cards">
                <div class="card stat-card">
                    <div class="icon-box blue"><i class="fa-solid fa-robot"></i></div>
                    <div class="stat-info">
                        <p class="title">전체 AI</p>
                        <p class="value"><?= number_format($total_count) ?>개</p>
                    </div>
                </div>

                <div class="card stat-card">
                    <div class="icon-box purple"><i class="fa-solid fa-layer-group"></i></div> <div class="stat-info">
                        <p class="title">등록된 분야</p>
                        <p class="value"><?= number_format($total_themes) ?>개</p>
                    </div>
                </div>

                <div class="card stat-card">
                    <div class="icon-box green"><i class="fas fa-won-sign"></i></div>
                    <div class="stat-info">
                        <p class="title">평균 가격 (Max)</p>
                        <p class="value">₩<?= number_format($avg_max_price) ?></p>
                    </div>
                </div>
            </section>

            <section class="ai-list-management">
                <div class="list-header">
                    <h3>AI 목록</h3>
                </div>

                <div class="filter-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="ai-search-input" placeholder="AI 이름, 설명 검색...">
                    </div>
                </div>

                <div class="card table-card">
                    <table>
                        <thead>
                            <tr>
                                <th class="col-id">ID</th>
                                <th class="col-name">서비스명</th>
                                <th class="col-category">분야(테마)</th>
                                <th class="col-price">가격</th>
                                <th class="col-description">설명</th> 
                                <th class="col-actions">작업</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ai_programs as $row): ?>
                            <tr data-id="<?= $row['id'] ?>"
                                data-name="<?= htmlspecialchars($row['name']) ?>"
                                data-min="<?= $row['min_price'] ?>"
                                data-max="<?= $row['max_price'] ?>"
                                data-desc="<?= htmlspecialchars($row['description']) ?>"
                                data-themes="<?= htmlspecialchars($row['theme_names'] ?? '') ?>">
                                
                                <td class="col-id"><?= $row['id'] ?></td>
                                <td class="col-name"><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                                
                                <td class="col-category">
                                    <?php 
                                        if (!empty($row['theme_names'])) {
                                            $themes = explode(',', $row['theme_names']);
                                            
                                            foreach ($themes as $theme) {
                                                $themeName = trim($theme);
                                                
                                                // 이름(String)을 숫자로 바꿔서 0~7번 색상 중 하나를 자동 선택
                                                // abs()는 음수 방지, crc32()는 문자열 해시 함수
                                                $colorIndex = abs(crc32($themeName)) % 8; 
                                                
                                                // CSS 클래스 생성 (예: tag-color-3)
                                                $className = 'tag-color-' . $colorIndex;
                                                
                                                echo "<span class='theme-tag {$className}'>" . htmlspecialchars($themeName) . "</span>";
                                            }
                                        } else {
                                            echo "<span style='color:#ccc; font-size:0.9em;'>-</span>";
                                        }
                                    ?>
                                </td>

                                <td class="col-price">
                                    <?php 
                                        if ($row['min_price'] == 0 && $row['max_price'] == 0) {
                                            // 1. 완전 무료일 때
                                            echo '<span class="badge-free">무료</span>';
                                        } elseif ($row['min_price'] == 0) {
                                            
                                            echo '<span class="badge-free">무료</span> ~ ' . number_format($row['max_price']) . '$';
                                        } else {
                                            // 3. 유료일 때
                                            echo number_format($row['min_price']) . ' ~ ' . number_format($row['max_price']) . '$';
                                        }
                                    ?>
                                </td>
                                
                                <td class="col-description" title="<?= htmlspecialchars($row['description']) ?>">
                                    <?= htmlspecialchars($row['description']) ?>
                                </td>
                                
                                <td class="col-actions action-icons">
                                    <i class="fas fa-edit edit-icon action-edit-ai" title="수정"></i>
                                    
                                    <form method="POST" action="/ai_delete" style="display:inline;" 
                                          onsubmit="return confirm('정말로 [<?= htmlspecialchars($row['name']) ?>] 서비스를 삭제하시겠습니까?');">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="action-delete-btn" title="삭제">
                                            <i class="fas fa-trash-alt delete-icon"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div id="aiEditModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            
            <h2 id="aiModalTitle">AI 정보 수정</h2>
            
            <form id="aiEditForm">
                <input type="hidden" name="id" id="ai-id">

                <div class="form-group">
                    <label for="ai-name" class="modal-label">서비스명</label>
                    <input type="text" name="name" id="ai-name" class="modal-input" required>
                </div>

                <div class="form-group">
                    <label for="ai-min" class="modal-label">최소 가격 ($)</label>
                    <input type="number" name="min_price" id="ai-min" class="modal-input" required>
                </div>

                <div class="form-group">
                    <label for="ai-max" class="modal-label">최대 가격 ($)</label>
                    <input type="number" name="max_price" id="ai-max" class="modal-input" required>
                </div>

                <div class="form-group">
                    <label for="ai-desc" class="modal-label">설명</label>
                    <textarea name="description" id="ai-desc" class="modal-input" rows="4" required></textarea>
                </div>
                
                <p style="font-size:12px; color:#888;">* 분야(테마) 수정은 DB 담당자에게 문의바랍니다.</p>

                <div class="modal-button-group">
                    <button type="submit" class="action-btn primary save-button">저장</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('.table-card tbody');
            const modal = document.getElementById('aiEditModal');
            const form = document.getElementById('aiEditForm');
            const closeModalButtons = modal.querySelectorAll('.close');
            const modalTitle = document.getElementById('aiModalTitle');
            const searchInput = document.getElementById('ai-search-input');
            const aiRows = tableBody.querySelectorAll('tr');
            // 1. 모달 닫기
            closeModalButtons.forEach(btn => {
                btn.onclick = () => modal.style.display = "none";
            });
            window.onclick = (e) => {
                if (e.target === modal) modal.style.display = "none";
            };

            // 2. 수정 버튼 클릭 이벤트
            tableBody.addEventListener('click', function(e) {
                const editIcon = e.target.closest('.action-edit-ai');
                
                if (editIcon) {
                    // 데이터 먼저 가져오기 (순서 중요!)
                    const row = editIcon.closest('tr');
                    const data = row.dataset;

                    // 타이틀 및 폼 데이터 채우기
                    modalTitle.textContent = `[${data.name}] 정보 수정`;
                    document.getElementById('ai-id').value = data.id;
                    document.getElementById('ai-name').value = data.name;
                    document.getElementById('ai-min').value = data.min;
                    document.getElementById('ai-max').value = data.max;
                    document.getElementById('ai-desc').value = data.desc;

                    modal.style.display = "block";
                }
            });

            // 3. 폼 제출 (AJAX - 라우터 경로 사용)
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);

                // 라우터에 등록된 경로: /ai_edit_process
                fetch('/ai_edit_process', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('성공적으로 수정되었습니다.');
                        modal.style.display = "none";
                        window.location.reload();
                    } else {
                        alert('수정 실패: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('통신 오류가 발생했습니다. (F12 > Network 확인 필요)');
                });
            });
            function filterAiPrograms() {
                const searchText = searchInput.value.toLowerCase().trim(); // 검색어 (소문자로 변환 및 공백 제거)

                aiRows.forEach(row => {
                    // data-name (서비스명) 및 data-desc (설명) 속성 값을 가져옴
                    // theme_names도 검색 대상에 추가할 수 있지만, 현재 플레이스홀더에는 '이름, 설명'만 언급되어 있습니다.
                    const name = row.dataset.name ? row.dataset.name.toLowerCase() : '';
                    const description = row.dataset.desc ? row.dataset.desc.toLowerCase() : '';

                    // 검색어가 이름이나 설명 중 하나라도 포함되어 있으면 true
                    const isMatch = name.includes(searchText) || 
                                    description.includes(searchText);

                    // 검색 결과에 따라 행 표시/숨김
                    // 빈 검색어일 경우 (searchText === '')는 모든 행을 표시합니다.
                    row.style.display = isMatch ? '' : 'none';
                });
            }
            if (searchInput) {
                searchInput.addEventListener('keyup', filterAiPrograms); // 키를 뗄 때마다 필터링 실행
                searchInput.addEventListener('change', filterAiPrograms); // 값 변경 시 필터링 실행
            }
        });
    </script>

</body>
</html>