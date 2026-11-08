// --- AI 기능 소개 섹션 탭 및 페이지네이션 기능 ---
const featureTabs = document.querySelectorAll('.feature-tabs li');
const featureContents = document.querySelectorAll('.feature-content .feature-grid');
const prevButton = document.querySelector('.ai-feature-section .prev-btn');
const nextButton = document.querySelector('.ai-feature-section .next-btn');
const currentPageSpan = document.querySelector('.ai-feature-section .current-page');
const totalPagesSpan = document.querySelector('.ai-feature-section .total-pages');

// 모든 관련 요소가 존재하는지 확인 후 실행
if (featureTabs.length > 0 && featureContents.length > 0 && prevButton && nextButton && currentPageSpan && totalPagesSpan) {
    let currentFeatureIndex = 0;
    const totalFeatures = featureTabs.length;

    function showFeature(index) {
        featureTabs.forEach(tab => tab.classList.remove('active'));
        featureContents.forEach(content => content.classList.remove('active'));
        featureTabs[index].classList.add('active');
        featureContents[index].classList.add('active');
        currentPageSpan.textContent = index + 1;
        currentFeatureIndex = index;
    }

    featureTabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            showFeature(index);
        });
    });

    prevButton.addEventListener('click', () => {
        let newIndex = (currentFeatureIndex - 1 + totalFeatures) % totalFeatures;
        showFeature(newIndex);
    });

    nextButton.addEventListener('click', () => {
        let newIndex = (currentFeatureIndex + 1) % totalFeatures;
        showFeature(newIndex);
    });

    totalPagesSpan.textContent = totalFeatures;
}