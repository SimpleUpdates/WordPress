<?php

class SF_router_wordpress implements SF_interface_router_basic
{
	static $base_path = "/package/WordPress";
	
	static public function route( array $slug_array )
	{
		if( $slug_array[0] !== SF_static_configure::read( LOCAL_DOCUMENT_ROOT."/package/WordPress/config/wordpress.php", 'base_path', false ) )
			return NULL;
		
		list( , $url_path ) = SF_system_router::getURLBaseAndPath();
		
		$url_path = self::$base_path.substr( $url_path, strlen( "/".$slug_array[0] ) );
		
		//test if the url_path is a file
		if( is_dir( LOCAL_DOCUMENT_ROOT.$url_path ) ) {
			$url_path = rtrim( $url_path, "/" ).'/index.php';
		}
		#var_dump($url_path);die;
		if( ! file_exists( LOCAL_DOCUMENT_ROOT.$url_path ) )
			return NULL;
		
		SF_legacy_magicquotes::setEnabled( TRUE );
		SF_legacy_environment::applyExploitSafeguard();
		SF_legacy_environment::addLegacyFolderToIncludePath();
		
		if( substr( LOCAL_DOCUMENT_ROOT.$url_path, -4 ) != ".php" ) {
			header( "Location: ".$url_path );
			die;
		}
		
		/* Correct some system variables */
		$_SERVER["SCRIPT_NAME"] = $url_path;
		$_SERVER["PHP_SELF"] = $url_path;
		$GLOBALS["PHP_SELF"] = $url_path;
		$_SERVER["SCRIPT_FILENAME"] = LOCAL_DOCUMENT_ROOT.$url_path;
		chdir( dirname( $_SERVER["SCRIPT_FILENAME"] ) );
		restore_error_handler();
		restore_exception_handler();
		error_reporting( INIT_ERROR_REPORTING );
		throw new SF_exception_route_legacy_require( $url_path );
	}
	
}

?>