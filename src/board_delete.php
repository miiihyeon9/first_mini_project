<?php
    define("SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
    define("URL_DB", SRC_ROOT."common/db_common.php");
    include_once(URL_DB);

    $arr_get = $_GET;

    $result_cnt = delete_board_info_no($arr_get["board_no"]);
    header( "Location: board_list.php" );
//     header() 함수는 PHP에서 웹 페이지의 HTTP 헤더를 설정하기 위해 사용되는 함수입니다.
//      HTTP 헤더는 서버에서 클라이언트(웹 브라우저 등)로 보내지는 정보 중 하나로, 브라우저가 해당 페이지를 요청할 때 서버에서 보내는 데이터입니다.

// header() 함수를 사용하면, HTTP 헤더 정보를 동적으로 변경할 수 있습니다.
//  예를 들어, 페이지를 리다이렉트하는 경우, 특정 쿠키 값을 설정하는 경우, 캐시 설정을 변경하는 경우 등에 사용됩니다.
    exit();



?>