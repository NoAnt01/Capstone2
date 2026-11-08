<?php
// 기존 함수: HTML 렌더링용
function get_themes_html(int $ai_id, array $group_themes): string {
    $themes_html = '';
    
    if (isset($group_themes[$ai_id])) {
        foreach ($group_themes[$ai_id] as $theme) {
            // HTML 문자열 생성 로직
            $themes_html .= '<span class="theme-tag">' . htmlspecialchars($theme['name']) . '</span>';
        }
    }
    
    return $themes_html;
}

//ai_themes.php 필터링을 위한 data-attribute 문자열 생성용
function get_filter_tags_string(int $ai_id, array $group_themes): string {
    $filter_tags = [];
    
    if (isset($group_themes[$ai_id])) {
        foreach ($group_themes[$ai_id] as $theme_info) {
            // ai_themes.php에서 탭에 사용했던 필터 값 생성 로직과 동일해야 함
            // 예: "이미지 생성" -> "theme-이미지-생성"
            $tag = 'theme-' . str_replace([' ','/'], '-', strtolower($theme_info['name']));
            $filter_tags[] = $tag;
        }
    }
    
    // "tag1 tag2 tag3" 형태로 공백으로 구분된 문자열 반환
    return implode(' ', $filter_tags);
}

?>