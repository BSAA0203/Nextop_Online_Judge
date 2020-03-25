<?php include "../inc/dbinfo.inc";?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
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

$sql = 'SELECT count(*) as cnt from account_info' . $searchSql;
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$allPost = $row['cnt'];

if(empty($allPost)) {
  $emptyData = '<tr><td class="textCenter" colspan="5" bgcolor=white align=center>
  <font size=3><strong>해당 회원은 존재하지 않습니다.</strong></font></td></tr>';
}

$sql = 'SELECT * from account_info '.$searchSql.'order by memberSeq';
$res = $mysqli->query($sql);
?>
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
            <td align="left">
              <a href=List_Admin.php><strong>
                  <font size=3>[메인 게시판으로]</font>
                </strong></a></td>
        </table>
      </center><br>
      <center>
        <form action="Mlevel.php" method="get">
          <select name="searchColumn">
            <option <?php echo $searchColumn=='id'?'selected="selected"':null?> value="id">아이디</option>
            <option <?php echo $searchColumn=='name'?'selected="selected"':null?> value="name">이름</option>
          </select>
          <input type="text" name="searchText" required value="<?php echo isset($searchText)?$searchText:null?>">
          <button type="submit">검색</button>
        </form><br>

        <table width=1200 border=0 cellpadding=2 cellspacing=1 bgcolor=#777777>

          <tr height=20 bgcolor=#999999>
            <td width=120 align=center>
              <b>
                <font color=white font size=4>아이디</font>
              </b>
            </td>
            <td width=120 align=center>
              <b>
                <font color=white font size=4>이름</font>
              </b>
            </td>
            <td width=120 align=center>
              <b>
                <font color=white font size=4>레벨</font>
              </b>
            </td>
            <td width=350 align=center>
              <b>
                <font color=white font size=4>레벨 선택</font>
              </b>
            </td>
          </tr>

          <?php
if(isset($emptyData)) {
  echo $emptyData;
}
else {
  while($row = mysqli_fetch_array($res))
  {
    if(strpos($row['name'],"어드민")!==false){
      continue;
    }
    else{
?>
          <tr>
            <td align=center height=20 bgcolor=white>
              <font size=4><?php echo $row['id']?></font>
            </td>
            <td align=center height=20 bgcolor=white>
              <font size=4><?php echo $row['name']?></font>
            </td>
            <td align=center height=20 bgcolor=white>
              <font size=4><?php echo $row['level']?></font>
            </td>
            <td align=center height=20 bgcolor=white>
              <form action="Mlevel_ch.php?id=<?php echo $row['id']?>" method='post' style="inline-block">
                <select name="list">
                  <option value=0>0</option>
                  <option value=1>1</option>
                  <option value=2>2</option>
                </select>
                <input type="submit" value="변경" />
              </form>
            </td>
          </tr>
          <!-- 행끝 -->
          <?php
}
}
}
?>
        </table>
        <a href="Mlevel.php"><img src="https://user-images.githubusercontent.com/33346331/77515966-dbdfb680-6ebc-11ea-9f72-344d2b6cfed3.png" width="150px" height="150px" alt="샘플 로고">/a><br>
      </center>
</body>

</html>
