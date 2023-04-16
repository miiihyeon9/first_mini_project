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
    $password = "0809";   //password
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


//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
// 함수     : select_board_info_no()
// 기능     : 게시판 특정 게시글 정보 검색 
// 파라미터 : INT &$param_no
// 리턴값   : ARRAY $result
//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

function select_board_info_no( &$param_no )
{
    $sql = " SELECT "
            ." board_no "
            ." ,board_title "
            ." ,board_contents "
            ." ,board_write_date "          //0412 작성일 추가
            ." FROM "
            ." board_info "
            ." WHERE "
            ." board_no = "
            ." :board_no "            
            ;

    $arr_prepare = 
                array(
                    ":board_no"=>$param_no
                );

    $conn = null;
    try 
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchALL();
    } 
    catch (Exception $e) 
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;//     데이터베이스 종료
    }
    return $result[0];
}


//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
// 함수명  : update_board_info_no
// 기능    : 게시판 특정 게시글 수정
// 파라미터 : Array &$param_arr
// 리턴값   : INT/STRING   $result_cnt/ERRMSG 
//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
function update_board_info_no( &$param_arr )
{
    $sql = " UPDATE "
        ." board_info "
        ." SET "
        ." board_title = "
        ." :board_title "
        .", board_contents = "
        ." :board_contents "
        ." WHERE "
        ." board_no = "
        ." :board_no "
        ;
    
    $arr_prepare = 
            array(
            ":board_title" => $param_arr["board_title"]
            ,":board_contents" =>$param_arr["board_contents"]
            ,":board_no" =>$param_arr["board_no"]
            );

    $conn = null;
    try 
    {
        db_conn( $conn );       // PDO object 셋
        $conn->beginTransaction(); // Transaction시작  commit이나 rollback만나면 종료
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    }
    catch (Exception $e) 
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;//     데이터베이스 종료
    }
    return $result_cnt;     //행의 개수 리턴 
}


//ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
// 함수명   : delte_board_info_no
// 기능     : 게시판 특정 게시글 정보 삭제플러그 갱신
// 파라미터 : INT &$param_no
// 리턴값   : INT/STRING    $result_cnt/ERRMSG
// ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
function delete_board_info_no( &$param_no )
{
    $sql = " UPDATE "
            ." board_info "
            ." SET "
            ." board_del_flg = "
            ." '1' "
            ." ,board_del_date = "
            ." NOW() "
            ." WHERE "
            ." board_no = "
            ." :board_no "
            ;

    $arr_prepare = 
                array(
                    ":board_no"=> $param_no
                );
    
    $conn = null;
    try 
    {
        db_conn( $conn );       // PDO object 셋
        $conn->beginTransaction(); // Transaction시작  commit이나 rollback만나면 종료
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    }
    catch (Exception $e) 
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;//     데이터베이스 종료
    }
    return $result_cnt; 
}

// ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
// 함수명 : insert_board_info
// 기능 : 새로운 게시글 생성
// 파라미터 : STRING &$param_title, &$param_contents
// 리턴값 : INT $result_cnt / STRING ERRMSG
// ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
function insert_board_info( &$param_array )
{
    $sql = " INSERT INTO "
            ." board_info "
            ." ( "
            ." board_title "
            ." ,board_contents "
            ." ,board_write_date "
            ." ) "
            ." VALUES "
            ." ( "
            ." :board_title "
            ." ,:board_contents "
            ." ,NOW() "
            ." ) "
            ." ; ";

    $arr_prepare = 
                array(
                    ":board_title" => $param_array["board_title"]
                    ,":board_contents" => $param_array["board_contents"]
                );

    $conn = null;
    try 
    {
        db_conn( $conn );       // PDO object 셋
        $conn->beginTransaction(); // Transaction시작  commit이나 rollback만나면 종료
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        if($result_cnt !== 1)
            {
                throw new Exception ('rowCount ERROR');
            }
        $conn->commit();
    }
    catch (Exception $e) 
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;//     데이터베이스 종료
    }

    return $result_cnt; 
}





?>