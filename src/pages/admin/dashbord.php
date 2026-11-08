<!--모듈화-->
<aside class="sidebar">
    <div class="header">관리자 페이지</div>
    <nav class="nav">
        <?php
            $current_uri = $_SERVER['REQUEST_URI'];
            $path = parse_url($current_uri, PHP_URL_PATH);
        ?>
        
        <a href="user_management" class="nav-item <?php echo (basename($path) === 'user_management') ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> 사용자 관리
        </a>
        
        <a href="ai_management" class="nav-item <?php echo (basename($path) === 'ai_management') ? 'active' : ''; ?>">
            <i class="fas fa-list"></i> AI 관리
        </a>

        <a href="inquiry_admin" class="nav-item <?php echo (basename($path) === 'inquiry_admin') ? 'active' : ''; ?>">
            <i class="fas fa-solid fa-pen"></i> 문의 답변
        </a>
    </nav>
    <div class="footer">
        <a href="#"><i class="fas fa-sign-out-alt"></i> 로그아웃</a>
    </div>
</aside>