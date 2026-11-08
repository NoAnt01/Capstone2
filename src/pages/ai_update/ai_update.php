<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_user_id = $_SESSION['user_id'] ?? 0;

include_once __DIR__ . '/../../shared/api/db_config.php';
include_once __DIR__ . '/../../shared/componets/cardUI_query.php';
include_once __DIR__ . '/../../shared/componets/themes_func.php';

$style1 = file_get_contents(__DIR__ . '/../../shared/componets/ai_rec_cardUI.css');
$style2 = file_get_contents(__DIR__ . '/ai_update.css');
$style = '<style>' . $style1 . $style2 . '</style>';

$all_themes=[];     //테마 저장

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <?php echo $style;?>
</head>
<body>

    <h1 style="text-align: center;"> 새롭게 <span style="color: #007BFF;">출시 / 업데이트</span>된 AI 추천 !</h1>
    <h1><?= htmlspecialchars($page_title) ?></h1>

    <div class="sort-bar">
      <div class="notice-text">2025-10-20 최신화 </div>
      <div class="sort-box">
        <select id="sort-select">
            <option value="">최근 출시일 빠른 순</option>
            <option value="">최근 출시일 느린 순</option>
            <option value="">업데이트 빠른 순</option>
            <option value="">업데이트 느린 순</option>
        </select>
      </div>
    </div>

    <div class="comp-card-grid">
        <?php foreach ($ai_list as $ai): 
            $current_ai_id = $ai['id'];
            $themes_html = get_themes_html($current_ai_id, $group_themes);
        ?>
            <?php include __DIR__ .'/../../shared/componets/ai_rec_cardUI.php'; ?>
        <?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    const DETAIL_PAGE_PATH = '/ai_detail'; 
    
    //조회수 증가 함수
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

    <?php include __DIR__ .'/../../shared/componets/ai_card_func.php'; ?>

    <?php if (empty($ai_list)): ?>
        <p style="text-align: center; max-width: 1200px; margin: 20px auto;">현재 등록된 AI 프로그램이 없습니다.</p>
    <?php endif; ?>

</body>
</html>