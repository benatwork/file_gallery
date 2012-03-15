

jQuery(document).ready(function($) {
	 $('#fileTree').fileTree({ 
	 	root: './projects/',
	 	expandSpeed: 50,
	 	collapseSpeed: 50
 	}, function(file) {  
    	prepareFile(file);
    });

});



function prepareFile(filePath){
	swfDimensions = {
		width : 300,
		height : 250
	}
	var swfDimensions
	$.post("getSwfDimensions.php", {filePath : filePath}, 
		function(res){			
			if(!res.error){	
				swfDimensions = jQuery.parseJSON(res);
				playFile(filePath, swfDimensions);
			} else {
				//if the php scripts return an error, still build an object but use the default size
				console.log(res.error);
			}
			return(swfDimensions);
		}
		
	)

}

function playFile(file, swfDimensions){

	console.log("Attempting to load:" + file + " its dimensions are " + swfDimensions.width + "x" + swfDimensions.height);

	
	$("#sampleTitle").text(file
		.replace(/\\/g,'/')
		.replace( /.*\//, '' )
		.replace(/\.[^\.]*$/, '')
		.replace('_',' '));
	if(file.match('.swf')){
		clearContainers();
		$('#swfObjectContainer').append("<div id='swfObj'></div>");
		swfobject.embedSWF(file, "swfObj", swfDimensions.width, swfDimensions.height, "9.0.0", "expressInstall.swf");
	} else  {
		clearContainers();
		$('#contentContainer').html("<img src='"+file+"' "+swfDimensions.sizeString+"> </img>");

			//"<img src='"+file+"/>")
	}
	function clearContainers(){
		$('#swfObjectContainer').empty();
		$('#contentContainer').empty();
	}
}