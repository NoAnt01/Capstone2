<?php
// PHP 변수 정의
$current_time = date('H시 i분'); 

// 1. 데이터 정의
// [핵심 수정]: theme 값을 아래 버튼의 data-filter 값(chatbot, media, iot 등)과 일치시켰습니다.
$hot_news_data = [
    [
        'title' => '뤼튼, "GPT-5 무제한 무료" 선언…글쓰기 경험 혁신',
        'source' => 'AI타임스',
        'time' => '3개월 전',
        'theme' => 'chatbot', 
        'url' => 'https://www.aitimes.com/news/articleView.html?idxno=160279',

    ],
    [
        'title' => '뤼튼, 오픈AI GPT-5 무료로 오늘부터 무제한 제공',
        'source' => '전자신문 etnews',
        'time' => '4개월 전',
        'theme' => 'chatbot', 
        'url' => 'https://www.etnews.com/20250808000119',

    ],
    [
        'title' => '뤼튼에서 최신 GPT5 유료 서비스를 무제한 무료로',
        'source' => '뉴스1',
        'time' => '4개월 전',
        'theme' => 'chatbot',
        'url' => 'https://www.news1.kr/it-science/general-it/5873327',

    ],
    [
        'title' => '생성형 AI 톱100과 트렌드···14개 올스타기업·바이브코딩 등 주목',
        'source' => '테크42',
        'time' => '1일 전',
        'theme' => 'lifestyle',
        'url' => 'https://www.tech42.co.kr/%EC%83%9D%EC%84%B1%ED%98%95-ai-%ED%86%B1100%EA%B3%BC-%ED%8A%B8%EB%A0%8C%EB%93%9C%C2%B7%C2%B7%C2%B714%EA%B0%9C-%EC%98%AC%EC%8A%A4%ED%83%80%EA%B8%B0%EC%97%85%C2%B7%EB%B0%94%EC%9D%B4%EB%B8%8C%EC%BD%94/?utm_source=rss&utm_medium=rss&utm_campaign=%25ec%2583%259d%25ec%2584%25b1%25ed%2598%2595-ai-%25ed%2586%25b1100%25ea%25b3%25bc-%25ed%258a%25b8%25eb%25a0%258c%25eb%2593%259c%25c2%25b7%25c2%25b7%25c2%25b714%25ea%25b0%259c-%25ec%2598%25ac%25ec%258a%25a4%25ed%2583%2580%25ea%25b8%25b0%25ec%2597%2585%25c2%25b7%25eb%25b0%2594%25ec%259d%25b4%25eb%25b8%258c%25ec%25bd%2594',

    ],
    [
        'title' => '[사설] AI-SW 모든 것을 만날 기회',
        'source' => '전자신문 etnews',
        'time' => '1일 전',
        'theme' => 'education',
        'url' => 'https://www.etnews.com/20251202000327',
  
    ],
    [
        'title' => '챗GPT가 우리 브랜드 제품 추천하게 만드는 방법',
        'source' => '전자신문 etnews',
        'time' => '1일 전',
        'theme' => 'chatbot',
        'url' => 'https://www.etnews.com/20251202000338',

    ],
    [
        'title' => '딥엘, 언어AI 넘어 엔터프라이즈 AI 파트너로 진화 선언',
        'source' => '전자신문 etnews',
        'time' => '1일 전',
        'theme' => 'chatbot',
        'url' => 'https://www.etnews.com/20251202000277',

    ],
    [
        'title' => 'AI 콘텐츠도 귀여우면 괜찮아...SNS에 AI 동물 콘텐츠 열풍',
        'source' => 'AI타임스',
        'time' => '1일 전',
        'theme' => 'lifestyle',
        'url' => 'https://www.aitimes.com/news/articleView.html?idxno=204442',

    ],
    [
        'title' => '"GPT-5가 올해 수능 435.5점 기록...AI 중 가장 뛰어나"',
        'source' => 'AI타임스',
        'time' => '1개월 전',
        'theme' => 'education',
        'url' => 'https://www.aitimes.com/news/articleView.html?idxno=204062',

    ],
];

// 실시간 급상승 데이터
// 실시간 급상승 데이터 (AI 관련, 링크 포함)
$realtime_news = [
    ['title' => '“생성형 AI는 예고편, 에이전틱AI와 피지컬 AI 시대 온다”', 'url' => 'https://www.betanews.net/article/view/beta202512020087'],
    ['title' => '“AI로 신약 개발, 임상, 진단… 의료 서비스 확 바뀔 것”', 'url' => 'https://news.daum.net/ai-tech'],
    ['title' => '“\'거품 아니다\' AI 수요 \'우상향\'…2030년 반도체 시장규모 1700조”', 'url' => 'https://www.news1.kr/industry/general-industry/5892646'],
    ['title' => '“AI 반도체 시장의 현황과 전망: 엔비디아의 아성과 경쟁사의 도전”', 'url' => 'https://www.samsungsds.com/kr/insights/ai-semiconductor.240306.html'],
    ['title' => '“생성형 AI 부정행위와 윤리의식: 가치와 문화, 교육이 해결의 출발점”', 'url' => 'https://www.seoul.co.kr/news/editOpinion/world-stories/2025/12/02/20251202035005'],
    ['title' => '“시청자미디어재단 \'AI활용 미디어 제작 지원 가이드\' 발표”', 'url' => 'https://www.yna.co.kr/view/AKR20251127057300017'],
    ['title' => '“AI 시대에도 좋은 콘텐츠가 핵심…신뢰 바탕 다양한 실험을”', 'url' => 'https://www.hani.co.kr/arti/society/media/1232064.html'],
    ['title' => '“충남교육청, 생성형 인공지능(AI)윤리 교육자료 개발·보급”', 'url' => 'http://www.geumsan-news.com/news/articleView.html?idxno=28652'],
    ['title' => '“AI가 투명 인간처럼 결제하는 시대… 안전한 시스템 갖춰야”', 'url' => 'https://news.daum.net/ai-tech'],
    ['title' => '“넥스트 \'생성형AI\'는?…소프트웨어정책연구소 “\'뇌·컴퓨터 인터페이스\' 주목해야””', 'url' => 'https://www.etnews.com/20251202000296'],
];

$style = '<style>' . file_get_contents(__DIR__ . '/ai_news.css') . '</style>';


?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AI 소식</title>
    <?php echo $style; ?>
    <style>
        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="tab active"> 아이픽이 알려주는 AI 소식 </div>
    <div class="main-content">
        <section class="news-section">
            <div class="realtime-rank">
                <h2>실시간 급상승 AI관련 소식 📈</h2>
                <span class="view-all" id="toggleBtn">더보기 <span class="arrow">▼</span></span>
                <ul class="rank-list" id="rankList">
                    <?php
                    foreach ($realtime_news as $index => $item) {
                        $rank = $index + 1;
                        echo "<li class='rank-item' style='--delay: " . ($index * 0.15) . "s'>
                                    <span class='rank-num'>{$rank}</span>
                                    <a href='{$item['url']}' target='_blank' class='rank-link'><span class='rank-text'>{$item['title']}</span></a>
                                </li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="hot-news-section">
                <h2> 테마별로 알아보는 AI들의 최근 소식 <strong>!!!</strong></h2>
                
                <div class="categories">
                    <button class="category-btn active" data-filter="all">전체</button>
                    <button class="category-btn" data-filter="chatbot">대화형 AI 챗봇</button>
                    <button class="category-btn" data-filter="media">미디어</button>
                    <button class="category-btn" data-filter="iot">IoT</button>
                    <button class="category-btn" data-filter="education">교육/학습</button>
                    <button class="category-btn" data-filter="lifestyle">실생활</button>
                </div>

                <div id="newsRenderArea">
                    <div id="mainNewsContainer"></div>
                    <div id="subNewsContainer" class="sub-news-list"></div>
                </div>

            </div>
        </section>

        <aside class="sidebar-section">
            <div class="trending-news">
                <h3>주간 핫한 AI 소식 🔥</h3>
                <ul class="hot-list">
                    <li><span class="list-num">1.</span> <a href="https://www.yna.co.kr/view/AKR20251202076700017">"한국·오픈AI 협력 본격화…첫 워킹그룹 가동"</a></li>
                    <li><span class="list-num">2.</span> <a href="https://www.yna.co.kr/view/AKR20251127035900005">"정부, 창작자 보호 'AI 학습 가이드라인' 마련…내달 발표"</a></li>
                    <li><span class="list-num">3.</span> <a href="https://www.ddaily.co.kr/page/view/2025113020514951168">"인재는 `파격 지원` 규제는 `대폭 완화`... 하드웨어 넘어 `체질 개선`"</a></li>
                    <li><span class="list-num">4.</span> <a href="https://news.daum.net/ai-tech">"AI로 신약 개발, 임상, 진단… 의료 서비스 확 바뀔 것"</a></li>
                    <li><span class="list-num">5.</span> <a href="https://news.daum.net/ai-tech">"AI가 투명 인간처럼 결제하는 시대… 안전한 시스템 갖춰야"</a></li>
                    <li><span class="list-num">6.</span> <a href="https://www.aitimes.kr/">"카카오, 미래 인재 양성 위한 청소년 대상 'AI 루키 캠프' 시작"</a></li>
                    <li><span class="list-num">7.</span> <a href="https://www.yna.co.kr/view/AKR20251202069800017">"AI번역 딥엘 CEO \"한국, 디지털 도입 속도 최고\""</a></li>
                    <li><span class="list-num">8.</span> <a href="https://www.etnews.com/20251202000177">"소프트웨이브 250개 기업이 펼친 'AI 비즈니스 지도'"</a></li>
                    <li><span class="list-num">9.</span> <a href="https://www.yna.co.kr/view/AKR20251201137800017">"내년 광고시장 트렌드는 AI 마케팅·발견형 커머스·OTT·DOOH"</a></li>
                    <li><span class="list-num">10.</span> <a href="https://news.daum.net/ai-tech">"영상 검색 AI모델, 북미 잡고 유럽으로"</a></li>
                </ul>
            </div>
        </aside>
    </div>
</div>

<script>
    const allNewsData = <?php echo json_encode($hot_news_data); ?>;
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainContainer = document.getElementById('mainNewsContainer');
    const subContainer = document.getElementById('subNewsContainer');
    const categories = document.querySelector('.categories');
    const rankList = document.getElementById('rankList');
    const toggleBtn = document.getElementById('toggleBtn');

    // 초기 화면 렌더링
    renderNews('all');

    // 카테고리 필터링
    categories.addEventListener('click', function(e) {
        if (!e.target.classList.contains('category-btn')) return;

        const currentActive = document.querySelector('.category-btn.active');
        if(currentActive) currentActive.classList.remove('active');
        e.target.classList.add('active');

        const filter = e.target.getAttribute('data-filter');
        renderNews(filter);
    });

    function renderNews(filter) {
        let filteredData = [];
        if (filter === 'all') {
            filteredData = allNewsData;
        } else {
            // theme 값을 기준으로 필터링
            filteredData = allNewsData.filter(item => item.theme === filter);
        }

        const displayData = filteredData.slice(0, 5);

        mainContainer.innerHTML = '';
        subContainer.innerHTML = '';

        if (displayData.length === 0) {
            mainContainer.innerHTML = '<p style="text-align:center; padding:40px; color:#999;">해당 카테고리의 소식이 없습니다.</p>';
            return;
        }

        const subFragment = document.createDocumentFragment();

        displayData.forEach((item, index) => {
            const rank = index + 1;
            const defaultImg = "/assets/images/AiCon/canva.png";
            const imgSrc = item.img ? item.img : defaultImg;
            const summaryText = item.summary ? item.summary : item.title;

            if (index === 0) {
                // [1위 뉴스] CSS 제어를 위해 'first-image' 클래스 사용
                const mainHtml = `
                    <a href="${item.url}" target="_blank" rel="noopener noreferrer" class="main-article first-news fade-in">
                        <div class="article-rank">1위</div>
                        <h3>${item.title}</h3>
                        <div class="article-meta">
                            <span class="source">${item.source}</span>
                            <span class="time">${item.time}</span>
                            <span class="separator">·</span>

                        </div>
                    </a>
                `;
                mainContainer.innerHTML = mainHtml;

            } else {
                // [2~5위 뉴스] CSS 제어를 위해 'sub-image' 클래스 사용
                const subArticle = document.createElement('div');
                subArticle.className = 'sub-article fade-in';
                subArticle.innerHTML = `
                    <div class="article-rank">${rank}위</div>
                    <a href="${item.url}" target="_blank" rel="noopener noreferrer">
                        <h4>${item.title}</h4>
                    </a>
                    <div class="article-meta">
                        <span class="source">${item.source}</span>
                        <span class="time">${item.time}</span>
                        <span class="separator">·</span>
                    </div>
                `;
                subFragment.appendChild(subArticle);
            }
        });
        
        subContainer.appendChild(subFragment);
    }

    // 더보기/접기 토글
    toggleBtn.addEventListener('click', function() {
        const arrowSpan = this.querySelector('.arrow');
        rankList.classList.toggle('all-visible');
        this.classList.toggle('expanded');
        if(rankList.classList.contains('all-visible')) {
            this.childNodes[0].nodeValue = '접기 ';
            if (arrowSpan) arrowSpan.textContent = '▲';
        } else {
            this.childNodes[0].nodeValue = '더보기 ';
            if (arrowSpan) arrowSpan.textContent = '▼';
        }
    });
});
</script>
</body>
</html>