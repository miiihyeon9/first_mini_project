<?php
    define("SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
    // $_SERVER["DOCUMENT_ROOT"] - 서버의 기본 경로 
    define("URL_DB", SRC_ROOT."common/db_common.php");
    define("URL_HEADER", SRC_ROOT."board_header.php");
    include_once(URL_DB);

    // $http_method = $_SERVER["REQUEST_METHOD"];
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

    // max page number(전체페이지수)
    $max_page_number = ceil((int)$result_cnt[0]["cnt"]/$limit_num);
    // echo $max_page_number;
    
    $arr_prepare = 
    array
    (
        "limit_num" => $limit_num
        ,"offset" => $offset
    );
    $result_paging = select_board_info_paging($arr_prepare);
    
    // 페이지 5칸씩 앞으로 이동 
    if($page_num > 6)
    {
    $five_prev_page = $page_num - 5;
    }else
    {
        $five_prev_page = 1;
    }

    // 이전 페이지 이동
    if($page_num > 1)
    {
        $prev_page = $page_num -1;
    }
    else
    {
        $prev_page = 1;
    }

    // 다음 페이지 이동
    if($page_num < $max_page_number)
    {
        $next_page = $page_num + 1;
    }
    else
    {
        $next_page = $max_page_number;
    }

    // 페이지 5칸씩 뒤로 이동
    $max_five_min_page_number = $max_page_number - 5 ; 
    if($page_num < $max_five_min_page_number)
    {
        $ten_next_page = $page_num + 5;
            
    }else
    {
        $ten_next_page = $max_page_number;
    }
    ?>

<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;900&display=swap" rel="stylesheet">        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./css/board_list.css">
        <link rel="stylesheet" href="./css/common.css">
        <title>Board</title>
    </head>
    <body>
        <header>
            <?php include_once(URL_HEADER) ?>
            <h2>List</h2>
        </header>
        <main>
            <div class="table_border">   
            <button class="write" type="button"><a class="write_link" href="board_insert.php">글 쓰기</a></button>
                <table>
                    <thead>
                        <tr class="table_col">
                            <th>게시글 번호</th>
                            <th>게시글 제목</th>
                            <th>작성일자</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach( $result_paging as $recode)
                            {
                                $date_sub = mb_substr($recode["board_write_date"],0,10);        // $date_sub = 작성일 시간부분 지우기
                                ?>
                                <tr class="board_list_row" >
                                    <td><?php echo $recode["board_no"] ?></td>
                                    <td ><a class="table_list" href="board_detail.php?board_no=<?php echo $recode["board_no"] ?>"><?php echo $recode["board_title"] ?></a></td>
                                    <td><?php 
                                        echo $date_sub ?></td>
                                </tr>    
                                <?php
                            }
                            ?>
                    </tbody>
                </table>
            </div> 
            
            <!-- 버튼 -->
            <div class="page_list" ><a class="list" href='board_list.php?page_num=<?php echo $five_prev_page ?>'> << </a></div>
            
            <div class="page_list" ><a  class="list" href='board_list.php?page_num=<?php echo $prev_page ?>'><</a></div>
            <?php
                // 버튼 5개 제한 
                $start_page = max(1, $page_num - 4); // 시작 페이지 번호
                $end_page = $start_page + 4 ; // 끝 페이지 번호
                for ($i = $start_page; $i <= $end_page; $i++) 
                {
                    // ?>
                    <div class="page_list"><a class="list" href='board_list.php?page_num=<?php echo $i?>'><?php echo $i ?></a></div>
                    
                    <?php
                                
                            }
                            // get 방식 : url뒤에 이동할 페이지를 
                            // post 방식 : 숨겨서 이동 
                            // string
                            ?>
                    <div class="page_list " ><a class="list" href='board_list.php?page_num=<?php echo $next_page; ?>'> > </a></div>
                    <div class="page_list" ><a class="list" href='board_list.php?page_num=<?php echo $ten_next_page ?>'> >> </a></div>
                </div>
        </main>
                
            </body>
            </html>
            