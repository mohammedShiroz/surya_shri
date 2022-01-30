<?php
$get_current_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$get_language = GetStringAfterSecondSlashInURL($get_current_url);


$locals=array('en','ta','si');
if(in_array($get_language,$locals,true)){
}else{
    $set_ur="";
    if($get_language == "store-admin"){
        $set_ur=GetFirstInURL($get_current_url)."/store-admin/login";
        //echo '<script type="text/javascript">alert("false '.$set_ur.'")</script>';
    }else{
        $set_ur=GetFirstInURL($get_current_url)."/en/".GetotherInURL($get_current_url);
    }
    header("Location: http://".$set_ur, true, 301);
    exit();
}
function GetFirstInURL($the_url)
{
    $parts = explode("/",$the_url,3);
    if(isset($parts[0])){
        return $parts[0];
    }
}
function GetStringAfterSecondSlashInURL($the_url)
{
    $parts = explode("/",$the_url,3);
    if(isset($parts[1])){
        return $parts[1];
    }
}
function GetotherInURL($the_url)
{
    $parts = explode("/",$the_url,3);
    if(isset($parts[2])){
        return $parts[2];
    }
}
?>

