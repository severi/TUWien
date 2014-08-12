<?php

define( 'WEB_PAGE_TO_ROOT', '' );

require_once WEB_PAGE_TO_ROOT.'includes/businessPage.inc.php';

$page = grabNewPage();

$page[ 'title' ] .= $page[ 'title_separator' ].'Welcome';

$page[ 'page_id' ] = 'home';

if(isset($_POST['btnSign']))
{
    postComment($_POST['mtxMessage'], $_POST['txtName'], $_GET['id']);
}

$page[ 'body' ] .= fetchArticle($_GET['id'],$_GET['comments']);


htmlEcho( $page );

?>
