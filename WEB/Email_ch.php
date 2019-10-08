<?php include "../inc/dbinfo.inc";?>
<?php
session_start();
$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$email=$_POST['email'];

$sql = "SELECT * FROM account_info WHERE email = '{$email}'";
$res = $mysqli->query($sql);
$row = $res->fetch_array();

if(!$row){
   echo "<script>alert(\"없는 계정입니다.\");
   location.replace('http://13.209.168.153/Search.html');
   </script>";
 }
 else{
   $_SESSION['email']=$email;
   echo "<script>alert(\"인증 완료!\\n비밀번호를 변경합니다.\");
   location.replace('http://13.209.168.153/Pw.php');
   </script>";
   }
 ?>
