<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_user_id = $_SESSION['user_id'] ?? 0;

include_once __DIR__ . '/../../shared/api/db_config.php';
include_once __DIR__ . '/../../shared/componets/cardUI_query.php';
include_once __DIR__ . '/../../shared/componets/themes_func.php';

if (!isset($conn) || !$conn instanceof PDO) {
    $conn = false; 
}

$result_views = [];
$result_likes = [];
$ai_list = [];
$group_themes = []; 

if ($conn) {
    try {
        $sql_views_ranking = "
            SELECT id, name, views, image_url, website_url
            FROM ai_programs
            ORDER BY views DESC
            LIMIT 10
        ";
        $ret_views = $conn->prepare($sql_views_ranking); 
        $ret_views->execute();
        $result_views = $ret_views->fetchAll(PDO::FETCH_ASSOC);

        $sql_likes_ranking = "
            SELECT id, name, likes, image_url, website_url
            FROM ai_programs
            ORDER BY likes DESC
            LIMIT 10
        ";
        $ret_likes = $conn->prepare($sql_likes_ranking);
        $ret_likes->execute();
        $result_likes = $ret_likes->fetchAll(PDO::FETCH_ASSOC);
        
        $sql_ai_list = "
            SELECT 
                a.id, a.image_url, a.name, a.description, a.min_price, a.max_price, a.website_url,
                a.likes,
                (
                    SELECT COUNT(*)
                    FROM user_likes ul
                    WHERE ul.user_id = :user_id 
                      AND ul.ai_id = a.id
                ) AS is_liked
            FROM 
                ai_programs a;
        ";

        $ret1 = $conn->prepare($sql_ai_list); 
        $ret1->bindParam(':user_id', $current_user_id, PDO::PARAM_STR);
        $ret1->execute();
        $ai_list = $ret1->fetchAll(PDO::FETCH_ASSOC);

        $sql_ai_themes = "
            SELECT 
                pt.program_id, t.theme_name
            FROM 
                ai_themes t
            JOIN 
                ai_program_themes pt
            ON 
                t.theme_id = pt.theme_id;";

        $ret2 =$conn->prepare($sql_ai_themes); 
        $ret2->execute();
        $themes = $ret2->fetchAll(PDO::FETCH_ASSOC); 

        foreach ($themes as $themes_info) {
            $ai_id = $themes_info['program_id'];
            if (!isset($group_themes[$ai_id])) {
                $group_themes[$ai_id] = [];
            }
            $group_themes[$ai_id][] = ['name' => $themes_info['theme_name']];
        }


    } catch (PDOException $e) {
        error_log("DB Query Error: " . $e->getMessage());
    }
}

$style1 = file_get_contents(__DIR__ . '/../../shared/componets/ai_rec_cardUI.css');
$style2 = file_get_contents(__DIR__ . '/ai_user.css');
$style = '<style>' . $style1 . $style2 . '</style>';

$page_title = $page_title ?? "AI 추천 페이지";
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

    <h1 style="text-align: center; margin-bottom: 50px;"> <span style="color: #007BFF;">사용자</span> 리뷰 기반 AI 추천 !</h1>

<div class="ranking-section">
    <div class="ranking-title">🔥 조회수 랭킹</div>
    
    <div class="ranking-carousel-container">
        <button class="scroll-button left-arrow" onclick="scrollRankings(this, -1)">&#10094;</button>
        
        <div class="ranking-list" id="views-ranking-list">
            <?php
            $rank = 1;
            
            if (is_array($result_views) && count($result_views) > 0) { 
                foreach ($result_views as $row) {
                    $ai_id = $row['id'];
                    $website_url = htmlspecialchars($row['website_url']);
                    $image_url = htmlspecialchars($row['image_url']);
                    $themes_html = get_themes_html($ai_id, $group_themes);
                    
                    echo "<div class='ranking-item' onclick=\"handleCardClick({$ai_id}, '{$website_url}')\">"; 
                    echo "  <div class='ranking-image-container'>";
                    echo "      <img src='{$image_url}' alt='{$row['name']} 이미지' class='ranking-image'>";
                    echo "  </div>";
                    echo "  <div class='ranking-name'>{$row['name']}</div>";
                    echo "  <div class='ranking-themes'>{$themes_html}</div>";
                    echo "  <div class='ranking-rank-small'>#{$rank}</div>";
                    echo "</div>";
                    $rank++;
                }
            } else if (!$conn) {
                echo "<p style='padding-left: 10px; color: red;'>DB 연결 실패 (소스 파일 경로 문제 확인)</p>";
            } else {
                echo "<p style='padding-left: 10px;'>조회수 랭킹 데이터가 없습니다.</p>";
            }
            ?>
        </div>
        
        <button class="scroll-button right-arrow" onclick="scrollRankings(this, 1)">&#10095;</button>
    </div>
</div>

<div class="ranking-section">
    <div class="ranking-title">💖 좋아요 랭킹</div>
    
    <div class="ranking-carousel-container">
        <button class="scroll-button left-arrow" onclick="scrollRankings(this, -1)">&#10094;</button>
        
        <div class="ranking-list" id="likes-ranking-list">
            <?php
            $rank = 1;
            if (is_array($result_likes) && count($result_likes) > 0) { 
                foreach ($result_likes as $row) {
                    $ai_id = $row['id'];
                    $website_url = htmlspecialchars($row['website_url']);
                    $image_url = htmlspecialchars($row['image_url']);
                    $themes_html = get_themes_html($ai_id, $group_themes);
                    
                    echo "<div class='ranking-item' onclick=\"handleCardClick({$ai_id}, '{$website_url}')\">"; 
                    echo "  <div class='ranking-image-container'>";
                    echo "      <img src='{$image_url}' alt='{$row['name']} 이미지' class='ranking-image'>";
                    echo "  </div>";
                    echo "  <div class='ranking-name'>{$row['name']}</div>";
                    echo "  <div class='ranking-themes'>{$themes_html}</div>";
                    echo "  <div class='ranking-rank-small'>#{$rank}</div>";
                    echo "</div>";
                    $rank++;
                }
            } else if (!$conn) {
                echo "<p style='padding-left: 10px; color: red;'>DB 연결 실패 (소스 파일 경로 문제 확인)</p>";
            } else {
                echo "<p style='padding-left: 10px;'>좋아요 랭킹 데이터가 없습니다.</p>";
            }
            ?>
        </div>
        
        <button class="scroll-button right-arrow" onclick="scrollRankings(this, 1)">&#10095;</button>
    </div>
</div>

    <h1 style="text-align: center; margin-top: 100px;"> 전체 목록</h1>
<div class="sort-bar-container">
    <div class="sort-box">
        <select id="ai-sort-select" onchange="sortFullList(this.value)">
            <option value="" disabled selected>정렬 기준</option>
            <option value="views_desc">조회수 순</option>
            <option value="likes_desc">좋아요 순</option>
        </select>
    </div>
</div>

<div class="comp-card-grid">
        <?php
        if (!empty($ai_list)):
            foreach ($ai_list as $ai): 
                $current_ai_id = $ai['id'];
                $themes_html = get_themes_html($current_ai_id, $group_themes); 
        ?>
            <?php include __DIR__ .'/../../shared/componets/ai_rec_cardUI.php'; ?>
        <?php endforeach; 
        endif;
        ?>
    </div>

    <?php if (empty($ai_list)): ?>
        <p style="text-align: center; max-width: 1200px; margin: 20px auto;">현재 등록된 AI 프로그램이 없습니다.</p>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <script>
    // ⚠️ PHP 파일에서 수정한 경로와 일치하도록 상대 경로로 변경 (ai_detail 폴더의 ai_detail.php로 이동 가정)
    const DETAIL_PAGE_PATH = '/ai_detail'; 
    
    // 🚨 1. 전체 목록 카드에서 호출하는 함수를 정의합니다.
    function handleCardDetailClick(aiId) {
        // 랭킹 카드의 handleCardClick 함수와 동일하게 조회수 API를 호출합니다.
        fetch('/api/view_inc.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + aiId 
        })
        .then(response => {
            // API 호출 후, <a> 태그의 기본 동작(ai_rec_cardUI.php)에 의해 페이지 이동됨.
        })
        .catch(error => {
            console.error("조회수 증가 API 오류:", error);
        });
        
        // <a> 태그의 href가 페이지 이동을 담당합니다.
    }

    // 🚨 2. 기존 랭킹 카드 클릭 함수(handleCardClick)를 재정의합니다.
    // 랭킹 카드는 <a> 태그가 없으므로 직접 페이지 이동을 처리해야 합니다.
    function handleCardClick(aiId, websiteUrl) {
        // handleCardDetailClick을 호출하여 조회수 증가 API만 실행
        handleCardDetailClick(aiId); 

        // 랭킹 카드는 <a> 태그가 없으므로 직접 상세 페이지로 이동시킵니다.
        window.location.href = `${DETAIL_PAGE_PATH}?id=${aiId}`;
    }

    /**
     * 랭킹 리스트를 좌우로 스크롤하는 함수 (버튼 방식)
     */
    function scrollRankings(buttonElement, direction) {
        const container = buttonElement.parentNode;
        const list = container.querySelector('.ranking-list');
        
        if (list) {
            // 항목 너비 + 마진 (150px + 15px) * 3개 항목 만큼 이동
            const itemWidth = 150 + 15; 
            const scrollDistance = itemWidth * 3 * direction; 
            
            list.scrollBy({
                left: scrollDistance,
                behavior: 'smooth'
            });
        }
    }

    function sortFullList(sortKey) {
        console.log("전체 목록 정렬 기준 변경:", sortKey);
    }
    </script>

    <?php include __DIR__ .'/../../shared/componets/ai_card_func.php'; ?>
    
</body>
</html>