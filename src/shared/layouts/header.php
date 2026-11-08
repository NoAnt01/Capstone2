<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="다양한 AI 서비스를 한 곳에서 비교·검색하고, 관련 교육 콘텐츠와 사용자 커뮤니티를 함께 제공하는 플랫폼">
  <title>아이픽ㅣ필요한 모든 AI를 한 곳에서</title>

  <meta property="og:type" content="website">
  <meta property="og:title" content="아이픽ㅣ필요한 모든 AI를 한 곳에서">
  <meta property="og:description" content="다양한 AI 서비스를 한 곳에서 비교·검색해보세요.">
  <meta property="og:image" content="/assets/images/openimage4.jpg">
  <meta property="og:url" content="http://aipick.ai.kr/">

  <meta name="google-site-verification" content="5E5ZCemTqEBYiR3BIlmU91vEHWQ0eid2JXYCUKbJA5k" />

  <link rel="icon" type="image/png" href="/assets/images/mainlogo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Noto+Sans+KR:wght@400;500&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --aipick-primary: #4facfe;
      --aipick-primary-dark: #3185ff;
      --aipick-bg: #f8f9fa;
      --aipick-text: #222;
      --aipick-muted: #6b7280;
      --header-height: 66px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', 'Noto Sans KR', sans-serif;
      background-color: var(--aipick-bg);
    }

    /* 상단 인포바 */
    .topbar {
      width: 100%;
      background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
      color: #fff;
      font-size: 13px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      padding: 7px 16px 6px;
    }

    .topbar a {
      color: #fff;
      text-decoration: underline;
      text-underline-offset: 3px;
      font-weight: 500;
    }

    .site-header {
      position: sticky;
      top: 0;
      z-index: 9999;
      /* 헤더를 항상 최상단 레이어로 */
      background-color: #fff;
      box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
      backdrop-filter: saturate(180%) blur(6px);
    }

    .header-shell {
      max-width: 1280px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: var(--header-height);
      gap: 24px;
      padding: 0 32px;
    }

    /* 로고 */
    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      color: var(--aipick-text);
      white-space: nowrap;
    }

    .logo img {
      height: 48px;
      display: block;
      transition: transform 0.25s ease;
    }

    .logo strong {
      font-size: 20px;
      font-weight: 700;
      letter-spacing: -0.03em;
    }

    .logo small {
      display: block;
      font-size: 11px;
      color: var(--aipick-muted);
      margin-top: -2px;
    }

    .logo:hover img {
      transform: scale(1.03);
    }

    /* 검색창 */
    .search-bar {
      flex: 1;
      max-width: 360px;
      position: relative;
      display: flex;
      align-items: center;
    }

    .search-bar input {
      width: 100%;
      border: 1px solid #e5e7eb;
      background-color: #f9fafb;
      border-radius: 999px;
      padding: 9px 34px 9px 14px;
      outline: none;
      font-size: 14px;
      transition: all 0.2s ease;
    }

    .search-bar input:focus {
      border-color: rgba(79, 172, 254, 0.55);
      background-color: #fff;
      box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.12);
    }

    .search-bar button {
      position: absolute;
      right: 6px;
      border: none;
      background: var(--aipick-primary);
      color: #fff;
      width: 26px;
      height: 26px;
      border-radius: 999px;
      cursor: pointer;
      font-size: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* 메인 내비 */
    .main-nav {
      display: flex;
      align-items: center;
      gap: 18px;
    }

    .main-nav a {
      text-decoration: none;
      color: #374151;
      font-size: 15px;
      font-weight: 500;
      padding: 6px 0;
      position: relative;
      transition: color 0.2s ease;
      white-space: nowrap;
    }

    .main-nav a::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -18px;
      width: 100%;
      height: 3px;
      background: var(--aipick-primary);
      transform: scaleX(0);
      transform-origin: center;
      transition: transform 0.2s ease;
      border-radius: 99px;
    }

    .main-nav a:hover {
      color: var(--aipick-primary);
    }

    .main-nav a.active::after,
    .main-nav a:hover::after {
      transform: scaleX(1);
    }

    .main-nav .badge {
      background: rgba(79, 172, 254, 0.13);
      color: var(--aipick-primary);
      font-size: 10px;
      font-weight: 600;
      padding: 1px 7px 2px;
      border-radius: 99px;
      margin-left: 4px;
    }

    /* 우측 유저 영역 */
    .user-area {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .btn-primary {
      background-color: var(--aipick-primary);
      color: #fff;
      border: none;
      border-radius: 999px;
      padding: 8px 18px 9px;
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      font-size: 14px;
    }

    .btn-primary:hover {
      background-color: var(--aipick-primary-dark);
      transform: translateY(-1px);
      box-shadow: 0 8px 20px rgba(79, 172, 254, 0.24);
    }

    /*체크포인트*/
    .avatar {
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--aipick-primary);
      color: #fff;
      padding: 8px 18px;
      border-radius: 999px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }

    .avatar:hover {
      background-color: var(--aipick-primary-dark);
      transform: translateY(-1px);
      box-shadow: 0 8px 20px rgba(79, 172, 254, 0.24);
    }

    .avatar i {
      font-size: 15px;
    }

    .mypage-btn {
      width: 75px;
      padding: 6px 0 !important;
      flex-direction: column;
      gap: 2px;
      font-size: 12px;
    }

    .mypage-btn i {
      font-size: 14px;
      line-height: 1;
    }

    .mypage-btn span {
      font-size: 10px;
      line-height: 1;
      opacity: 0.9;
    }
    
    .mypage-btn {
      text-decoration: none !important;
    }

    /* 모바일 토글 */
    .menu-toggle {
      display: none;
      width: 34px;
      height: 34px;
      border-radius: 9px;
      border: 1px solid rgba(148, 163, 184, 0.45);
      background: #fff;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      flex-direction: column;
      gap: 4px;
    }

    .menu-toggle span {
      width: 19px;
      height: 2px;
      background: #0f172a;
      border-radius: 99px;
      transition: all 0.3s ease;
    }

    /* 모바일 메뉴 */
    @media (max-width: 992px) {
      .header-shell {
        gap: 14px;
        padding: 0 16px;
      }

      .search-bar {
        display: none;
      }

      .main-nav {
        position: fixed;
        top: calc(var(--header-height) + 0px);
        left: 0;
        right: 0;
        background: #fff;
        flex-direction: column;
        align-items: flex-start;
        gap: 0;
        padding: 14px 20px 20px;
        border-bottom: 1px solid #e2e8f0;
        transform: translateY(-120%);
        opacity: 0;
        pointer-events: none;
        transition: all 0.28s ease;
      }

      .main-nav.open {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
      }

      .main-nav a {
        display: block;
        width: 100%;
        padding: 10px 0;
      }

      .main-nav a::after {
        bottom: 0;
      }

      .user-area {
        display: none;
      }

      .menu-toggle {
        display: flex;
      }
    }

    @media (max-width: 480px) {
      .logo strong {
        font-size: 18px;
      }

      .topbar {
        font-size: 12px;
      }
    }
  </style>
</head>

<body>

  <div class="topbar">
    새로운 AI 교육 콘텐츠가 업데이트되었습니다.
    <a href="/ai_edu">바로 보기</a>
  </div>

  <header class="site-header">
    <div class="header-shell">
      <a href="/" class="logo">
        <img src="/assets/images/mainlogo.png" alt="AIPICK">
      </a>

      <form class="search-bar" action="/search" method="get">
        <input type="text" name="q" placeholder="AI 이름이나 기능을 검색하세요" autocomplete="off">
        <button type="submit">⌕</button>
      </form>

      <nav class="main-nav" id="mainNav">
        <a href="/ai_rec" class="">AI 추천<span class="badge">NEW</span></a>
        <a href="/ai_edu">AI 교육</a>
        <a href="/ai_news">AI 소식</a>
        <a href="/community">커뮤니티</a>
        <a href="/ads">광고/후원</a>
      </nav>

      <div class="user-area">
        <?php if (isset($_SESSION['user_id'])): ?>
          <?php
          // 간단한 이니셜 만들기
          $username = $_SESSION['username'] ?? 'USER';
          $initial = mb_substr($username, 0, 1, 'UTF-8');
          ?>
          <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
            <a href="/user_management" class="btn-primary">관리자</a>
          <?php endif; ?>
          <a href="/mypage" class="avatar mypage-btn" title="마이페이지">
            <i class="fa-regular fa-user"></i>
            <span>마이페이지</span>
          </a>
          <a href="/signout" class="btn-primary" style="background:#e2e8f0; color:#0f172a;">로그아웃</a>
        <?php else: ?>
          <a href="/signin" class="btn-primary">로그인 / 회원가입</a>
        <?php endif; ?>
      </div>

      <div class="menu-toggle" id="menuToggle" aria-label="모바일 메뉴 열기">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </header>

  <script>
    const menuBtn = document.getElementById('menuToggle');
    const mainNav = document.getElementById('mainNav');
    let isOpen = false;

    menuBtn.addEventListener('click', () => {
      isOpen = !isOpen;
      mainNav.classList.toggle('open', isOpen);

      // 햄버거 애니메이션
      const bars = menuBtn.querySelectorAll('span');
      if (isOpen) {
        bars[0].style.transform = 'translateY(6px) rotate(45deg)';
        bars[1].style.opacity = '0';
        bars[2].style.transform = 'translateY(-6px) rotate(-45deg)';
      } else {
        bars[0].style.transform = '';
        bars[1].style.opacity = '1';
        bars[2].style.transform = '';
      }
    });
  </script>

</body>

</html>