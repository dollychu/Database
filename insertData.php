<?php

$conn = new mysqli("localhost", "dbteam16", "DBteam16;", "DB_project");
if($conn->connect_error){
	die($conn->connect_error);
}

if(isset($_POST['submit'])){
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$passwd = mysqli_real_escape_string($conn, $_POST['passwd']);

	$sql = "INSERT INTO User(Name, passwd) VALUES ('$name', '$passwd')";
	if($conn->query($sql)===True){
		echo"<h3>User's data is inserted successfully</h3>";
	}else{
		echo"<h3 align='center'> Isertion failed</h3>";
	}
}
$conn->close();
?>
