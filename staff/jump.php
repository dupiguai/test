<?php
    session_start();
    $time=time();
    $private_key='-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC2dWtjFMHKriJb56w/WNOcICDQSH74691pqfwibPDkzdV7xRfN
kwiS0UV+Jy2htyguqsLjRXTaECoMhPoXq1RCXZepnIW9gj+0UcJ2nZ0PKUfVQvd6
1tSAZRGhs/YX18f4qOQnH/Dhz1Jvh99R6MEBapCaklMkStrhGvyK46QRgQIDAQAB
AoGADF6bgCUZGj+B7s8e+1BvUCdRci1oBkIfSZmPkVnnXuuhbHmpKnOsYh+z4WCQ
lGURYVCMU9ISoPH1l9GwDsi7toLE2YiCiqlkDX2vabB4YEwZbnX+SObZq+sMRRAS
6Bv2pFQV4OIiTKYr0pIjjJPH4dBITzhKUl/m2aBXDCzD8y0CQQDgQzlwrvjYVQZF
C76tl38O38QbcpE4bV9D2kqf19jYlFNz4oJt6IuWaWaDZjQP5DMXLOHMyrbbn8/C
lSdEmztHAkEA0Eev4Hgl/FP0w1AitjnzpBLCTrbugjG67ie4FrZ21j/JPAYjr7eg
HrlmPy3/hUn1jfsOpYX4HCGvYe4DsmMg9wJAOj6bY32+GYlzmGkle7ZWBInvR+Wo
e8xEKr4+FWec5RsY1Yclst/rqQP04PmhWeM9ta4tct/PQBkwf2v3h+T9LwJBAMnh
Ik1dx9va+LyzmOGuLEUVVbd8QpR5ZWnfn+SL+YXTj9cZUE/KmW4OYFfO2wQz2spC
1UCFKScDU36FeJnY0aMCQEoIxMGeAjJpc9CUufO9/WQZ1aMRek7VZIRVKquTpGEk
wvmnrsOy3RTN9uoiHEvT3289Dino0KDjqB4mQlJKg0M=
-----END RSA PRIVATE KEY-----';
    $pi_key=openssl_pkey_get_private($private_key);
    if(!isset($_SESSION['staffid'])){
        header('Content-type: text/html; charset=utf-8');
        @$ID=$_POST["user"];
        @$psd=$_POST["password"];
        @$psc=$_POST["passcode"];
        @$tsp=$_POST["timestamp"];
        openssl_private_decrypt(base64_decode($ID), $decryptedID, $pi_key);
        openssl_private_decrypt(base64_decode($psd), $decryptedpsd, $pi_key);
        openssl_private_decrypt(base64_decode($psc), $decryptedpsc, $pi_key);
        openssl_private_decrypt(base64_decode($tsp), $decryptedtsp, $pi_key);
        $decryptedtsp=htmlspecialchars(base64_decode($decryptedtsp));
        $decryptedID=htmlspecialchars($decryptedID);
        $decryptedpsd=htmlspecialchars($decryptedpsd);
        $decryptedpsc=htmlspecialchars($decryptedpsc);
        $timelimt=$time-$decryptedtsp;
        include_once('../common/connect.php');
        $sql = "SELECT sid FROM staff where id = ? and password = ? limit 1";
        $mysqli_stmt = $conn->prepare($sql);
     
        $mysqli_stmt->bind_param('ii',$decryptedID,$decryptedpsd);
        $mysqli_stmt->bind_result($sid);
        $mysqli_stmt->execute();
        $row=0;
        while($mysqli_stmt->fetch())
        {
            $row=$sid;
        }
        //$rows=$conn->query($sql);
        if(!isset($_SESSION['time']))
        {
            $_SESSION['time']=$decryptedtsp;
        }else{
            if($_SESSION['time']==$decryptedtsp)
            {
                exit('连接超时！');
            }
            else{
                $_SESSION['time']=$decryptedtsp;
            }
        }
        if($timelimt>5)
        {
            exit('连接超时！');
        }
        else if(!isset($_SESSION['authcode']))
        {
            exit('验证码错误!');
        }
        else if($decryptedpsc!=md5($_SESSION['authcode']))
        {
            session_destroy();
            exit('验证码错误!');
        }
        else if($row!=0){
        //登录成功
        $_SESSION['staffid'] = $row;//$result["sid"];
        } else {
            session_destroy();
          exit('登录失败!账号或密码错误!');
           }
        $mysqli_stmt->close();
        $conn->close();
    }else{
        header("Location:http://localhost/express/staff/common.php");  
    }
?>