<?php

define( 'WEB_PAGE_TO_ROOT', '' );

require_once WEB_PAGE_TO_ROOT.'includes/businessPage.inc.php';
global $_SESSION;
startup( array( 'authenticated', 'redirect'=>'backend.php' ) );

	if (isset($_POST['btnSubmit']) && $_POST['CSRFToken']==$_SESSION['TOKEN']) {
            $content = filter_var($_POST['mtxContent'], FILTER_SANITIZE_STRING);
			$target_path = WEB_PAGE_TO_ROOT."uploads/";
			$target_path .= basename( $_FILES['uploaded']['name']);

			$imageData = @getimagesize($_FILES['uploaded']['tmp_name']);
			if($imageData === FALSE || !($imageData[2] == IMAGETYPE_GIF || $imageData[2] == IMAGETYPE_JPEG || $imageData[2] == IMAGETYPE_PNG)) {
		      	$html .= '<pre>';
				$html .= 'Your image was not uploaded - wrong file format.';
				$html .= '</pre>';
		    }

			else if(!move_uploaded_file($_FILES['uploaded']['tmp_name'], $target_path)) {

				$html .= '<pre>';
				$html .= 'Your image was not uploaded.';
				$html .= '</pre>';

      		} else {
                                $content.="<br /><img heigth=250 width=250 src=\"". $target_path ."\"> ";
				$html .= '<pre>';
				$html .= $target_path . ' succesfully uploaded!';
				$html .= '</pre>';

			}
                  if(isset($_POST['txtRef']))
                      $content.="<br /><a href=\"".$_POST['txtRef']."\">External Reference </a>";
                  $title=$_POST['txtTitle'];
                  $name=$_POST['user'];
                  $published=gmdate("Y-m-d H:i:s");

                $pdo = databaseConnect1();
                $stmt = $pdo->prepare('INSERT INTO article (headline,content,created,published) VALUES (:title, :content, :published, :name)');
				$stmt->execute(array('title' => $title, 'content' => $content, 'published' => $published, 'name' => $name));
		}

$page = grabNewPage();

$page[ 'title' ] .= $page[ 'title_separator' ].'Welcome';

$page[ 'page_id' ] = 'home';

$page[ 'body' ] .= "Welcome to the Management Backend!<br />
    You can add an article below:<br />

    <form enctype=\"multipart/form-data\" method=\"post\" name=\"article\">

    Title *<br /><input name=\"txtTitle\" type=\"text\" size=\"30\" maxlength=\"20\"><br/>
                Content *<br/>
		<textarea name=\"mtxContent\" cols=\"500\" rows=\"10\" maxlength=\"5000\"></textarea><br/>
                Add an Image to the article:
			<br /><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"512000\" />
			<input name=\"uploaded\" type=\"file\" /><br />
                        External Reference *<br /><input name=\"txtRef\" type=\"text\" size=\"30\" maxlength=\"60\"><br/>";
$page[ 'body' ] .=getAuthors();
$page[ 'body' ] .="<br/><input name=\"btnSubmit\" type=\"submit\" value=\"Submit\"><br/>
	<input type=\"hidden\" name=\"CSRFToken\" value=\"".$_SESSION['TOKEN']."\">
    </form>
";


htmlEcho( $page );

?>
