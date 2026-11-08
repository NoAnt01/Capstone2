document.addEventListener("DOMContentLoaded", function () {
  const cards = document.querySelectorAll(".stat-card");
  const rows = document.querySelectorAll(".table-card tbody tr");
  const modal = document.getElementById("replyModal");
  const modalTitle = document.getElementById("modalTitle");
  const modalContent = document.getElementById("modalContent");
  const replyText = document.getElementById("replyText");
  const saveBtn = document.getElementById("saveReply");
  const closeBtn = modal.querySelector(".close");

  // 상단 카드 클릭 필터
  cards.forEach((card) => {
    card.addEventListener("click", () => {
      const filter = card.getAttribute("data-filter");

      rows.forEach((row) => {
        const isAnswered = row.classList.contains("answered");

        if (filter === "all") row.style.display = "";
        else if (filter === "unanswered")
          row.style.display = isAnswered ? "none" : "";
        else if (filter === "answered")
          row.style.display = isAnswered ? "" : "none";
      });

      // 선택된 카드 강조
      cards.forEach((c) => c.classList.remove("active-filter"));
      card.classList.add("active-filter");
    });
  });

  // edit-icon 클릭 이벤트
  document.querySelectorAll(".edit-icon").forEach((btn) => {
    btn.addEventListener("click", function () {
      const row = btn.closest("tr");
      const userId = row.querySelector(".col-user .ellipsis").innerText; // user_id
      const id = row.querySelector(".col-id").innerText;
      const title = row.querySelector(".col-title").innerText;
      const content = row.querySelector(".col-content").innerText;
      const currentReply = row.querySelector(".col-reply").innerText || "";

      document.getElementById("replyModalUser").innerText = `${userId}님의 문의 내용`;

      // 모달 내용 세팅
      modalTitle.innerText = title;
      modalContent.innerText = content;
      replyText.value = currentReply;

      // 모달 열기
      modal.style.display = "flex";

      // 저장 버튼 클릭 이벤트
      saveBtn.onclick = function () {
        const reply = replyText.value.trim();
        if (!reply) return alert("답변 내용을 입력해주세요.");

        fetch("/inquiry_reply", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `id=${id}&reply=${encodeURIComponent(reply)}`,
        })
          .then((res) => res.json())
          .then((data) => {
            alert(data.message);
            if (data.success) location.reload();
          });
      };
    });
  });

  // delete-icon 클릭 이벤트
  document.querySelectorAll(".delete-icon").forEach((btn, index) => {
    btn.addEventListener("click", function () {
      const row = btn.closest("tr");
      const id = row.querySelector(".col-id").textContent.trim();

      if (!confirm(`정말로 ${id}번 문의를 삭제하시겠습니까?
삭제 후 복구가 불가능합니다.`)) return;

      // AJAX 요청 (fetch)
      fetch("/inquiry_delete", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + encodeURIComponent(id)
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert("삭제가 완료되었습니다.");
            row.remove();
          } else {
            alert(data.message || "삭제 중 오류가 발생했습니다.");
          }
        });

    });
  });


  // 읽기 전용 모달
  document.querySelectorAll(".ellipsis-long").forEach((span) => {
    span.addEventListener("click", function (e) {
      e.stopPropagation();

      const row = span.closest("tr");
      const userId = row.querySelector(".col-user .ellipsis").innerText; // user_id
      const title = row.querySelector(".col-title span").dataset.fulltext;
      const content = row.querySelector(".col-content span").dataset.fulltext;
      const reply = row.querySelector(".col-reply span").dataset.fulltext || "";

      // "닉네임님의 문의" 표시
      document.getElementById("viewModalUser").innerText = `${userId}님의 문의`;

      document.getElementById("viewModalTitle").innerText = title;
      document.getElementById("viewModalContent").innerHTML = content.replace(
        /\n/g,
        "<br>"
      );
      document.getElementById("viewModalReply").innerHTML = reply.replace(
        /\n/g,
        "<br>"
      );

      const modal = document.getElementById("viewModal");
      modal.style.display = "flex";

      modal.querySelector(".close").onclick = function () {
        modal.style.display = "none";
      };
      modal.onclick = function (e) {
        if (e.target === modal) modal.style.display = "none";
      };
    });
  });

  // 닫기 버튼
  closeBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // 모달 배경 클릭 시 닫기
  window.addEventListener("click", function (e) {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });
});
