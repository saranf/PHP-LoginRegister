<?php

$conn = mysqli_connect(/*host,id,pw,name*/);
//mysqli_query($conn,"set names utf8");

if (mysqli_connect_errno())
{
	echo "MySQL 연결 실패 : " . mysqli_connect_error();
}
// 이름 이메일 패스워드(가입 요소)
$name	  = $_POST["name"];
$email    = $_POST["email"];
$password = $_POST["password"];

//$name	  = "NAME";
//$email    = "abcdefff@naver.com";
//$password = "123456789";

mysqli_set_charset($conn, "utf8");

$today = date("Ymd");
// RESULT
// FALSE or TRUE
if(!mysqli_query($conn,"INSERT INTO EasterEgg_Users (User_Name,User_Email,User_Password,User_Date) VALUES ('$name','$email','$password','$today')"))
{
	$state = array('state'=>'FALSE');
	$json = json_encode($state);
	echo $json;
	mysqli_close($conn);
	exit;
}
else
{
	$state = array('state'=>'TRUE');
	$json = json_encode($state);
	echo $json;
	mysqli_close($conn);
	exit;
}
?>