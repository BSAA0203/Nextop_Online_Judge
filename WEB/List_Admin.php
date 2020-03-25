<?php include "../inc/dbinfo.inc";?>
<?php
session_start();
$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if(!isset($_SESSION['name'])) {
  echo "<script>alert('로그인이 필요합니다.');</script>";
  echo "<meta http-equiv='refresh' content='0;url=Login.html'>";
  exit;
}

if($_SESSION['level']!=3){
  echo "<script>alert('관리자 전용 페이지 입니다.');
  history.back();
  </script>";
}

if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

if(isset($_GET['searchColumn'])) {
		$searchColumn = $_GET['searchColumn'];
		$subString .= '&amp;searchColumn=' . $searchColumn;
	}
	if(isset($_GET['searchText'])) {
		$searchText = $_GET['searchText'];
		$subString .= '&amp;searchText=' . $searchText;
	}
	if(isset($searchColumn) && isset($searchText)) {
		$searchSql = ' where ' . $searchColumn . ' like "%' . $searchText . '%"';
	} else {
		$searchSql = '';
	}

  $sql = 'SELECT count(*) as cnt from board' . $searchSql;
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();

	$allPost = $row['cnt'];

  if(empty($allPost)) {
		$emptyData = '<tr><td class="textCenter" colspan="5" bgcolor=white align=center>
    <font size=3><strong>해당 글이 존재하지 않습니다.</strong></font></td></tr>';
	}
  else {
	$onePage = 20;
	$allPage = ceil($allPost / $onePage);
	if($page < 1 || ($allPage && $page > $allPage)) {
?>
<script>
  alert("존재하지 않는 페이지입니다.");
  history.back();
</script>
<?php
		exit;
	}

	$oneSection = 10;
	$currentSection = ceil($page / $oneSection);
	$allSection = ceil($allPage / $oneSection);
	$firstPage = ($currentSection * $oneSection) - ($oneSection - 1);

	if($currentSection == $allSection) {
		$lastPage = $allPage;
	} else {
		$lastPage = $currentSection * $oneSection;
	}
	$prevPage = (($currentSection - 1) * $oneSection);
	$nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1);

	if($page != 1) {
		$paging .= '<a href=List_Admin.php?page=1'.$subString.'><font size=3>[처음]</font></a>';
	}
	for($i = $firstPage; $i <= $lastPage; $i++) {
		if($i == $page) {
			$paging .=   $i  ;
		} else {
			$paging .= '<a href=List_Admin.php?page=' . $i . $subString.'> <font size=3>'. $i .'</font> </a>';
		}
	}
	if($page != $allPage) {
		$paging .= '<a href=List_Admin.php?page=' . $allPage . $subString.'><font size=3>[끝]</font></a>';
	}

	$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
	$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문
	$sql = 'SELECT * from board '.$searchSql.'order by id desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
	$result = $mysqli->query($sql);
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <title>메인 게시판</title>
  <style>
    td {
      font-size: 9pt;
    }

    A:link {
      font: 9pt;
      color: black;
      text-decoration: none;
      fontfamily: 굴림;
      font-size: 9pt;
    }

    A:visited {
      text-decoration: none;
      color: black;
      font-size: 9pt;
    }

    A:hover {
      text-decoration: underline;
      color: black;
      font-size: 9pt;
    }

    html,
    body {
      height: 90%
    }

    body {
      margin: 0
    }

    #body {
      min-height: 100%
    }

    #content {
      padding-bottom: 1.9em
    }

    #foot {
      margin-top: -1.9em;
      height: 1.9em
    }
  </style>
  <link rel="shortcut icon" href="http://www.edu.co.kr/default/img/_images/favicon.ico">
</head>

<body topmargin=0 leftmargin=0 text=#464646>
  <div id="body">
    <div id="content">
      <table style="float: right">
        <tr>
          <td style="font-size: 15"><strong>관리자 : <?php echo $_SESSION['name'] ?> </strong></td>
        </tr>
        <tr>
          <td align=right><a href="Logout.php"><input type="button" value="Logout"></a></td>
        </tr>
      </table>
      <BR><BR><BR><BR>
      <center>
        <table width=1200 border=0 cellpadding=2 cellspacing=1>
          <tr>
            <td align="left"><a href=Mlevel.php><strong>
                  <font size=3>회원 관리</font>
                </strong></a></td>
            <td align="right">
              <a href=Write.php><strong>
                  <font size=3>문제 등록</font>
                </strong></a></td>
          </tr>
        </table>
      </center>
      <center>
        <!-- 게시물 리스트를 보이기 위한 테이블 -->
        <table width=1200 border=0 cellpadding=2 cellspacing=1 bgcolor=#777777>
          <!-- 리스트 타이틀 부분 -->
          <tr height=20 bgcolor=#999999>
            <td width=60 align=center>
              <b>
                <font color=white font size=4>번호</font>
              </b>
            </td>
            <td width=960 align=center>
              <b>
                <font color=white font size=4>제목</font>
              </b>
            </td>
            <td width=120 align=center>
              <b>
                <font color=white font size=4>작성 날짜</font>
              </b>
            </td>
            <td width=80 align=center>
              <b>
                <font color=white font size=4>조회수</font>
              </b>
            </td>
          </tr>
          <!-- 리스트 타이틀 끝 -->
          <!-- 리스트 부분 시작 -->
          <?php
if(isset($emptyData)) {
  echo $emptyData;
}
else {
  while($row = $result->fetch_assoc())
  {
?>
          <!-- 행 시작 -->
          <tr>
            <!-- 번호 -->
            <td align=center height=20 bgcolor=white>
              <font size=3><?php echo $row['id']?></font>
            </td>
            <!-- 번호 끝 -->
            <!-- 제목 -->
            <td align=center height=20 bgcolor=white>
              <a href=Read_Admin.php?id=<?php echo $row['id']?>>
                <font size=3><?php echo $row['title']?></font>
              </a>
            </td>
            <!-- 제목 끝 -->
            <!-- 날짜 -->
            <td align=center height=20 bgcolor=white>
              <font size=3><?php echo $row['date']?></font>
            </td>
            <td align=center height=20 bgcolor=white>
              <font size=3><?php echo $row['view']?></font>
            </td>
          </tr>
          <!-- 행끝 -->
          <?php
}
}
?>
        </table>
      </center>
    </div>
  </div>
  <div id="footer">
    <center>
      <div class="paging">
        <?php echo $paging ?>
      </div>
      <br>
      <div class="searchBox">
        <form action="List_Admin.php" method="get">
          <select name="searchColumn">
            <option <?php echo $searchColumn=='title'?'selected="selected"':null?> value="title">제목</option>
          </select>
          <input type="text" name="searchText" required value="<?php echo isset($searchText)?$searchText:null?>">
          <button type="submit">검색</button>
        </form>
      </div>
      <a href="List_Admin.php"><img src="https://user-images.githubusercontent.com/33346331/77515966-dbdfb680-6ebc-11ea-9f72-344d2b6cfed3.png" width="150px" height="150px" alt="샘플 로고"></a><br>
    </center>
  </div>
</body>

</html>
