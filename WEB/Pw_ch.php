<?php include "../inc/dbinfo.inc";?>
<?php
session_start();
$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$email=$_SESSION['email'];
$pw=$_POST['pw'];
$pass = password_hash($pw, PASSWORD_DEFAULT);

$sql = "UPDATE account_info set pw='{$pass}' where email='{$email}'";

if($mysqli->query($sql)){
   echo "<script>alert(\"비밀번호 변경 완료!\");
   location.replace('http://13.209.168.153/Login.html');
   </script>";
   session_destroy();
   }
   else{
     echo "<script>alert(\"비밀번호를 변경 실패...(입력오류 혹은 서버,DB에 오류가 있습니다.)\");
     history.back();
     </script>";
   }
 ?>
