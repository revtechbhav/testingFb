jQuery(document).ready(function() {
	/*disable or enable giftbox */
	jQuery('#collapse5 .togglebutton').click(function(e){
		e.preventDefault();
		var text = jQuery(this).find('.active').text();
		if(text == 'OFF') {
			jQuery.toast({
				text: 'GiftBox is disabled and will show only in preview!',
				hideAfter: false,
				bgColor: '#fd518b',
				textColor: 'white'
			});
			jQuery('.warning-text').show();
		} else {
			jQuery('.jq-toast-wrap.bottom-left').remove();
			jQuery('.warning-text').hide();
		}
	});
	/*disable or enable giftbox */
	/*Image upload*/
	jQuery('.uploadbuttn').click(function() {
		jQuery(this).next().next().click();
	});

	jQuery("input[type='file']").change(function(){
		var filename = $(this).val();
		var imgClass = $(this).attr('name');
		var extension = filename.replace(/^.*\./, '');
		if(extension == 'png') {
			readURL(this, imgClass);
		} else {
			ShopifyApp.flashError("Only png images are supported.");
		}
	});

	function readURL(input, divClass) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('.'+divClass+' img').show();
				$('.'+divClass+' img').attr('src', e.target.result);
				$('.'+divClass+' img').css('width', '171px').css('height','171px');
			}
			reader.readAsDataURL(input.files[0]);
			ShopifyApp.flashNotice("Uploaded");
		} 
	}
	/*Image upload*/
	/*Change boxs*/
	jQuery('.select-coupon').change(function() {
		var value = jQuery(this).val();
		if(value == 'Free Product') {
			jQuery(this).parent().parent().find('.shopify-product').show();
			jQuery(this).parent().parent().find('input').addClass('text-bold');
			jQuery(this).parent().parent().find('.coupon-code').hide();
			jQuery(this).parent().parent().find('.shopify-product select').attr('name','coupon_code[]');
			jQuery(this).parent().parent().find('.coupon-code input').removeAttr('name');
		} else {
			jQuery(this).parent().parent().find('.shopify-product').hide();
			jQuery(this).parent().parent().find('.coupon-code').show();
			jQuery(this).parent().parent().find('input').removeClass('text-bold');
			jQuery(this).parent().parent().find('.shopify-product select').removeAttr('name');
			jQuery(this).parent().parent().find('.coupon-code input').attr('name','coupon_code[]');
		}
	});
	/*Change boxs*/
	/*open toggle for choose product*/
	jQuery('.edit-details-product').click(function() {
		jQuery('.free_prod_details').removeClass('active');
		jQuery(this).next().addClass('active');
	});
	/*open toggle for choose product*/
	/*close toggle for choose product*/
	jQuery('.free_buttons .btn_close').click(function() {
		jQuery(this).parent().parent().removeClass('active');
	});
	/*close toggle for choose product*/

	/*dropdown with images*/
	try {
		jQuery("body .shopify-product-list").msDropDown();
	} catch(e) {
		alert(e.message);
	}
	/*dropdown with images*/
	/*Gravity handle*/
	jQuery('.change-gravity').change(function() {
		var total_val = 0;
		var total_per = 0;
		jQuery('.change-gravity').each(function() {
			total_val+=parseInt(jQuery(this).val());
		});
		jQuery('.change-gravity').each(function() {
			total_per = jQuery(this).val()/total_val*100;
			jQuery(this).next().children().text(Math.round(total_per));
			jQuery(this).next().next().val(Math.round(total_per));
		});

	});
	/*Gravity handle*/
	/*toggle button*/
	jQuery('.togglebutton').click(function(e) {
		e.preventDefault();
		var text = jQuery(this).find('.active').text();
		jQuery(this).parent().parent().next().find('.disable-me').toggle();
		if(text == 'OFF') {
			jQuery(this).find('input').val(0);
		} else {
			jQuery(this).find('input').val(1);
		}
	});
	jQuery('#show_pull_div').click(function(e) {
		e.preventDefault();
		jQuery('.showpulltab .tabicon .disable-me').toggle();
	});
	jQuery('#show_pull_div').click(function() {
		jQuery('.showpulltab .disable-me').toggle();
	});
	/*toggle button*/
	/*remove image*/
	jQuery('.closebuttn').click(function(){
		var divClass = $(this).next().attr('name');
		jQuery(this).next().val('');
		jQuery(this).next().next().val('');
		jQuery('.'+divClass+' img').removeAttr('src');
		jQuery('.'+divClass+' img').hide();
	});
	/*remove image*/
	/*open box*/
	jQuery(".wall").click(function(e){
		jQuery(this).parents('#cube').find('.main-block').toggleClass('open');
		jQuery(this).parents('#cube').toggleClass('stop-anim')
	});
	jQuery(".spin").click(function(e){
		jQuery('.main-block').removeClass('open');
		jQuery('.anim').removeClass('stop-anim');
	});

	var autoRotate = true,
	yDeg = 0,
	xDeg = 40,
	intervalID;
	jQuery('.box').click(function() {
		jQuery(this).toggleClass('open');
	});     

	jQuery(".cube-wrapper").click(function () {
		jQuery(this).toggleClass("open");
	});            
	/*open box*/

	/*change appearnce of box*/
	jQuery('#box_theme').change(function() {
		var value = jQuery(this).val();
		if(value == 'default') {
			jQuery('#default-box').show();
			jQuery('#shoe-box').hide();
			jQuery('#gift-box').hide();
			jQuery('#default-box .main-block').removeClass('open');
			jQuery('#click_me_txt').css({'margin-top':'50px', 'position':'inital','top': '0px'});
			jQuery('#box_inside_color_div').hide();

			var box_font_color = jQuery('#msg a').css('color'); 
			var box_outside_color = jQuery('.wall').css('background-color'); 
			jQuery('#box_font_color').val(box_font_color);
			jQuery('#box_font_color').css('background',box_font_color);
			jQuery('#box_outside_color').val(box_outside_color);
			jQuery('#box_outside_color').css('background',box_outside_color);

		} else if(value == 'shoe_box') {
			jQuery('#default-box').hide();
			jQuery('#shoe-box').show();
			jQuery('#gift-box').hide();
			jQuery('#shoe-box .box.nike').removeClass('open');
			jQuery('#click_me_txt').css({'position':'relative', 'top':'-230px', 'margin-top':'50px' });
			jQuery('#box_inside_color_div').show();

			var box_font_color = jQuery('.backside span').css('color'); 
			var box_outside_color = jQuery('.box.nike .frontside').css('background-color');
			var box_inside_color_div = jQuery('.box.nike .backside').css('background-color');
			
			jQuery('#box_font_color').val(box_font_color);
			jQuery('#box_outside_color').val(box_outside_color);
			jQuery('#box_inside_color').val(box_inside_color_div);

			jQuery('#box_font_color').css('background',box_font_color);
			jQuery('#box_outside_color').css('background',box_outside_color);
			jQuery('#box_inside_color').css('background',box_inside_color_div);

		} else {
			jQuery('#default-box').hide();
			jQuery('#shoe-box').hide();
			jQuery('#gift-box').show();
			jQuery('#gift-box .cube-wrapper').removeClass('open');
			jQuery('#click_me_txt').css({'margin-top':'0px', 'position':'inital','top': '0px'});
			jQuery('#box_inside_color_div').hide();

			var box_font_color = jQuery('.cube .present .coupon .coupon-front').css('color'); 
			var box_outside_color = jQuery('.cube .front, .cube .back').css('background-color'); 
			//jQuery('#box_background_color').val();
			jQuery('#box_font_color').val(box_font_color);
			jQuery('#box_font_color').css('background',box_font_color);
			jQuery('#box_outside_color').val(box_outside_color);
			jQuery('#box_outside_color').css('background',box_outside_color);

		}
	});

	/*change appearnce of box*/

	/*add url for pages*/
	jQuery('.adyrl').click(function() {
		var data = `<div class="multiple_urls">
								<div class="col-sm-3">
									<select name="url_do[]" class="form-control">
										<option value="does">Does</option>
										<option value="doesnot">Does&#39;t</option>
									</select>
								</div>
								<div class="col-sm-3">
									<select name="url_end[]" class="form-control">
										<option>match</option>
										<option>contain</option>
										<option>begin with</option>
										<option>end with</option>
									</select>
								</div>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="url_link[]" value="https://">
								</div>
								<div class="col-sm-1 psttnabst">
									<span class="btn-default removeButton">X</span>
								</div>
							</div>`;
		jQuery('.add_url_pages').append(data);		
	});
	/*add url for pages*/
	/*remove url*/
	jQuery('body').on('click','.removeButton',function(){
		jQuery(this).parent().parent().remove();
	});
	/*remove url*/
	jQuery('.shopify-product-list').change(function(){
		jQuery(this).parent().next().next().val(jQuery('option:selected', this).attr('data-image'));
	});
});

function BoxBgColor(color) {
	$('.greycolor').css('background-color','#'+color);
}
function BoxFontColor(color) {
	$('#msg a').css('color', '#'+color);
	$('.backside span').css('color', '#'+color);
	$('.cube .present .coupon .coupon-front, .cube .present .coupon .coupon-back').css('color','#'+color);
}
function BoxOutsideColor(color) {
	var value = jQuery('#box_theme :selected').val();
	if(value == 'default') {
		$('.wall').css('background-color','#'+color);
	} else if(value == 'shoe_box') {
		console.log('b');
		$('.box.nike .frontside').css('background-color','#'+color);
		$('.box.nike .face.front .flap').css('background-color','#'+color);
	} else {
		$('.cube .top div').css('background-color','#'+color);
		$('.cube .front').css('background-color','#'+color);
		$('.cube .back').css('background-color','#'+color);
		$('.cube .right').css('background-color','#'+color);
		$('.cube .left').css('background-color','#'+color);
		$('.cube .bottom').css('background-color','#'+color);
	}

}
function BoxInsideColor(color) {
	$('.box.nike .backside').css('background-color','#'+color);
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}