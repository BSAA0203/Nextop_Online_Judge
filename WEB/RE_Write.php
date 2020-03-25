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

 $sql="SELECT * FROM board WHERE id='{$id}'";
 $res = $mysqli->query($sql);
 $row = $res->fetch_assoc();
 ?>
 <!DOCTYPE html>
 <html lang="ko">

 <head>
   <meta charset="utf-8">
  <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(nicEditors.allTextAreas);
  </script>

  <title>문제 등록</title>
  <style>
    td {
      font-size: 9pt;
    }

    A:link {
      font: 9pt;
      color: black;
      text-decoration: none;
      font-family: 굴림;
      font-size: 9pt;
    }

    A:visited {
      text-decoration: none;
      color: black;
      font-size: 9pt;
    }

    A:hover {
      text-decoration: underline;
      color: black;
      font-size: 9pt;
    }

    html,
    body {
      height: 90%
    }

    body {
      margin: 0
    }

    #body {
      min-height: 100%
    }

    #content {
      padding-bottom: 1.9em
    }

    #foot {
      margin-top: -1.9em;
      height: 1.9em
    }

    table {
      border: 1px solid #444444;
    }
  </style>
</head>

<body topmargin=0 leftmargin=0 text=#464646>
  <div id="body">
    <div id="content">
      <center>
        <BR>

        <form action=RE_Insert.php?id=<?php echo $row['id']?> method=post>
          <table width='70%' border=0 cellpadding=2 cellspacing=1 bgcolor=#777777>
            <tr>
              <td height=20 align=center bgcolor=#999999>
                <font color=white size=3><strong>글 수정</strong></font>
              </td>
            </tr>
            <!-- 입력 부분 -->
          </table>
          <table width='70%'>
            <tr>
              <td width=60 align=center><strong>제목</strong></td>
              <td align=left>
                <INPUT type=text name=title size=40 maxlength=35 value="<?php echo $row['title'] ?>" required>
              </td>
            </tr>
            <tr>
              <td width=60 align=center><strong>내용</strong></td>
              <td align=left>
                <TEXTAREA name=content style='width:98%; height:700px;'>
                <?php echo $row['content'] ?>
              </TEXTAREA>
              </td>
            </tr>
            <tr>
              <td colspan=10 align=center>
                <INPUT type=submit value="문제 업로드">
                &nbsp;&nbsp;
                <INPUT type=button value="되돌아가기" onclick="history.back()">
              </td>
            </tr>
          </table>
          <script type="text/javascript">
            //<![CDATA[
            /*bkLib.onDomLoaded(function() {
            nicEditors.editors.push(
            new nicEditor().panelInstance(
            document.getElementById('myNicEditor')
            )
            );
            });*/
            //]]>
            add_filter('wp_kses_allowed_html', 'my_allowed_html', 10, 2);

            function my_allowed_html($tags, $context) {
              $tags['span'] = array(
                'style' => array(),
                'dir' => true,
                'align' => true,
                'lang' => true,
                'xml:lang' => true,
                'class' => array(),
              );
              return $tags;
            }
          </script>
          <!-- 입력 부분 끝 -->
          </table>
        </form>
    </div>
  </div>
  <div id="foot">
    <center>
    <img src="https://user-images.githubusercontent.com/33346331/77515966-dbdfb680-6ebc-11ea-9f72-344d2b6cfed3.png" width="150px" height="150px" alt="샘플 로고">
    </center>
    </center>
  </div>
</body>

</html>
