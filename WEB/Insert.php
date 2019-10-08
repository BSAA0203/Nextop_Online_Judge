<?php include "../inc/dbinfo.inc";?>
<?php
session_start();
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
$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$title= $_POST['title'];
$content= $_POST['content'];
$date = date('Y-m-d');

$sql="insert into board(title, content,date)
values('$title', '$content','$date')";

if($mysqli->query($sql))
{
  echo "<script>alert(\"문제가 등록 되었습니다.\");
  location.replace('http://13.209.168.153/List_Admin.php');
  </script>";
}
else{
  echo "<script>alert(\"문제가 등록 되지 못하였습니다..(입력오류 혹은 서버나 DB에 오류가 있습니다.)\");
  history.back();
  </script>";
}

?>
