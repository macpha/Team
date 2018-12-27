<?php
  require_once("../tools.php");
  require_once("BoardDao.php");

  //전달된 페이지 번호 저장
  $page = requestValue("page");

  //화면 구성에 관련된 상수 정의
  define("NUM_LINES", 5);
  define("NUM_PAGE_LINKS", 3);

  //게시판의 전체 게시글 수 구하기
  $dao = new BoardDao();
  $numMsgs = $dao->getNumMsgs();

  if($numMsgs > 0) {
    // 전체 페이지 수 구하기
    $numPages = ceil($numMsgs / NUM_LINES);

    // 현재 페이지 수 구하기
    if($page < 1)
		$page = 1;
    if($page > $numPages)
		$page = $numPages;

    //리스트에 보일 게시글 데이터 읽기
    $start = ($page - 1) * NUM_LINES;//첫 줄의 레코드 번호
    $msgs = $dao->getManyMsgs($start, NUM_LINES);

    //페이지네이션 컨트롤의 처음 마지막 헤이지 링크 번호 계산
    $firstLink = floor(($page - 1)/NUM_PAGE_LINKS) * NUM_PAGE_LINKS + 1;
    $lastLink = $firstLink + NUM_PAGE_LINKS - 1;
    if ($lastLink > $numPages)
      $lastLink = $numPages;
  }

  session_start_if_none();
  $loginId = sessionVar("uid");
?>

<!DOCTYPE html>
<html>
<head>
	<?php require("../html_head.php") ?>
</head>
<body>

<div id="m-container">
  <?php require("../header.php") ?>

  <div id="m-content">
	   <?php if ($numMsgs == 0) : ?>
		     <table class = "list">
			        <tr>
				            <th class='list-num'>번호</th>
				            <th class='list-title'>제목</th>
				            <th class='list-writer'>작성자</th>
			              <th class='list-regrime'>작성일시</th>
				            <th>조회수</th>
			        </tr>
	   <?php endif ?>

	   <?php if ($numMsgs > 0) : ?>
		     <table class = "list">
			        <tr>
				            <th class='list-num'>번호</th>
				            <th class='list-title'>제목</th>
				            <th class='list-writer'>작성자</th>
				            <th class='list-regrime'>작성일시</th>
				            <th>조회수</th>
			        </tr>

			        <?php foreach ($msgs as $row): ?>
				      <tr>
					         <td><?= $row["num"] ?></td>
					         <td class="left"> <a href="<?= bdUrl("view.php", $row["num"], $page) ?>"><?= $row["title"] ?></a> </td>
					         <td><?= $row["writer"] ?></td>
					         <td><?= $row["regtime"] ?></td>
					         <td><?= $row["hits"] ?></td>
				      </tr>
			        <?php endforeach ?>
		     </table>

		     <br>
		     <?php if ($firstLink > 1): ?>
			        <a href="<?= bdUrl("board.php", 0, $page - NUM_PAGE_LINKS) ?>"><</a>&nbsp;
		     <?php endif ?>

		     <?php for ($i = $firstLink; $i <= $lastLink; $i++) : ?>
			        <?php if($i == $page): ?>
				            <a href="<?=bdUrl("board.php", 0, $i)?>"><b><?=$i ?></b></a>&nbsp;
			        <?php else: ?>
				            <a href="<?=bdUrl("board.php", 0, $i)?>"><?=$i ?></a>&nbsp;
			        <?php endif ?>
		     <?php endfor ?>

		     <?php if($lastLink < $numPages) : ?>
			        <a href="<?=bdUrl("board.php", 0, $page + NUM_PAGE_LINKS) ?>">></a>
		     <?php endif ?>

	   <?php endif ?>

     <?php if ($loginId) : ?>
       <br><br>
       <div class="right">
		       <input type="button" value="글쓰기" onclick="location.href='<?=bdUrl("write_form.php", 0, $page) ?>'">
       </div>
     <?php endif ?>
   </div>

   <?php require("../footer.php") ?>
</div>

</body>
</html>
