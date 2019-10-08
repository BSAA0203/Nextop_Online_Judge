<?php include "../inc/dbinfo.inc";?>
<?php
session_start();
$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$ID = $_POST['user_id'];
$PW = $_POST['user_pass'];

$sql = "SELECT * FROM account_info WHERE id = '{$ID}'";
$res = $mysqli->query($sql);
$row = $res->fetch_array();

if (password_verify($PW, $row['pw'])){
  $_SESSION['name'] = $row['name'];
  $_SESSION['level']=$row['level'];

  if($row['level']==3){
      header('Location: ./List_Admin.php');
    }
    else{
      header('Location: ./List.php');
    }
  }
else{
    echo "<script>alert(\"로그인 실패!\\n아이디 혹은 비밀번호를 잘못 입력하셨습니다.\");
    history.back();
    </script>";
  }
?>
