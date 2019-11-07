<?php
session_start();
?>

<html>
<head>
	<center>
	<?php require_once("header.php");
  ?>
</center>
<link rel="stylesheet" href="signup.css">
</head>
<body>
<Center>
<span>  <h1>Sign-Up Page</h1> </span>
<p> Please fill in this form to create an account </P>

<form method="post" action="signuphandler.php">
<div>  <label for="email">  <div> <b>Email</b> </div> </label>
<div>
<input type="text" placeholder="Enter Email" name="email"
value="<?php echo isset($_SESSION['formInput']) ? $_SESSION['formInput']['email'] : ''; ?>"
</div>
</div>
<?php
	if(isset($_SESSION['emailErr'])) {
echo "<div id ='error'>" . $_SESSION['emailErr'] . "</div>";
}
	unset($_SESSION['emailErr']);

	if(isset($_SESSION['email_used'])) {
echo "<div id ='error'>" . $_SESSION['email_used'] . "</div>";
}
	unset($_SESSION['email_used']);
?>


<div>
<label for="password"> <div> <b>Password</b> </div> </label>
<div> <input type="password" placeholder="Enter Password" name="password" >
</div>
</div>
<?php
if(isset($_SESSION['passwordErr'])) {
echo "<div id ='error'>" . $_SESSION['passwordErr'] . "</div>";
}
unset($_SESSION['passwordErr']);
?>

<div>
<label for="psw-repeat"> <div> <b>Re-enter Password</b> </div></label>

<div><input type="password" placeholder="Confirm Password" name="password2" >
</div>
</div>
<?php
if(isset($_SESSION['password2Err'])) {
echo "<div id ='error'>" . $_SESSION['password2Err'] . "</div>";
}
unset($_SESSION['password2Err']);
?>
<div><input type="submit" value="Sign-up"></div>

<?php
if(isset($_SESSION['message'])){
echo "<div id ='error'>" . $_SESSION['message'] . "</div>";
}
unset($_SESSION['message']);
unset($_SESSION['valid']);
unset($_SESSION['formInput']);
	?>

</form>
</Center>
<?php
require_once 'footer.php';
 ?>
