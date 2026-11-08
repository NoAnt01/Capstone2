// --- 요소 선택 ---
const banners = document.querySelectorAll('.ad-banner .banner-link');
const paginationContainer = document.querySelector('.banner-pagination');

// --- 필수 요소가 없으면 스크립트 중단 ---
if (banners.length === 0 || !paginationContainer) {
    console.error("배너 또는 페이지네이션 컨테이너를 찾을 수 없습니다.");
} else {
    let currentBannerIndex = 0;
    let bannerInterval;

    // 배너가 1개일 경우 점만 표시하고 기능 중단
    if (banners.length <= 1) {
        const dot = document.createElement('button');
        dot.classList.add('dot', 'active');
        paginationContainer.appendChild(dot);
    } else {
        // --- 1. 페이지네이션 점(dot) 생성 ---
        banners.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.classList.add('dot');
            dot.dataset.index = index;
            if (index === 0) dot.classList.add('active');
            paginationContainer.appendChild(dot);
        });

        const dots = document.querySelectorAll('.banner-pagination .dot');

        // --- 2. 특정 배너로 이동하는 함수 ---
        function goToBanner(index) {
            banners[currentBannerIndex].classList.remove('active');
            dots[currentBannerIndex].classList.remove('active');
            currentBannerIndex = index;
            banners[currentBannerIndex].classList.add('active');
            dots[currentBannerIndex].classList.add('active');
        }

        // --- 3. 배너 자동 전환 시작 함수 ---
        function startBannerRotation() {
            clearInterval(bannerInterval);
            bannerInterval = setInterval(() => {
                const nextIndex = (currentBannerIndex + 1) % banners.length;
                goToBanner(nextIndex);
            }, 5000); // 5초로 시간 변경된 상태
        }

        // --- 4. 페이지네이션 점 클릭 이벤트 ---
        paginationContainer.addEventListener('click', (e) => {
            if (e.target.matches('.dot')) {
                const index = parseInt(e.target.dataset.index);
                if (index !== currentBannerIndex) {
                    goToBanner(index);
                    startBannerRotation();
                }
            }
        });

        // --- 최초 자동 전환 시작 ---
        startBannerRotation();
    }
}