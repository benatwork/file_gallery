<?php
	$path = $_POST['filePath'];
	$size=getimagesize($path);
	$sizeString = $size[3];
	$sizeArray = array('width' => $size[0], 'height' => $size[1], 'sizeString' => $size[3]);
	$response = json_encode($sizeArray);
	

	if(!$response){
        die(json_encode(array('error' => 'Couldnt get the Swf Dimensions, using default values', 'code' => 1337)));
	} else {
		echo($response);
	}

?>