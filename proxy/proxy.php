<?php
  //echo "<pre >";
  // session_start();
require __DIR__.'/vendor/autoload.php';
use phpish\shopify;

require __DIR__.'/conf.php';
  //require __DIR__.'../app/include/DBConnection.php';
include_once '../app/include/DBConnection.php';
if(isset($_SESSION['shop'])){
	$storeName = $_SESSION['shop'];
	$query = $db->query("SELECT * FROM tbl_usersettings WHERE store_name='".$storeName."' ORDER BY id DESC LIMIT 1");
	$data = $query->fetch_assoc();
	$access_token = $data['access_token'];
}

$shop = $storeName;
$token = $access_token;

$shopify= shopify\client($shop, SHOPIFY_APP_API_KEY, $token);

$themes = $shopify('GET /admin/themes.json');
foreach ($themes as  $value) {
	if($value['role'] == 'main') {
		$theme_ids = $value['id'];
    //print_r($theme_ids);
	}
}

try
{

	$ShopDetails = $shopify('GET /admin/shop.json');
}

catch (shopify\ApiException $e)
{
      # HTTP status code was >= 400 or response contained the key 'errors'
	echo $e;
	print_r($e->getRequest());
	print_r($e->getResponse());
}
catch (shopify\CurlException $e)
{
      # cURL error
	echo $e;
	print_r($e->getRequest());
	print_r($e->getResponse());
}


//del webhook running
$data = $shopify('GET /admin/webhooks.json');

foreach ($data as $key => $value) {
	if($value['topic'] == 	'app/uninstalled'){
		$shopify('DELETE /admin/webhooks/'.$value['id'].'.json');
	}
}


$webhook_delete = array(
	'webhook' =>
	array(
		'topic' => 'app/uninstalled',
		'address' => 'https://'.$_SERVER['HTTP_HOST'].'/NewPixelApp/app/delhook.php?shop='.$shop,
		'format' => 'json'
	)
);
$result = $shopify('POST /admin/webhooks.json',$webhook_delete);

$resultPixel = $db->query("select * from tbl_pixel_ids WHERE shop_name='".$_SESSION['shop']."'");
while($fetch = mysqli_fetch_array($resultPixel)){
	$pixel_id[] = $fetch['pixel_id'];
	$pix_id = json_encode($pixel_id);
	$taxes[] = $fetch['tax_status'];
	$include_tax = json_encode($taxes);
	$shiping[] = $fetch['shipping_status'];
	$include_shipping = json_encode($shiping);
}
$tax_get_val = $db->query("SELECT enable_tax_ship from tbl_tax_include Where shop_name='".$_SESSION['shop']."'");
if($tax_get_val->num_rows > 0){
	$taxValue  = $tax_get_val->fetch_assoc();
}
$tax_ship  = $taxValue['enable_tax_ship'];
// foreach ($taxes as $key => $value) {
// 	echo $id[] = $value;
// 	// $ship_val = $include_shipping[$key];
// }
$newArray = json_encode(array_combine($pixel_id, $taxes));

$asset_code = array(
	'asset' => array(
		"key" => "assets/logic_trk.js",
		"value"=> "(function() {
			window.FacebookPixel = undefined;
			if (typeof fbq === 'undefined') {
				!function(f,b,e,v,n,t,s)
				{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
					n.callMethod.apply(n,arguments):n.queue.push(arguments)};
					if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
					n.queue=[];t=b.createElement(e);t.async=!0;
					t.src=v;s=b.getElementsByTagName(e)[0];
					s.parentNode.insertBefore(t,s)}(window, document,'script',
					'https://connect.facebook.net/en_US/fbevents.js');
					window.FacebookPixel = fbq;
					var newArr = $pix_id;
					for (var i = 0; i < newArr.length; i++) {
						FacebookPixel('init', newArr[i]);
					}
				
					FacebookPixel('track', 'PageView');
				}
				if (location.pathname.match(/\/products\/.+/)) {
					FacebookPixel('track', 'ViewContent', {
						content_ids: __st.rid,
						content_type: __st.rtyp,
						content_category: meta.product.type,
						content_name: meta.product.variants[0].name,
					});
					jQuery('form[action=\"/cart/add\"]').submit(function() {
						FacebookPixel('track', 'AddToCart', {
							content_ids: __st.rid,
							content_type: __st.rtyp,
							content_category: meta.product.type,
							content_name: name = meta.product.variants[0].name,
						});
					});
				}
				if (location.pathname.match(/^\/cart/)) {
					$('form[action=\"/cart\"]').submit(function(e) {
						FacebookPixel('track', 'InitiateCheckout', {
							content_ids: __st.rid,
							content_type: __st.rtyp,
						});
					});
				}
				if (Shopify.Checkout && Shopify.Checkout.page == 'thank_you') {
					var getOrderID = localStorage.getItem('order_id');
					var orderID = Shopify.checkout.order_id;
					var taxes = $include_tax;
					var shipping = $include_shipping;
					var amount = '';
					var newArr = $pix_id;
					var newLengthPixel  =  $newArray;
					var includeTAxOrNoT = $tax_ship;
					var checkout = Shopify.checkout;

					/*for( z in newLengthPixel){
						console.log(newLengthPixel);
						for( k in newLengthPixel){
							if( z  == k ){
								if(newLengthPixel[k] == 1){
									amount = parseFloat(checkout.total_price);
									console.log(amount);
									console.log('if',newLengthPixel[k]);
									purchase(amount);
									continue;
								}else{
									amount = parseFloat(checkout.subtotal_price);
									console.log(amount);
									console.log('else',newLengthPixel[k]);
									purchase(amount);
									continue;
								}
							}
						}
					}*/

					if(includeTAxOrNoT == true){
						amount = parseFloat(checkout.total_price);
					}else{
						amount = parseFloat(checkout.subtotal_price);
					}
					function purchase(amount) {
						FacebookPixel('track', 'Purchase', {
							content_ids: checkout.line_items[0].product_id,
							content_type: 'product',
							value:amount,
							currency: checkout.currency,
							num_items: checkout.line_items.length,
						});
					}
					purchase(amount);
				}
			})()"
		)
);
$qyet1 = $shopify("PUT /admin/themes/$theme_ids/assets.json",$asset_code);

try
{
	$aset_get = $shopify("GET /admin/themes/$theme_ids/assets.json?asset[key]=assets/logic_trk.js&theme_id=$theme_ids");
	$scropt = $shopify('GET /admin/script_tags.json');
}
catch (shopify\ApiException $e)
{
      # HTTP status code was >= 400 or response contained the key 'errors'
	echo $e;
	print_r($e->getRequest());
	print_r($e->getResponse());
}
catch (shopify\CurlException $e)
{
      # cURL error
	echo $e;
	print_r($e->getRequest());
	print_r($e->getResponse());
}

foreach($scropt as $scrp){
	$delet = $shopify('DELETE /admin/script_tags/'.$scrp["id"].'.json');
}

$pos = strrpos($aset_get['public_url'], '?');
$id = $pos === false ? $aset_get['public_url'] : substr($aset_get['public_url'], $pos + 1);
$data = array(
	'script_tag' => array(
		"event" => "onload",
		"src"=> $aset_get['public_url'],));
try
{
	$fb_query = $shopify('POST /admin/script_tags.json',$data);
}
catch (shopify\ApiException $e)
{
      # HTTP status code was >= 400 or response contained the key 'errors'
	echo $e;
	print_r($e->getRequest());
	print_r($e->getResponse());
}
catch (shopify\CurlException $e)
{
      # cURL error
	echo $e;
	print_r($e->getRequest());
	//print_r($e->getResponse());
}
//$variant_id=$variant_query[0]['id'];
//print_r($fb_query);

//$_SESSION['id'] = $fb_query['id'];
?>





