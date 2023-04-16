<?php
    define("SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
    define("URL_DB", SRC_ROOT."common/db_common.php");
    define("URL_HEADER", SRC_ROOT."board_header.php");
    include_once(URL_DB);
    
    $http_method = $_SERVER["REQUEST_METHOD"];


    if( $http_method === "POST" )
    // array_key_exists() : array에 키가 존재하는지 확인하는 함수
    {
        $arr_post = $_POST;
        $result_cnt = insert_board_info( $arr_post );

        header( "Location:board_list.php" );
        exit();
    }





?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Board-writing</title>
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/board_insert.css">
</head>
<body>
    <!-- <div id="layers">
        <div class="layer"></div>
        <div class="layer"></div>
        <div class="layer"></div>
        <div class="layer"></div>
        <div class="layer"></div>
    </div> -->
    <header>
        <?php include_once(URL_HEADER) ?>
            <h2>Writing</h2>
        </header>
    <main>
        <form method="post" action="board_insert.php">

            <label for= "title" >게시글 제목</label>
            <input type="text" id = "title" name="board_title" required maxlength="100">
            
            <label for="contents">게시글 내용</label>
            <textarea class="contents_write" id="contents" name="board_contents" maxlength="1000"></textarea>
            
            <button type="submit">작성</button>
            <button><a href="board_list.php">취소</a></button>
            
        </form>
    </main>
</body>
</html>