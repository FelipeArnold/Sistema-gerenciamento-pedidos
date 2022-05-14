<?php

header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
clearstatcache();


//$dominio = explode( ".", $_SERVER['SERVER_NAME'] );

//session_name($dominio);
//session_set_cookie_params( 0, '/', $dominio.".com.br" );
session_cache_limiter( "private");
session_cache_expire(1);
session_start();