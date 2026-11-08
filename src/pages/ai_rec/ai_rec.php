<?php
// CSS 파일을 읽어와 <style> 태그 안에 포함
$style = '<style>' . file_get_contents(__DIR__ . '/ai_rec.css') . '</style>';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI 추천 허브</title>
    <?php echo $style; ?>
</head>
<body class="ai-edu-page">

<div class="ai-container">
    <h1>아이픽 AI 추천 허브</h1>
    <p class="subtitle">
        업무·학습·개인 프로젝트까지, 목적에 맞는 AI를 한 번에 탐색하고 비교해 보세요.
        아이픽이 수많은 서비스 중 지금 쓰기 좋은 AI만 골라드립니다.
    </p>

    <div class="card-group">

        <!-- ✅ 테마별 AI 보기 -->
        <div class="edu-card">
            <div class="card-header">
                <h2>테마별 AI 모아보기</h2>
            </div>
            <p class="card-description">
                문서작성, 코딩, 디자인, 영상 편집 등 활용 목적별로 자주 쓰이는 AI를 묶어서 보여줍니다.
                “어떤 종류의 AI가 있는지” 감을 잡고 싶을 때 먼저 살펴보는 섹션입니다.
            </p>
            <a href="/ai_theme" class="btn btn-support">테마별 AI 살펴보기</a>
        </div>

        <!-- ✅ 최근 출시/업데이트 된 AI -->
        <div class="edu-card">
            <div class="card-header">
                <h2>최근 출시·업데이트된 AI</h2>
            </div>
            <p class="card-description">
                최근 출시되었거나 대규모 업데이트가 반영된 AI만 선별해 큐레이션합니다.
                카드 클릭 시 공식 사이트로 이동해 바로 체험해 볼 수 있습니다.
            </p>

            <?php
            $aiList = [
                [
                    "img"   => "/assets/images/AiCon/gpt.png",
                    "title" => "ChatGPT",
                    "desc"  => "최근 업데이트 · 2025년 8월",
                    "link"  => "https://chat.openai.com/"
                ],
                [
                    "img"   => "/assets/images/AiCon/gemini.png",
                    "title" => "Gemini",
                    "desc"  => "최근 업데이트 · 2025년 6월",
                    "link"  => "https://gemini.google.com/"
                ],
                [
                    "img"   => "/assets/images/AiCon/claude.png",
                    "title" => "Claude AI",
                    "desc"  => "최근 업데이트 · 2025년 10월",
                    "link"  => "https://claude.ai/"
                ],
                [
                    "img"   => "/assets/images/AiCon/canva.jpg",
                    "title" => "Canva",
                    "desc"  => "최근 업데이트 · 2025년 7월",
                    "link"  => "https://www.canva.com/"
                ],
                [
                    "img"   => "/assets/images/AiCon/wrtn.png",
                    "title" => "뤼튼(Wrtn)",
                    "desc"  => "최근 업데이트 · 2025년 8월",
                    "link"  => "https://wrtn.ai/"
                ],
                [
                    "img"   => "/assets/images/AiCon/sora.png",
                    "title" => "Sora",
                    "desc"  => "최근 업데이트 · 2025년 9월",
                    "link"  => "https://openai.com/sora"
                ],
                [
                    "img"   => "/assets/images/AiCon/cursor.png",
                    "title" => "Cursor AI",
                    "desc"  => "최근 업데이트 · 2025년 10월",
                    "link"  => "https://www.cursor.sh"
                ],
                [
                    "img"   => "/assets/images/AiCon/liner.jpg",
                    "title" => "Liner",
                    "desc"  => "최근 업데이트 · 2025년 10월",
                    "link"  => "https://liner.ai"
                ],
                [
                    "img"   => "/assets/images/AiCon/removebg.jpg",
                    "title" => "Remove.bg",
                    "desc"  => "최근 업데이트 · 2024년 12월",
                    "link"  => "https://www.remove.bg"
                ],
                [
                    "img"   => "/assets/images/AiCon/synthesia.jpg",
                    "title" => "Synthesia",
                    "desc"  => "최근 업데이트 · 2024년 6월",
                    "link"  => "https://www.synthesia.io"
                ],
            ];
            ?>

            <!-- 🔽 카드 리스트 -->
            <div class="ai-scroll-wrapper">
                <!-- 왼쪽 화살표 -->
                <button class="ai-scroll-arrow ai-scroll-prev" type="button" aria-label="이전 카드 보기">
                    ‹
                </button>

                <div class="ai-scroll-container">
                    <?php foreach ($aiList as $ai): ?>
                        <a href="<?= htmlspecialchars($ai['link']) ?>"
                           target="_blank"
                           class="ai-card-large">
                            <div class="ai-card-hero">
                                <img src="<?= htmlspecialchars($ai['img']) ?>"
                                     alt="<?= htmlspecialchars($ai['title']) ?>">
                                <div class="ai-card-badge">
                                    <img src="<?= htmlspecialchars($ai['img']) ?>"
                                         alt="<?= htmlspecialchars($ai['title']) ?> 로고">
                                </div>
                            </div>
                            <div class="ai-card-body">
                                <h3><?= htmlspecialchars($ai['title']) ?></h3>
                                <p><?= htmlspecialchars($ai['desc']) ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- 오른쪽 화살표 -->
                <button class="ai-scroll-arrow ai-scroll-next" type="button" aria-label="다음 카드 보기">
                    ›
                </button>
            </div>

            <a href="/ai_update" class="btn btn-popular">업데이트된 AI 전체 보기</a>
        </div>

        <!-- ✅ 사용자 리뷰 기반 AI 추천 -->
        <div class="edu-card">
            <div class="card-header">
                <h2>사용자 리뷰 기반 추천</h2>
            </div>
            <p class="card-description">
                단순 스펙이 아니라 실제 사용자들이 남긴 평가, 사용 패턴, 재방문 비율을 종합해
                “지금 만족도가 높은 AI”를 선별합니다. 처음 AI를 선택할 때 가장 도움이 되는 영역입니다.
            </p>
            <a href="/ai_user" class="btn btn-book">리뷰 기반 추천 보러가기</a>
        </div>

    </div>
</div>

<!-- 🔽 좌우 화살표 클릭 시 스크롤 이동 -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ai-scroll-wrapper').forEach(function (wrapper) {
        const container = wrapper.querySelector('.ai-scroll-container');
        const prevBtn   = wrapper.querySelector('.ai-scroll-prev');
        const nextBtn   = wrapper.querySelector('.ai-scroll-next');

        if (!container) return;

        function getScrollAmount() {
            return container.clientWidth;
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                container.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                container.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
            });
        }
    });
});
</script>

</body>
</html>
