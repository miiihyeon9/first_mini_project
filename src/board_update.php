<?php
    define("SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
    //$_SERVER["DOCUMENT_ROOT"] apach/hdocs에 내가 열려고하는 주소 
    define("URL_DB", SRC_ROOT."common/db_common.php");
    define("URL_HEADER", SRC_ROOT."board_header.php");
    include_once(URL_DB);
    
    
// var_dump($_SERVER,$_GET,$_POST);
    // request method를 가져옴
    $http_method = $_SERVER["REQUEST_METHOD"];
    // get이나 post로 넘어옴 

    // if( array_key_exists("page_num",$_GET) )
    // // array_key_exists() : array에 키가 존재하는지 확인하는 함수
    //     {
    //         $page_num = $_GET["page_num"];
    //     }
    // else
    //     {
    //         $page_num = 1;
    //     }

    // GET 체크
    // 셋팅값이 보이면 get방식 안보이면 post 방식
    if( $http_method === "GET" )
    {
        $board_no = 1;
        if( array_key_exists("board_no",$_GET) )
            {
                $board_no = $_GET["board_no"];
                
            }
            

        $result_info = select_board_info_no( $board_no );
    }
    // POST일 때
    else
    {
        $arr_post = $_POST;
        $arr_info = 
                array(
                    "board_no"        => $arr_post["board_no"]
                    ,"board_title"    => $arr_post["board_title"]
                    ,"board_contents" => $arr_post["board_contents"]
                );
        // update
        $result_cnt = update_board_info_no( $arr_info );

        // select
        // $result_info = select_board_info_no( $arr_post["board_no"] );    0412 delete

        header( "Location: board_detail.php?board_no=".$arr_post["board_no"] );
        exit(); //exit 실행하면 그 밑에 있는 코드는 실행이 안됨. 53행(header())에서 redirect 했기 때문에 이후의 소스코드는 실행할 필요가 없다. 
                // list -> detail -> update-> detail 
    }

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/board_update.css">
    <link rel="stylesheet" href="./css/star.css">
</head>
<body>
    <div id="layers">
        <div class="layer"></div>
        <div class="layer"></div>
        <div class="layer"></div>
        <div class="layer"></div>
        <div class="layer"></div>
    </div>
    <header>
        <?php include_once(URL_HEADER) ?>
        <h2>MODIFY</h2>
    </header>
    <main>
        <button class="list_button"><a href="board_list.php">LIST</a></button>
        <form method="post" action="board_update.php">
            <label for="bno">게시글 번호</label>
            <input type="text" id="bno" name="board_no" value = "<?php echo $result_info['board_no'] ?>" readonly >
            
            <label for= "title" >게시글 제목</label>
            <input type="text" id = "title" name="board_title" value = "<?php echo $result_info['board_title'] ?>" >
            
            <label for="contents">게시글 내용</label>
            <textarea id="contents" name="board_contents" value = "<?php echo $result_info['board_contents'] ?>" ></textarea>
            <!-- <button><a href="board_list.php?page_num=<?php //echo $page_num ?>">리스트</a></button> -->
            <button type="submit">수정</button>
            <button><a href="board_detail.php?board_no=<?php echo $result_info["board_no"] ?>">
                취소
                </a>
            </button>
            
        </form>
    </main>

</body>
</html>