<?php
    define("SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
    define("URL_DB", SRC_ROOT."common/db_common.php");
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
    <link rel="stylesheet" href="./css/board_detail.css">
    <link rel="stylesheet" href="./css/star.css">
    <title>Detail</title>
</head>
<body>
    <header>
        <h1>Details</h1>
    </header>
    <main>
        <div>
            <p>게시글 번호 : <?php echo $result_info["board_no"] ?></p>
            <p>작성일 : <?php echo $result_info["board_write_date"] ?></p>
            <p>게시글 제목 : <?php echo $result_info["board_title"] ?></p>
            <p>게시글 내용 : <?php echo $result_info["board_contents"] ?></p>
        </div>
        <button type="button"><a href="board_update.php?board_no=<?php echo $result_info["board_no"] ?>">수정</a></button>
        <button type="button"><a href="board_delete.php?board_no=<?php echo $result_info["board_no"] ?>">삭제</a></button>
    </main>    
</body>
</html>

<!-- D:\Students\first_mini_project>xcopy D:\Students\first_mini_project\src C:\Apache24\htdocs\src /e /h /f /y -->
<!-- rmdir /s /q C:\Apache24\htdocs\src    삭제-->