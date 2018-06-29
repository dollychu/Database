<?php

function decodeUrlVar($url, $var_name){
  $matches = array();
  preg_match("/$var_name=(.*)/", $url, $matches);
  
  $result = false;
  if(count($matches) > 0){
    $result = explode("$var_name=", $matches[0])[1];
    if(preg_match("/&/", $result)){
      $result = explode("&", $result)[0];
    }
  }
  return $result;
}


?>
