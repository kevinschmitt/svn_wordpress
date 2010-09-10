<?php
/**
 * svn_wordpress.php
 * 
 * Gets WordPress via SVN.
 * 
 * Usage: Call svn_wordpress.php?get-wordpress=yes
 *
 * @author Kevin Schmitt
 */
	require_once('phpsvnclient.php');
	
	$svn_memory_limit = '128M';
	$wp_repository = 'http://core.svn.wordpress.org/';
	$wp_version = '3.0.1';
	$wp_revision = '';
	$wp_local_dir = $_SERVER['DOCUMENT_ROOT'] . '/wordpress';
	
	
	echo "Trying to increase php.ini memory limit<br />\n";
	$mem = ini_set('memory_limit', $svn_memory_limit);
	if( $mem != FALSE ){
		$mem_new = ini_get('memory_limit');
		echo "Old memory limit: " . $mem . "<br />\nNew memory limit: " . $mem_new . "<br />\n";
	} else {
		echo "Increasing memory limit failed!<br />\n";
	}
	
	
	if( isset($_GET['wp-version']) && $_GET['wp-version'] != '' ){
	
		$wp_version = $_GET['wp-version'];
		
	}
	
	
	if( isset($_GET['wp-revision']) && $_GET['wp-revision'] != '' ){
	
		$wp_revision = $_GET['wp-revision'];
		
	}
		
	
	if( isset($_GET['get-wordpress']) && $_GET['get-wordpress'] == 'yes' ){
		
		echo "Initializing SVN client...<br />\n";
		echo "Connecting to $wp_repository ...<br />\n";
		$svn = new phpsvnclient($wp_repository);
		
		// deprecated
		//$svn->setRepository( $wp_repository );
		
		$wp_revision_latest = $svn->getVersion();
		echo "Latest revision is: $wp_revision_latest<br />\n";
		
		
		if( isset($wp_revision) && $wp_revision != '' ) {
		
			$files = $svn->getDirectoryFiles( '/tags/' . $wp_version . '/', $wp_revision );
			
		} else {
		
			$files = $svn->getDirectoryFiles( '/tags/' . $wp_version . '/' );
			
			echo "Writing files to: " . $wp_local_dir . "<br />\nThis may take several minutes.<br />\n";
			$svn->checkout( '/tags/' . $wp_version . '/', $wp_local_dir );

		}
		
/*		if( isset($files) ){
			echo "<pre>\n";
			print_r($files);
			echo "</pre>\n";
		}
*/		
	}
?>
