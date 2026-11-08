<?php
// db_config.php 불러오기
include_once __DIR__ . '/../../shared/api/db_config.php';
$style = '<style>' . file_get_contents(__DIR__ . '/nation_support.css') . '</style>';

$courses = [];       //강의 저장 (sql1)
$categories = [];    //카테고리 저장 (sql2)
$all_tags_data = []; //모든 태그 저장 (sql3)
$grouped_tags = [];  //강의별 태그 묶음 (sql3)


$sql1=               //강의 정보 검색
"SELECT 
    c.c_id,c.course_name,c.training_months,
    DATE_FORMAT(c.recruitment, '%m월%d일') AS recruit,
    DATE_FORMAT(c.start_date, '%y년%m월%d일') AS start_date,
    DATE_FORMAT(c.end_date, '%y년%m월%d일') AS end_date,
    c.start_date AS sort_start_date,/*정렬용 Data*/
    c.link,cat.category_name,i.insitution_name,cat.Image_URL
FROM 
    n_courses c
INNER JOIN 
    n_categories cat
ON 
    c.category_id=cat.cat_id
INNER JOIN 
    n_institutions i
ON 
    c.institution=i.i_id
ORDER BY 
    recruit;";

$sql2=               //카테고리 태그 검색
"SELECT 
    cat_id,category_name
FROM 
    n_categories
ORDER BY 
    cat_id asc;";

$sql3=               //강의별 디테일 태그 검색
"SELECT 
    ct.c_id,         
    t.t_name,        
    t.tag_style      
FROM 
    n_course_tags AS ct
INNER JOIN 
    n_detailTag AS t 
ON 
    ct.t_id = t.t_id
ORDER BY ct.c_id, t.t_name;";


try {                              // sql1 객체 생성

    $ret1 = $conn->prepare($sql1); //보안상 query -> prepare 사용
    $ret1->execute();
    $courses = $ret1->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Query Error: " . $e->getMessage());
}

try {                              //sql2 객체 생성
    $ret2 =$conn->prepare($sql2); 
    $ret2->execute();
    $categories = $ret2->fetchAll(PDO::FETCH_ASSOC); 

} catch (PDOException $e) {
    error_log("Query Error: " . $e->getMessage());
}

try {                              //sql3 객체 생성
    
    $ret3_tags = $conn->prepare($sql3);
    $ret3_tags->execute();
    $all_tags_data = $ret3_tags->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Tag Query Error: " . $e->getMessage());
}


// 태그 데이터 강의ID와 그룹화
foreach ($all_tags_data as $tag_info) {
    $course_id = $tag_info['c_id'];
    
    // 해당 강의 ID 배열이 없으면 새로 만듬
    if (!isset($grouped_tags[$course_id])) {
        $grouped_tags[$course_id] = [];
    }
    
    // 태그 이름과 스타일 정보 추가
    $grouped_tags[$course_id][] = [
        'name' => $tag_info['t_name'],
        'style' => $tag_info['tag_style']
    ];
}

//Script에서 사용할 JSON 배열 생성 (모집기간 빠른 순)
$initial_course_order = array_column($courses, 'c_id');
$initial_order_json = json_encode($initial_course_order);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>국비지원</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php echo $style;?>
</head>

<body>
    <h1>전액 <span style="color: #007BFF;">무료!</span> 국비지원 부트캠프</h1>
    <div class="course-filter">
        
        <!--검색바-->
        <input type="text" id="courseSearch" placeholder="원하시는 교육을 입력해주세요." class="search-input">
        

        <!--필터탭-->
        <ul class="filter-tabs">
            <li class="tab active" data-filter="all">전체</li>
            <?php foreach($categories as $category):
                $category_name = $category['category_name'];
                $filter_class = str_replace(' ', '-', htmlspecialchars($category_name)); 
            ?>
                <li class="tab" data-filter="<?= $filter_class ?>">
                    <?= htmlspecialchars($category_name) ?>
                </li>
            <?php endforeach;?> 
        </ul>


        <!--정렬바-->
        <div class="sort-bar">
            <label for="sort-select" class="sort-label"></label>
                <select id="sort-select" class="sort-dropdown">
                    <option value="recruit_asc">모집기간 빠른 순으로 볼래요</option>
                    <option value="start_date_asc">교육날짜 빠른 순으로 볼래요</option>
                    <option value="duration_asc">교육기간 짧은 순으로 볼래요</option>
                    </select>
            </div>
    </div>
    
    <!--교육 리스트-->
    <div class="course-list">
        <?php foreach ($courses as $course):
            $course_class = str_replace(' ', '-', htmlspecialchars($course['category_name']));
            $current_course_id = $course['c_id'];
        ?>
            <div class="course-item <?= $course_class ?>"
                data-id="<?= htmlspecialchars($current_course_id) ?>"
                data-duration="<?= htmlspecialchars($course['training_months']) ?>"
                data-start-date="<?= htmlspecialchars($course['sort_start_date']) ?>">
                
                <!--이미지-->
                <div class="course-image">
                <img src="<?= htmlspecialchars($course['Image_URL']) ?>" 
                        alt="<?= htmlspecialchars($course['category_name']) ?> 이미지" 
                        class="course-thumb">
                </div>

                <!--제목-->
                <div class="course-title"><?= htmlspecialchars($course['course_name']) ?></div>

                <!--교육정보-->
                <div class="course-details">
                    <p><strong>교육기간:</strong> <?= htmlspecialchars($course['training_months']) ?>개월</p>
                    <p class="date-range" style="font-size: 0.9em; margin-top: -8px; color: #959595ff;">
                    <?= htmlspecialchars($course['start_date']) ?> ~ <?= htmlspecialchars($course['end_date']) ?>
                    </p>
                    <p><strong>모집기간:</strong> ~<?= htmlspecialchars($course['recruit']) ?> 까지</p>
                    <p><strong>기관:</strong> <?= htmlspecialchars($course['insitution_name']) ?></p>
                </div>

                <!--태그-->
                <div class="course-tags">
                    <?php 
                    if (isset($grouped_tags[$current_course_id])): 
                        foreach ($grouped_tags[$current_course_id] as $tag):
                    ?>
                            <span class="tag-badge <?= htmlspecialchars($tag['style']) ?>">
                                <?= htmlspecialchars($tag['name']) ?>
                            </span>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                
                <!--링크-->
                </div>
                <a href="<?= htmlspecialchars($course['link']) ?>"
                    target="_blank"
                    class="link-button">
                        신청하러 가기
                </a>
            </div>
        <?php endforeach; ?>   
    </div>
    
    <script>
        //JSON 파일의 순서를 배열로 가져오기(정렬 순서)
        const INITIAL_ORDER = <?php echo $initial_order_json ?? '[]'; ?>;

        let activeFilter = "all"; 
        const searchInput = document.getElementById("courseSearch");
        const sortDropdown = document.getElementById("sort-select");


        //**정렬 함수**
        function sortCourses(sortType) {
            const courseList = document.querySelector(".course-list");
            if (!courseList) return;
            
            // 전체 강의 아이템을 ID를 키로 하는 Map으로 구성 (순서 복원에 사용)
            const courseItemsMap = new Map();
            document.querySelectorAll('.course-item').forEach(item => {
                const courseId = parseInt(item.getAttribute('data-id')); 
                if (!isNaN(courseId)) {
                    courseItemsMap.set(courseId, item);
                }
            });
            //현재 보이는 강의만 배열로 담음
            let coursesToSort = Array.from(courseList.querySelectorAll('.course-item:not(.hidden)'));
            
            // 정렬 로직
            if (sortType === 'recruit_asc') {
                // 1. 모집기간 빠른 순 (초기 순서) 복원
                let reorderedCourses = [];
                INITIAL_ORDER.forEach(initialId => {
                    const item = courseItemsMap.get(initialId);
                    //필터링으로 숨겨지지 않은 강의만 포함
                    if (item && !item.classList.contains('hidden')) {
                         reorderedCourses.push(item);
                    }
                });
                coursesToSort = reorderedCourses;
                
            } else {
                // 2. 교육 날짜/기간 순 정렬
                coursesToSort.sort((a, b) => {
                    
                    if (sortType === 'start_date_asc') {
                        // 교육날짜 빠른 순 (start_date 오름차순)
                        const dateA = a.getAttribute('data-start-date');
                        const dateB = b.getAttribute('data-start-date');
                        if (dateA < dateB) return -1;
                        if (dateA > dateB) return 1;
                        return 0;
                        
                    } else if (sortType === 'duration_asc') {
                        // 교육기간 짧은 순 (training_months 오름차순)
                        const durationA = parseInt(a.getAttribute('data-duration'));
                        const durationB = parseInt(b.getAttribute('data-duration'));
                        return durationA - durationB;
                    }
                    return 0;
                });
            }

            // 정렬된 순서대로 DOM 요소 재배치
            coursesToSort.forEach(course => {
                courseList.appendChild(course);
            });
        }


        //**검색 함수**
        function filterCourses(filter, searchTerm = "") {
            document.querySelectorAll(".course-item").forEach(item => {
                const itemClasses = item.className;
                
                // 검색 범위: 제목 + 기관명
                const courseTitleElement = item.querySelector(".course-title");
                const courseTitle = courseTitleElement ? courseTitleElement.textContent.toLowerCase() : "";
                
                //.course-details p:last-child 요소가 null이 아닌지 확인
                const courseInstitutionElement = item.querySelector(".course-details p:last-child");
                const courseInstitution = courseInstitutionElement ? courseInstitutionElement.textContent.toLowerCase() : "";
                
                // 1. 카테고리 필터링
                const categoryMatch = (filter === 'all' || itemClasses.includes(filter));
                
                // 2. 검색어 필터링 (제목 또는 기관명에 포함되는지 확인)
                const searchMatch = courseTitle.includes(searchTerm) || courseInstitution.includes(searchTerm);
                
                
                if (categoryMatch && searchMatch) {
                    item.classList.remove("hidden");
                } else {
                    item.classList.add("hidden");
                }
            });
            
            //필터링 적용 후 정렬 기준 다시 적용
            const currentSortValue = sortDropdown.value;
            sortCourses(currentSortValue);
            
            // "현재 등록된 강의가 없습니다." 메시지 처리
            const noCoursesMessage = document.querySelector('.course-list > p[style*="text-align: center"]');
            if (noCoursesMessage) {
                const visibleCourses = document.querySelectorAll(".course-item:not(.hidden)");
                noCoursesMessage.style.display = visibleCourses.length > 0 ? 'none' : 'block';
            }
        }

        //**이벤트 핸들러**
        function handleFilterClick(clickedTab) {
            document.querySelectorAll(".filter-tabs .tab").forEach(t => t.classList.remove("active"));
            clickedTab.classList.add("active");
        
            // 클릭한 탭의 data-filter 값을 전역 변수에 할당
            activeFilter = clickedTab.getAttribute("data-filter"); 
            const searchTerm = searchInput.value.toLowerCase();
            // 필터링 함수 호출
            filterCourses(activeFilter, searchTerm);
        }
        document.addEventListener("DOMContentLoaded", () => {
            // 초기 설정
            filterCourses(activeFilter);
            document.querySelector('.filter-tabs [data-filter="all"]').classList.add('active');
            
            // 검색창 입력 이벤트
            searchInput.addEventListener("input", function() {
                filterCourses(activeFilter, this.value.toLowerCase());
            });

            // 탭 클릭 시 handleFilterClick을 호출하여 activeFilter를 업데이트
            document.querySelectorAll(".filter-tabs .tab").forEach(tab => {
                tab.addEventListener("click", function() {
                    handleFilterClick(this);
                });
            });
            
            sortDropdown.addEventListener('change', function() {
                const selectedValue = this.value;
                sortCourses(selectedValue); // 선택된 값 그대로 전달
            });
        });
    </script>
</body>
</html>