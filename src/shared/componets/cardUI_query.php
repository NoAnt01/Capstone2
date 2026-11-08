<?php
include_once __DIR__ . '/../api/db_config.php';

if (!isset($current_user_id)) {
    $current_user_id = 0; 
}

$ai_list =[];   
$group_themes=[];  

$sql_ai_list = "
SELECT 
    a.id, a.image_url, a.name,a.k_name, a.description, a.min_price, a.max_price, a.website_url,
    a.likes, -- **총 좋아요 수 컬럼 추가 (ai_programs.likes)**
    (
        SELECT COUNT(*)
        FROM user_likes ul
        WHERE ul.user_id = :user_id 
          AND ul.ai_id = a.id
    ) AS is_liked -- **현재 사용자의 좋아요 상태 (0 또는 1) 확인**
FROM 
    ai_programs a;
";

$sql_ai_themes = "
SELECT 
    pt.program_id, t.theme_name
FROM 
    ai_themes t
JOIN 
    ai_program_themes pt
ON 
    t.theme_id = pt.theme_id;";

try {
    $ret1 = $conn->prepare($sql_ai_list); 
    $ret1->bindParam(':user_id', $current_user_id, PDO::PARAM_STR);
    $ret1->execute();
    $ai_list = $ret1->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Query Error: " . $e->getMessage());
}

try {
    $ret2 =$conn->prepare($sql_ai_themes); 
    $ret2->execute();
    $themes = $ret2->fetchAll(PDO::FETCH_ASSOC); 

} catch (PDOException $e) {
    error_log("Query Error: " . $e->getMessage());
}

foreach ($themes as $themes_info) {
    $ai_id = $themes_info['program_id'];
    
    if (!isset($group_themes[$ai_id])) {
        $group_themes[$ai_id] = [];
    }
    
    $group_themes[$ai_id][] = [
        'name' => $themes_info['theme_name']
    ];
}
?>