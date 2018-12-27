<?php
	require_once("../tools.php");
	
	session_start_if_none();
	unset($_SESSION["uid"]);
	unset($_SESSION["uname"]);
	
	goNow(MAIN_PAGE);
?>