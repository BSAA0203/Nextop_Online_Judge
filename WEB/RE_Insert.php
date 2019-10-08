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

$id=$_GET['id'];
$title= $_POST['title'];
$content= $_POST['content'];
$date = date('Y-m-d');

$sql="UPDATE board SET title='{$title}', content='{$content}', date='{$date}' WHERE id='{$id}'";

if($mysqli->query($sql))
{
  echo "<script>alert(\"문제가 수정 되었습니다.\");
  location.replace('http://13.209.168.153/Read_Admin.php?id=$id');
  </script>";
}
else{
  echo "<script>alert(\"문제가 수정 되지 못하였습니다..\");
  history.back();
  </script>";
}

?>
