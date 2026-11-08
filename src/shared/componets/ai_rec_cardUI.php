<?php
// ai_rec_cardUI.php 파일 (수정됨)

// ⚠️ 상세 페이지 경로 설정 (실제 경로에 맞게 조정 필요)
// 만약 루트 폴더에서 접근 가능하다면 /ai_detail/ai_detail.php
$detail_page_path = '/ai_detail'; 

$card_ai_id = $ai['id'] ?? 0;
// 상세 페이지로 이동할 URL
$target_url = $detail_page_path . '?id=' . htmlspecialchars($card_ai_id);

?>
<a href="<?= $target_url ?>" 
   class="ai-card"
   
   onclick="handleCardDetailClick(<?= htmlspecialchars($card_ai_id) ?>)"
   
    data-filter-tags="<?= htmlspecialchars($data_filter_tags ?? '') ?>"
    data-k-name="<?= htmlspecialchars($ai['k_name'] ?? '') ?>"
>
    
    <div class="card-top-section">
        
        <div class="card-image-wrapper">
            <img src="<?= htmlspecialchars($ai['image_url']) ?>" 
                alt="<?= htmlspecialchars($ai['name']) ?> 사진" 
                class="card-image">
        </div>

        <div class="top-content-wrapper">
            <h2 class="ai-name"><?= htmlspecialchars($ai['name']) ?></h2>
            <div class="ai-meta">
                <?= $themes_html ?>
            </div>
        </div>
        
    </div>

    <div class="card-bottom-section">
        
        <p class="summary"><?= htmlspecialchars($ai['description']) ?></p>
        
        <div class="price-like-row"> 
            
            <div class="price-section">
                <?php 
                    $min_price = $ai['min_price'] !== null ? htmlspecialchars($ai['min_price']) : '0';
                    $max_price = $ai['max_price'] !== null ? htmlspecialchars($ai['max_price']) : '정보 없음';
                ?>
                <span class="price-range"><?= $min_price ?> $ ~ <?= $max_price ?> $</span>
            </div>

            <div class="like-container">
                <?php 
                    $is_liked = $ai['is_liked'] ?? 0; 
                    $like_class = $is_liked ? 'liked' : '';
                ?>
                <button 
                    class="like-heart-button <?= $like_class ?>" 
                    data-ai-id="<?= htmlspecialchars($ai['id']) ?>" 
                    
                    onclick="event.stopPropagation(); toggleLike(event, <?= htmlspecialchars($ai['id']) ?>, this); return false;" 
                >
                    <span class="heart-icon"><?= $is_liked ? '❤️' : '🤍' ?></span>
                </button>
                <span class="like-count-display" id="like-count-<?= htmlspecialchars($ai['id']) ?>">
                    <?= htmlspecialchars(number_format($ai['likes'] ?? 0)) ?>
                </span>
            </div>
            
        </div> 
    </div>
</a>