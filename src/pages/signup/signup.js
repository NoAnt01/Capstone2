document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.signup-form');
    const userId = document.querySelector('.user_id-input');
    const pw = document.querySelector('.password-input');
    const pwChk = document.querySelector('.chkpw-input');
    const chkBtn = document.querySelector('.chkpw-btn');
    const pwStatus = document.getElementById('pw-status');
    const email = document.querySelector('.email-input');
    const nickname = document.querySelector('.nickname-input');
    const clearBtn = document.querySelector('.clear-btn');

    // 비밀번호 확인 버튼 클릭 시
    // 두 비밀번호 입력칸이 비어있지 않은지 확인 후 메시지 표시
    chkBtn.addEventListener('click', () => {
        pwStatus.classList.remove('success', 'error');

        if (!pw.value || !pwChk.value) {
            pwStatus.textContent = '비밀번호를 모두 입력해주세요.';
            pwStatus.className = 'error';
            return;
        }
        if (pw.value === pwChk.value) {
            pwStatus.textContent = '비밀번호가 일치합니다.';
            pwStatus.className = 'success';
        } else {
            pwStatus.textContent = '비밀번호가 일치하지 않습니다.';
            pwStatus.className = 'error';
        }
    });

    // 폼 제출 전 모든 입력값 유효성 검사
    form.addEventListener('submit', (e) => {

        // 아이디 형식 검사
        // 영문 대소문자 + 숫자, 길이: 4~16자
        const idRegex = /^[a-zA-Z0-9]{4,16}$/;
        if (!idRegex.test(userId.value)) {
            alert('아이디는 영문과 숫자 조합의 4~16자여야 합니다.');
            e.preventDefault();
            return;
        }

        // 비밀번호 형식 검사
        // 최소 한 개의 영문, 숫자, 특수문자 포함 필수, 길이: 10~16자
        const pwRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*]).{10,16}$/;
        if (!pwRegex.test(pw.value)) {
            alert('비밀번호는 영문/숫자/특수문자 조합으로 10~16자여야 합니다.');
            e.preventDefault();
            return;
        }

        // 비밀번호 일치 여부 확인
        if (pw.value !== pwChk.value) {
            alert('비밀번호가 일치하지 않습니다.');
            e.preventDefault();
            return;
        }

        // 이메일 유효성 검사
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            alert('올바른 이메일 주소를 입력해주세요.');
            e.preventDefault();
            return;
        }

        // 닉네임 형식 검사
        // 허용 문자 - 한글, 영문, 숫자, 길이: 1~10자, 특수문자 사용 불가
        const nickRegex = /^[a-zA-Z0-9가-힣]{1,10}$/;
        if (!nickRegex.test(nickname.value)) {
            alert('닉네임은 특수문자 없이 최대 10자까지 가능합니다.');
            e.preventDefault();
            return;
        }
    });

    // 다시 입력 버튼 클릭 시 입력칸 모두 초기화, 비밀번호 상태 메시지 제거
    clearBtn.addEventListener('click', () => {
        form.reset();
        pwStatus.textContent = '';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});