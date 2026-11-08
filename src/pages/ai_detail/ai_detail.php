<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_user_id = $_SESSION['user_id'] ?? null;
$current_user_name = $_SESSION['user_name'] ?? 'Guest'; 

include_once __DIR__ . '/../../shared/api/db_config.php';

$css_file_path = __DIR__ . '/ai_detail.css';
$style = ''; 
if (file_exists($css_file_path)) {
    $style = file_get_contents($css_file_path);
}

$ai_id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 1; 

$ai_detail = [];
$ai_reviews = [];
$db_error = false;

try {
    if (!isset($conn) || !$conn) {
        throw new Exception("데이터베이스 연결 객체를 찾을 수 없습니다.");
    }

    $stmt_program = $conn->prepare("SELECT name, website_url, likes, views, last_update, image_url FROM ai_programs WHERE id = :ai_id");
    $stmt_program->bindParam(':ai_id', $ai_id, PDO::PARAM_INT);
    $stmt_program->execute();
    $program_info = $stmt_program->fetch(PDO::FETCH_ASSOC);

    if ($program_info) {
        $ai_detail = array_merge($ai_detail, $program_info); 
        $ai_detail['bookmark_count'] = $program_info['likes']; 
        $ai_detail['view_count'] = $program_info['views'];
        $ai_detail['update_date'] = $program_info['last_update'];
        $ai_detail['slogan'] = ''; 
    } else {
        throw new Exception("요청하신 AI 정보를 찾을 수 없습니다. (ID: $ai_id)");
    }

    $stmt_reviews = $conn->prepare("
        SELECT r.id, r.user_id, r.content, r.created_at, u.nickname AS user_name
        FROM ai_reviews r
        JOIN users u ON r.user_id = u.user_id
        WHERE r.ai_id = :ai_id
        ORDER BY r.created_at DESC
    ");
    $stmt_reviews->bindParam(':ai_id', $ai_id, PDO::PARAM_INT);
    $stmt_reviews->execute();
    $ai_reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

    $stmt_details = $conn->prepare("
        SELECT tab_type, attr_key, attr_value 
        FROM ai_details 
        WHERE ai_id = :ai_id 
        ORDER BY tab_type ASC, sort_order ASC
    ");
    $stmt_details->bindParam(':ai_id', $ai_id, PDO::PARAM_INT);
    $stmt_details->execute();
    $ai_details_list = $stmt_details->fetchAll(PDO::FETCH_ASSOC);

    $ai_detail['info'] = [];
    $ai_detail['features'] = [];
    $ai_detail['tech_info'] = [];
    $ai_detail['description'] = '제공되는 상세 정보가 없습니다.';

    foreach ($ai_details_list as $row) {
        $tab_type = $row['tab_type'];
        $attr_key = $row['attr_key'];
        $attr_value = $row['attr_value'];

        if ($tab_type === 'intro') {
            $ai_detail['description'] = $attr_value;
        } else if ($tab_type === 'features') {
            $ai_detail['features'][] = $attr_value;
        } else if (in_array($tab_type, ['info', 'tech_info'])) {
            $ai_detail[$tab_type][$attr_key] = $attr_value;
        }
    }

} catch (Exception $e) {
    $db_error = true;
    error_log("DB 연동 오류: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Pick | <?= htmlspecialchars($ai_detail['name'] ?? '상세 정보') ?> 상세 정보</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        <?= $style ?>
    </style>
</head>
<body>
    <main class="detail-container">
        
        <header class="ai-header">
            <div class="ai-header-layout">
                <div class="ai-logo-large" style="display: flex; justify-content: center; align-items: center; font-size: 40px; color: white;">
                    <?php if (!empty($ai_detail['image_url'])): ?>
                        <img src="<?= htmlspecialchars($ai_detail['image_url']) ?>" 
                             alt="<?= htmlspecialchars($ai_detail['name'] ?? 'AI 로고') ?>" 
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
                    <?php else: ?>
                        🤖 
                    <?php endif; ?>
                </div>
                <div class="ai-header-content">
                    <h1><?= htmlspecialchars($ai_detail['name'] ?? 'AI 이름') ?></h1>
                    <p class="slogan"><?= htmlspecialchars($ai_detail['slogan'] ?? '') ?></p> 
                    <a href="<?= htmlspecialchars($ai_detail['website_url'] ?? '#') ?>" target="_blank" class="btn-primary">서비스 바로가기</a>
                    <div class="meta-info">
                        <span>❤️ 좋아요: <?= number_format($ai_detail['bookmark_count'] ?? 0) ?></span> | 
                        <span>👁️ 조회수: <?= number_format($ai_detail['view_count'] ?? 0) ?></span>
                        <span style="display: block; margin-top: 5px;">최종 업데이트: <?= htmlspecialchars($ai_detail['update_date'] ?? 'N/A') ?></span>
                    </div>
                </div>
            </div>
        </header>

        <div class="detail-content-box">
            
            <?php if ($db_error): ?>
                <div style="color: red;">
                    <h2>데이터베이스 오류</h2>
                    <p><?= htmlspecialchars($ai_detail['description']) ?></p>
                </div>
            <?php else: ?>
            
            <div class="content-split-row">
                <div class="intro-left-col">
                    <h2>AI 서비스 소개</h2>
                    <p><?= nl2br(htmlspecialchars($ai_detail['description'] ?? '')) ?></p>
                </div>

                <div class="summary-right-col">
                    <h3>핵심 정보 요약</h3>
                    <div class="summary-table">
                        <ul>
                            <?php foreach ($ai_detail['info'] ?? [] as $key => $value): ?>
                            <li>
                                <strong><?= htmlspecialchars($key) ?></strong>
                                <span><?= htmlspecialchars($value) ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <hr class="content-divider">

            <div class="bottom-split-row">
                
                <div class="features-left-col">
                    <h2>핵심 기능 목록</h2>
                    <ul class="feature-list-simple">
                        <?php foreach ($ai_detail['features'] ?? [] as $feature): ?>
                        <li><?= htmlspecialchars($feature) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="tech-right-col">
                    <h2>기술 및 배경 정보</h2>
                    <ul class="tech-list-simple">
                        <?php foreach ($ai_detail['tech_info'] ?? [] as $key => $value): ?>
                        <li>
                            <span class="tech-label"><?= htmlspecialchars($key) ?></span>
                            <span class="tech-divider">:</span>
                            <span class="tech-content"><?= htmlspecialchars($value) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
            
            <?php endif;?>

        </div>
    </main>

    <section class="review-section">
        <h2>사용자 후기</h2>
        <?php if ($current_user_id): ?>
        <div class="review-form">
            <h3>후기 작성하기</h3>
            <form id="reviewForm" method="POST" action="/review/submit">
                <input type="hidden" name="ai_id" value="<?= htmlspecialchars($ai_id) ?>">
                <textarea name="content" placeholder="이 AI 서비스에 대한 후기를 남겨주세요." required></textarea>
                <button type="submit">등록</button>
            </form>
        </div>
        <?php else: ?>
        <p class="login-required">후기를 작성하려면 <a href="/signin">로그인</a>이 필요합니다.</p>
        <?php endif; ?>

        <div class="review-list">
            <h3>최근 사용자 후기</h3>
            <?php if (!empty($ai_reviews)): ?>
                <?php foreach ($ai_reviews as $review): ?>
                <div class="review-item" style="position: relative;">
                    <div class="review-meta">
                        <strong><?= htmlspecialchars($review['user_name'] ?? '익명') ?></strong>
                        <span><?= htmlspecialchars($review['created_at'] ?? '') ?></span>
                    </div>
                    <p class="review-content"><?= nl2br(htmlspecialchars($review['content'] ?? '')) ?></p>
                    
                    <?php if ($current_user_id && $current_user_id === $review['user_id']): ?>
                        <div class="review-actions" style="position: absolute; bottom: 15px; right: 15px;">
                            <a href="/review/delete?review_id=<?= $review['id'] ?>&ai_id=<?= $ai_id ?>" 
                               onclick="return confirm('정말로 이 후기를 삭제하시겠습니까?');"
                               style="text-decoration: none; color: #dc3545; font-size: 1.1em;">
                                
                                <i class="fas fa-trash-alt"></i> 
                                
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>아직 등록된 후기가 없습니다.</p>
            <?php endif; ?>
        </div>
    </section>
    
    <footer class="global-footer"><p>&copy; 2024 AI Pick.</p></footer>
</body>
</html>