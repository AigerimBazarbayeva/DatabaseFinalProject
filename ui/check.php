<? 
session_start(); 
if (!isset($_SESSION['counter'])) $_SESSION['counter']=0;
echo "Refreshed ".$_SESSION['counter']++." times.<br>
<a href=".$_SERVER['PHP_SELF'].'?'.session_name().'='.session_id().">refresh</a>"; 
?>