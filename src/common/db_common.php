<?php
//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
// 함수명   : db_conn
// 기능     : DB Connect
// 파라미터  : PDO   &$param_conn
// 리턴     : 없음 
//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

function db_conn( &$param_conn )
{
    $host = "localhost"; // 원래는 아이피가 들어감
    $user = "root";      // user
    $password = "root506";   //password
    $name = "board";     // DB name
    $charset = "utf8mb4";    //charset
    $dns = "mysql:host=".$host.";dbname=".$name.";charset=".$charset;
    $pdo_option = array(
                PDO::ATTR_EMULATE_PREPARES      => false     
                , PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
                , PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC  //  연상배열로 FETCH 하도록 설정 
                );  
    // PDO class로 DB 연동
    
    try
    {
        $param_conn = new PDO( $dns, $user, $password, $pdo_option);
    }
    catch( Execption $e)
    {
        $param_conn = null;
        throw new Exception( $e->getMessage() );
        // 데이터베이스 연결시 에러가 발생할 경우 Message 
    }    
}

//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
// 함수명 : select_board_info
// 기능 : 게시글 select
// 파라미터 :  &$param_arr
// 리턴 : $result
//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
function select_board_info_paging( &$param_arr )
{
    $sql = " SELECT "
            ." board_no "
            ." ,board_title "
            ." ,board_write_date "
            ." FROM "
            ." board_info "
            ." WHERE "
            ." board_del_flg ="
            ."'0'"
            ." ORDER BY "
            ." board_no "
            ." DESC "
            ." LIMIT "
            ." :limit_num "
            ." OFFSET "
            ." :offset "
            ." ; "
            ;
            
    $arr_prepare = array
                (
                    ":limit_num"     => $param_arr["limit_num"] 
                    , ":offset"   => $param_arr["offset"]
                );
    
    $conn = null;
    try 
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare);
        $result_paging = $stmt->fetchALL();
    } 
    catch (Exception $e) 
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;//     데이터베이스 종료
    }
    return $result_paging;
}

// TODO : test Start 
// $arr = 
//     array
//     (
//         "limit_num" => 5
//         ,"offset"   => 0
//     );

// $result = select_board_info_paging($arr);

// print_r($result);

// TODO : test End

//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
// 함수     : select_board_info_count()
// 기능     : 게시글 총 개수 확인
// 파라미터 : X
// 리턴값   : $result_count
//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ



function select_board_info_count()
{
    $sql = " SELECT "
            ." COUNT(*) cnt "
            ." FROM "
                ." board_info "
            ." WHERE "
                ." board_del_flg = "
                ." '0' "
            ." ; "
            ;

    $arr_prepare = array();

    $conn = null;
    try 
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->fetchALL();
    } 
    catch (Exception $e) 
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;//     데이터베이스 종료
    }
    return $result_cnt;
}





?>