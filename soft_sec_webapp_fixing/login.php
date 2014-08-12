<?php

define( 'WEB_PAGE_TO_ROOT', '' );

require_once WEB_PAGE_TO_ROOT.'includes/businessPage.inc.php';

startup( array() );

databaseConnect();

if( isset( $_POST[ 'Login' ] ) ) {


	$user = $_POST[ 'username' ];

	$pass = $_POST[ 'password' ];

	$pdo = databaseConnect1();
	$stmt = $pdo->prepare('SELECT password FROM users WHERE user = :user');
	$stmt->execute(array('user' => $user));
	$correct=0;
	foreach ($stmt as $row) {
	    if (password_verify($pass, $row[0])){
	    	$correct = 1;
	    	break;
	    }
	}

	if( $correct == 1 ) {	// Login Successful...

		messagePush( "You have logged in as '".$user."'" );
		login( $user );
                if(isset($_POST['redirect'])){
                    redirect($_POST['redirect']);
                } else {
                    redirect( 'index.php' );
                }

	}

	// Login failed
	messagePush( "Login failed" );
	redirect( 'login.php' );
}

$messagesHtml = messagesPopAllToHtml();

Header( 'Cache-Control: no-cache, must-revalidate');		// HTTP/1.1
Header( 'Content-Type: text/html;charset=utf-8' );		// TODO- proper XHTML headers...
Header( "Expires: Tue, 23 Jun 2009 12:00:00 GMT");		// Date in the past

echo "

<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

	<head>

		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />

		<link rel=\"stylesheet\" type=\"text/css\" href=\"".WEB_PAGE_TO_ROOT."css/main.css\" />

	</head>

	<body>

	<div align=\"center\">

	<br />

	<p><img src=\"".WEB_PAGE_TO_ROOT."images/login_logo.png\" /></p>

	<br />

	<form action=\"login.php\" method=\"post\">

	<fieldset>

			<label for=\"user\">Username</label> <input type=\"text\" class=\"loginInput\" size=\"20\" name=\"username\"><br />


			<label for=\"pass\">Password</label> <input type=\"password\" class=\"loginInput\" AUTOCOMPLETE=\"off\" size=\"20\" name=\"password\"><br />

			<input type=\"hidden\" name=\"redirect\" value=".$_GET['redirect'].">
			<p class=\"submit\"><input type=\"submit\" value=\"Login\" name=\"Login\"></p>

	</fieldset>

	</form>

	<br />

	{$messagesHtml}

	</div> <!-- end align div -->

	</body>

</html>
";

?>

