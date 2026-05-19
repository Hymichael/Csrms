<?php
require_once __DIR__ . '/config.php';
session_start();

function is_logged_in(){
    return isset($_SESSION['user_id']);
}
function require_login(){
    if(!is_logged_in()){
        header('Location: /csrms_project/login.php');
        exit;
    }
}
function current_user(){
    if(!is_logged_in()) return null;
    return ['id'=>$_SESSION['user_id'],'name'=>$_SESSION['user_name'],'role'=>$_SESSION['user_role']];
}
?>