<?php
$style = '<style>' . file_get_contents(__DIR__ . '/ads.css') . '</style>';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아이픽 후원 · 배너 광고 안내</title>
    <?php echo $style; ?>
</head>
<body class="ai-edu-page">
    <div class="container">
        <h1>아이픽 후원 · 배너 광고 안내</h1>
        <p>
            아이픽은 <strong>“어떤 AI를 쓸지, 어디서 배울지, 어떤 소식이 나오는지”</strong>를  
            한눈에 정리하고자 만든 1인 운영 프로젝트입니다.  
            서비스 유지와 개선에 들어가는 서버·도메인·개발 비용은 모두 개인 부담으로 진행되고 있으며,  
            여러분의 <strong>배너 광고</strong>와 <strong>개인 후원</strong>이 아이픽을 계속 이어가는 가장 큰 힘이 됩니다.
        </p>

        <!-- 공통 입금 계좌 정보 -->
        <div class="donation-method">
            <h2>입금 계좌 안내</h2>
            <p><strong>은행명 :</strong> KB국민은행</p>
            <p><strong>계좌번호 :</strong> 743801-01-372071</p>
            <p><strong>예금주 :</strong> 김주호</p>
            <p style="margin-top: 10px;">
                배너 광고 또는 개인 후원 입금 후, 카카오톡으로  
                <strong>아이픽_입금자 아이디</strong>를 남겨주시면  
                확인 및 적용이 훨씬 빨라집니다.
            </p>
        </div>

        <!-- 1. 배너 광고 (1920x300, 500x500) -->
        <div class="sponsorship-section">
            <h2>1. 배너 광고</h2>
            <p>
                아이픽에 배너를 게재해 <strong>서비스, 프로젝트, 채널, 이벤트</strong> 등을 소개할 수 있습니다.  
                배너는 모두 <strong>클릭 시 지정하신 링크</strong>로 이동되며, 하루 단위로 운영됩니다.
            </p>

            <h3>① 메인 상단 와이드 배너 (1920 × 300)</h3>
            <p>
                아이픽 메인 화면 최상단에 노출되는 가로형 와이드 배너입니다.  
                방문자가 가장 먼저 보는 영역으로, 브랜드나 주요 이벤트 홍보에 적합합니다.
            </p>
            <p><strong>이미지 규격</strong></p>
            <ul>
                <li>권장 해상도: <strong>1920 × 300px</strong></li>
                <li>형태: 가로 와이드형 배너</li>
                <li>파일 형식: <strong>PNG / JPG</strong></li>
            </ul>
            <p><strong>이용 요금</strong></p>
            <ul>
                <li><strong>하루(00:00 ~ 24:00) 3,000원</strong></li>
            </ul>

            <h3>② 메인 우측 정사각 배너 (500 × 500)</h3>
            <p>
                메인 화면 하단의 <strong>“한국에서 많이 쓰는 AI 챗봇 앱 TOP 10”</strong> 섹션 우측에  
                함께 노출되는 정사각형 배너입니다. 개인·팀·작은 프로젝트, 채널 소개 등에 잘 어울립니다.
            </p>
            <p><strong>이미지 규격</strong></p>
            <ul>
                <li>권장 해상도: <strong>500 × 500px</strong></li>
                <li>형태: 정사각형 배너</li>
                <li>파일 형식: <strong>PNG / JPG</strong></li>
            </ul>
            <p><strong>이용 요금</strong></p>
            <ul>
                <li><strong>하루(00:00 ~ 24:00) 2,000원</strong></li>
            </ul>

            <p><strong>배너 공통 안내</strong></p>
            <ul>
                <li>배너 클릭 시 연결할 <strong>URL 1개</strong>를 지정하실 수 있습니다. (사이트, 노션, 유튜브, SNS 등)</li>
                <li>배너 이미지는 후원자께서 직접 제작해 주셔야 하며, 별도의 디자인 대행은 제공하지 않습니다.</li>
                <li>법적 문제가 될 수 있는 내용, 과도하게 선정적인 표현, 도박·투자 권유 등의 배너는 게재가 제한될 수 있습니다.</li>
                <li>최종 게재 일정은 <strong>입금 및 이미지/문구 확인 이후</strong> 카카오톡을 통해 확정 안내드립니다.</li>
            </ul>
        </div>

        <!-- 2. 개인 후원 (닉네임 아이콘) -->
        <div class="sponsorship-section">
            <h2>2. 개인 후원 (닉네임 아이콘)</h2>
            <p>
                아이픽을 조용히 응원해 주시는 분들을 위해,  
                후원 금액에 따라 <strong>닉네임 앞에 작은 아이콘</strong>을 달아드리는 개인 후원 옵션을 운영합니다.  
                금액대별로 아이콘의 형태와 강조 정도가 달라집니다.
            </p>

            <table>
                <thead>
                    <tr>
                        <th>후원 금액</th>
                        <th>아이콘 단계</th>
                        <th>설명</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2,000원</td>
                        <td>Lv.1 아이콘</td>
                        <td>기본 후원자임을 표시하는 심플한 아이콘이 닉네임 앞에 표시됩니다.</td>
                    </tr>
                    <tr>
                        <td>5,000원</td>
                        <td>Lv.2 아이콘</td>
                        <td>Lv.1보다 조금 더 눈에 띄는 색상과 형태의 아이콘이 적용됩니다.</td>
                    </tr>
                    <tr>
                        <td>10,000원</td>
                        <td>Lv.3 아이콘</td>
                        <td>가장 강조된 스타일의 아이콘으로, 아이픽 운영을 크게 도와주신 분임을 나타냅니다.</td>
                    </tr>
                </tbody>
            </table>

            <div class="notes">
                <p><strong>※ 아이콘 적용 안내</strong></p>
                <ul>
                    <li>아이콘은 아이픽에서 사용하는 <strong>닉네임 기준</strong>으로 적용됩니다.</li>
                    <li>닉네임을 변경하신 경우, 카카오톡으로 이전 요청을 주시면 확인 후 아이콘을 옮겨드립니다.</li>
                    <li>후원 확인 및 아이콘 적용은 수작업으로 처리되므로, 적용까지 다소 시간이 걸릴 수 있습니다.</li>
                    <li>추가 후원을 해주신 경우, <strong>상위 단계 아이콘</strong>으로 업그레이드되거나, 아이콘 유지 기간 연장 형태로 반영될 수 있습니다.</li>
                </ul>
            </div>
        </div>

        <!-- 3. 후원 · 광고 문의 -->
        <div class="sponsorship-section">
            <h2>3. 후원 · 광고 문의</h2>
            <p>
                배너 광고 신청, 개인 후원 확인, 아이콘 적용/변경, 기타 운영 관련 문의는  
                아래 메일로 편하게 연락 주세요.
            </p>
            <p><strong>이메일 :</strong> juho9072@naver.com</p>

            <div class="notes">
                <p>
                    ※ 아이픽 서비스, 후원 및 배너 광고와 직접 관련된 문의에 우선적으로 답변드리며,  
                    그 외 개인적인 질문이나 다른 플랫폼 관련 문의는 응답이 어려울 수 있습니다. 1대1문의를 이용해주세요.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
