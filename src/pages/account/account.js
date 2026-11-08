window.addEventListener("load", function () {
  // ===== 이메일 수신 동의 =====
  const emailAgreeCheckbox = document.getElementById("email_agree");
  const statusText = document.getElementById("status_text");

  if (emailAgreeCheckbox && statusText) {
    emailAgreeCheckbox.addEventListener("change", function () {
      const email_agree = emailAgreeCheckbox.checked ? 1 : 0;

      fetch("/update_email_agree", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "email_agree=" + encodeURIComponent(email_agree),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            statusText.textContent = "저장되었습니다.";
            statusText.style.color = "green";
          } else {
            statusText.textContent = "에러 발생";
            statusText.style.color = "red";
          }
          statusText.style.display = "inline";
          setTimeout(() => (statusText.style.display = "none"), 2000);
        })
        .catch((err) => {
          console.error("Fetch 오류:", err);
          statusText.textContent = "에러 발생";
          statusText.style.color = "red";
          statusText.style.display = "inline";
          setTimeout(() => (statusText.style.display = "none"), 2000);
        });
    });
  }

  // ===== 회원 정보 수정 =====
  const editBtn = document.getElementById("edit-info");
  const editForm = document.getElementById("edit-form");
  const viewMode = document.getElementById("view-mode");
  const cancelEdit = document.getElementById("cancel-edit");

  if (editBtn && editForm) {
    editBtn.addEventListener("click", () => {
      viewMode.style.display = "none";
      editForm.style.display = "block";
    });

    cancelEdit.addEventListener("click", () => {
      editForm.style.display = "none";
      viewMode.style.display = "block";
    });

    editForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const formData = new FormData(editForm);
      const nickname = formData.get("nickname").trim();
      const email = formData.get("email").trim();

      // 닉네임 형식 체크 (특수문자 제외, 최대 10자)
      const nickRegex = /^[a-zA-Z0-9가-힣]{1,10}$/;
      if (!nickRegex.test(nickname)) {
        alert("닉네임은 특수문자 없이 최대 10자까지 가능합니다.");
        return;
      }

      // 이메일 형식 체크
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        alert("올바른 이메일 주소를 입력해주세요.");
        return;
      }

      // AJAX 요청
      fetch("/update_userinfo", {
        method: "POST",
        body: new URLSearchParams(formData),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            alert("정보가 수정되었습니다!");
            location.reload();
          } else {
            alert("수정 실패: " + (data.message || "알 수 없는 오류"));
          }
        })
        .catch((err) => {
          console.error("오류 발생:", err);
          alert("요청 중 오류가 발생했습니다.");
        });
    });
  }

  // ===== 비밀번호 변경 =====
  const pwForm = document.getElementById("pw-form");

  if (pwForm) {
    pwForm.addEventListener("submit", (e) => {
      e.preventDefault(); // 기본 제출 막기

      const formData = new FormData(pwForm);
      const currentPw = formData.get("current_pw");
      const newPw = formData.get("new_pw");

      // 새 비밀번호 유효성 검사
      const pwRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*]).{10,16}$/;
      if (!pwRegex.test(newPw)) {
        alert("비밀번호는 영문/숫자/특수문자 조합으로 10~16자여야 합니다.");
        return;
      }

      // AJAX 요청
      fetch("/update_password", {
        method: "POST",
        body: new URLSearchParams(formData),
      })
        .then((res) => res.json())
        .then((data) => {
          alert(data.message); // [변경] 메시지를 alert로 표시
          if (data.success) pwForm.reset(); // 성공하면 폼 초기화
        })
        .catch((err) => {
          console.error(err);
          alert("요청 중 오류가 발생했습니다.");
        });
    });
  }

  // ===== 회원 탈퇴 =====
  const withdrawBtn = document.getElementById("withdraw-btn");

  if (withdrawBtn) {
    withdrawBtn.addEventListener("click", (e) => {
      e.preventDefault(); // 폼 제출 방지
      if (
        !confirm("정말 회원 탈퇴하시겠습니까?\n탈퇴하면 복구할 수 없습니다.")
      ) {
        return; // 취소 시
      }

      // AJAX 요청
      fetch("/withdraw", {
        method: "POST",
      })
        .then((res) => res.json())
        .then((data) => {
          alert(data.message);
          if (data.success) {
            // 탈퇴 성공하면 로그아웃 후 메인페이지 이동
            location.href = "/";
          }
        })
        .catch((err) => {
          console.error(err);
          alert("요청 중 오류가 발생했습니다.");
        });
    });
  }
});
