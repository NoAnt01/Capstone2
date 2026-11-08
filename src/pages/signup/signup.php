<?php
// ==== CSS 불러오기 ====
$style = '<style>' . file_get_contents(__DIR__ . '/signup.css') . '</style>';
//php와 연결하는 코드
$signup_script = file_get_contents(__DIR__ . '/signup.js');
$email_agree = $_POST['email_agree'] ?? 0;
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아이픽 회원가입</title>
    <?= $style ?>
</head>

<body>
    <div class="container">
        <!-- 단계 표시 프로그래스바 -->
        <div class="progress-wrapper">
            <div class="step">
                <div class="circle">1</div>
                <div class="label">약관동의</div>
            </div>
            <div class="line active"></div>
            <div class="step active">
                <div class="circle">2</div>
                <div class="label">회원가입</div>
            </div>
        </div>

        <h2>기본정보입력</h2>

        <!-- 입력 폼 -->
        <form class="signup-form" method="POST" action="/signup_process">
            <input type="hidden" name="email_agree" value="<?= isset($_POST['email_agree']) && $_POST['email_agree'] == 1 ? 1 : 0 ?>">
            <div class="input-container">

                <div class="user_id-container">
                    <b>사용자 아이디</b>
                    <input class="user_id-input" name="user_id" type="text" placeholder="아이디" maxlength="16" required>
                    <small>아이디는 <strong>최대 영문 16자</strong>로 입력해주세요.</small>
                </div>

                <div class="password-container">
                    <b>비밀번호</b>
                    <input class="password-input" name="password" type="password" placeholder="비밀번호" maxlength="16" required>
                    <small><strong>영문/숫자/특수문자 조합</strong>하여 <strong>10~16자</strong>로 입력해주세요.</small>
                </div>

                <div class="chkpw-container">
                    <b>비밀번호 확인</b>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <input class="chkpw-input" name="password_chk" type="password" placeholder="비밀번호 확인" maxlength="16" required>
                        <button type="button" class="chkpw-btn">확인</button>
                    </div>
                    <small id="pw-status">비밀번호를 다시 한번 입력해주세요.</small>
                </div>

                <div class="email-container">
                    <b>이메일</b>
                    <input class="email-input" name="email" type="email" placeholder="이메일 주소를 입력하세요" maxlength="40" required>
                    <small>이메일 형식으로 입력해주세요.</small>
                </div>

                <div class="nickname-container">
                    <b>닉네임</b>
                    <input class="nickname-input" name="nickname" type="text" placeholder="닉네임" maxlength="10" required>
                    <small>닉네임은 <strong>최대 10자로 입력</strong>해주세요. <strong>특수문자 제외</strong></small>
                </div>

            </div>

            <div class="btn-container">
                <button type="submit" class="next-btn">회원가입</button>
                <button type="button" class="clear-btn">다시 입력</button>
            </div>
        </form>

    </div>
</body>

</html>










<script>
    <?php echo $signup_script; // js와 연결하는 코드. js코드는 signup.js에 작성할 것 ?>
</script>