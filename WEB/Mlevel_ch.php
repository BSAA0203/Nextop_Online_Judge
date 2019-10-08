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

$values = $_POST['list'];
$id=$_GET['id'];

$sql="UPDATE account_info SET level='{$values}' WHERE id='{$id}'";

if($mysqli->query($sql)){
  echo "<script>alert(\"회원 레벨 변경 완료!\");
  location.replace('http://13.209.168.153/Mlevel.php');
  </script>";
}
else{
  echo "<script>alert(\"회원 레벨 변경 실패...(현재 서버나 DB에 오류가 있습니다.)\");
  history.back();
  </script>";
}
?>
