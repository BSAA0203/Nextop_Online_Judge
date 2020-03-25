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

 $id=$_GET['id'];
 $sql="SELECT * FROM board WHERE id='{$id}'";
 $res = $mysqli->query($sql);
 $row = $res->fetch_assoc();

 $sql2="UPDATE board SET view=view+1 WHERE id='{$id}'";
 $mysqli->query($sql2);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <title><?php echo $row['title'] ?></title>
</head>

<body>

  <table style="float: right">
    <tr>
      <td style="font-size: 15pt"><a href=RE_Write.php?id=<?php echo $row['id']?>><strong>[수정]</strong></td></a>
      <td style="font-size: 15pt"><a href=Delete.php?id=<?php echo $row['id']?>><strong>[삭제]</strong></td></a>
    </tr>
  </table>

  <table style="float: left">
    <tr>
      <td style="font-size: 15pt"><a href=List_Admin.php><strong>[목록으로]</strong></td></a>
    </tr>
  </table>
  <BR><BR>
  <div id="margin" style="margin:15px 50px 50px 15px">

    <h2>
      문&nbsp;제
    </h2>
    <br>
    <?php echo $row['content']; ?>
  </div>

  <div id="footer">
    <center>
    <img src="https://user-images.githubusercontent.com/33346331/77515966-dbdfb680-6ebc-11ea-9f72-344d2b6cfed3.png" width="150px" height="150px" alt="샘플 로고">
    </center>
  </div>
</body>

</html>
