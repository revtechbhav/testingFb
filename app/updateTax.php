<?php
include('include/header.php'); 
if(isset($_REQUEST) && $_REQUEST['value'] !='')
{
	$db->query("UPDATE tbl_tax_include SET enable_tax_ship = '".$_REQUEST['value']."' WHERE shop_name = '".$_SESSION['shop']."'");
	echo "True";
}else{
	$db->query("UPDATE tbl_tax_include SET enable_tax_ship = 'false' WHERE shop_name = '".$_SESSION['shop']."'");
	echo "false";
}
?>