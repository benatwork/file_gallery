var swfDimensions

jQuery(document).ready(function($) {
	 $('#fileTree').fileTree({ 
	 	root: './projects/',
	 	expandSpeed: 50,
	 	collapseSpeed: 50
 	}, function(file) {  
    	getSwfDimensions(file);
    	console.log("Attempting to load:" + file + " its dimensions are " + swfDimensions.width + "x" + swfDimensions.height);
    	swfobject.embedSWF(file, "myContent", swfDimensions.width, swfDimensions.height, "9.0.0", "expressInstall.swf");
    });

});

function getSwfDimensions(filePath){
	swfDimensions = {
		width : 300,
		height : 250
	}
	$.post("getSwfDimensions.php", {filePath : filePath}, 
		function(res){			
			if(!res.error){	
				
				swfDimensions = jQuery.parseJSON(res);
				
			} else {
				//if the php scripts return an error, still build an object but use the default size
				console.log(res.error);
			}
			return(swfDimensions);
		}
		
	)

}