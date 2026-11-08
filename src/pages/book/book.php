<?php
// DB 연결 불러오기
include_once __DIR__ . '/../../shared/api/db_config.php';

// 전체 데이터 불러오기
$sql = "SELECT book_id, title, author, publisher, cover_image_url, price, tag, published_date, link_url
        FROM books ORDER BY title";

$stmt = $conn->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

function esc($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

// CSS 불러오기
$style_content = file_get_contents(__DIR__ . '/book.css');
?>


<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>도서 추천</title>
  <style><?= $style_content ?></style>
</head>

<body>
  <h2><span style="color: #007BFF;">추천</span> 도서</h2>

  <!-- ✅ 검색창 & 태그 필터 영역 -->
  <div class="filter-container">
    <input type="text" id="search" placeholder="원하시는 도서를 입력해주세요.">
    <div id="tag-buttons">
      <button data-tag="">전체</button>
      <button data-tag="LLM">LLM</button>
      <button data-tag="Vibe Coding">Vibe Coding</button>
      <button data-tag="ChatGPT">ChatGPT</button>
      <button data-tag="Gemini">Gemini</button>
      <button data-tag="Claude">Claude</button>
    </div>
  </div>

  <div class="sort-bar">
    <div class="notice-text">*책 선택 시 교보문고 구매 사이트로 이동합니다</div>
    <div class="sort-box">
      <select id="sort-select">
        <option value="">정렬 없음</option>
        <option value="price-desc">가격 높은 순</option>
        <option value="price-asc">가격 낮은 순</option>
        <option value="date-desc">출판일 최신 순</option>
      </select>
    </div>
  </div>

  <!-- ✅ 카드 목록 -->
  <div class="book-container">
    <?php if (count($books) > 0): ?>
      <?php foreach ($books as $book): ?>
        <div class="book-card"
              data-title="<?= esc(strtolower($book['title'])) ?>"
              data-tags="<?= esc(strtolower($book['tag'])) ?>"
              data-price="<?= (int)$book['price'] ?>"
              data-date="<?= esc($book['published_date']) ?>">

          <?php if (!empty($book['cover_image_url'])): ?>
            <div class="thumbnail-container">
              <img
                src="<?= esc($book['cover_image_url']) ?>"
                alt="<?= esc($book['title']) ?> 표지"
                class="book-thumbnail"
                loading="lazy"
                onerror="this.style.display='none'">
            </div>
          <?php endif; ?>

          <div class="book-content">
            <h3 class="book-title"><?= esc($book['title']) ?></h3>
            <p class="book-meta">저자: <?= esc($book['author']) ?></p>
            <p class="book-meta">출판사: <?= esc($book['publisher']) ?></p>
            <p class="book-meta">카테고리: <?= esc($book['tag']) ?></p>
            <p class="book-price"><?= number_format((int)$book['price']) ?>원</p>

            <!-- ✅ 구매 버튼 추가 -->
            <div class="button-container">
              <a href="<?= esc($book['link_url']) ?>" 
                  target="_blank" 
                  class="buy-button">구매하기</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>등록된 도서가 없습니다.</p>
    <?php endif; ?>
  </div>

    <!-- ✅ 검색/정렬/태그 JS 그대로 유지 -->
    <script>
      const searchInput = document.getElementById('search');
      const buttons = document.querySelectorAll('#tag-buttons button');
      const books = document.querySelectorAll('.book-card');
      const sortSelect = document.getElementById('sort-select');
      const bookContainer = document.querySelector('.book-container');

      function filterBooks() {
        const keyword = searchInput.value.toLowerCase().trim();
        const tagFilter = document.querySelector('#tag-buttons button.active')?.dataset.tag.toLowerCase() || '';

        books.forEach(book => {
          const title = book.dataset.title || '';
          const tags = book.dataset.tags || '';

          const matchTitle = title.includes(keyword);
          const matchTag = tagFilter ? tags.includes(tagFilter) : true;

          book.style.display = (matchTitle && matchTag) ? '' : 'none';
        });
      }

      // 검색 필터
      searchInput.addEventListener('input', filterBooks);

      // 태그 버튼 필터
      buttons.forEach(btn => {
        btn.addEventListener('click', () => {
          buttons.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          filterBooks();
        });
      });

      // 정렬 기능
      function sortBooks(criteria) {
        const bookCards = Array.from(document.querySelectorAll('.book-card'));
        let sorted = [...bookCards];

        if (criteria === 'price-asc') {
          sorted.sort((a, b) => (parseInt(a.dataset.price) || 0) - (parseInt(b.dataset.price) || 0));
        }

        if (criteria === 'price-desc') {
          sorted.sort((a, b) => (parseInt(b.dataset.price) || 0) - (parseInt(a.dataset.price) || 0));
        }

        if (criteria === 'date-desc') {
          sorted.sort((a, b) => {
            const dateA = new Date(a.dataset.date || '1900-01-01');
            const dateB = new Date(b.dataset.date || '1900-01-01');
            return dateB - dateA;
          });
        }

        bookContainer.innerHTML = '';
        sorted.forEach(card => bookContainer.appendChild(card));
      }

      sortSelect.addEventListener('change', () => {
        sortBooks(sortSelect.value);
      });
    </script>
  
</body>
</html>

<?php $conn = null; ?>
