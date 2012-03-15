<?php
	include("directoryParser.php");
	//
	//error_reporting(E_ERROR | E_PARSE);
	//ini_set('display_errors','1'); 
	error_reporting(E_ALL);

	
	$directoryParser = new directoryParser();



	// the root folder in which to scan for projets
	$projectsFolder = "../projects";


	$deepLinkDepth = 0;
	$deepLinkArr = array();
	$path = $projectsFolder;
	$isFile = false;

	$GLOBALS["fileTypeFilters"] = array(".swf");


	//
	// if there is a path var, use that, otherwise build the path from query string
	//
	// A query string would could contain product/campaign/execution/files vars
	//

	if(isset($_GET['path'])){
		$path = $_GET['path'];
	} else {
		foreach($_GET as $name => $value) {
			$deepLinkDepth ++;
			array_push($deepLinkArr, $value);
			$path .= "./" . $value;
			if($name == "fileName") {
				//$path .= ".html";
				$isFile = true;
			}
		}
	}


	$response = $directoryParser->getDirectoryTree($path);


	if(!$response){
        die(json_encode(array('error' => 'Error, probably a bad query string in the url', 'code' => 1337)));
	} else {
		print(json_encode($response,true));
	}

?>