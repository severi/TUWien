<?php

define( 'WEB_PAGE_TO_ROOT', '' );

require_once WEB_PAGE_TO_ROOT.'includes/businessPage.inc.php';

$page = grabNewPage();

$page[ 'title' ] .= $page[ 'title_separator' ].'Welcome';

$page[ 'page_id' ] = 'home';

$file='readme.txt';

if(isset($_GET['sample']))
    $file = $_GET['sample'];

$page[ 'body' ] .= readfile($file);


htmlEcho( $page );

?>
