<?php

include("./scripts/FLVMetaData.php");
error_reporting(E_ERROR | E_PARSE);

$thelist = array();
$folder = 'videos';
//$folder = 'http://benatwork.me/work/videos';
$response;


	if ($handle = opendir('./videos')) {
		$extraData = json_decode(file_get_contents($folder."/data.json"),true);

	  	while (false !== ($file = readdir($handle))){

	  		$filePieces = explode(".",$file);
	  		$videoName = $filePieces[0];
	  		$filePath = $folder.'/'.$file;

		    if ($file != "." && $file != ".." && $filePieces[1] == "flv" ){

				
		    	$projectNode = array(
		    		"thumbUrl" => 'videos/'.$videoName.'.jpg',
		    		"videoUrl" =>$folder."/".$videoName.'.flv',
		    		"videoName" =>$videoName,
		    		"type" => null
			    );
				
    			$meta = new FLVMetaData($projectNode['videoUrl']);
      			$projectNode['meta'] = $meta->getMetaData();

				switch(substr($videoName,0,3)){
					case "app":
						//is an app
						$projectNode['category'] = "Facebook Apps";
						$projectNode['type'] = "app";
						break;
					case "mot":
						//is a motion graphics
						$projectNode['category'] = "Motion Graphics";
						$projectNode['type'] = "motion";
						break;
					case "ric":
						//is a rich banner
						$projectNode['category'] = "Rich media ads";
						$projectNode['type'] = "rich";
						break;
					case "sta":
						//is a standard banner
						$projectNode['category'] = "Standard Ad Banners";
						$projectNode['type'] = "standard";
						break;
					case "sit":
						//is a site
						$projectNode['category'] = "Sites";
						$projectNode['type'] = "site";
						break;
					case "oth":
						//is an other
						$projectNode['category'] = "Other";
						$projectNode['type'] = "other";
						break;
					default:
						$projectNode['category'] = null;
						$projectNode['type'] = null;
						break;
				}

    			if($extraData[$videoName]){
		    		$projectNode = array_merge($extraData[$videoName],$projectNode);
		    		$projectNode['hasExtra'] = true;
	    		} else {
	    			$projectNode['hasExtra'] = false;
	    			$projectNode['title'] = $videoName;
	    			$projectNode['description'] = "";
	    			$projectNode['tags'] = "";

	    		}
	    		array_push($thelist, $projectNode );
		    } 
	    }
	  
	 	closedir($handle);
	}
	
	$response = json_encode($thelist);
	
	echo($response);

?>
