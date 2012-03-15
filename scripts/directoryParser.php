<?php
class DirectoryParser{

	function getDirectoryContents($path, $type = "all"){
		$pathsArray = array();
		//echo('reading from :: '. $path . "<br/><br/>");
		if($pathHandle = opendir($path)){

			while(false !== ($item = readdir($pathHandle))){

				if($item != "." && $item != ".." && $this->checkValidFiletype($item)){
					
					$fullpath = $path . "/" . $item;
					

					switch($type){
						case "files":
							if(is_dir($fullpath) == 0) {
								//echo(is_dir($item). "  " .  $item . "<br />");
								array_push($pathsArray, $item);
							}
						break;

						case "folders":
							if(is_dir($fullpath) == 1) {
								//echo(is_dir($item). "  " .  $item . "<br />");
								array_push($pathsArray, $item);
							}
						break;

						case "all":
							//echo(is_dir($item). "  " .  $item . "<br />");

							array_push($pathsArray, $item);
						break;
					}
				} else {
					continue;
				}
			}
		} else {
			//directory or file doesnt exist, handle error
			return null;
		}
		return $pathsArray;
	}

	function getDirectoryTree($path ){
		$dir = new DirectoryIterator($path);
		$data = array();
		foreach ( $dir as $node ){
			if ( $node->isDir() && !$node->isDot()  ){
				$data[$node->getFilename()] = $this->getDirectoryTree( $node->getPathname());
			} else if ( $node->isFile()) {
				$data[] = $node->getFilename();
			}
		}
		return $data;
	}



	function checkValidFiletype($item){
		for ($i=0; $i < count($GLOBALS["fileTypeFilters"]); $i++) { 
			$ext = $GLOBALS["fileTypeFilters"][$i];
			$itemExt = stristr($item, '.');
			//echo($ext . "--" . $itemExt . "<br />");
			if($itemExt == $ext || $itemExt == ""){
				return true;
			} 
		}

	}
}

?>