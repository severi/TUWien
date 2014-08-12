<?php

define( 'WEB_PAGE_TO_ROOT', '' );

require_once WEB_PAGE_TO_ROOT.'includes/businessPage.inc.php';

$page = grabNewPage();

$page[ 'title' ] .= $page[ 'title_separator' ].'Welcome';

$page[ 'page_id' ] = 'home';

$page[ 'body' ] .= fetchArticles();


htmlEcho( $page );

?>
