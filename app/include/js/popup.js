jQuery("body").on('click','.wall',function(e){
	var giftBoxOpen = localStorage.getItem('giftBoxOpen');
	if(giftBoxOpen != 'true') {
		jQuery(this).parents('#cube').find('.main-block').toggleClass('open');
		jQuery(this).parents('#cube').toggleClass('stop-anim');
	}
	afterShuffle();
});

jQuery("body").on('click','.spin',function(e){
	jQuery('.main-block').removeClass('open');
	jQuery('.anim').removeClass('stop-anim');
});

var autoRotate = true,
yDeg = 0,
xDeg = 40,
intervalID;

jQuery('body').on('click','.box',function() {
	var giftBoxOpen = localStorage.getItem('giftBoxOpen');
	if(giftBoxOpen != 'true') {
		jQuery(this).toggleClass('open');
	}
	afterShuffle();
});     

jQuery("body").on('click','.cube-wrapper',function () {
	var giftBoxOpen = localStorage.getItem('giftBoxOpen');
	if(giftBoxOpen != 'true') {
		jQuery(this).toggleClass('open');
	}
	afterShuffle();
});         

jQuery('body').on('click','.spin-btn',function(){
	var email = jQuery('#email').val();
	if(email == '') {
		jQuery('#invalid_email_msg').show();
	} else if(jQuery('#email').val().search('@') < 0 &&  jQuery('#email').val().search('.') <= 0) {
		jQuery('#invalid_email_msg').show();
	} else {
		jQuery('#invalid_email_msg').hide();
		jQuery('#box-container').find('.open').removeClass('open');
		jQuery.ajax({
			url  : server_url,
			type : 'POST',
			data : 'email='+email+'&store_name='+storeName,
			success : function(data) {
				if(data == 1) {
					localStorage.setItem('shuffle',true);
					jQuery('body #box-container .box-shuffle').shuffle();
					jQuery('.spin-details-inner').hide();
				}
			}
		});
	}
}); 

jQuery('body').on('click','.reject-popup',function() {
	jQuery.ajax({
		url  :  server_url,
		type : 'POST',
		data : '&store_name='+storeName+'&reject=reject',
		success : function(data) { }
	});
});
