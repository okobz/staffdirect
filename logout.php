<?
require_once("function.php");
session_destroy();//Then destroy all sessions
$nextURL = "login.php?logout=true";
header("Location: ". $nextURL);
exit;
?>