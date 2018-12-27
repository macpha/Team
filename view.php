<?php
	require_once("../tools.php");
	require_once("BoardDao.php");

	$num = requestValue("num");
	$page = requestValue("page");

	$dao = new BoardDao();
	$row = $dao->getMsg($num);
	$dao->increaseHits($num);

	$row["title"] = str_replace(" ", "&nbsp;", $row["title"]);
	$row["content"] = str_replace(" ", "&nbsp;", $row["content"]);
	$row["content"] = str_replace("\n", "<br>", $row["content"]);

	session_start_if_none();
	$loginId = sessionVar("uid");
?>

<!doctype html>
<html>
<head>
	<?php require("../html_head.php") ?>
</head>
<body>

<div id="m-container">
	<?php require("../header.php") ?>

	<div id="m-content">

		<table class="msg">
			<tr>
				<th class="msg-header">제목</th>
				<td class="msg-text left"><?= $row["title"]; ?></td>
			</tr>

			<tr>
				<th>작성자</th>
				<td class="msg-text left"><?= $row["writer"]; ?></td>
			</tr>

			<tr>
				<th>작성일시</th>
				<td class="msg-text left"><?= $row["regtime"]; ?></td>
			</tr>

			<tr>
				<th>조회수</th>
				<td class="msg-text left"><?= $row["hits"]; ?></td>
			</tr>

			<tr>
				<th>내용</th>
				<td class="msg-text left"><?= $row["content"]; ?></td>
			</tr>
		</table>

		<br>
		<div class="left">
			<input type="button" value="목록보기" onclick="location.href='<?= bdUrl("board.php", 0, $page) ?>'">
			<?php if($loginId == $row["writer"]) : ?>
				<input type="button" value="수정" onclick="location.href='<?= bdUrl("modify_form.php", $num, $page) ?>'">
				<input type="button" value="삭제" onclick="location.href='<?= bdUrl("delete.php", $num, $page) ?>'">
			<?php endif ?>
		</div>
	</div>
	<?php require("../footer.php") ?>
</div>

</body>
</html>
