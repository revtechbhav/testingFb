<?php 
include('include/header.php'); 
include '../proxy/proxy.php';
include 'getresponse-api/GetResponseAPI3.class.php';
use sandeepshetty\shopify_api;
$getresponse = new GetResponse('8c0553655d39ed5a789e34228a0dec3e');

// echo "<pre>";
// print_r($ShopDetails);
// echo "</pre>";
// die();

//$details = $getresponse->getCampaigns();
$details = $getresponse->getCampaigns();
foreach ($details as $key => $value) {
	if($value->isDefault == "true"){
		$name = $value->name;
		$email = $ShopDetails['email'];
		$compaign = $value->campaignId;
		$description = $value->description;
	}
}

/* Get Response email subscription */
$get_response = $db->query("SELECT * From tbl_getresponse_email Where email = '".$ShopDetails['email']."' and shop_name = '".$_SESSION['shop']."' and status = '1'");
if($get_response->num_rows > 0){
}else{
	$db->query("INSERT INTO tbl_getresponse_email (`email`,`status`,`shop_name`,`created_at`) VALUES('".$ShopDetails['email']."','1','".$_SESSION['shop']."','".date('d-M-Y H:i')."')");
	$result = $getresponse->addContact(array(
		'name'   => $name,
		'email'  => $email,
		'dayOfCycle' => 10,
		'campaign'  =>array('campaignId' =>$compaign),
		'description' =>$description,
	));
	
}
/* Get Response email subscription */
$checkTAx_IN_Shop =  $db->query("SELECT * From tbl_tax_include Where shop_name = '".$_SESSION['shop']."'");

if($checkTAx_IN_Shop->num_rows > 0){
}else{
	$db->query("INSERT INTO tbl_tax_include (`enable_tax_ship`,`shop_name`,`created_at`) VALUES('true','".$_SESSION['shop']."','".date('d-M-Y H:i')."')");
}
/*Insert Pixel Id*/
function check_array($array)
{
	if(count(array_filter($array)) == 0){
		return 0;
	}else{
		return 1;
	}
}
function count_array($array){
	if(count($array)){
		return count($array);
	}else{
		return 0;
	}
}
$tax_get_val = $db->query("SELECT enable_tax_ship from tbl_tax_include Where shop_name = '".$_SESSION['shop']."'");
$taxValue = '';
if($tax_get_val->num_rows > 0){
	$taxValue  = $tax_get_val->fetch_assoc();
}
$count = $db->query("SELECT COUNT(*) as total_count from tbl_pixel_ids Where shop_name = '".$_SESSION['shop']."'");
if($count->num_rows > 0){
$count = $count->fetch_assoc();
$count = $count['total_count'];
}
if($count == 6 ){
	
}else{
if(isset($_REQUEST['pixel-id'])){
	$pixelId = $_REQUEST['pixel-id'];
	$check = count_array($pixelId);
	$total  = $count+$check;
	if($total > 6 ){
		echo '<script type="text/javascript">ShopifyApp.flashNotice("You can add only 6 pixel ids only !!");</script>';
	}else{
	$array_result = check_array($pixelId);
	if($array_result == 1){
		$current_date = date('d-M-Y H:i');
		$tax_status = $_REQUEST['tax-status'];
		$shipping_status = $_REQUEST['shipping-status'];
		echo '<script type="text/javascript">jQuery(".ajaxloader").show();</script>';
		for($i=0;$i<count($pixelId);$i++){
			
			$tbl_pixel_ids = $db->query("SELECT * FROM tbl_pixel_ids WHERE pixel_id = '".$pixelId[$i]."' AND shop_name = '".$_SESSION['shop']."'");
			if($tbl_pixel_ids->num_rows > 0){
				echo '<script type="text/javascript">ShopifyApp.flashError("Pixel Id Already Exists !!");</script>';
			}else{
				if(isset($pixelId[$i]) and $pixelId[$i]!=''){
					$db->query("INSERT INTO tbl_pixel_ids (`pixel_id`,`tax_status`,`shipping_status`,`shop_name`,`created_at`) VALUES('".$pixelId[$i]."','".$tax_status[$i]."','".$shipping_status[$i]."','".$_SESSION['shop']."','".$current_date."') ");
					echo '<script type="text/javascript">ShopifyApp.flashNotice("Pixel Saved Successfully !!");</script>';
				}				
			}
		}
	}else{
		echo '<script type="text/javascript">ShopifyApp.flashError("Pixel Id Field cannot be empty !!");</script>';
	}
}
}
}
/*Insert Pixel Id*/

/*Delete Pixel Id*/
if(isset($_REQUEST['del_id'])){
	echo '<script type="text/javascript">jQuery(".ajaxloader").hide();</script>';
	$db->query("DELETE FROM tbl_pixel_ids WHERE id = '".$_REQUEST['del_id']."' AND shop_name = '".$_SESSION['shop']."'");
	echo '<script type="text/javascript">ShopifyApp.flashNotice("Pixel deleted successfully !!");</script>';
}
/*Delete Pixel Id*/

/*Edit Pixel Id*/
if(isset($_REQUEST['update-pixel'])){
	echo '<script type="text/javascript">jQuery(".ajaxloader").show();</script>';
	$update_pixel_ids = $db->query("SELECT * FROM tbl_pixel_ids WHERE pixel_id = '".$_REQUEST['Update-pixel-id']."' AND shop_name = '".$_SESSION['shop']."'");
	$update_tax = $_REQUEST['Update-tax'] == on ? 1:0;
	$update_shipping = $_REQUEST['update-shipping'] == on ? 1:0;

	if($update_pixel_ids->num_rows > 0){
		$old_pixel_ids = $update_pixel_ids->fetch_assoc();
		if($old_pixel_ids['id'] == $_REQUEST['pixel_main_id']){
			$db->query("UPDATE tbl_pixel_ids SET pixel_id = '".$_REQUEST['Update-pixel-id']."',tax_status = '".$update_tax."',shipping_status = '".$update_shipping."',updated_at = '".date('d-M-Y H:i')."' WHERE id = '".$_REQUEST['pixel_main_id']."' AND shop_name = '".$_SESSION['shop']."'");
			echo '<script type="text/javascript">jQuery(".ajaxloader").hide();</script>';
			echo '<script type="text/javascript">ShopifyApp.flashNotice("Pixel updated successfully !!");</script>';
		}else{
			echo '<script type="text/javascript">jQuery(".ajaxloader").hide();</script>';
			echo '<script type="text/javascript">ShopifyApp.flashError("Pixel Id Already Exists !!");</script>';
		}	
	}else{
		$db->query("UPDATE tbl_pixel_ids SET pixel_id = '".$_REQUEST['Update-pixel-id']."',tax_status = '".$update_tax."',shipping_status = '".$update_shipping."',updated_at = '".date('d-M-Y H:i')."' WHERE id = '".$_REQUEST['pixel_main_id']."' AND shop_name = '".$_SESSION['shop']."'");
		echo '<script type="text/javascript">jQuery(".ajaxloader").hide();</script>';
		echo '<script type="text/javascript">ShopifyApp.flashNotice("Pixel updated successfully !!");</script>';
	}
}
/*Edit Pixel Id*/

/*Get list of all Pixel Ids*/
$get_pixel_ids = $db->query("SELECT * FROM tbl_pixel_ids WHERE shop_name = '".$_SESSION['shop']."'");
/*Get list of all Pixel Ids*/
?>

<div class="Wrapper">
	<div class="main-container">
		<?php include_once 'pixels.php'; ?>
	</div>
</div>



<script type="text/javascript">
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

jQuery('.del_pixel_id').click(function(){
	var form_id = '#'+jQuery(this).attr('data-id');
	jQuery(form_id).submit();
	jQuery('.ajaxloader').show();
});
</script>