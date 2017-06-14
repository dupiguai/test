<?php
    session_start();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <meta name="description" content="slick Login">
    <meta name="author" content="Webdesigntuts+">
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="http://www.modernizr.com/downloads/modernizr-latest.js"></script>
    <script type="text/javascript" src="placeholder.js"></script>
    <script src="../js/md5.js" type="text/javascript"></script>
    <script src="../js/jbase64.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="../jsencrypt-master/bin/jsencrypt.min.js"></script>
</head>
 
<body>
    <form name="form2" method="post" id="slick-login" >
        <label for="username">username</label><input type="text" name="user" id="user" class="placeholder" placeholder="123123">
        <label for="password">password</label><input type="password" name="password" id="passowrd" class="placeholder" placeholder="password">
		<input type="text" name="passcode" id="passcode" class="placeholder" placeholder="验证码"/>
        <a href="#" class="change" onclick="changeVer()">点击刷新</a><br/>
        <img src="code.php" name="KeyImg" id="KeyImg" ">         
        <textarea id="pubkey" rows="15" cols="65" style="display:none">-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC2dWtjFMHKriJb56w/WNOcICDQ
SH74691pqfwibPDkzdV7xRfNkwiS0UV+Jy2htyguqsLjRXTaECoMhPoXq1RCXZep
nIW9gj+0UcJ2nZ0PKUfVQvd61tSAZRGhs/YX18f4qOQnH/Dhz1Jvh99R6MEBapCa
klMkStrhGvyK46QRgQIDAQAB
-----END PUBLIC KEY-----</textarea>
    </form>
    <input type="submit" name="submit" value="登录" onClick="return mycheck();" id="but">
    <script type="text/javascript">
		//刷新验证码
	function changeVer(){
		document.getElementById("KeyImg").src="code.php?tmp="+Math.random();
	}
	</script>
    <script>
    function mycheck(){
        if(form2.user.value==""){
            alert("ID不能为空");form2.user.focus();return false;
        }
        else if(form2.password.value==""){
            alert("密码不能为空");form2.password.focus();return false;
        }
		else if(form2.passcode.value==""){
            alert("验证码不能为空");form2.passcode.focus();return false;
        }
        else{
            creatRequest();
        }
    }
    var http_request=false;
    function creatRequest(){
        var timestamp=Date.parse(new Date())/1000;
        timestamp=BASE64.encoder(timestamp);
        var usr=form2.user.value;
        var psw=form2.password.value;
        var psc=form2.passcode.value;
        var md5usr=hex_md5(usr);
        var md5psw=hex_md5(psw);
        var md5psc=hex_md5(psc);
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey($('#pubkey').val());
        var encryptedusr = encrypt.encrypt(md5usr);
        var encryptedpsw = encrypt.encrypt(md5psw);
        var encryptedpsc = encrypt.encrypt(md5psc);
        var encryptedtsp = encrypt.encrypt(timestamp);
        http_request=false;
        if(window.XMLHttpRequest){
            http_request=new XMLHttpRequest();
            if(http_request.overrideMimeType){
                http_request.overrideMimeType("text/xml");
            }
        }else if(window.ActiveXObject){
            try{
                http_request=new ActiveXObject("Msxml2.XMLHTTP");
            }catch(e){
                try{
                    http_request=new ActiveXObject("Microsoft.XMLHTTP");
                }catch(e){}
            }
        }
        if(!http_request){
            alert("不能创建XMLHTTP实例");
            return false;
        }
        http_request.onreadystatechange=alertContents;
        http_request.open("POST","jump.php",false);
        http_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        encryptedusr=encodeURIComponent(encryptedusr);
        encryptedpsw=encodeURIComponent(encryptedpsw);
        encryptedpsc=encodeURIComponent(encryptedpsc);
        encryptedtsp=encodeURIComponent(encryptedtsp);
        var send_string="user="+encryptedusr+"&password="+encryptedpsw+"&passcode="+encryptedpsc+"&timestamp="+encryptedtsp;
        //alert(send_string); 
        //return; 
        http_request.send(send_string);
    }
    function alertContents(){
        if(http_request.readyState==4){
            if(http_request.status==200){
                if(http_request.responseText){
                    alert(http_request.responseText);
                    changeVer();
                }else{
                    window.location.href="http://localhost/express/staff/jump.php";
                }
            }else{
            alert("你的请求出现错误");
            }
        }
    }
    </script>
</body>
 
</html>
