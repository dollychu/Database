<?php
require_once "utils.php";
$str = "path=Adele some one would like you.mp3&list_id=4";


echo decodeUrlVar($str, "path");



?>
