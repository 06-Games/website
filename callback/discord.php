<?php
if(isset($_GET['code'])){ 
    include("../api/v1/accounts/.private/checkToken.php");
    header('Content-Type: application/json;charset=utf-8');

    $path = substr(__DIR__, strlen(realpath('../')));
    $requestURL = 'http://localhost'.substr($_SERVER['REQUEST_URI'], 0, strlen($_SERVER['REQUEST_URI']) - strlen(basename($_SERVER['REQUEST_URI'])));
    $apiURL = substr($requestURL, 0, strlen($requestURL) - strlen($path)).'api/v1/accounts';
    $context =  stream_context_create(array('http'=>array('header'=>array("Referer: ".(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].strtok($_SERVER["REQUEST_URI"], '?')))));
    
    if($account == null) //Connect
    {
        $result = file_get_contents($apiURL."/auth/discord?code=".$_GET['code'], false, $context);
        $json = json_decode($result);
        if ($json != null && $json->{'code'} == 0) {
            setcookie('account', $json->{'token'}, 0, '/');
            header('Location: ../#Account');
        }
        echo $result;
    } 
    else { //Link
        $result = file_get_contents($apiURL."/manage/link?provider=Discord&authID=".$_GET['code'].'&token='.$_COOKIE['account'], false, $context);
        $json = json_decode($result);
        if ($json != null && $json->{'code'} == 0) header('Location: ../#Account');
        echo $result;
    }
}
else echo 'Error';