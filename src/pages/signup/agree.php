<?php
// ==== CSS 불러오기 ====
$stylePath = __DIR__ . '/agree.css';
$style = file_exists($stylePath) ? '<style>' . file_get_contents($stylePath) . '</style>' : '';
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아이픽 약관 동의</title>
    <?= $style ?>
</head>

<body>
    <div class="container">
        <!-- 단계 표시 프로그래스바 -->
        <div class="progress-wrapper">
            <div class="step active">
                <div class="circle">1</div>
                <div class="label">약관동의</div>
            </div>
            <div class="line"></div>
            <div class="step">
                <div class="circle">2</div>
                <div class="label">회원가입</div>
            </div>
        </div>

        <h2>다음 내용에 동의해주세요</h2>

        <!-- 모두 동의 -->
        <div class="agree-box">
            <label>
                <input type="checkbox" id="agree-all">
                <strong>모두 동의</strong> <span>필수 및 선택 항목 동의 포함</span>
            </label>
        </div>

        <!-- 개별 항목 -->
        <div class="agree-item">
            <label>
                <input type="checkbox" class="agree-checkbox" id="agree-service">
                서비스 이용약관 동의 <span class="required">(필수)</span>
            </label>
            <span class="arrow-0" data-type="service">›</span>
        </div>

        <!-- 모달 팝업 -->
        <div id="popup-modal" class="modal">
            <div class="modal-content">
                <span id="close-popup" class="close">&times;</span>
                <h3>서비스 이용약관</h3>
                <div class="popuptext-container">
                    <textarea class="popup-text" disabled></textarea>
                </div>
            </div>
        </div>

        <div class="agree-item">
            <label>
                <input type="checkbox" class="agree-checkbox" id="agree-privacy">
                개인정보 수집 및 이용 동의 <span class="required">(필수)</span>
            </label>
            <span class="arrow-1" data-type="privacy">›</span>
        </div>

        <!-- form으로 값 전달 -->
        <form id="agree-form" method="POST" action="/signup">
            <div class="agree-item">
                <label>
                    <input type="checkbox" class="agree-checkbox" id="agree-marketing" name="email_agree" value="1">
                    마케팅 정보 수신 동의(이메일)<span class="optional">(선택)</span>
                </label>
                <span class="arrow-2" data-type="marketing">›</span>
            </div>
            <button id="next-btn" type="submit">다음</button>
        </form>
    </div>

    <!-- ==== JS ==== -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const agreeAll = document.getElementById('agree-all');
            const checkboxes = document.querySelectorAll('.agree-checkbox');
            const nextBtn = document.getElementById('next-btn');
            const emailAgreeInput = document.getElementById('email_agree');

            const arrows = document.querySelectorAll('.arrow-0, .arrow-1, .arrow-2');
            const modal = document.getElementById('popup-modal');
            const closeBtn = document.getElementById('close-popup');
            const popupTitle = modal.querySelector('h3');
            const popupText = modal.querySelector('.popup-text');

            // 모두 동의
            agreeAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = agreeAll.checked);
            });

            // 개별 체크
            checkboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    agreeAll.checked = Array.from(checkboxes).every(c => c.checked);
                });
            });

            // 다음 버튼
            nextBtn.addEventListener('click', (e) => {
                const required = Array.from(checkboxes).filter(c => c.parentElement.querySelector('.required'));
                if (!required.every(c => c.checked)) {
                    e.preventDefault();
                    alert('필수 항목에 모두 체크해 주세요.');
                }
            });

            // 팝업
            arrows.forEach(arrow => {
                arrow.addEventListener('click', () => {
                    const type = arrow.dataset.type;
                    if (type === 'service') {
                        popupTitle.textContent = '서비스 이용약관';
                        popupText.value = '본 약관은 이용자가 본 사이트의 서비스를 사용하는 과정에서 필요한 기본적인 이용 규칙을 안내하기 위한 것입니다.\n\n회원가입을 완료하고 서비스를 이용하는 경우,\n이용자는 본 약관의 내용에 동의한 것으로 간주됩니다.';
                    } else if (type === 'privacy') {
                        popupTitle.textContent = '개인정보 수집 및 이용 동의';
                        popupText.value = '회원가입, 본인 확인, 서비스 제공 및 고객 문의 응대를 위해 아래의 개인정보를 수집합니다.\n\n수집 항목: 아이디, 비밀번호, 이메일, 닉네임\n수집 목적: 회원 식별, 서비스 제공 및 고객지원 \n보유 기간: 회원 탈퇴 시까지\n\n이 항목은 서비스 제공을 위해 반드시 필요한 최소한의 정보입니다.';
                    } else if (type === 'marketing') {
                        popupTitle.textContent = '마케팅 정보 수신 동의(이메일)';
                        popupText.value = '서비스 관련 소식, 이벤트, 프로모션 등 마케팅 정보를 이메일로 제공합니다.\n\n본 항목은 선택 사항이므로 거부할 수 있습니다.';
                    }
                    modal.style.display = 'block';
                });
            });

            closeBtn.addEventListener('click', () => { modal.style.display = 'none'; });
            window.addEventListener('click', e => { if (e.target === modal) modal.style.display = 'none'; });
        });
    </script>
</body>

</html>