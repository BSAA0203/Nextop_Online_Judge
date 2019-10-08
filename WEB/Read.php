<?php include "../inc/dbinfo.inc";?>
<?php
session_start();
if(!isset($_SESSION['name'])) {
  echo "<script>alert('로그인이 필요합니다.');</script>";
  echo "<meta http-equiv='refresh' content='0;url=Login.html'>";
  exit;
}
 $mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

 $id=$_GET['id'];
 $sql="SELECT * FROM board WHERE id='{$id}'";
 $res = $mysqli->query($sql);
 $row = $res->fetch_assoc();

 $sql2="UPDATE board SET view=view+1 WHERE id='{$id}'";
 $mysqli->query($sql2);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <title><?php echo $row['title'] ?></title>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link rel="stylesheet" href="https://codemirror.net/lib/codemirror.css">
  <link rel="stylesheet" href="https://codemirror.net/addon/scroll/simplescrollbars.css"><!-- 스크롤바 -->
  <link rel="stylesheet" href="https://codemirror.net/theme/default.css"><!-- theme -->
  <link rel="stylesheet" href="https://codemirror.net/theme/bespin.css">
  <link rel="stylesheet" href="https://codemirror.net/theme/base16-light.css">
  <script src="https://codemirror.net/lib/codemirror.js"></script><!-- 필수 -->
  <script src="https://codemirror.net/addon/edit/matchbrackets.js"></script><!-- 괄호강조 -->
  <script src="https://codemirror.net/keymap/sublime.js"></script><!-- 괄호강조 -->
  <script src="https://codemirror.net/addon/search/match-highlighter.js"></script><!-- 같은단어 강조 -->
  <script src="https://codemirror.net/mode/xml/xml.js"></script><!-- 필수 -->
  <script src="https://codemirror.net/mode/javascript/javascript.js"></script><!-- 필수 -->
  <script src="https://codemirror.net/mode/css/css.js"></script><!-- 필수 -->
  <script src="https://codemirror.net/mode/htmlmixed/htmlmixed.js"></script><!-- 필수 -->
  <script src="https://codemirror.net/addon/scroll/simplescrollbars.js"></script><!-- 스크롤바 -->
  <script src="https://codemirror.net/mode/clike/clike.js"></script>
  <style type="text/css">
    /* CodeMirror */
    .CodeMirror {
      border-top: 1px solid #eee;
      border-bottom: 1px solid #eee;
      line-height: 1.3;
      height: 100%;
    }

    #preview {
      width: 100%;
      height: 100%;
    }

    .cm-matchhighlight {
      background-color: #376060;
      color: #ffffff !important;
    }

    /* 같은단어강조 */
    .CodeMirror-matchingbracket {
      background-color: #cc0000;
      color: #000000 !important;
    }

    /* 괄호강조 */
    /* CodeMirror */
  </style>
  <style type="text/css">
    #aside_left {
      margin: 0 20px 20px 0;
      padding: 20px;
      width: 15%;
      float: left;
    }

    #section {
      margin-bottom: 20px;
      padding: 20px;
      width: 15%;
      float: left;
    }

    #aside_left_qa {
      margin-bottom: 10px;
      padding: 10px;
      width: 40%;
      float: left;
    }

    #section_code {
      margin-top: 10px;
      margin-left: 100px;
      width: 50%;
      float: left;
    }
  </style>
  <link rel="shortcut icon" href="http://www.nextopedu.co.kr/default/img/_images/favicon.ico">
</head>

<body>
  <table style="float: right">
    <tr>
      <td style="font-size: 15pt"><a href=Movie.php?id=<?php echo $row['id']?>><strong>[영상 보기]</strong></td></a>
      <td style="font-size: 15pt"><a href=Scoring.php?id=<?php echo $row['id']?>><strong>[문제 채점]</strong></td></a>
    </tr>
  </table>

  <table style="float: left">
    <tr>
      <td style="font-size: 15pt"><a href=List.php><strong>[목록으로]</strong></td></a>
    </tr>
  </table>
  <BR><BR>
  <div id="margin" style="margin:15px 50px 50px 15px">

    <div id="aside_left_qa">
      <h2>
        문&nbsp;제
      </h2>
      <br>
      <?php echo $row['content']; ?>
    </div>

    <div id="section_code">
      <h2>
        소&nbsp;스
      </h2>

      <select id='lang' name='lang' onchange='lang_selected()'>
        <option value='0' seelvalue='select' selected>-- 언어 선택 --</option>
        <option value='1'>C</option>
        <option value='2'>C++</option>
        <option value='3'>JAVA</option>
      </select>
      <br><br>

      <script>
        var editor, check = 0;

        function CreateEditor(mode) {
          check++;
          if (check >= 2) {
            editor.toTextArea();
            check = 1;
          }
          // Initialize CodeMirror editor with a nice html5 canvas demo.
          editor = CodeMirror.fromTextArea(document.getElementById('code'), {
            mode: mode, // 문서타입
            lineNumbers: true, // 라인넘버 표시
            scrollbarStyle: "simple", // 스크롤바 스타일
            keyMap: "sublime", // 괄호강조
            matchBrackets: true, // 괄호강조
            theme: "bespin", // 테마
            tabSize: 3, // 탭키 간격
            lineWrapping: true, // 가로 스크롤바 숨김, 너비에 맞게 줄바꿈.
            highlightSelectionMatches: {
              showToken: /\w/,
              annotateScrollbar: true
            }, // 같은단어강조
            extraKeys: {
              "Ctrl-Space": "autocomplete"
            }
          });
        }

        function lang_selected() {
          var obj = document.getElementById('lang');
          var index = obj.selectedIndex;
          var value = obj.options[index].value;
          var text = obj.options[index].text;
          var mode;
          if (obj.selectedIndex == 1) {
            mode = 'text/x-csrc';
            CreateEditor(mode);
          }
          if (obj.selectedIndex == 2) {
            mode = 'text/x-c++src';
            CreateEditor(mode);
          }
          if (obj.selectedIndex == 3) {
            mode = 'text/x-java';
            CreateEditor(mode);
          }
        }
      </script>
      <textarea id="code" name="code" cols="134" rows="59"></textarea>
    </div>
  </div>
  <div id="footer">
    <center>
      <img src="http://www.nextopedu.co.kr/default/img/_images/logo.png" alt="넥스탑정보보안학원">
    </center>
  </div>
</body>

</html>
