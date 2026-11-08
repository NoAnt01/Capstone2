<?php
// DB 연결
include __DIR__ . '/../../shared/api/db_config.php';
// CSS 로드 (파일 경로: admin.css, managements.css)
$style1 = @file_get_contents(__DIR__ . '/admin.css');
$style2 = @file_get_contents(__DIR__ . '/managements.css');
// file_get_contents 실패 시 경고를 숨기고 빈 문자열로 처리 (@ 사용)
$style = '<style>' . $style1 . $style2 . '</style>';

$userquery="
SELECT * FROM users order by id asc";
$stmt = $conn->prepare($userquery);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 사용자 통계 계산
$total_users = count($users); 
$admin_count = 0;
$email_agreed_count = 0;

foreach ($users as $user) {
    if ($user['role'] === 'admin') {
        $admin_count++;
    }
    // email_agree가 1이거나 'true'와 같은 긍정 값일 경우 카운트
    if ($user['email_agree'] == 1 || $user['email_agree'] === 'Y') {
        $email_agreed_count++;
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>사용자 관리 페이지</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        <?php echo $style; ?>
    </style>
</head>
<body>
    <div class="container">
        <?php require_once 'dashbord.php'; ?>

        <main class="main-content">
            
            <div class="header-section">
                <h2>사용자 관리</h2>
            </div>

            <section class="stats-cards">
                <div class="card stat-card">
                    <div class="icon-box blue"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <p class="title">전체 사용자</p>
                        <p class="value"><?php echo number_format($total_users); ?>명</p>
                    </div>
                </div>
                <div class="card stat-card">
                    <div class="icon-box red"><i class="fa-solid fa-screwdriver-wrench"></i></i></div>
                    <div class="stat-info">
                        <p class="title">관리자</p>
                        <p class="value"><?php echo number_format($admin_count); ?>명</p>
                    </div>
                </div>
                <div class="card stat-card">
                    <div class="icon-box green"><i class="fa-regular fa-envelope"></i></div>
                    <div class="stat-info">
                        <p class="title">메일 동의</p>
                        <p class="value"><?php echo number_format($email_agreed_count); ?>개</p>
                    </div>
                </div>
            </section>


            <section class="ai-list-management">
                <div class="list-header">
                    <h3>사용자 목록</h3>
                    
                </div>
                <div class="filter-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="search-input" placeholder="사용자 ID, 닉네임, Email 검색...">
                    </div>
                </div> 
                <div class="card table-card">
                    <table>
                        <thead>
                            <tr>
                                <th class="col-id">고유번호</th>
                                <th class="col-userid">ID</th>
                                <th class="col-password">비밀번호</th> <th class="col-email">Email</th>
                                <th class="col-name">닉네임</th>
                                <th class="col-role">권한</th> 
                                <th class="col-created">생성일</th>
                                <th class="col-agree">메일동의</th>
                                <th class="col-actions">작업</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($users as $user): 
                            ?>
                            <tr data-id="<?php echo $user['id']; ?>" 
                                data-userid="<?php echo htmlspecialchars($user['user_id']); ?>"
                                data-email="<?php echo htmlspecialchars($user['email']); ?>"
                                data-nickname="<?php echo htmlspecialchars($user['nickname']); ?>"
                                data-role="<?php echo htmlspecialchars($user['role']); ?>"
                                data-agree="<?php echo $user['email_agree']; ?>"> 
                                <td class="col-id"><?php echo htmlspecialchars($user['id']); ?></td>
                                <td class="col-userid"><?php echo htmlspecialchars($user['user_id']); ?></td>
                                <td class="col-password">********</td> <td class="col-email"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="col-name"><?php echo htmlspecialchars($user['nickname']); ?></td>
                                <td class="col-role">
                                    <span class="user-state-tag tag-<?php echo str_replace(' ', '-', strtolower($user['role'])); ?>">
                                        <?php echo htmlspecialchars($user['role']); ?>
                                    </span>
                                </td>
                                <td class="col-created"><?php echo htmlspecialchars($user['created_at']); ?></td>
                                <td class="col-agree"><?php echo $user['email_agree'] == 1 ? 'Y' : 'N'; ?></td>
                                <td class="col-actions action-icons">
                                    
                                    <i class="fas fa-edit edit-icon action-edit-modal" title="수정" data-id="<?php echo $user['id']; ?>"></i>
                                    
                                    <form method="POST" action="/user_delete" style="display:inline;" 
                                            onsubmit="return confirm('정말로 사용자 <?php echo htmlspecialchars($user['user_id']); ?> 님을 삭제하시겠습니까?');">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="action-delete-btn" title="삭제">
                                            <i class="fas fa-trash-alt delete-icon"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div id="userEditModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>

        <h2 id="modalHeaderTitle"></h2>

        <form id="userEditForm">
            <div class="form-group">
                <label for="read-only-user_id" class="modal-label">사용자 ID</label>
                <input type="text" id="read-only-user_id" name="user_id" class="modal-input read-only-input" readonly>
            </div>

            <input type="hidden" name="id" id="edit-id">
            <input type="hidden" name="email_agree" id="hidden-email_agree" value="0"> 

            <div class="form-group">
                <label for="edit-email" class="modal-label">이메일</label>
                <input type="email" name="email" id="edit-email" class="modal-input" required>
            </div>

            <div class="form-group">
                <label for="edit-nickname" class="modal-label">닉네임</label>
                <input type="text" name="nickname" id="edit-nickname" class="modal-input" required>
            </div>

            <div class="form-group">
                <label for="edit-role" class="modal-label">권한</label>
                <select name="role" id="edit-role" class="modal-select" required>
                    <option value="user">일반 사용자</option>
                    <option value="admin">관리자</option>
                </select>
            </div>
            
            <div class="form-group form-group-checkbox">
                <label class="checkbox-label">
                    <input type="checkbox" id="edit-email_agree" value="1" disabled>
                    메일 수신 동의
                </label>
            </div>

            <div class="modal-button-group">
                <button type="submit" class="action-btn primary save-button">저장</button>
            </div>
        </form>
    </div>
</div>
    

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('.table-card tbody');
    const modal = document.getElementById('userEditModal');
    const form = document.getElementById('userEditForm');
    const closeModalButtons = modal.querySelectorAll('.close, .close-modal');
    const searchInput = document.getElementById('search-input');
    const userRows = tableBody.querySelectorAll('tr');

    // 모달 내 필드 참조
    const editEmailAgreeCheckbox = document.getElementById('edit-email_agree');
    const hiddenEmailAgreeInput = document.getElementById('hidden-email_agree');

    // 1. 모달 닫기 이벤트
    closeModalButtons.forEach(btn => {
        btn.onclick = () => modal.style.display = "none";
    });

    window.onclick = (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    };

    // 2. 수정 아이콘 클릭 시 모달 열기 및 데이터 채우기
    tableBody.addEventListener('click', function(e) {
        const editIcon = e.target.closest('.action-edit-modal');
        
        if (editIcon) {
            const row = editIcon.closest('tr');
            const data = row.dataset; 

            // 폼 필드에 데이터 채우기
            document.getElementById('modalHeaderTitle').textContent = `${data.nickname}님의 정보 수정`;
            
            // 읽기 전용 필드 (보여주기용 ID)
            document.getElementById('read-only-user_id').value = data.userid;
            
            // 숨겨진 필드 (실제 전송용 PK)
            document.getElementById('edit-id').value = data.id;

            document.getElementById('edit-email').value = data.email;
            document.getElementById('edit-nickname').value = data.nickname;
            document.getElementById('edit-role').value = data.role;

            // 체크박스 처리 (disabled 상태를 반영)
            const isAgreed = (data.agree === '1');
            editEmailAgreeCheckbox.checked = isAgreed;
            
            // **[수정]** disabled된 체크박스의 상태를 숨겨진 필드에 복사합니다.
            hiddenEmailAgreeInput.value = isAgreed ? '1' : '0';
            
            modal.style.display = "block";
        }
    });

    // 3. 폼 제출 (AJAX 통신)
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // 기본 폼 제출 방지

        const formData = new FormData(form);
        
        // disabled된 필드는 FormData에 포함되지 않으므로, hidden 필드를 통해 상태를 전송합니다.
        // hiddenEmailAgreeInput.value는 이미 클릭 이벤트에서 설정되었습니다.

        fetch('/user_edit_process', { 
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('정보가 성공적으로 수정되었습니다.');
                modal.style.display = "none";
                window.location.reload(); // 성공 시 페이지 새로고침
            } else {
                alert('수정 실패: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('통신 오류가 발생했습니다.');
        });
    });
    function filterUsers() {
        const searchText = searchInput.value.toLowerCase(); // 검색어 (소문자로 변환)

        userRows.forEach(row => {
            // data-userid, data-email, data-nickname 속성 값을 가져옴
            const userId = row.dataset.userid ? row.dataset.userid.toLowerCase() : '';
            const email = row.dataset.email ? row.dataset.email.toLowerCase() : '';
            const nickname = row.dataset.nickname ? row.dataset.nickname.toLowerCase() : '';

            // 검색어가 ID, 이메일, 닉네임 중 하나라도 포함되어 있으면 true
            const isMatch = userId.includes(searchText) || 
                                email.includes(searchText) || 
                                nickname.includes(searchText);

            // 검색 결과에 따라 행 표시/숨김
            row.style.display = isMatch ? '' : 'none';
        });
    }
    if (searchInput) {
        searchInput.addEventListener('keyup', filterUsers); // 키를 뗄 때마다 필터링 실행
        searchInput.addEventListener('change', filterUsers); // 값 변경 시 필터링 실행
    }
});
</script>
</body>
</html>