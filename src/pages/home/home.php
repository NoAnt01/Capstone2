<?php
// home.css 파일의 내용을 읽어 <style> 태그로 감싸 $style 변수에 저장
$style = '<style>' . file_get_contents(__DIR__ . '/home.css') . '</style>';

// ▼▼▼ 이 부분을 추가해주세요 ▼▼▼
$banner_script = file_get_contents(__DIR__ . '/bannerad.js');
$tabs_script = file_get_contents(__DIR__ . '/featuretab.js');
$dday_script = file_get_contents(__DIR__ . '/dday.js');
// ▲▲▲ 여기까지 추가 ▲▲▲
// 최신 날짜를 변수로 지정
$latest_date = "25.09.29";

// 기사 배열 (제목, 링크, 배경 색상)
$articles = [
    [
        "title" => "구글, AI 모델의 “종료 거부(resist shutdown)” 위험 경고문 갱신",
        "url" => "https://www.axios.com/2025/09/22/google-ai-risk-models-resist-shutdown?utm_source=chatgpt.com",
        "bg_class" => "bg-purple"
    ],
    [
        "title" => "MIT, 의료 영상 분야에서 임상 연구를 가속화할 새 AI 시스템 개발",
        "url" => "https://www.androidcentral.com/phones/honor-phones/honor-enters-its-dual-engine-ai-era-teasing-magic-8-pro-snapdragon-summit-2025?utm_source=chatgpt.com",
        "bg_class" => "bg-blue"
    ],
    [
        "title" => "한국, AI 주권 확보 위해 국내 기업 5곳에 5,300억 원 투입 계획 발표",
        "url" => "https://apnews.com/article/artificial-intelligence-un-ai-5cb0f21feeb3e734cc0c25eab67fe26d",
        "bg_class" => "bg-pink"
    ],
    [
        "title" => "임시 테스트용 칸 늘리기",
        "url" => "https://www.androidcentral.com/phones/honor-phones/honor-enters-its-dual-engine-ai-era-teasing-magic-8-pro-snapdragon-summit-2025?utm_source=chatgpt.com",
        "bg_class" => "bg-blue"
    ]
];
$ranking_data = [
    // 1~5위
    [
        'rank' => 1, 'Ainame' => 'ChatGPT (OpenAI)', 'category' => '범용 생성형 AI 챗봇', 'tags' => ['HOT'],
        'up_down' => 'up', 'change' => 0, 'color' => 'red'
    ],
    [
        'rank' => 2, 'Ainame' => '뤼튼 (Wrtn)', 'category' => '한국어 특화 생성형 AI', 'tags' => ['HOT'],
        'up_down' => 'up', 'change' => 0, 'color' => 'red'
    ],
    [
        'rank' => 3, 'Ainame' => '제미나이 (Gemini, Google)', 'category' => '범용 생성형 AI, 검색 통합', 'tags' => ['HOT'],
        'up_down' => 'up', 'change' => 0, 'color' => 'red'
    ],
    [
        'rank' => 4, 'Ainame' => '클로드 (Claude, Anthropic)', 'category' => '장문 처리 특화 생성형 AI 챗봇', 'tags' => [''],
        'up_down' => 'down', 'change' => 0, 'color' => 'red'
    ],
    [
        'rank' => 5, 'Ainame' => '에이닷 (A-dot, SKT)', 'category' => '통신사 기반 개인화 AI 비서', 'tags' => [''],
        'up_down' => 'down', 'change' => 0, 'color' => 'red'
    ],
    // 6~10위
    [
        'rank' => 6, 'Ainame' => '퍼플렉시티 (Perplexity)', 'category' => '검색 및 정보 요약 특화 AI', 'tags' => [],
        'up_down' => 'up', 'change' => 11, 'color' => 'blue'
    ],
    [
        'rank' => 7, 'Ainame' => 'DeepL 번역기', 'category' => '고품질 문맥 기반 전문 번역', 'tags' => [],
        'up_down' => 'up', 'change' => 4, 'color' => 'blue'
    ],
    [
        'rank' => 8, 'Ainame' => '노트북LM', 'category' => '자료 정리 및 연구 보조 AI', 'tags' => [],
        'up_down' => 'up', 'change' => 10, 'color' => 'blue'
    ],
    [
        'rank' => 9, 'Ainame' => '미드저니 (Midjourney)', 'category' => '고해상도 이미지 생성', 'tags' => [],
        'up_down' => 'up', 'change' => 2, 'color' => 'blue'
    ],
    [
        'rank' => 10, 'Ainame' => '다글로', 'category' => 'AI 기반 문서 요약 및 텍스트 분석', 'tags' => [],
        'up_down' => 'up', 'change' => 1, 'color' => 'blue'
    ],
    // 11~15위
    [
        'rank' => 11, 'Ainame' => '캔바 AI (Canva AI)', 'category' => '디자인 및 마케팅 콘텐츠 생성', 'tags' => ['NEW'],
        'up_down' => 'up', 'change' => 5, 'color' => 'purple'
    ],
    [
        'rank' => 12, 'Ainame' => 'Veed.io', 'category' => '영상 편집 및 자동 자막 생성', 'tags' => ['NEW'],
        'up_down' => 'down', 'change' => 5, 'color' => 'purple'
    ],
    [
        'rank' => 13, 'Ainame' => 'ChatPDF', 'category' => 'PDF 문서 요약 및 생성', 'tags' => ['NEW'],
        'up_down' => 'down', 'change' => 14, 'color' => 'purple'
    ],
    [
        'rank' => 14, 'Ainame' => 'Cursor AI', 'category' => '개발 코드 생성 및 디버깅 보조', 'tags' => ['NEW'],
        'up_down' => 'up', 'change' => 1, 'color' => 'purple'
    ],
    [
        'rank' => 15, 'Ainame' => '제타 (Zeta)', 'category' => 'AI 기반 대화/롤플레잉 챗봇', 'tags' => ['NEW'],
        'up_down' => 'up', 'change' => 11, 'color' => 'purple'
    ],
];

// 3개의 컬럼으로 데이터를 나눔
$col1_data = array_slice($ranking_data, 0, 5);
$col2_data = array_slice($ranking_data, 5, 5);
$col3_data = array_slice($ranking_data, 10, 5);

// 랭킹 리스트 출력 함수 (RK 클래스 적용)
function render_ranking_list($data) {
    echo '<ul class="rk-ranking-list">';
    foreach ($data as $item) {
        // 순위 변화 아이콘 및 텍스트 설정
        $change_icon = '';
        if ($item['up_down'] === 'up') {
            $change_icon = '▲'; 
            $change_class = 'rk-change-up';
        } elseif ($item['up_down'] === 'down') {
            $change_icon = '▼'; 
            $change_class = 'rk-change-down';
        } else {
            $change_class = 'rk-change-no-change';
        }

        echo '<li class="rk-rank-item">';
        // CSS 변수를 사용해 순위 색상 적용
        echo '<div class="rk-rank-number" style="background-color: var(--rk-color-' . $item['color'] . ');">' . $item['rank'] . '</div>';
        echo '<div class="rk-company-info">';
        echo '<p class="rk-company-name">' . $item['Ainame'] . '</p>';
        echo '<p class="rk-category-tags">';
        echo '<span>' . $item['category'] . '</span>';
        foreach ($item['tags'] as $tag) {
            echo '<span class="rk-tag rk-tag-' . strtolower($tag) . '">' . $tag . '</span>';
        }
        echo '</p>';
        echo '</div>';
        echo '<div class="rk-rank-change">';
        echo '<span class="change-icon ' . $change_class . '">' . $change_icon . '</span>';
        echo '<span class="change-value ' . $change_class . '">' . $item['change'] . '</span>';
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
}

// 최신 날짜를 변수로 지정
$latest_date = "25.09.29";

$korea_chatbot_stats = [
  ['rank' => 1, 'name' => '챗GPT', 'users' => '1,844만 명', 'note' => '압도적 1위'],
  ['rank' => 2, 'name' => '제타', 'users' => '304만 명', 'note' => ''],
  ['rank' => 3, 'name' => '뤼튼', 'users' => '245만 명', 'note' => ''],
  ['rank' => 4, 'name' => '퍼플렉시티 (Perplexity)', 'users' => '171만 명', 'note' => ''],
  ['rank' => 5, 'name' => '에이닷', 'users' => '138만 명', 'note' => ''],
  ['rank' => 6, 'name' => '다글로', 'users' => '63만 명', 'note' => ''],
  ['rank' => 7, 'name' => '채티', 'users' => '43만 명', 'note' => ''],
  ['rank' => 8, 'name' => '클로드 (Claude)', 'users' => '42만 명', 'note' => ''],
  ['rank' => 9, 'name' => '그록 (Grok) AI', 'users' => '36만 명', 'note' => ''],
  ['rank' => 10, 'name' => '크랭', 'users' => '35만 명', 'note' => ''],
];

?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <title>아이픽 홈</title>
  <?php echo $style; // home.css 파일의 내용이 이곳에 삽입됩니다. ?>
</head>
<body>

<!-- 아이픽 추천 AI 영역 시작 -->
<section class="aipick-featured">
  <div class="aipick-featured__inner">
    <div class="aipick-featured__head">
      <div>
        <p class="eyebrow">AIPICK Selected</p>
        <h2>아이픽이 추천하는 AI</h2>
        <!-- 설명 문장 제거 -->
      </div>
      <div class="aipick-featured__actions">
        <a href="/ai_rec" class="btn-outline">전체 보기</a>
      </div>
    </div>

    <div class="aipick-featured__grid">
      <!-- 카드 1 -->
      <article class="ai-pill ai-pill--primary">
        <div class="ai-pill__top">
          <div class="ai-pill__icon">
            <img src="/assets/images/AiCon/gpt.png" alt="ChatGPT">
          </div>
          <span class="tag tag--hot">가장 많이 사용</span>
        </div>
        <h3>ChatGPT</h3>
        <p class="ai-pill__meta">대화, 글쓰기, 번역, 코드</p>
        <p class="ai-pill__desc">한국어 잘하고 문서 작업이 빠른 범용형. 플러그인과 파일 업로드도 지원.</p>
        <a href="https://chat.openai.com" target="_blank" rel="noopener noreferrer" class="ai-pill__link">
          바로가기 <span aria-hidden="true">→</span>
        </a>
      </article>

      <!-- 카드 2 -->
      <article class="ai-pill">
        <div class="ai-pill__top">
          <div class="ai-pill__icon ai-pill__icon--soft">
            <img src="/assets/images/AiCon/gemini.png" alt="Google Gemini">
          </div>
          <span class="tag">검색 연동</span>
        </div>
        <h3>Google Gemini</h3>
        <p class="ai-pill__meta">자료 정리, 이미지 이해</p>
        <p class="ai-pill__desc">구글 생태계와 자연스럽게 연결돼서 리서치할 때 편리해.</p>
        <a href="https://gemini.google.com" target="_blank" rel="noopener noreferrer" class="ai-pill__link">
          바로가기 <span aria-hidden="true">→</span>
        </a>
      </article>

      <!-- 카드 3 -->
      <article class="ai-pill">
        <div class="ai-pill__top">
          <div class="ai-pill__icon ai-pill__icon--soft">
            <img src="/assets/images/AiCon/wrtn.png" alt="뤼튼">
          </div>
          <span class="tag tag--kr">한국어 강점</span>
        </div>
        <h3>뤼튼</h3>
        <p class="ai-pill__meta">국내 서비스, 마케팅 글</p>
        <p class="ai-pill__desc">한국어 템플릿이 다양해서 블로그, 쇼핑몰, 공지 쓰기 좋음.</p>
        <a href="https://wrtn.ai" target="_blank" rel="noopener noreferrer" class="ai-pill__link">
          바로가기 <span aria-hidden="true">→</span>
        </a>
      </article>

      <!-- 카드 4 -->
      <article class="ai-pill">
        <div class="ai-pill__top">
          <div class="ai-pill__icon ai-pill__icon--soft">
            <img src="/assets/images/AiCon/canva.jpg" alt="Canva AI">
          </div>
          <span class="tag">디자인</span>
        </div>
        <h3>Canva AI</h3>
        <p class="ai-pill__meta">썸네일, 카드뉴스</p>
        <p class="ai-pill__desc">디자인 모르는 사람도 브랜드 톤 맞춰 이미지 뽑기 쉬움.</p>
        <a href="https://www.canva.com" target="_blank" rel="noopener noreferrer" class="ai-pill__link">
          바로가기 <span aria-hidden="true">→</span>
        </a>
      </article>
    </div>
  </div>
</section>
<!-- 아이픽 추천 AI 영역 끝 -->


<main class="main-content">
    <div class="banner-wrapper">
        <div class="ad-banner">
            <a href="https://djzerofe.com/" target="_blank" class="banner-link active">
                <img src="/assets/images/adbanner_daejeon.jpg" alt="광고 배너 1">
            </a>
            <a href="https://cafe.naver.com/rfskorea" target="_blank" class="banner-link">
                <img src="/assets/images/adbanner_cafe.jpg" alt="광고 배너 2">
            </a>
            
        </div>
        <div class="banner-pagination"></div>
    </div>
    

<div class="ai-feature-section">
  <div class="feature-heading-row">
    <div>
      <h2>아이픽만의 기능을 소개합니다!</h2>
      <p class="feature-sub">업로드·보정·카피작성까지 가장 자주 쓰는 워크플로우를 모았습니다.</p>
    </div>
  </div>

  <nav class="feature-tabs">
    <ul>
      <li class="active" data-tab="ai-designer">AI 추천</li>
      <li data-tab="ai-image">AI 교육</li>
      <li data-tab="ai-generate">AI 소식</li>
      <li data-tab="ai-erase">AI 커뮤니티</li>
    </ul>
  </nav>

  <div class="feature-content">
    <!-- 탭 1 -->
    <div class="feature-grid active" id="ai-designer">
      <!-- 카드 1 -->
      <article class="feature-card">
        <header class="feature-card-top">
          <span class="feature-badge badge-green">이미지</span>
          <span class="feature-status">추천</span>
        </header>
        <div class="feature-card-body">
          <h3>테마별 AI</h3>
          <p>각 분야에 사용되는 AI들을 한눈에 살펴보세요.</p>
        </div>
        <footer class="feature-card-footer">
          <button type="button" class="feature-link">지금 사용하기 →</button>
        </footer>
      </article>

      <!-- 카드 2 -->
      <article class="feature-card">
        <header class="feature-card-top">
          <span class="feature-badge badge-blue">보정</span>
          <span class="feature-status muted">v2.1</span>
        </header>
        <div class="feature-card-body">
          <h3>최근 출시/업데이트 된 AI</h3>
          <p>최근 새로 출시되거나, 새롭게 업데이트 된 AI들을 만나보세요.</p>
        </div>
        <footer class="feature-card-footer">
          <button type="button" class="feature-link">미리보기 →</button>
        </footer>
      </article>

      <!-- 카드 3 -->
      <article class="feature-card">
        <header class="feature-card-top">
          <span class="feature-badge badge-purple">문서</span>
          <span class="feature-status muted">템플릿</span>
        </header>
        <div class="feature-card-body">
          <h3>사용자 리뷰 기반 AI 추천</h3>
          <p>사용자 리뷰 기반 AI를 추천해드립니다.</p>
        </div>
        <footer class="feature-card-footer">
          <button type="button" class="feature-link">템플릿 보기 →</button>
        </footer>
      </article>

      <!-- 카드 4 -->
      <article class="feature-card">
        <header class="feature-card-top">
          <span class="feature-badge badge-orange">상품</span>
          <span class="feature-status muted">자동배경</span>
        </header>
        <div class="feature-card-body">
          <h3>AI 상세 검색</h3>
          <p>원하는 조건을 설정해 자신만의 AI를 찾아보세요.</p>
        </div>
        <footer class="feature-card-footer">
          <button type="button" class="feature-link">샘플 보기 →</button>
        </footer>
      </article>
    </div>

    <!-- 탭 2~4는 일단 플레이스홀더 -->
    <div class="feature-grid" id="ai-image">
  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-blue">강의</span>
      <span class="feature-status muted">초급</span>
    </header>
    <div class="feature-card-body">
      <h3>생성형 AI 개념 빠르게 이해하기</h3>
      <p>LLM, 프롬프트, 컨텍스트 같은 기본 개념을 짧은 영상으로 정리합니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">학습 시작 →</button>
    </footer>
  </article>

  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-purple">워크숍</span>
      <span class="feature-status muted">실습</span>
    </header>
    <div class="feature-card-body">
      <h3>이미지 편집 AI 실습</h3>
      <p>배경제거, 업스케일, 스타일 변경을 실제 에셋으로 연습해보는 과정입니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">실습 열기 →</button>
    </footer>
  </article>

  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-green">커리어</span>
      <span class="feature-status muted">추천</span>
    </header>
    <div class="feature-card-body">
      <h3>마케터를 위한 AI 활용법</h3>
      <p>캠페인 카피, 썸네일, 리포트까지 마케터 업무에 맞춘 활용 예제를 제공합니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">가이드 보기 →</button>
    </footer>
  </article>

  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-orange">자료</span>
      <span class="feature-status muted">PDF</span>
    </header>
    <div class="feature-card-body">
      <h3>업무 자동화 프롬프트 모음</h3>
      <p>반복 작업에 바로 복사해 쓸 수 있는 한국어 프롬프트만 선별했습니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">다운로드 →</button>
    </footer>
  </article>
</div>

    <div class="feature-grid" id="ai-generate">
  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-purple">업데이트</span>
      <span class="feature-status muted">오늘</span>
    </header>
    <div class="feature-card-body">
      <h3>주요 AI 모델 출시 소식</h3>
      <p>이번 주에 공개된 생성형/이미지 모델을 한 번에 정리해줍니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">자세히 보기 →</button>
    </footer>
  </article>

  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-blue">비교</span>
      <span class="feature-status muted">리포트</span>
    </header>
    <div class="feature-card-body">
      <h3>국내 AI 서비스 동향</h3>
      <p>국내에서 인기 있는 챗봇·이미지·교육 서비스의 변화만 골라서 보여줍니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">리포트 열기 →</button>
    </footer>
  </article>

  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-green">이벤트</span>
      <span class="feature-status muted">모집중</span>
    </header>
    <div class="feature-card-body">
      <h3>AI 콘테스트 / 해커톤</h3>
      <p>현재 신청 가능한 대회, 공모, 온라인 챌린지를 모아둔 페이지입니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">참여하기 →</button>
    </footer>
  </article>

  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-orange">공지</span>
      <span class="feature-status muted">AIPICK</span>
    </header>
    <div class="feature-card-body">
      <h3>플랫폼 공지사항</h3>
      <p>서비스 점검, 신규 AI 추가, 요금 정책 변경이 있으면 이곳에 노출합니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">공지 보기 →</button>
    </footer>
  </article>
</div>

    <div class="feature-grid" id="ai-erase">
  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-blue">HOT</span>
      <span class="feature-status muted">오늘</span>
    </header>
    <div class="feature-card-body">
      <h3>이번 주 내가 만든 AI 결과물</h3>
      <p>사용자들이 만든 썸네일·피피티·광고 콘텐츠를 모아서 보여줍니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">갤러리 보기 →</button>
    </footer>
  </article>

  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-green">Q&amp;A</span>
      <span class="feature-status muted">해결됨</span>
    </header>
    <div class="feature-card-body">
      <h3>“배경제거가 들쭉날쭉해요”</h3>
      <p>같은 문제를 겪는 사람들을 위한 팁과 추천 모델을 모아둔 글입니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">답변 보기 →</button>
    </footer>
  </article>

  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-purple">사례</span>
      <span class="feature-status muted">실무</span>
    </header>
    <div class="feature-card-body">
      <h3>마케팅팀 AI 도입 후기</h3>
      <p>어떤 워크플로우에 가장 효과가 있었는지 실무자가 적은 활용기입니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">사례 읽기 →</button>
    </footer>
  </article>

  <article class="feature-card">
    <header class="feature-card-top">
      <span class="feature-badge badge-orange">모집</span>
      <span class="feature-status muted">3명</span>
    </header>
    <div class="feature-card-body">
      <h3>AI 툴 리뷰어 모집</h3>
      <p>새로 올라오는 AI 서비스를 먼저 써보고 후기 남겨줄 크리에이터를 찾는 공간입니다.</p>
    </div>
    <footer class="feature-card-footer">
      <button type="button" class="feature-link">참여 신청 →</button>
    </footer>
  </article>
</div>


  <!-- JS에서 쓰는 페이지네이션 요소는 유지 -->
  <div class="feature-pagination">
    <button class="prev-btn" aria-label="이전 탭으로 이동">&lt;</button>
    <span><span class="current-page">1</span> / <span class="total-pages">4</span></span>
    <button class="next-btn" aria-label="다음 탭으로 이동">&gt;</button>
  </div>
</div>


  <!--
    <div class="latest-news-container">
        <div class="latest-news-title">최신 뉴스</div>
        <p class="latest-news-date">최신 날짜 <?php echo $latest_date; ?></p>

        <div class="latest-news-cards">
            <?php foreach ($articles as $article): ?>
                <div class="news-card <?php echo $article['bg_class']; ?>">
                    <div class="news-title"><?php echo $article['title']; ?></div>
                    <a href="<?php echo $article['url']; ?>" target="_blank" rel="noopener noreferrer" class="news-link">기사 바로가기</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
  -->
    
<section class="kr-chatbot-stats section-shell">
  <div class="kr-chatbot-shell">
    <header class="kr-chatbot-header">
      <div>
        <h2>한국에서 많이 쓰는 AI 챗봇 앱</h2>
        <p class="lead">
          2025년 6월 AI 챗봇 앱 사용 현황(WISEAPP • RETAIL)
        </p>
      </div>
    </header>

    <div class="kr-chatbot-grid">
      <!-- 왼쪽 리스트 -->
      <div class="kr-chatbot-left">
        <ol class="kr-chatbot-list">
          <?php foreach ($korea_chatbot_stats as $item): ?>
            <li class="kr-chatbot-row <?php echo $item['rank'] <= 3 ? 'is-top' : ''; ?>">
              <div class="rank-chip"><?php echo $item['rank']; ?></div>
              <div class="chatbot-info">
                <div class="chatbot-name-line">
                  <span class="chatbot-name"><?php echo $item['name']; ?></span>
                  <?php if (!empty($item['note'])): ?>
                    <span class="chatbot-pill"><?php echo $item['note']; ?></span>
                  <?php endif; ?>
                </div>
              </div>
              <div class="chatbot-users-inline">
                <?php echo $item['users']; ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <!-- 오른쪽 정사각형 배너 -->
      <aside class="kr-chatbot-aside">
        <div class="sq-banner-card">
          <a href="http://aipick.ai.kr/ads" class="sq-banner-media">
            <img src="/assets/images/squareAd_2.jpg" alt="스폰서 배너">
          </a>
          <div class="sq-banner-body">
            <p class="sq-title">아이픽 - AI에 대한 모든 것</p>
            <p class="sq-text">AI 선택, 학습, 소식, 질문·답변까지 필요한 모든 것을 한 번에 만나보세요.</p>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>
  
</main>

<script>
    <?php echo $banner_script; ?>
    <?php echo $tabs_script; ?>
</script>

</body>
</html>