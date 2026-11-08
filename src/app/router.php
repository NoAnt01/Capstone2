<?php
// 현재 요청 URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST 요청 URI: " . $uri);
}

// 로그아웃 처리 우선
if ($uri === '/signout') {
    include __DIR__ . '/../shared/api/signout.php';
    exit;
}

// 로그인 POST 처리
if ($uri === '/signin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../shared/api/signin_process.php';
    exit;
}

// 회원가입 POST 처리
if ($uri === '/signup_process' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../shared/api/signup_process.php';
    exit;
}

// 이메일 수신 동의 상태 업데이트 
if ($uri === '/update_email_agree' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../shared/api/update_email_agree.php';
    exit;
}

// 사용자 정보 수정 (닉네임, 이메일)
if ($uri === '/update_userinfo' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../shared/api/update_userinfo.php';
    exit;
}

// 비밀번호 변경
if ($uri === '/update_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../shared/api/update_password.php';
    exit;
}

// 회원 탈퇴
if ($uri === '/withdraw' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../shared/api/withdraw.php';
    exit;
}

// 문의 작성
if ($uri === '/inquiry_write' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../shared/api/inquiry_write.php';
    exit;
}

// 문의 삭제
if ($uri === '/inquiry_delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../shared/api/inquiry_delete.php';
    exit;
}

// 문의 답변
if ($uri === '/inquiry_reply' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../shared/api/inquiry_reply.php';
    exit;
}

/* 커뮤니티 글쓰기 저장 */
if ($uri === '/community_write' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../pages/community/community_write_process.php';
    exit;
}

// 후기 작성
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/review/submit') {
    include __DIR__ . '/../pages/ai_detail/review_submit.php';
    exit;
}

if ($uri === '/review/delete') {
    include __DIR__ . '/../pages/ai_detail/review_delete.php'; 
    exit;
}

if ($uri === '/review/delete') {
    include __DIR__ . '/../pages/ai_detail/review_delete.php'; 
    exit;
}

// 사용자 관리 API 라우팅 (POST 요청 처리)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 사용자 정보 수정 처리
    if ($uri === '/user_edit_process') { //
        include __DIR__ . '/../pages/admin/user_edit_process.php';
        exit;
    }

    // 사용자 삭제 처리
    if ($uri === '/user_delete') {
        include __DIR__ . '/../pages/admin/user_delete.php';
        exit;
    }

    //ai 데이터 삭제/변경 관리
    if ($uri === '/ai_edit_process') {
        include __DIR__ . '/../pages/admin/ai_edit_process.php';
        exit; // 
    }
    if ($uri === '/ai_delete') {
        include __DIR__ . '/../pages/admin/ai_delete.php';
        exit; // 리다이렉트 후 종료
    }
}

// 좋아요/조회수 AJAX API 라우팅
// AJAX 요청 경로와 실제 PHP 파일 경로 매핑
$api_routes = [
    '/api/like_handler.php' => __DIR__ . '/../pages/ai_user/like_handler.php',
    '/api/view_inc.php' => __DIR__ . '/../pages/ai_user/view_inc.php',
];

if (array_key_exists($uri, $api_routes)) {
    // API 파일만 실행하고 즉시 종료합니다.
    include $api_routes[$uri];
    exit;
}


// 기존 페이지 매핑 및 HTML 출력 시작
$routes = [
    '/' => __DIR__ . '/../pages/home/home.php',
    //AI 교육 관련 페이지 매핑
    '/ai_edu' => __DIR__ . '/../pages/ai_edu/ai_edu.php',
    '/book' => __DIR__ . '/../pages/book/book.php',
    '/nation-support' => __DIR__ . '/../pages/nation_support/nation_support.php',
    '/video-lecture' => __DIR__ . '/../pages/video_lecture/video_lecture.php',
    //광고, 후원 페이지 매핑
    '/ads' => __DIR__ . '/../pages/ads/ads.php',
    //AI 소식
    '/ai_news' => __DIR__ . '/../pages/ai_news/ai_news.php',
    //AI 추천
    '/ai_rec' => __DIR__ . '/../pages/ai_rec/ai_rec.php',
    '/ai_theme' => __DIR__ . '/../pages/ai_theme/ai_theme.php',
    '/ai_update' => __DIR__ . '/../pages/ai_update/ai_update.php',
    '/ai_user' => __DIR__ . '/../pages/ai_user/ai_user.php',
    '/ai_detail' => __DIR__ . '/../pages/ai_detail/ai_detail.php', //미완
     //커뮤니티
    '/community'       => __DIR__ . '/../pages/community/community.php',
    '/community_view'  => __DIR__ . '/../pages/community/community_view.php',   
    '/community_write' => __DIR__ . '/../pages/community/community_write.php',  
    //로그인/회원가입
    '/signin' => __DIR__ . '/../pages/signin/signin.php',
    '/agree' => __DIR__ . '/../pages/signup/agree.php',
    '/signup' => __DIR__ . '/../pages/signup/signup.php',
    //마이페이지
    '/mypage' => __DIR__ . '/../pages/account/account.php',
    '/admin' => __DIR__ . '/../pages/admin/admin.php',
    '/inquiry' => __DIR__ . '/../pages/inquiry/inquiry.php',
    //관리자
    '/inquiry_admin' => __DIR__ . '/../pages/admin/inquiry_admin.php',
    '/ai_management' => __DIR__ . '/../pages/admin/ai_management.php',
    '/user_management' => __DIR__ . '/../pages/admin/user_management.php',
];

// 공통 레이아웃 경로
$header = __DIR__ . '/../shared/layouts/header.php';
$footer = __DIR__ . '/../shared/layouts/footer.php';

// PHP 로직이 완료된 후 HTML 출력을 시작합니다.
?>
<!DOCTYPE html>
<html lang="ko">
<?php
if (array_key_exists($uri, $routes)) {
    include $header;
    include $routes[$uri];
    include $footer;
} else {
    include $header;
    echo "<h2>404 페이지를 찾을 수 없습니다.</h2>";
    include $footer;
}
?>