<?php // footer.php ?>

<style>
    /* ===== 공통: 푸터 전체 ===== */
    .footer {
        width: 100%;
        background-color: #f3f4f6; /* 살짝 짙은 회색 배경 */
        color: #4b5563;
        border-top: 1px solid #e5e7eb;
        padding: 32px 0 0;
        font-family: 'Poppins', 'Noto Sans KR', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        font-size: 14px;
    }

    /* ===== 내부 컨테이너 ===== */
    .footer-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 32px 24px;
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1.2fr) minmax(0, 1.2fr) minmax(0, 1.4fr);
        gap: 28px;
        align-items: flex-start;
    }

    /* ===== 섹션 공통 ===== */
    .footer-section {
        min-width: 200px;
    }

    .footer-section h4 {
        color: #111827;
        font-size: 15px;
        font-weight: 600;
        margin: 0 0 12px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-section ul li {
        margin-bottom: 8px;
    }

    .footer-section a {
        color: #4b5563;
        text-decoration: none;
        font-size: 13px;
        transition: color 0.18s ease;
    }

    .footer-section a:hover {
        color: var(--aipick-primary, #3185ff);
    }

    /* ===== 소개 영역 ===== */
    .footer-section.about .footer-logo {
        height: 30px;
        margin-bottom: 10px;
        display: block;
    }

    .footer-section.about p {
        font-size: 13px;
        line-height: 1.7;
        margin: 0;
        color: #374151;
    }

    /* ===== 문의 / 후원 섹션 ===== */
    .footer-section.contact p {
        margin: 0 0 6px;
        font-size: 13px;
        line-height: 1.6;
    }

    .footer-section.contact p strong {
        color: #1f2933;
        font-weight: 600;
    }

    .footer-chip-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 999px;
        border: 1px solid #d1d5db;
        font-size: 12px;
        color: #4b5563;
        text-decoration: none;
        margin-top: 4px;
        background: #f9fafb;
        transition: all 0.18s ease;
    }

    .footer-chip-link:hover {
        border-color: var(--aipick-primary, #3185ff);
        color: var(--aipick-primary, #3185ff);
        background: #ffffff;
    }

    /* ===== 하단 카피라이트 ===== */
    .footer-bottom {
        border-top: 1px solid #e5e7eb;
        margin-top: 8px;
        padding: 14px 0 18px;
        text-align: center;
    }

    .footer-bottom p {
        margin: 0;
        font-size: 12px;
        color: #9ca3af;
    }

    /* ===== 반응형 ===== */
    @media (max-width: 960px) {
        .footer-container {
            grid-template-columns: minmax(0, 2fr) minmax(0, 1.5fr);
            row-gap: 24px;
        }
    }

    @media (max-width: 640px) {
        .footer-container {
            padding: 0 20px 20px;
            grid-template-columns: minmax(0, 1fr);
        }

        .footer-section.about {
            order: 0;
        }
        .footer-section.links {
            order: 1;
        }
        .footer-section.support {
            order: 2;
        }
        .footer-section.contact {
            order: 3;
        }
    }
</style>

<footer class="footer">
    <div class="footer-container">
        <!-- 소개 -->
        <div class="footer-section about">
            <img src="/assets/images/mainlogo.png" alt="AIPICK Logo" class="footer-logo">
            <p>
                AIPICK은 수많은 AI 서비스들을<br>
                비교·정리하고, 나에게 맞는 도구를<br>
                더 빠르게 찾을 수 있도록 돕는<br>
                AI 서비스 큐레이션 플랫폼입니다.
            </p>
        </div>

        <!-- 바로가기 -->
        <div class="footer-section links">
            <h4>바로가기</h4>
            <ul>
                <li><a href="/ai_rec">AI 추천</a></li>
                <li><a href="/ai_edu">AI 교육</a></li>
                <li><a href="/ai_news">AI 소식</a></li>
                <li><a href="/community">커뮤니티</a></li>
                <li><a href="/ads">배너·후원 안내</a></li>
            </ul>
        </div>

        <!-- 이용 안내 -->
        <div class="footer-section support">
            <h4>이용 안내</h4>
            <ul>
                <li><a href="/terms">이용약관</a></li>
                <li><a href="/privacy">개인정보처리방침</a></li>
                <li><a href="/support">고객센터</a></li>
            </ul>
        </div>

        <!-- 문의 / 후원 -->
        <div class="footer-section contact">
            <h4>문의 · 후원</h4>
            <p><strong>광고 · 후원 안내 :</strong></p>
            <p>
                배너 광고 및 개인 후원은<br>
                상단 메뉴 또는 아래 링크에서<br>
                자세한 내용을 확인하실 수 있어요.
            </p>
            <a href="/ads" class="footer-chip-link">배너 · 후원 안내 페이지 바로가기 →</a>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> AIPICK. All Rights Reserved.</p>
    </div>
</footer>

</body>
</html>
