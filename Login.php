<?php
	// json으로 된 한국어를 깨지지 않도록 보호함
	header('Content-Type: application/json');

	//header("Cache-Control: no-cache, must-revalidate");

	//php header로 한국어를 깨지지 않도록 보호함
	//header("Content-type: text/html; charset=UTF-8");

	//mysql로 한국어를 깨지지 않도록 보호함 
	//단 mysql이 연결되어 있는 상태에서 이 방법을 쓰도록 한다
	//mysqli_set_charset($conn,"utf-8");

//-----------------mysql 연결--------------------------------//
$conn = mysqli_connect(/*host,id,pw,name*/);
// mysqli_connect(host,id,pw,name)

mysqli_query($conn,"SET NAMES 'utf8'");

if (mysqli_connect_errno())
{
	echo "MySQL 연결 실패 : " . mysqli_connect_error();
}

//-----------------------------------------------------------//


//------------------------ 이메일 & 패스워드-----------------//

$email    = "asdf@naver.com";
$password = "123456789";

//$email = $_POST['email'];
//$email = $_POST['password'];

//-----------------------------------------------------------//

//------------------------ Query구문-------------------------//


$result = mysqli_query($conn,"SELECT * FROM EasterEgg_Users WHERE User_Email = '$email' and User_Password = '$password'");

$count = $result->num_rows;;
$data  = $result->fetch_row;

//---------------------------------------------------------//

//------------------data base에 아이디가 있다면-----------//

if($count==1)
{
	$row = mysqli_fetch_assoc($result);

	$send_email = $row["User_Email"];
	$send_name  = $row["User_Name"];

	//echo $send_email;
	//echo $send_name;

	//echo $send_name;
	//iconv("CP949","UTF-8",$send_name);

	// ------------------------[ O ]
	//$member = array(
	//	'state'=>'TRUE',
	//	'user_name'=> "이름",
	//	'user_email'=>$send_email);

	//echo $user_name;
	// ------------------------[ X ]
	 $member = array(
	 	'state'=>'TRUE',
	 	'user_name'=> $send_name,
	 	'user_email'=>$send_email);

	//$member = my_json_encode($member);
	//var_dump($row);
	echo json_encode($member);

	//$ex = iconv("utf8", "euckr", $send_name);
	//echo "{\"state\":\"TRUE\",\"user_email\":\"$send_email\",\"user_name\":\"$send_name\"}";

	mysqli_close($conn);
	exit;
}
// 없거나 틀리다면
else if(($email!="" || $password!="") && $data[0]!=1)
{
	// 아이디는 있지만 비밀번호가 틀렸을떄
	$state = array('state'=>'FALSE');
	$json = json_encode($state);
	echo $json;
	mysqli_close($conn);
	exit;
}
//-----------------------------------------------------------------------------------------------------------------------------//
?>
