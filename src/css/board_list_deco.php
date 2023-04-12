<?php


$page_num = 1; // 현재 페이지 번호

// $max_page_number // 전체 페이지 수

$start_page = max(1, $page_num - 9); // 시작 페이지 번호

$end_page = min($max_page_number, $page_num + 9); // 끝 페이지 번호

// echo '<div class="pagination">';

// if ($currentPage > 1) {
//     echo '<a href="?page=' . ($currentPage - 1) . '">이전</a>';
// }

if($start_page < 10)
{
    $start_page=1;
}
for ($i = $start_page; $i <= $end_page; $i++) {
    echo '<a href="?page=' . $i . '">' . $i . '</a>';
}


// if ($currentPage < $totalPages) {
//     echo '<a href="?page=' . ($currentPage + 1) . '">다음</a>';
// }

// echo '</div>';


?>