<?php
//include '../proxy/proxy.php';
//include_once 'app/include/DBConnection.php';
include_once '../app/include/DBConnection.php';
if (isset($_REQUEST['shop'])) {
	$query = $db->query("UPDATE tbl_getresponse_email SET status ='0' WHERE shop_name='".$_REQUEST['shop']."'");
	echo "added";
}else{
	//echo "UPDATE tbl_getresponse_email SET status ='0' WHERE shop_name='".$_REQUEST['shop']."'";
	echo "not added";
}
?>
