<?php
    $servername = "localhost";
    $username = "root";
    $password = "g5t7w6Z21285@";
    $dbname = "express";
    // 创建连接
    $conn = new mysqli($servername, $username, $password,$dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("$ordernumber"."连接失败: " . $conn->connect_error);
    } 
    mysqli_query($conn,'set names utf8'); 
?>