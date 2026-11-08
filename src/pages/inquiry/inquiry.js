document.addEventListener("DOMContentLoaded", () => {
    const items = document.querySelectorAll(".inquiry-item .question");

    items.forEach(item => {
        item.addEventListener("click", () => {
            const answer = item.parentElement.querySelector(".answer");
            if (answer) {
                answer.classList.toggle("hidden");
            }
        });
    });


    // 새 문의 작성 AJAX 처리
    const form = document.querySelector(".write-form");
    form.addEventListener("submit", e => {
        e.preventDefault(); // 기본 폼 제출 막기
        const formData = new FormData(form);

        fetch("/inquiry_write", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("문의가 작성되었습니다.");
                form.reset();
                location.reload();
            } else {
                alert("문의 작성 실패: " + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert("문의 작성 중 오류가 발생했습니다.");
        });
    });

    // 문의 삭제
    const deleteButtons = document.querySelectorAll(".delete-btn");
    deleteButtons.forEach(btn => {
        btn.addEventListener("click", e => {
            e.stopPropagation(); // 부모 클릭 이벤트 방지
            const id = btn.getAttribute("data-id");

            if (confirm("이 문의를 삭제하시겠습니까?")) {
                fetch("/inquiry_delete", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id=${encodeURIComponent(id)}`
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            btn.closest(".inquiry-item").remove();
                            alert("문의가 삭제되었습니다.");
                        } else {
                            alert("삭제 실패: " + data.message);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("삭제 중 오류가 발생했습니다.");
                    });
            }
        });
    })
});
