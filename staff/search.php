<?php
    session_start();
    if(!isset($_SESSION['staffid']))
    {
      die("无权访问");
    }
    include_once('../common/connect.php');
    //查询员工信息
    $sql1 = "SELECT * FROM staff where sid =".$_SESSION['staffid'];
    $row1=$conn->query($sql1);
    $ro1 = $row1->fetch_assoc();
    $location=$ro1["location"];
    include_once('../common/connloca.php');
    $sql="SELECT express_num FROM express_info where location='$location'";
    $rows=$con->query($sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>欢迎登录</title>
	<meta charset="UTF-8">
    <meta name="keywords" content="keyword1,keyword2,keyword3">
    <meta name="description" content="this is my page">
    <meta name="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/common1.css">
  </head>
  
  <body>
    <div id="header">
        <div id="title">欢迎登录</div>
        <ul id="na">
          <li><a href="search.php" style="background-color: #ffb100; color: white">查询</a></li>
          <li><a href="find.php">揽件</a></li>
          <li><a href="./update.php">更新</a></li>
          <li><a href="./receive.php">接收</a></li>
          <li><a href="./send.php">派送</a></li>
          <li><a href="./accept.php">签收</a></li>
          <li><a href="./login.php">注销</a></li>
        </ul>
      </div>
    <div id="banner">	
        <table width="100%" border="0" cellspacing="0" cellpadding="7" style="table-layout: fixed">
	      <?php
            $num=$rows->num_rows;
            if($num>0)
            {
                while($row=$rows->fetch_row())
                {
                   echo "<tr><td>".$row[0]."订单未处理</td></tr>";
                }
            }else{
                   echo "<tr><td>没有订单在库中！</td></tr>";
            }
        ?> 
        </table>
    </div>
  </body>
</html>
