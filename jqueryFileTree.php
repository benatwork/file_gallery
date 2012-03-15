<?php
//
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008

// Modified By Ben Roth
// BBH
// 15 March 2012
//
// History:
// 1.02 - added hardcoded filetype and filename filters
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//



//error_reporting(E_ALL);


$GLOBALS["excludedFileNames"] = array(".DS_Store", "index.html", ".", "..");
$GLOBALS["excludedExtensions"] = array(".html", ".js", ".fla", ".mov",".jpg", ".gif", ".mov");

$_POST['dir'] = urldecode($_POST['dir']);



if( file_exists($_POST['dir']) ) {
	$files = scandir($_POST['dir']);
	natcasesort($files);
	if( count($files) > 2 ) { /* The 2 accounts for . and .. */
		echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
		// All dirs
		foreach( $files as $file ) {
			if( file_exists($_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($_POST['dir'] . $file) ) {
				echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
			}
		}
		// All files
		foreach( $files as $file ) {
			if( file_exists($_POST['dir'] . $file) && isAllowedFileName($file) && isAllowedFileType($file) && !is_dir($_POST['dir'] . $file) ) {
				$ext = preg_replace('/^.*\./', '', $file);
				echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
			}
		}
		echo "</ul>";	
	}
}

function isAllowedFileName($file){
	foreach ($GLOBALS["excludedFileNames"] as $val) {
		if($file == $val){
			return false;
		}
	}
	return true;
	
}

function isAllowedFileType($file){
	foreach ($GLOBALS["excludedExtensions"] as $val) {
		if($val == stristr($file, '.')){
			return false;
		}
	}
	return true;
}

?>