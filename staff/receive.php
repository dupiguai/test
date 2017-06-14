<?php
    session_start();
    if(!isset($_SESSION['staffid']))
    {
      die("无权访问");
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>欢迎登录</title>
    <meta charset="UTF-8">
    <meta name="keywords" content="keyword1,keyword2,keyword3">
    <meta name="description" content="this is my page">
    <meta name="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <script src="../js/resolve.js" type="text/javascript"></script>
  </head>
  
  <body>
    <div id="header">
        <div id="title">欢迎登录</div>
        <ul id="na">
          <li><a href="search.php">查询</a></li>
          <li><a href="find.php">揽件</a></li>
          <li><a href="./update.php" >更新</a></li>
          <li><a href="./receive.php" style="background-color: #ffb100; color: white">接收</a></li>
          <li><a href="./send.php">派送</a></li>
          <li><a href="./accept.php">签收</a></li>
          <li><a href="./login.php">注销</a></li>
        </ul>
      </div>
    <div id="banner">   
    <form name="form3" method="post"  >
	<table >
		<tr>
			<td height="30">订单号:
              <input type="file" name="num" id="num" size="20" style="margin: 0 35%">
            </td> 
		</tr>			
	</table>
    </form>
    <input type="button" onclick="javascript:mycheck()" value="接收" id="bt"/> 
    </div>
</body>
</html>