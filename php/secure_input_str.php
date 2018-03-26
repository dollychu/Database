<?php

function secure_input($conn, $str){
    return mysqli_fix_string($conn, $str);
}

function mysql_fix_string($conn, $str){
    return $conn->mysqli_real_escape_string($str);
}

?>

