CREATE TABLE board_info (
	board_no INT(11) NOT NULL AUTO_INCREMENT,
, board_title VARCHAR(100) NOT NULL 
,	board_contents VARCHAR(1000) NOT NULL 
,	board_write_date DATETIME NOT NULL,
, board_del_flg CHAR(1) NOT NULL DEFAULT '0' 
,	board_del_date DATETIME NULL 

)
;