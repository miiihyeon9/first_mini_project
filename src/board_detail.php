<?php
    define("SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
    define("URL_DB", SRC_ROOT."common/db_common.php");
    define("URL_HEADER", SRC_ROOT."board_header.php");
    include_once(URL_DB);
    //Request Parameter 획득 (GET)
    $arr_get = $_GET;

    //DB에서 게시글 정보 획득
    $result_info = select_board_info_no($arr_get["board_no"]);
    // var_dump($result_info);


?>



<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/star.css">
    <link rel="stylesheet" href="./css/board_detail.css">
    <title>Detail</title>
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
        <h2 class="title">Details</h2>
    </header>
    <main>
        <div id="list_container">
            <div class="board_number">게시글 번호</div>
            <div class="board_number" ><?php echo $result_info["board_no"] ?></div>
            <div>작성일</div> 
            <div><?php echo $result_info["board_write_date"] ?></div>
            <div>게시글 제목</div> 
            <div><?php echo $result_info["board_title"] ?></div>
            <div>게시글 내용</div> 
            <div><?php echo $result_info["board_contents"] ?></div>
        </div>
        <button class= "main_button_1" type="button"><a href="board_update.php?board_no=<?php echo $result_info["board_no"] ?>">수정</a></button>
        <button class="main_button_2" type="button"><a href="board_delete.php?board_no=<?php echo $result_info["board_no"] ?>">삭제</a></button>
    </main>    
</body>
</html>

<!-- D:\Students\first_mini_project>xcopy D:\Students\first_mini_project\src C:\Apache24\htdocs\src /e /h /f /y -->
<!-- rmdir /s /q C:\Apache24\htdocs\src    삭제-->