<?php
/*
Handler for signup page
*/
require_once 'Dao.php';
session_start();
$email = $password = $password2 = "";
$_SESSION['valid'] = true;
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$email = sanitize($_POST['email']);
	$email = validating_email($email);
	$password = sanitize($_POST["password"]);
  $password = validating_password($password);
	$password2 = sanitize($_POST["password2"]);
	$password2 = validating_password2($password, $password2);
}
function sanitize($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
function validating_email($data){
        if(!empty($data)){
                if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $data)){
								if(exist_email($data) <= 0){
								return $data;
                }
								else{
                        $_SESSION['email_used'] = "This email is already in use";
                        $_SESSION['valid'] = false;
}
}
								else{
                        $_SESSION['emailErr'] = "Email is not valid";
                        $_SESSION['valid'] = false;
                }
        }
				else{
                $_SESSION['emailErr'] = "Email is required";
                $_SESSION['valid'] = false;
        }
}
/*
Validating password
*/
function validating_password($data){
	if(!empty($data)){
		if(preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/", $data) === 0){
			$_SESSION['passwordErr'] = "Password must be of length 8 and include capital letter,
			small letter and number";
			$_SESSION['valid'] = false;
		}else{
			return $data;
		}
	}
	else{
		$_SESSION['passwordErr'] ="Please enter password";
		$_SESSION['valid'] = false;
	}
}
/*
Checks if the password and repeat password matches or not
*/
function validating_password2($data, $redata){
	if(!empty($data) && !empty($redata) && ($data === $redata)){
		return $redata;
	}
	if (!empty($data) && !empty($redata) && ($data != $redata)){
		$_SESSION['passwordErr'] = "Password and repeat-password do not match";
		$_SESSION['valid'] = false;
	}
	if(!empty($data) && empty($redata)){
		$_SESSION['passwordErr'] = "Please enter and confirm password";
		$_SESSION['valid'] = false;
	}
}
function exist_email($eml){
		$dao1 = new Dao();
		$Email = $dao1->getUser($eml);
		return $Email;
}
if($_SESSION['valid'])
{

		$dao = new Dao();
		$password= hash("sha256", $password);  // password encryption
	$password2= hash("sha256", $password2);  // password encryption
		$dao->createUser($email,$password, $password2);
		header('Location: login.php');
	}
else{
		$_SESSION['formInput'] = $_POST;
		header('Location: signup.php');
	}
	exit;
	?>
