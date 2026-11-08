<!--<?php/*
$style = '<style>' . file_get_contents(__DIR__ . '/admin.css') . '</style>';
$current_uri = $_SERVER['REQUEST_URI'];
// 가상의 주간 방문자 데이터 (실제 DB에서 가져와야 함)
$weekly_visitors_data = [
    'labels' => ['월', '화', '수', '목', '금', '토', '일'], // 요일 레이블
    'data' => [1250, 1500, 1400, 1800, 2200, 2500, 1900] // 각 요일의 방문자 수
];
// 이 데이터를 JavaScript에서 사용할 수 있도록 JSON으로 인코딩합니다.
$visitors_json = json_encode($weekly_visitors_data);
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 페이지 - 대시보드</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        <?php echo $style; ?>
    </style>
</head>
<body>
    <div class="container">
        <?php require_once 'dashbord.php'; ?>

        <main class="main-content">

            <section class="stats-cards">
                <div class="card stat-card">
                    <div class="icon-box blue"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <p class="title">총 사용자</p>
                        <p class="value">4명</p>
                    </div>
                    
                </div>
                <div class="card stat-card">
                    <div class="icon-box red"><i class="fa-solid fa-exclamation"></i></div>
                    <div class="stat-info">
                        <p class="title">미답변 문의</p>
                        <p class="value">4개</p>
                    </div>
                </div>
                <div class="card stat-card">
                    <div class="icon-box blue"><i class="fa-solid fa-robot"></i></div>
                    <div class="stat-info">
                        <p class="title">AI</p>
                        <p class="value">32개</p>
                    </div>
                </div>
            </section>

            <section class="chart-section">
                <div class="card chart-box">
                    <h3>주간 방문자</h3>
                    <div class="chart-placeholder">
                        <canvas id="weeklyVisitorsChart"></canvas>
                                            </div>
                </div>
            </section>

            <section class="recent-orders">
                <h3>최근 변경 이력</h3>
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>이름</th>
                                <th>변경 전</th>
                                <th>변경 후</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>15</td>
                                <td>suno AI</td>
                                <td>22.00</td>
                                <td>24.00</td>
                                
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>chatGPT</td>
                                <td>텍스트 / 이미지 / 지식 답변 멀티모달 AI</td>
                                <td>텍스트 / 이미지 / 코딩 / 지식 답변 멀티모달 AI</td>
                                
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Perplexity</td>
                                <td>18.00</td>
                                <td>20.00</td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    <script>
        // PHP에서 JSON으로 인코딩된 데이터를 JavaScript 변수로 가져옵니다.
        const visitorsData = <?php echo $visitors_json; ?>;

        // 차트를 그릴 canvas 요소를 가져옵니다.
        const ctx = document.getElementById('weeklyVisitorsChart');

        // Chart.js를 사용하여 꺾은선(line) 그래프를 생성합니다.
        new Chart(ctx, {
            type: 'line', // 그래프 유형: 꺾은선 그래프
            data: {
                labels: visitorsData.labels, // 요일 레이블: 월, 화, 수, 목, 금, 토, 일
                datasets: [{
                    label: '주간 방문자 수',
                    data: visitorsData.data, // 방문자 수 데이터
                    borderColor: '#007bff', // 선 색상
                    backgroundColor: 'rgba(0, 123, 255, 0.1)', // 영역 배경 색상
                    fill: true, // 영역 채우기
                    tension: 0.3 // 선의 부드러움 (0.0은 직선)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // 컨테이너 크기에 맞게 크기 조절
                scales: {
                    y: {
                        beginAtZero: true, // y축 0부터 시작
                        title: {
                            display: true,
                            text: '방문자 수'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: '요일'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // 범례 숨기기
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });
    </script>
</body>
</html>
