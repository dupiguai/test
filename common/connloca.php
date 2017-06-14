<?php
    $servername = "localhost";
    $username = "root";
    $password = "g5t7w6Z21285@";
    $dbname = "express_location";
    // 创建连接
    $con = new mysqli($servername, $username, $password,$dbname);
    // 检测连接
    if ($con->connect_error) {
        die("$ordernumber"."连接失败: " . $con->connect_error);
    } 
    mysqli_query($con,'set names utf8'); 
?>