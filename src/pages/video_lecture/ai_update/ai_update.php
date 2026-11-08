<?php
include_once __DIR__ . '/../../shared/api/db_config.php';
include_once __DIR__ . '/../../shared/componets/cardUI_query.php';
include_once __DIR__ . '/../../shared/componets/themes_func.php';

$style1 = file_get_contents(__DIR__ . '/../../shared/componets/ai_rec_cardUI.css');
$style2 = file_get_contents(__DIR__ . '/ai_theme.css');
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
    
    <h1><?= htmlspecialchars($page_title) ?></h1>
    <p class="comp-description">재사용 가능한 AI 정보 카드 UI 테스트입니다.</p>

    <div class="comp-card-grid">
        <?php foreach ($ai_list as $ai): 
            $current_ai_id = $ai['id'];

            // AI별 분야들
            $themes_html = get_themes_html($current_ai_id, $group_themes);
        ?>
            <!--컨포넌트 사용-->
            <?php include __DIR__ .'/../../shared/componets/ai_rec_cardUI.php'; ?>
        <?php endforeach; ?>
    </div>

    <?php if (empty($ai_list)): ?>
        <p style="text-align: center; max-width: 1200px; margin: 20px auto;">현재 등록된 AI 프로그램이 없습니다.</p>
    <?php endif; ?>
</body>
</html>