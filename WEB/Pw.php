<?php session_start();

if(!isset($_SESSION['email'])) {
  echo "<script>alert('이메일 인증이 필요합니다.');</script>";
  echo "<meta http-equiv='refresh' content='0;url=Search.html'>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <title>비밀번호 수정</title>
</head>
<div class="container clearfix width-full text-center">
<img src="https://user-images.githubusercontent.com/33346331/77515966-dbdfb680-6ebc-11ea-9f72-344d2b6cfed3.png" width="320px" height="300px" alt="샘플 로고">
</div>

<body>
  <form method="post" data-ajax="false" action="Pw_ch.php">
    <fieldset>
      <legend><b>
          <font size=6>비밀번호 수정</font>
        </b></legend><br>
      새로운 비밀번호 : <input type="password" name="pw" placeholder="새로 바꿀 비밀번호를 입력" autofocus required>
    </fieldset>
    <br>
    <center>
      <input type="submit" style="width:100pt;height:20pt;font-weight:bold;" value="확인">
      &nbsp<a href="Search.html"><input type="button" style="width:100pt;height:20pt;font-weight:bold" value="취소"></a>
    </center>
  </form>
</body>

</html>
