<?php 
function linka()
{
    $url ="http://localhost/test";
    if($url=="http://localhost/test1")
    {
        header("Location:http://localhost/test");
    }
    else
    {
        header("Location:https://dl.dropboxusercontent.com/content_link/uuiGy14hyjCttclT5Ku09fFx4EDqfuSXyRT2M2q6KZrkmd71M3Ruo7HZ0KPPgy8Z/file/");
    }
}
?>