<?php
// ==== DB 연결 ==== 
include __DIR__ . '/../../shared/api/db_config.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: signin");
    exit;
}

// ==== DB에서 회원정보 불러오기 ====
$stmt = $conn->prepare("SELECT id, email, nickname, email_agree, created_at FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<p>회원 정보를 불러오지 못했습니다.</p>";
    exit;
}

$emailAgree = isset($user['email_agree']) ? (int) $user['email_agree'] : 0;

// ==== CSS 불러오기 ====
$style = '<style>' . file_get_contents(__DIR__ . '/account.css') . '</style>';
//php와 연결하는 코드
$account_script = file_get_contents(__DIR__ . '/account.js');
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $style ?>
</head>

<body>
    <div class="mypage-wrapper">
        <div class="mypage-container">
            <h1>마이페이지</h1>

            <!-- 내 정보 -->
            <section class="user-info">
                <!-- 정보 조회 -->
                <h2>내 정보</h2>
                <div id="view-mode">
                    <p><strong>닉네임:</strong> <?= htmlspecialchars($_SESSION['nickname']) ?></p>
                    <p><strong>이메일:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>가입일:</strong> <?= htmlspecialchars((new DateTime($user['created_at']))->format('Y-m-d')) ?></p>
                    <button id="edit-info" class="edit-btn">정보 수정</button>
                </div>

                <!-- 정보 수정 -->
                <form id="edit-form" style="display:none;">
                    <input type="text" name="nickname" id="nickname_input"
                        value="<?= htmlspecialchars($_SESSION['nickname']) ?>" required>
                    <input type="email" name="email" id="email_input" value="<?= htmlspecialchars($user['email']) ?>"
                        required>
                    <button type="submit" class="save-btn">저장</button>
                    <button type="button" id="cancel-edit" class="cancel-btn">취소</button>
                </form>
            </section>

            <!-- 비밀번호 변경 -->
            <section class="password-section">
                <h2>비밀번호 변경</h2>
                <form id="pw-form">
                    <input type="password" name="current_pw" placeholder="현재 비밀번호" required>
                    <input type="password" name="new_pw" placeholder="새 비밀번호" required>
                    <button type="submit" class="change-btn">비밀번호 변경</button>
                </form>
            </section>

            <!-- 이메일 수신 정보 변경 -->
            <section class="marketing">
                <h2>이메일 수신 동의</h2>
                <label>
                    <input type="checkbox" id="email_agree" <?= $emailAgree ? 'checked' : '' ?>> 이메일 수신에 동의합니다
                </label>
                <span id="status_text" style="margin-left:10px; display:none;">저장되었습니다.</span>
            </section>

            <!-- 버튼 -->
            <div class="actions">
                <button class="inquiry-btn" onclick="location.href='/inquiry'">문의하기</button>
                <button class="signout-btn" onclick="location.href='/signout'">로그아웃</button>
                <button id="withdraw-btn" class="withdraw-btn" type="button">회원 탈퇴</button>
            </div>
        </div>
    </div>
</body>

</html>









<script>
    <?php echo $account_script; // js와 연결하는 코드. js코드는 account.js에 작성할 것 ?>
</script>