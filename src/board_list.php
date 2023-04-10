<?php
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define("URL_DB", DOC_ROOT."src/common/db_common.php");
    include_once(URL_DB);
    $http_method = $_SERVER["REQUEST_METHOD"];
    // 세션에 있는 request_method

    if( array_key_exists("page_num",$_GET) )
    // array_key_exists() : array에 키가 존재하는지 확인하는 함수
    {
        $arr_get = $_GET;
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1;
    }
    
    $limit_num = 5;

    // 한페이지 넘어갈 때 5씩 증가
    $offset = ( $page_num * $limit_num ) - $limit_num;
    // 게시판 정보 테이블 전체 카운트  획득 
    $result_cnt = select_board_info_count();

    // max page number
    $max_page_number = ceil((int)$result_cnt[0]["cnt"]/$limit_num);
    // echo $max_page_number;
    // var_dump($max_page_number);

    $arr_prepare = 
                array
                (
                    "limit_num" => $limit_num
                    ,"offset" => $offset
                );
    $result_paging = select_board_info_paging($arr_prepare);
    // print_r($result_paging);



    // // 이전페이지, 다음페이지 버튼 만들기 
    // $current_url = $_SERVER['REQUEST_URI'];
    // $prev_page = $page - 1;
    // if ($prev_page > 0) {
    //     $prev_url = strtok($current_url, '?') . '?page=' . $prev_page;
    //     echo "<a href=\"$prev_url\">이전 페이지</a>";
    // }

    // // 다음 페이지 URL 구하기
    // $next_page = $page + 1;
    // $next_url = strtok($current_url, '?') . '?page=' . $next_page;
    // echo "<a href=\"$next_url\">다음 페이지</a>";

?>

<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- 부트스트랩 CSS -->
        <!-- <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous"
        /> -->
        <link rel="stylesheet" href="./css/board_list.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;900&display=swap" rel="stylesheet">        <title>게시판</title>
    </head>
<body>
    <h1>Boarder</h1>
    <table class="table table-striped">
        <thead>
            <tr>
            <th>게시글 번호</th>
            <th>게시글 제목</th>
            <th>작성일자</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $result_paging as $recode)
                {
            ?>
                    <tr>
                        <td><?php echo $recode["board_no"] ?></td>
                        <td><?php echo $recode["board_title"] ?></td>
                        <td><?php echo $recode["board_write_date"] ?></td>
                    </tr>    
            <?php
                }
            ?>
        </tbody>
    </table>
                <!-- <button><a href=""></a></button> -->
            
            <?php
                for( $i= 1; $i <= $max_page_number ; $i++ )
                {
            ?>
                    <div class="page_list"><a href='board_list.php?page_num=<?php echo $i?>'><?php echo $i ?></a></div>
            <?php
                }
            // get 방식 : url뒤에 이동할 페이지를 
            // post 방식 : 숨겨서 이동 
            // string
            ?>

                <!-- <button><a href=""></a></button> -->

    </body>
</html>

<!-- PS D:\Students\first_mini_project> xcopy D:\Students\first_mini_project\src  C:\Apache24\htdocs\src /e /h /f /y -->
<!-- //                                                복사하고싶은 파일                     복사할 장소         파일이 있으면 덮어쓰고, 파일의 형태 복사, 디렉토리 비어있을 때 해당 디렉토리 복사, 숨김파일 복사  -->