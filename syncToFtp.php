<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
	// $ftp_server=$_POST['server'];
	// $ftp_user_name=$_POST['username'];
	// $ftp_user_pass=$_POST['password'];
	// $source_file=$_FILES['file']['name'];// retrieve name of the file to be uploaded
	$ftp_server="benatwork.me";
	$ftp_user_name="storage";
	$ftp_user_pass="boogie6153";
	$source_file="projects/product2/another_cool_campaign/another_execution/westin_300x250.swf";//$_FILES['file']['name'];// retrieve name of the file to be uploaded
	$destination_file="hi.swf";
	// make a connection to the ftp server 
	$conn_id = ftp_connect($ftp_server);

	// login with username and password 
	$login_result = ftp_login($conn_id , $ftp_user_name , $ftp_user_pass);

	// check connection 
	if((!$conn_id)||(!$login_result)){ 
		echo "FTP connection has failed!" ; 
		echo "Attempted to connect to $ftp_server for user $ftp_user_name" ; 
		exit; 
	}else{ 
		echo "Connected to $ftp_server, for user $ftp_user_name" ; 
	} 
	// upload the file 
	$upload = ftp_put($conn_id,$destination_file,$source_file,FTP_ASCII );

	// check upload status 
	if(!$upload){ 
		echo "FTP upload has failed!"; 
	}else{ 
		echo "Uploaded $source_file to $ftp_server as $destination_file" ; 
	}

	// close the FTP stream 
	ftp_close($conn_id); 
?> 
</body>
</html>
 