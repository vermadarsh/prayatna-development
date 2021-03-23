"use strict";
jQuery(document).ready(function($) {
	
	$('.ypop-modal .ypop-wrapper').prepend( $('.ypop-modal .ypop-header') );
	$('.ypop-modal .ypop-header').css({'height':'auto'});
	$('.ypop-modal input').on('focus', function() {
		$(this).parent().prev('label').addClass('hide');
	}).on('blur',function(){
		if( $(this).val() == ""){
			$(this).parent().prev('label').removeClass('hide');
		}
	});
});