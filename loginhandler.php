<?php
require_once 'Dao.php';
session_start();

$email=$pass="";
$_SESSION['valid'] = true;

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$email = test_input($_POST['Email']);
	$email = validate_email($email);
	$pass = test_input($_POST["password"]);
	$pass = validate_password($pass);
}

function validate_password($data){
		if(!empty($data)){
			if(preg_match("/^.*(?=,{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $data)===0){
				return $data;
			}
			else{
				$_SESSION['passwordErr'] = "Password should contain atlease 8 characher, atlease one lower case letter,
					one upper case letter and one digit";
				$_SESSION['valid'] = false;
			}
		}
		else{
			$_SESSION['passwordErr'] ="Please enter password";
			$_SESSION['valid'] = false;
		}
}


function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function validate_email($data){
	if(!empty($data)){
  	if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$data)){
		if(exist_email($data) > 0){
		return $data;
		}else{
			$_SESSION['email_doesnot'] = "Email doesnot found in database.";
			$_SESSION['valid'] = false;
		}
		}
			else{
				$_SESSION['emailErr'] = "Enter valid e-mail!";
				$_SESSION['valid'] =false;
		}
	}
		else{
		$_SESSION['emailErr'] = "Enter your e-mail address!";
	  $_SESSION['valid'] =false;
	}
}

function exist_email($eml){
		$dao1 = new Dao();
		$Email = $dao1->getUser($eml);
		return $Email;
}


function exist_account($eml, $passWord) {
 $dao1 = new Dao();
 $passWord = hash("sha256", $passWord);  // password encryption
 $Email = $dao1->verify_Password($eml, $passWord);
 return $Email;
}

if($_SESSION['valid']){
	if(exist_account($email, $pass) > 0){
		$_SESSION['loggedIn'] = true;
		$_SESSION['username'] = $email;
		header('Location: homepage.php');
	}
	else{
		if(!isset($_SESSION['passwordErr'])){
	 		$_SESSION['passwordErr']="Please enter correct password";
	 		$_SESSION['formInput'] =$_POST;
	 		header('Location: index.php');
	 }

	}
}
else{
	header('Location: index.php');
}
exit;

?>
