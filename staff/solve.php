<?php
    session_start();
    header('Content-type: text/html; charset=utf-8');
    @$num=$_POST["num"];
    @$action=$_POST["action"];
    if($action=="更新")
    {
        @$destnation=$_POST["destnation"];
    }
    if($num=='.')
    {
        echo "扫描出错，请重新扫描！";
        return ;
    }
    $strlocal='../image/'.$_POST["num"];
    include_once('../php-qr-decoder/lib/QrReader.php');
    $qrcode=new QrReader($strlocal);
    $text=$qrcode->text();
    //获取时间
    date_default_timezone_set("Asia/Hong_Kong");
    $arr=getdate();
    $time=$arr['year']."-".$arr['mon']."-".$arr['mday']." ".$arr['hours'].":".$arr['minutes'].":".$arr['seconds'].":".$arr['weekday'];
    include_once('../common/connect.php');
    //查询员工信息
    $sql1 = "SELECT * FROM staff where sid =".$_SESSION['staffid'];
    $row1=$conn->query($sql1);
    $ro1 = $row1->fetch_assoc();
    $name=$ro1["name"];
    $location=$ro1["location"];
    $express_name=$ro1["express_name"];
    //查询快递是否存在
    $sql2 = "SELECT * FROM express_info where express_num=".$text;
    $row2=$conn->query($sql2);
    $ro2=$row2->fetch_assoc();
    if($action=="揽件")
    {
        $info1="#".$time."#快递已被揽收，".$location."，扫描员".$name;
        $express_name=$ro1["express_name"];
        $sql3 = "INSERT INTO express_info (express_num,express_address,express_name) VALUES ('$text','$info1','$express_name')";
        $finalrow=$conn->query($sql3);
        include_once('../common/connloca.php');
        $sql="INSERT INTO express_info (express_num,location) VALUES ('$text','$location')";
        $rows=$con->query($sql);
        echo "揽件成功";
    }
    else if($action=="更新")
    {
        $info1=$ro2["express_address"]."#".$time."#快递已从".$location."发出,扫描员".$name."。正在发往".$destnation;
        $sql3="UPDATE express_info SET express_address='$info1' where express_num=".$text;
        $finalrow=$conn->query($sql3);
        include_once('../common/connloca.php');
        $sql="DELETE FROM express_info where express_num=".$text;
        $rows=$con->query($sql);
        echo "更新成功";
    }
    else if($action=="接收")
    {
        $info1=$ro2["express_address"]."#".$time."#快递已到".$location.",扫描员".$name;
        $sql3="UPDATE express_info SET express_address='$info1' where express_num=".$text;
        $finalrow=$conn->query($sql3);
        include_once('../common/connloca.php');
        $sql="INSERT INTO express_info (express_num,location) VALUES ('$text','$location')";
        $rows=$con->query($sql);
        echo "接收成功";
    }
    else if($action=="派送")
    {
        $phone=$ro1["phone"];
        $info1=$ro2["express_address"]."#".$time."#快递正在派送中,派送员".$name."，电话：".$phone;
        $sql3="UPDATE express_info SET express_address='$info1' where express_num=".$text;
        $finalrow=$conn->query($sql3);
        include_once('../common/connloca.php');
        $sql="DELETE FROM express_info where express_num=".$text;
        $rows=$con->query($sql);
        echo "正在派送";
    }
    else if($action=="签收")
    {
        $info1=$ro2["express_address"]."#".$time."#快递已签收";
        $sql3="UPDATE express_info SET express_address='$info1' where express_num=".$text;
        $finalrow=$conn->query($sql3);
        echo "签收成功";
    }
?>