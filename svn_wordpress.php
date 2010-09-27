<?php
/**
 * svn_wordpress.php
 * 
 * Gets WordPress via SVN.
 * 
 * Usage: Call svn_wordpress.php enter repository URL and local installation path
 *        Check version and revision & click yes to checkout from repoository.
 *
 * @author Kevin Schmitt
 */
	require_once('phpsvnclient.php');
	
	$svn_memory_limit = '128M';
	$wp_repository = 'http://core.svn.wordpress.org/';
	$wp_version = '3.0.1';
	$wp_revision = '';
	$wp_local_dir = $_SERVER['DOCUMENT_ROOT'] . '/wordpress';
	
	$svn = new phpsvnclient($wp_repository);
	
	$wp_revision_latest = $svn->getVersion();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	
	<title>parched-art</title>
	
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="de-de" />
	<meta http-equiv="author" content="Kevin Schmitt" />
	
	<meta name="language" content="de-de" />
	<meta name="robots" content="noindex,nofollow" />

</head>
<body>
	Connected to <?=$wp_repository?><br />
	Latest revision is: <?=$wp_revision_latest?><br />
	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
		<fieldset>
		
			<legend>Repository-Setup</legend>
			
			<label for="wp-repository">Repository-URL</label>
			<input type="text" name="wp-repository" id="wp-repository" value="<?=$wp_repository?>" />
			
			<label for="wp-local-dir">Local Installation-Directory</label>
			<input type="text" name="wp-local-dir" id="wp-local-dir" value="<?=$wp_local_dir?>" />
			
		</fieldset>
		<fieldset>
		
			<legend>Wordpress-Version</legend>
			
			<label for="wp-version">Wordpress-Version</label>
			<input type="text" name="wp-version" id="wp-version" value="<?=$wp_version?>" />
			
			<label for="wp-revision">Revisions-Number</label>
			<input type="text" name="wp-revision" id="wp-revision" value="<?=$wp_revision_latest?>" />
			
			<label for="get-wordpress">Create new local WordPress-Installation?</label>
			<input type="submit" name="get-wordpress" id="get-wordpress" value="yes" />
			
		</fieldset>
	</form>
</body>
</html>
<?php
	
	if( isset($_POST['get-wordpress']) && $_POST['get-wordpress'] == 'yes' ){
	
		if( isset($_POST['wp-repository']) && $_POST['wp-repository'] != '' ){
			$wp_repository = $_POST['wp-repository'];
		}
		
		if( isset($_POST['wp-local-dir']) && $_POST['wp-local-dir'] != '' ){
			$wp_local_dir = $_POST['wp-local-dir'];
		}
		
		if( isset($_POST['wp-version']) && $_POST['wp-version'] != '' ){
			$wp_version = $_POST['wp-version'];
		}
		
		if( isset($_POST['wp-revision']) && $_POST['wp-revision'] != '' ){
			$wp_revision = $_POST['wp-revision'];
		}
		
		$mem = ini_set('memory_limit', $svn_memory_limit);
		if( $mem != FALSE ){
			$mem_new = ini_get('memory_limit');
		} else {
			die("Increasing memory limit failed!<br />\n");
		}
		
		if( isset($wp_revision) && $wp_revision != '' ) {
			echo "Writing files to: " . $wp_local_dir . "<br />\nThis may take several minutes.<br />\n";
			$svn->checkout( '/tags/' . $wp_version . '/', $wp_local_dir );
					} else {
			echo "Writing files to: " . $wp_local_dir . "<br />\nThis may take several minutes.<br />\n";
			$svn->checkout( '/tags/' . $wp_version . '/', $wp_local_dir );
		}		
	}
?>
