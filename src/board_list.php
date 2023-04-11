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

    // max page number(전체페이지수)
    $max_page_number = ceil((int)$result_cnt[0]["cnt"]/$limit_num);
    // echo $max_page_number;
    var_dump($result_cnt);


    
    $arr_prepare = 
                array
                (
                    "limit_num" => $limit_num
                    ,"offset" => $offset
                );
    $result_paging = select_board_info_paging($arr_prepare);
    
    ?>

<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="./css/board_list.css" type="text/css" >
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;900&display=swap" rel="stylesheet">        
        <title>게시판</title>
    </head>
    <body>
        <header>
            <h1>BOARD</h1>
            <div class="tree_img"></div>
        </header>
        <main>
            <table>
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
                                <td ><a class="table_list" href="board_update.php?board_no=<?php echo $recode["board_no"] ?>&&page_num=<?php echo $page_num ?>"><?php echo $recode["board_title"] ?></a></td>
                                <td><?php echo $recode["board_write_date"] ?></td>
                            </tr>    
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </main>
        <footer>
            <?php 
                    if($page_num > 11)
                    {
                    $ten_prev_page = $page_num - 10;
                    }else
                    {
                        $ten_prev_page = 1;
                ?>

                <div class="page_list" ><a href='board_list.php?page_num=<?php echo $ten_prev_page ?>'> << </a></div>
                <?php
                    }
                ?>

                <?php  

                    if($page_num > 1)
                    {
                    $prev_page = $page_num - 1;
                    // }
                    // else
                    // {
                    // $prev_page = 1;
                    
                    ?>

                <div class="page_list" ><a href='board_list.php?page_num=<?php echo $prev_page ?>'> < </a></div>
                    
                <?php
                    }
                ?>

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
                <?php 

                    if($page_num < $max_page_number)
                    {
                        $next_page = $page_num + 1;
                ?>  

                    <div class="page_list " ><a href='board_list.php?page_num=<?php echo $next_page ?>'> > </a></div>
                            
                <?php
                    }
                ?>

                <?php 
                
                    $max_ten_min_page_number = $max_page_number - 10 ; 
                    if($page_num < $max_ten_min_page_number)
                    {
                        $ten_next_page = $page_num + 10;
                            
                    }else
                    {
                        $ten_next_page = $max_page_number;
                ?>
                
                    <div class="page_list" ><a href='board_list.php?page_num=<?php echo $ten_next_page ?>'> >> </a></div>
                <?php
                    }
                ?> 
            </div>
    </footer>
</body>
</html>
