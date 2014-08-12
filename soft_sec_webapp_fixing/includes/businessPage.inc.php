<?php

if( !defined( 'WEB_PAGE_TO_ROOT' ) ) {

	define( 'System error- WEB_PAGE_TO_ROOT undefined' );
	exit;

}


session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    // last request was more than 15 minutes ago
    logout();
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
    $_SESSION['TOKEN'] = md5(uniqid(rand(), true));
} else if (time() - $_SESSION['CREATED'] > 900) {
    // session started more than 15 minutes ago
    session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}

$_BUSINESS = array();
$_BUSINESS[ 'db_server' ] = 'localhost';
$_BUSINESS[ 'db_database' ] = 'business';
$_BUSINESS[ 'db_user' ] = 'root';
$_BUSINESS[ 'db_password' ] = 'password';

// Declare the $html variable
if(!isset($html)){

	$html = "";

}

// Start session functions --

function &sessionGrab() {

	if( !isset( $_SESSION[ 'business' ] ) ) {

		$_SESSION[ 'business' ] = array();

	}

	return $_SESSION[ 'business' ];
}


function startup( $pActions ) {

	if( in_array( 'authenticated', $pActions ) ) {
		if( !isLoggedIn()){
                        if(array_key_exists( 'redirect', $pActions )) {
                            redirect( WEB_PAGE_TO_ROOT.'login.php?redirect='.$pActions['redirect'] );
                        } else {
                            redirect( WEB_PAGE_TO_ROOT.'login.php');
                        }

		}
	}
}


function login( $pUsername ) {

	$businessSession =& sessionGrab();

    $pdo = databaseConnect1();
	$stmt = $pdo->prepare("SELECT user_id FROM users where user=:uname");
	$stmt->execute(array('uname' => $pUsername));
	$result;
    foreach ($stmt as $row) {
        $result=$row;
        break;
    }

    $businessSession['id'] = $result[0];
	$businessSession['username'] = $pUsername;
    $_SESSION['business'] = $businessSession;
}


function isLoggedIn() {

	$businessSession =& sessionGrab();

	return isset( $businessSession['username'] );

}


function logout() {

	$businessSession =& sessionGrab();

	unset( $token);
	unset( $businessSession['username'] );
    unset( $businessSession['id'] );

    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    	);
	}
    session_destroy();

}


function pageReload() {

	redirect( $_SERVER[ 'PHP_SELF' ] );

}

// -- END

function &grabNewPage() {

	$returnArray = array(
		'title' => 'Super secure and highly userfriendly web App',
		'title_separator' => ' :: ',
		'body' => '',
		'page_id' => '',
		'help_button' => '',
		'source_button' => '',
	);

	return $returnArray;
}

// Start message functions --
function messagePush( $pMessage ) {

	$businessSession =& sessionGrab();

	if( !isset( $businessSession[ 'messages' ] ) ) {

		$businessSession[ 'messages' ] = array();

	}

	$businessSession[ 'messages' ][] = $pMessage;
}



function messagePop() {

	$businessSession =& sessionGrab();

	if( !isset( $businessSession[ 'messages' ] ) || count( $businessSession[ 'messages' ] ) == 0 ) {

		return false;

	}

	return array_shift( $businessSession[ 'messages' ] );
}


function messagesPopAllToHtml() {

	$messagesHtml = '';

	while( $message = messagePop() ) {	// TODO- sharpen!

		$messagesHtml .= "<div class=\"message\">{$message}</div>";

	}

	return $messagesHtml;
}
// --END

function htmlEcho( $pPage ) {

	$menuBlocks = array();

        if(isLoggedIn()){
            $menuBlocks['vulnerabilities'] = array();
            $session= sessionGrab();
            $menuBlocks['vulnerabilities'][] = array( 'id' => 'profile', 'name' => 'Profile', 'url' => 'profile.php');
            $menuBlocks['vulnerabilities'][] = array( 'id' => 'backend', 'name' => 'Add new Article', 'url' => 'backend.php' );
            $menuBlocks['vulnerabilities'][] = array( 'id' => 'test', 'name' => 'Testarea', 'url' => 'designCheck.php' );
            $menuBlocks['logout'] = array();
            $menuBlocks['logout'][] = array( 'id' => 'logout', 'name' => 'Logout', 'url' => 'logout.php' );
        }

	$menuHtml = '<ul>';

	foreach( $menuBlocks as $menuBlock ) {

		$menuBlockHtml = '';

		foreach( $menuBlock as $menuItem ) {

			$selectedClass = ( $menuItem[ 'id' ] == $pPage[ 'page_id' ] ) ? 'selected' : '';

			$fixedUrl = WEB_PAGE_TO_ROOT.$menuItem['url'];

			$menuBlockHtml .= "<li onclick=\"window.location='{$fixedUrl}'\" class=\"{$selectedClass}\"><a href=\"{$fixedUrl}\"><span>{$menuItem['name']}</span></a></li>";

		}

		$menuHtml .= "{$menuBlockHtml}";
	}

        $menuHtml .= '</ul>';
        $city = 'Vienna';
        if(isset($_POST['btnSubmit']))
            $city=filter_var($_POST['txtCity'], FILTER_SANITIZE_STRING);
        $menuHtml.="Get weather for your city:";

        $menuHtml.="

    <form enctype=\"multipart/form-data\" method=\"post\" name=\"userupdate\" onsubmit=\"return validate_form(this)\">

    <input name=\"txtCity\" type=\"text\" size=\"30\">
    <input name=\"btnSubmit\" type=\"submit\" value=\"Submit\" onClick=\"return checkForm();\"><br/>
    </form>";

        $cmd = "Weather report for:".$city.": ".rand(0,40)." °C";
        $menuHtml.= $cmd;

	// Send Headers + main HTML code
	Header( 'Cache-Control: no-cache, must-revalidate');		// HTTP/1.1
	Header( 'Content-Type: text/html;charset=utf-8' );		// TODO- proper XHTML headers...
	Header( "Expires: Tue, 23 Jun 2009 12:00:00 GMT");		// Date in the past

	echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />

		<title>{$pPage['title']}</title>

		<link rel=\"stylesheet\" type=\"text/css\" href=\"".WEB_PAGE_TO_ROOT."css/main.css\" />

	</head>


	<body>

<div id=\"header\">
                	<div class=\"header\">
			<div id=\"logo\">
				<a href=\"index.php\"><img src=\"".WEB_PAGE_TO_ROOT."images/logo.jpg\" alt=\"\" /></a>
			</div>
			{$menuHtml}
	</div>
        </div>

<div id=\"footer\">
                            <div class=\"featured\">
				{$pPage['body']}
                            </div>
</div>

	</body>

</html>";
}

// Database Management --



 $DBMS_errorFunc = 'mysql_error()';

$DBMS_connError = '<div align="center">
		<img src="'.WEB_PAGE_TO_ROOT.'images/logo.png">
		<pre>Unable to connect to the database.<br>'.$DBMS_errorFunc.'<br /><br /></pre>
		Click <a href="'.WEB_PAGE_TO_ROOT.'setup.php">here</a> to setup the database.
		</div>';

function databaseConnect() {

	global $_BUSINESS;
	global $DBMS;
	global $DBMS_connError;

		if( !@mysql_connect( $_BUSINESS[ 'db_server' ], $_BUSINESS[ 'db_user' ], $_BUSINESS[ 'db_password' ] )
		|| !@mysql_select_db( $_BUSINESS[ 'db_database' ] ) ) {
			die( $DBMS_connError );
		}
}
function databaseConnect1() {

        global $_BUSINESS;
        global $DBMS;
        global $DBMS_connError;

        try{
        	$pdo = new PDO('mysql:host='.$_BUSINESS[ 'db_server' ].';dbname='.$_BUSINESS[ 'db_database' ].';charset=utf8', $_BUSINESS[ 'db_user' ], $_BUSINESS[ 'db_password' ]);
       		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	 }catch(PDOException $ex){
		    die('ERROR!!!!!');
		}
}

// -- END


function redirect( $pLocation ) {
	session_commit();
	header( "Location: {$pLocation}" );
	exit;

}


function fetchArticles() {
	$pdo = databaseConnect1();
	$stmt = $pdo->prepare("SELECT headline, created, published, id FROM article");
	$stmt->execute();
	$articles = '<lu>';
	foreach ($stmt as $row) {
	    $curauth = $pdo->prepare("SELECT first_name, last_name FROM users WHERE user_id = :uid");
	    $curauth->execute(array('uid' => $row[2]));
	    foreach ($curauth as $name) {
	    	$articles .= "<li><h3>$row[1]<br /><a href=\"showArticle.php?id=$row[3]&comments=0\">$row[0]</a></h3><p>$name[0] $name[1]</p></li>";
	    }
	}
    $articles .= '</lu>';
    return $articles;
}

function fetchArticle($id, $commentson){


	$pdo = databaseConnect1();
	$stmt = $pdo->prepare("SELECT id, headline, content, created, published FROM article where id=:id");
	$stmt->execute(array('id' => $id));
	$result;
	foreach ($stmt as $res) {
		$result = $res;
		break;
	}

	$stmt = $pdo->prepare("SELECT first_name, last_name FROM users WHERE user_id = :uid");
	$stmt->execute(array('uid' => $result[4]));
	$curauth;
	foreach ($stmt as $res) {
		$curauth = $res;
		break;
	}

	$comments = $pdo->prepare("SELECT user, comment FROM comments WHERE articleid = :id");
	$comments->execute(array('id' => $id));
	$num_comments=0;
	foreach ($stmt as $res) {
		$num_comments++;
	}

	///////////////////////////////////////////////////////////

//    $article = '<div id="body" class="header">';
    $article= "<h3>$result[1]<br />$result[3]</h3><br />$result[2]<br />$curauth[1]";
//    $article.= '</div><div>';

    if($commentson == 1)
        $article.= "<p>Leave a comment below:</p>";

    if($num_comments > 0) {

    	foreach ($comments as $row) {
    		$article.="<p>$row[0]<br />$row[1]</p>";
    	}

    } else {
        $article.="<p>There are no comments yet!</p>";
    }

 //   $article.='</div></br>';
    if($commentson == 1)
    $article.="
<div class=\"featured\">
		<form method=\"post\" name=\"guestform\">
		Name *<input name=\"txtName\" type=\"text\" size=\"30\" maxlength=\"10\">
                Message *
		<textarea name=\"mtxMessage\" cols=\"50\" rows=\"3\" maxlength=\"50\"></textarea>
		<input name=\"btnSign\" type=\"submit\" value=\"Sign Guestbook\">
		</form>
    ";

    return $article;
}

function postComment($message, $name, $id) {
    $pdo = databaseConnect1();
    $stmt = $pdo->prepare("INSERT INTO comments (comment,user,articleid) VALUES (:msg, :name, :id)");
	$stmt->execute(array('msg' => $message, 'name' => $name, 'id' => $id));
}

function getAuthors() {
    $pdo = databaseConnect1();
    $stmt = $pdo->prepare("SELECT user_id, user FROM users");
	$stmt->execute();

    $users = "<select name='user'>";

    foreach($stmt as $row){
        $users .= "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
    }

    $users .= '</select>';
    return $users;
}
?>
