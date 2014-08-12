<?php

define( 'WEB_PAGE_TO_ROOT', '' );
require_once WEB_PAGE_TO_ROOT.'includes/businessPage.inc.php';

startup( array() );

if( !isLoggedIn() ) {	
	redirect( 'login.php' );
}

logout();
messagePush( "You have logged out" );
redirect( 'index.php' );

?>

