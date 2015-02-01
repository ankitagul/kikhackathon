<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<Head>
		<meta charset="utf-8"/>
		<title> Kik the trip </title>
		<style>
		*{
	margin:0;
}
Header{
	background-color:#052238;
	padding:0px;
	height:50px;
	font-family:Arial;
	font-weight:Bold;
	font-size:20px;
	font-margin:;	
	color:f9fdfc;
}


Footer{
	background-color:#052238;
	padding:0px;
	height:30px;
	font-family:Arial;
	font-weight:Bold;
	font-size:10;
	color:f9fdfc;
	position:absolute;
	bottom:0px;
}

body{
	background: url(../../images/Login_Background_00.jpg) no-repeat center center fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	padding:0px;

}

		</style>
	</Head>

	<Body>
		<Header>		

		</Header>
		<div class="wrapper">		
		<div style="text-align: center;">
		<div style="box-sizing: border-box; display: inline-block; width: auto; max-width: 480px; background-color: #FFFFFF; border: 2px solid #0361A8; border-radius: 5px; box-shadow: 0px 0px 8px #0361A8; margin: 80px auto auto;">
		<div style="background: #0361A8; border-radius: 5px 5px 0px 0px; padding: 15px;"><span style="font-family: verdana,arial; color: #D4D4D4; font-size: 1.00em; font-weight:bold;">Enter your login and password</span></div>
		<div style="background: ; padding: 15px">
		<style type="text/css" scoped>
		td { text-align:left; font-family: verdana,arial; color: #064073; font-size: 1.00em; }
		input { border: 1px solid #CCCCCC; border-radius: 5px; color: #666666; display: inline-block; font-size: 1.00em;  padding: 5px; width: 100%; }
		input[type="button"], input[type="reset"], input[type="submit"] { height: auto; width: auto; cursor: pointer; box-shadow: 0px 0px 5px #0361A8; float: right; text-align:right; margin-top: 10px; margin-left:7px;}
		table.center { margin-left:auto; margin-right:auto; }
		.error { font-family: verdana,arial; color: #D41313; font-size: 1.00em; }
		</style>
		<?php echo validation_errors(); ?>
   <?php echo form_open('verifylogin'); ?>
		<table class='center'>
		<tr><td>Login:</td><td><input type="text" id="username" name="username"></td></tr>
		<tr><td>Password:</td><td><input type="password" id="password" name="password"></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" value="Sign In"></td></tr>
		<tr><td colspan=2>&nbsp;</td></tr>
		<tr><td colspan=2>Not member yet? Click <a href="index.php/register/index">here</a> to register.</td></tr>
		</table>
		</form>
		</div></div></div> </div>
		<div><Footer>
			
		<Footer></div>
	</Body>
</html>