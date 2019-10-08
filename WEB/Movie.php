<?php include "../inc/dbinfo.inc";?>
<?php
session_start();
if(!isset($_SESSION['name'])) {
  echo "<script>alert('로그인이 필요합니다.');</script>";
  echo "<meta http-equiv='refresh' content='0;url=Login.html'>";
  exit;
}

 if($_SESSION['level']<2){
   echo "<script>alert('레벨2 전용 서비스 입니다.');
   history.back();
   </script>";
 }
 else{
   echo '현재 준비중...';
 }
?>
