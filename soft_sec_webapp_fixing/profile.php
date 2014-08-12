<?php

define( 'WEB_PAGE_TO_ROOT', '' );

require_once WEB_PAGE_TO_ROOT.'includes/businessPage.inc.php';
$pw_hash="";
global $_SESSION;
startup( array( 'authenticated', 'redirect'=>'profile.php' ) );

	if (isset($_POST['btnSubmit']) && $_POST['CSRFToken']==$_SESSION['TOKEN']) {


                $pdo = databaseConnect1();

                $stmt = $pdo->prepare('SELECT password FROM users WHERE user_id = :user');
                $stmt->execute(array('user' => sessionGrab()['id']));
                $correct=0;
                foreach ($stmt as $row) {
                    if (password_verify($_POST['txtOldPass'], $row[0])){
                        $correct = 1;
                        break;
                    }
                }

                if( $correct == 1 ) {   // Login Successful...


                    $stmt = $pdo->prepare("SELECT first_name, last_name, user, password FROM users WHERE user_id = :uid");
                    $stmt->execute(array('uid' => sessionGrab()['id']));
                    $num_results=0;
                    foreach ($stmt as $row) {
                        $num_results++;
                    }

                    $pw_hash = password_hash($_POST['txtPass'], PASSWORD_DEFAULT);
                    if($num_results > 0) {
                        $stmt = $pdo->prepare("UPDATE users SET first_name=:txtFirst, last_name=:txtLast, user=:txtUser, password=:password WHERE user_id = :uid");
                        $stmt->execute(array('txtFirst' => $_POST['txtFirst'],'txtLast' => $_POST['txtLast'],'txtUser' => $_POST['txtUser'],'password' => $pw_hash,'uid' => sessionGrab()['id']));
                    } else {
                        $stmt = "INSERT INTO users (first_name,last_name,user,password) VALUES (first_name=:txtFirst, last_name=:txtLast, user=:txtUser, password=:password)";
                        $stmt->execute(array('txtFirst' => $_POST['txtFirst'], 'txtLast' => $_POST['txtLast'], 'txtUser' => $_POST['txtUser'], 'password' => $pw_hash));
                    }
                }
		}
$profile = "";
$pdo = databaseConnect1();
$stmt = $pdo->prepare("SELECT first_name, last_name, user, password FROM users WHERE user_id = :uid");
$stmt->execute(array('uid' => sessionGrab()['id']));

foreach ($stmt as $row) {
    $profile=$row;// do something with $row
    break;
}

$page = grabNewPage();

$page[ 'title' ] .= $page[ 'title_separator' ].'Welcome';

$page[ 'page_id' ] = 'home';

$page[ 'body' ] .= "This is your user Profile<br />
    Feel free to make changes below:<br />
    <form enctype=\"multipart/form-data\" method=\"post\" name=\"userupdate\">
    First Name *<br /><input name=\"txtFirst\" type=\"text\" size=\"30\" maxlength=\"15\" value=\"". $profile[0] . "\"><br/>
    Last Name *<br /><input name=\"txtLast\" type=\"text\" size=\"30\" maxlength=\"15\" value=\"". $profile[1] . "\"><br/>
    Username *<br /><input name=\"txtUser\" type=\"text\" size=\"30\" maxlength=\"15\" value=\"". $profile[2] . "\"><br/>
    New Password *<br /><input name=\"txtPass\" type=\"password\" size=\"30\" maxlength=\"32\" value=\"\"><br/>
    Old Password *<br /><input name=\"txtOldPass\" type=\"password\" size=\"30\" maxlength=\"32\" value=\"\"><br/>
    <input type=\"hidden\" name=\"CSRFToken\" value=\"".$_SESSION['TOKEN']."\">
    <input name=\"btnSubmit\" type=\"submit\" value=\"Submit\"><br/>

    </form>
";


htmlEcho( $page );

?>
