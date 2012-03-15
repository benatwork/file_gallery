var activeLinks = [];
var deepLinkChunks = [];
var deepLinkPath = "";
var deeplinkdepth = 0;
var pathsScrapedCount = 0;
var fileScraper = "scripts/getFiles.php";

jQuery(document).ready(function($) {
	refreshFormsFromUrl();

	$('select').change(function() {
	   //alert('Value change to ' + $(this).attr('value'));
	   onSelectionMade($(this).attr('name'),$(this).attr('value'));
	});
});

function refreshFormsFromUrl(){
	pathsScrapedCount = 0;
	var urlString = "getFiles.php";
	var product = getParameterByName("product");
	var campaign = getParameterByName("campaign");
	var execution = getParameterByName("execution");


	if(product != "") {
		urlString += "?product="+product;
		deepLinkChunks.push("../" +product);
		deeplinkdepth ++;
	}
	if(campaign != "") {
		urlString += "&campaign="+campaign;
		deepLinkChunks.push(deepLinkChunks[0] + "/" + campaign);
		deeplinkdepth ++;
	}
	if(execution != "") {
		deepLinkChunks.push(deepLinkChunks[1] + "/" + execution);
		urlString += "&execution="+execution;
		deeplinkdepth ++;
	}

	scrapeDirectory(fileScraper);
}

function scrapeDirectory(path){
	console.log('scraping for '+ path);
	$.ajax({
		url: path,
		context: document.body,
		success: function(res){
			//$(this).addClass("done");
			
			var fileObj = jQuery.parseJSON(res);
			if(!fileObj.error){	
				if(deepLinkChunks[pathsScrapedCount]) scrapeDirectory(fileScraper+"?url="+deepLinkChunks[pathsScrapedCount]);
				populateForm(pathsScrapedCount, fileObj);
				pathsScrapedCount ++;
			} else {
				//if the php scripts return an error
				console.log(fileObj.error);
				//console.log(fileObj.error)
			};
		}
	});
}

function refreshForms(urlString){
	$.ajax({
		url: "getFiles.php?path=" + urlString,
		context: document.body,
		success: function(res){
			//$(this).addClass("done");	
			var fileObj = jQuery.parseJSON(res);
			if(!fileObj.error){
				console.log(fileObj);
				listFiles(fileObj);
			} else {
				console.log(fileObj.error);
			};
		}
	});
}


function populateForm(formId, data){
	console.log(data);
	$.each(data, function(i, value) { 
		$("form #"+formId)
			.append($('<option>', { value : findBaseName(value) })
			.text(findBaseName(value))); 
	});
}

function onSelectionMade(fieldName, value){
	console.log("Selection Made in the "+fieldName+" field :: "+ value);
	//TODO build the new string from current values and off you go.
	//$("form #"+formId).selected
}

function processAjaxData(response, urlPath){
     document.getElementById("content").innerHTML = response.html;
     document.title = response.pageTitle;
     window.history.pushState({"html":response.html,"pageTitle":response.pageTitle},"", urlPath);
 }



//____________ utils _______________________________________________________________

function getParameterByName(name){
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.search);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function findBaseName(url) {
    var fileName = url.substring(url.lastIndexOf('/') + 1);
    var dot = fileName.lastIndexOf('.');
    return dot == -1 ? fileName : fileName.substring(0, dot);
}