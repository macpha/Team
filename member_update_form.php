<?php
	require_once("../tools.php");
	require_once("MemberDao.php");

	session_start_if_none();
	$mdao = new MemberDao();
	$member = $mdao->getMember($_SESSION["uid"]);
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
			<form action="member_update.php" method="post">
				<table>
					<tr>
						<td>아이디</td>
						<td><input type="text" name="id" value=<?= $member["id"] ?> readonly></td>
					</tr>
					<tr>
						<td>비밀번호</td>
						<td><input type="password" name="pw" value=<?= $member["pw"] ?>></td>
					</tr>
					<tr>
						<td>성명</td>
						<td><input type="text" name="name" value=<?= $member["name"] ?>></td>
					</tr>
				</table>
				<input type="submit" value="확인">
			</form>
	</div>

	<?php require("../footer.php") ?>
</div>

</body>
</html>
