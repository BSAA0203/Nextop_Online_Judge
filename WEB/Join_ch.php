<?php include "../inc/dbinfo.inc";?>
<?php
$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

$id=$_POST['id'];
$password=$_POST['pw'];
$password2=$_POST['pwcheck'];
$name=$_POST['name'];
$email=$_POST['email'];

$sql = "SELECT * FROM account_info WHERE id = '{$id}'";
$res = $mysqli->query($sql);
$sql2 = "SELECT * FROM account_info WHERE name = '{$name}'";
$res2 = $mysqli->query($sql2);
$sql3 = "SELECT * FROM account_info WHERE email = '{$email}'";
$res3 = $mysqli->query($sql3);

if($res->num_rows >= 1){
  echo "<script>alert(\"이미 존재하는 아이디입니다.\");
  history.back();
  </script>";
}
else if($res2->num_rows>=1){
  echo "<script>alert(\"이미 존재하는 닉네임입니다.\");
  history.back();
  </script>";
}
else if($res3->num_rows>=1){
  echo "<script>alert(\"이미 존재하는 메일주소입니다.\");
  history.back();
  </script>";
}
else if($password !== $password2){
  echo "<script>alert(\"비밀번호가 일치하지 않습니다.\");
  history.back();
  </script>";
}
else if(strlen($password)<4){
  echo "<script>alert(\"비밀번호는 최소 4자리 입니다.\");
  history.back();
  </script>";
}

else{
  $pass=password_hash($password, PASSWORD_DEFAULT);

  if(strpos($name,"어드민")!==false){
    $sql = "insert into account_info (id, pw, name,email,level)";
    $sql = $sql. "values('$id','$pass','$name','$email','3')";
  }
  else{
    $sql = "insert into account_info (id, pw, name,email)";
    $sql = $sql. "values('$id','$pass','$name','$email')";
  }

  if($mysqli->query($sql)){
    echo "<script>alert(\"가입 완료!\");
    location.replace('http://13.209.168.153/Login.html');
    </script>";
  }
  else{
    echo "<script>alert(\"가입 실패(입력오류 혹은 서버,DB에 오류가 있습니다.)\");
    history.back();
    </script>";
  }
}
?>
