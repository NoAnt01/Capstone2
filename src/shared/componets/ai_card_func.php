<?php
?>
<script>
const CURRENT_USER_ID = <?= json_encode($current_user_id ?? 0) ?>; 

//조회수 증가 함수
function incrementView(aiId) {
    $.ajax({
        url: '/api/view_inc.php',
        type: 'POST', 
        data: { id: aiId },
        success: function(response) {
            console.log("View incremented successfully for AI ID: " + aiId); 
        },
        error: function(xhr, status, error) {
            console.error("Error incrementing view for AI ID: " + aiId, error);
        }
    });
}

function toggleLike(event, aiId, buttonElement) {
    event.preventDefault(); 
    
    if (!CURRENT_USER_ID) { 
        alert("로그인 후 좋아요를 누를 수 있습니다.");
        return;
    }

    const isCurrentlyLiked = $(buttonElement).hasClass('liked'); 
    let currentCount = parseInt($('#like-count-' + aiId).text().replace(/,/g, '')) || 0;
    let newOptimisticCount = isCurrentlyLiked ? currentCount - 1 : currentCount + 1;

    $(buttonElement).toggleClass('liked');
    $(buttonElement).find('.heart-icon').text(isCurrentlyLiked ? '🤍' : '❤️');
    $('#like-count-' + aiId).text(newOptimisticCount.toLocaleString());

    $.ajax({
        url: '/api/like_handler.php', 
        type: 'POST',
        data: { 
            ai_id: aiId,
            user_id: CURRENT_USER_ID 
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#like-count-' + aiId).text(response.new_count.toLocaleString());
            } else {
                $(buttonElement).toggleClass('liked');
                $(buttonElement).find('.heart-icon').text(isCurrentlyLiked ? '❤️' : '🤍');
                $('#like-count-' + aiId).text(currentCount.toLocaleString());
                
                alert('좋아요 처리 중 오류가 발생했습니다: ' + (response.message || 'DB 오류'));
            }
        },
        error: function(xhr, status, error) {
            $(buttonElement).toggleClass('liked');
            $(buttonElement).find('.heart-icon').text(isCurrentlyLiked ? '❤️' : '🤍');
            $('#like-count-' + aiId).text(currentCount.toLocaleString()); 
            
            alert('서버와 통신 중 오류가 발생했습니다.'); 
            console.error("AJAX Error:", status, error);
        }
    });
}
</script>