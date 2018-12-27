<?php
	require_once("../tools.php");
	require_once("BoardDao.php");
	
	$writer = requestValue("writer");
	$title = requestValue("title");
	$content = requestValue("content");
	
	if($writer && $title && $content) {
		$dao = new BoardDao();
		$dao->insertMsg($writer, $title, $content);
		
		goNow(bdUrl("board.php", 0, 0));
	} else
		errorBack("모든 항목이 빈칸 없이 입력되어야 합니다.");
?>