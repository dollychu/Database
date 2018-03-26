<?php
require_once "login.php";

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['submit'])){
    $stmt_ = $conn->prepare("SELECT Name FROM User WHERE Name=?");
    $stmt_->bind_param("s", $name);
    $name = $_POST['name'];
    $stmt_->execute();
    $result = $stmt_->get_result();
    if($result->num_rows){
        echo"<h1>Account exist!! Please use other names.</h1>";
    }else{
        $stmt = $conn->prepare("INSERT INTO User (Name, passwd) VALUES (?,?)");
        $stmt->bind_param("ss", $name, $token);

        $passwd = $_POST['passwd'];
        $token = password_hash($passwd, PASSWORD_DEFAULT);
        $stmt->execute();
	
        echo "<h2>Successfully create a new acount~</h2>";
        $stmt->close();
    }
    $result->free();
    $stmt->close();
}
$conn->close();

$wait = 7;
echo "<h4>Redirect after $wait seconds...</h4>";
header('Refresh: $wait; ../index.html');
exit();

?>
