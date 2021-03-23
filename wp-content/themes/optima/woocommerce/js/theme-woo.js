jQuery(document).ready(function($) {
	gt3_product_single_carousel();
	jQuery('.easyzoom').easyZoom();
	gt3_product_carousel_init ();
	gt3_category_accordion ();
	gt3_animate_cart ();
	gt3_spinner_up_down ();
	gt3_sidebar_products_top();
})

jQuery(window).load(function($) {
	gt3_masonry_shop ();
	if (jQuery(".gt3-animation-wrapper.gt3-anim-product").length) {
		gt3_scroll_animation(jQuery('.gt3-animation-wrapper.gt3-anim-product'), false);
	}
});

function gt3_masonry_shop () {
	if (jQuery('.products.shop_grid_masonry').length) {
		jQuery('.products.shop_grid_masonry').isotope({
			itemSelector: 'li.product',
			sortBy: 'original-order',
			percentPosition: true,
			  masonry: {
			    columnWidth: 1
			  }
		});

		resetShopGrid ();
	}	
}
jQuery(window).resize(function($){
	setTimeout( resetShopGrid ,100)
});

function resetShopGrid () {
	var width = Math.floor(jQuery('.product-default-width').width());
	jQuery('.products.shop_grid_masonry.shop_grid_packery li.product').each(function () {
		var margin = jQuery(this).parent().hasClass('gap_default') ? 30 : 0;
		switch (true) {
			case jQuery(this).hasClass('large'):
				jQuery(this).height(Math.floor(width * 0.8) * 2 + margin);
				break;
			case jQuery(this).hasClass('large_vertical'):
				jQuery(this).height(Math.floor(width * 0.8) * 2 + margin);
				break;
			default:
				jQuery(this).height(Math.floor(width * 0.8));
				break;
		}
	});
	jQuery('.products.shop_grid_masonry.shop_grid_packery li.product').css('opacity', 1);
	jQuery('.products.shop_grid_masonry.shop_grid_packery .bubblingG').css('opacity', 0);
	jQuery('.products.shop_grid_masonry.shop_grid_packery').isotope('layout');
}

function gt3_product_single_carousel () {
	if (jQuery('.thumbnails').length) {
		jQuery('.images, #yith-quick-view-content').each(function(){
			var cur_slidesToShow = 1;
			var cur_sliderAutoplay = 4000;
			var cur_fade = true;

			jQuery(this).find('.gt3-single-woo-slick').slick({
				slidesToShow: cur_slidesToShow,
				slidesToScroll: cur_slidesToShow,
				autoplay: false,
				autoplaySpeed: cur_sliderAutoplay,
				speed: 500,
				dots: false,
				fade: cur_fade,
				focusOnSelect: true,
				arrows: false,
				infinite: false,
				asNavFor: jQuery(this).find('.thumbnails')
			});
			jQuery(this).find('.thumbnails').slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				nextArrow: '<i class="slick-next fa fa-angle-right"></i>',
  				prevArrow: '<i class=" slick-prev fa fa-angle-left"></i>',
				asNavFor: jQuery(this).find('.gt3-single-woo-slick'),
				dots: false,
				focusOnSelect: true,
				infinite: false,
			})
		});
		
	}
}
jQuery( document ).ajaxComplete(function() {
	if( ! jQuery('.gt3-thumbnails-control.slick-slider').length ){
		gt3_thumbnails_slider ();
	}
	var select = jQuery('#yith-quick-view-modal .variations select');
	select.on('change', function(){
		var thumbnails = jQuery('#yith-quick-view-modal .gt3-thumbnails-control');
		var selectEmpty = true;

		select.each(function(){	
		    var easyzoom = jQuery("#yith-quick-view-content .woocommerce-product-gallery__image").easyZoom();
			var api = easyzoom.data('easyZoom');
			api.teardown();
			api._init();

			if ( this.value !== '') {
				selectEmpty = false;
			}
		});

		if ( selectEmpty ) {
			thumbnails.css({'height':'auto'});
		} else {
			thumbnails.find('.gt3-thumb-control-item:first').trigger( "click" );
			thumbnails.css({'height':'0'});
		}
	})
});
function gt3_thumbnails_slider () {
	var controls_wrapper, slider, slides, slide, item;
	slider = jQuery('#yith-quick-view-content .woocommerce-product-gallery__wrapper');
	slides = slider.find('.woocommerce-product-gallery__image');
	controls_wrapper = jQuery('<div class="gt3-thumbnails-control"></div>');

	for (var i = 0; i < slides.length; i++) {
		slide = slides[i];
		item = '<div class="gt3-thumb-control-item"><img src="' + jQuery(slide).attr( 'data-thumb' ) + '"></div>';
		controls_wrapper.append(item);
	}

	slider.parent().append(controls_wrapper);

	imagesLoaded(slider.parent(), gt3_vertical_thumb );
	jQuery('#yith-quick-view-content .woocommerce-product-gallery__image').easyZoom();
}

function gt3_vertical_thumb (){
	jQuery('#yith-quick-view-content').each(function(){
		var cur_slidesToShow = 1;
		var cur_sliderAutoplay = 4000;
		var cur_fade = true;
		
		jQuery(this).find('.woocommerce-product-gallery__wrapper').slick({
			slidesToShow: cur_slidesToShow,
			slidesToScroll: cur_slidesToShow,
			autoplay: false,
			autoplaySpeed: cur_sliderAutoplay,
			speed: 500,
			dots: false,
			fade: cur_fade,
			focusOnSelect: true,
			arrows: false,
			infinite: false,
			asNavFor: jQuery(this).find('.gt3-thumbnails-control')
		});
		jQuery(this).find('.gt3-thumbnails-control').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			nextArrow: '<i class="slick-next fa fa-angle-right"></i>',
				prevArrow: '<i class=" slick-prev fa fa-angle-left"></i>',
			asNavFor: jQuery(this).find('.woocommerce-product-gallery__wrapper'),
			dots: false,
			focusOnSelect: true,
			infinite: false,
		})
		var x = jQuery(this).find('.woocommerce-product-gallery')[0];
		jQuery(x).addClass('ready');
	});	
}
function gt3_product_carousel_init () {
	jQuery('.cross-sells .products').slick({
		autoplay: false,
		slidesToShow: 4,
		slidesToScroll: 1,
		nextArrow: '<i class="slick-next fa fa-angle-right"></i>',
  		prevArrow: '<i class=" slick-prev fa fa-angle-left"></i>',
		dots: false,
		infinite: false,
		responsive: [
		    {
		      breakpoint: 768,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 1
		      }
		    }
		]
	})
}

function gt3_scroll_animation($el, newItem) {
    var order = 0
      , lastOffsetTop = 0;
    jQuery.each($el, function(index, value) {
        var el = jQuery(this);
        el.imagesLoaded(function() {
            var elOffset = el.offset()
              , windowHeight = jQuery(window).outerHeight()
              , delay = 0
              , offset = 20;
            if (elOffset.top > (windowHeight + offset)) {
                if (order == 0) {
                    lastOffsetTop = elOffset.top;
                } else {
                    if (lastOffsetTop != elOffset.top) {
                        order = 0;
                        lastOffsetTop = elOffset.top;
                    }
                }
                order++;
                index = order;
            }
            delay = index * 0.20;
            el.css({
                'transition-delay': delay + 's'
            });
            el.attr('data-delay', delay);
            el.attr('data-delay', delay);
        });
    });
    $el.appear(function() {
        var el = jQuery(this)
          , windowScrollTop = jQuery(window).scrollTop();
        if (newItem) {
            el.addClass('loaded');
        } else {
            var addLoaded = setTimeout(function() {
                el.addClass('loaded');
            }, 300);
            if (windowScrollTop > 100) {
                clearTimeout(addLoaded);
                el.addClass('loaded');
            }
        }
        var elDur = el.css('transition-duration')
          , elDelay = el.css('transition-delay')
          , timeRemove = elDur.split('s')[0] * 1000 + elDelay.split('s')[0] * 1000 + 4000
          , notRemove = '.wil-progress';
        el.not(notRemove).delay(timeRemove).queue(function() {
            el.removeClass('loaded gt3-anim-product').dequeue();
        });
        el.delay(timeRemove).queue(function() {
            el.css('transition-delay', '');
        });
    }, {
        accX: 0,
        accY: 30
    });
}

function gt3_category_accordion () {
	jQuery('.widget_product_categories').each(function(){
		var elements = jQuery(this).find('.product-categories>li.cat-parent');
		for (var i = 0; i < elements.length; i++) {
			jQuery(elements[i]).append("<span class=\"gt3-button-cat-open\"></span>");
		}
	})
	jQuery(".gt3-button-cat-open").on("click", function () {
		jQuery(this).parent().toggleClass('open');
		if (jQuery(this).parent().hasClass('open')) {
			jQuery(this).parent().children('.children').slideDown();
		} else {
			jQuery(this).parent().children('.children').slideUp();
		}
	})
}

/* Cart Count Icon Animation */
function gt3_animate_cart () {
	jQuery.fn.shake = function(intShakes, intDistance, intDuration) {
		this.each(function() {
			for (var x=1; x<=intShakes; x++) {
				jQuery(this).animate({left:(intDistance*-1)}, (((intDuration/intShakes)/4)))
				.animate({left:intDistance}, ((intDuration/intShakes)/2))
				.animate({left:0}, (((intDuration/intShakes)/4)));
			}
		});
		return this;
	};
	jQuery(document.body).live('added_to_cart', function(el, data, params){
		setTimeout(function(){
			jQuery(".gt3_header_builder_cart_component").addClass("show_cart");
			jQuery(".woo_mini-count").shake(3,1.2,300);
		}, 300);
		setTimeout(function(){
			jQuery(".gt3_header_builder_cart_component").removeClass("show_cart");
		}, 2800);
    });
}

/* Input spinner */
function gt3_spinner_up_down () {
	jQuery('body').on('tap click', '.gt3_qty_spinner .quantity-up', function() {
		var input 	= jQuery(this).parent().find('input[type="number"]'),
		max 		= input.attr('max'),
		oldValue 	= parseFloat(input.val());
		if (oldValue >= max && '' != max) {
			var newVal = oldValue;
		} else {
			var newVal = oldValue + 1;
		}
		input.val(newVal);
		input.trigger("change");
	});
	jQuery('body').on('tap click', '.gt3_qty_spinner .quantity-down, .gt3_qty_spinner .quantity-down', function() {
		var input 	= jQuery(this).parent().find('input[type="number"]'),
		min 		= input.attr('min'),
		oldValue 	= parseFloat(input.val());
		if (oldValue <= min && '' != min) {
			var newVal = oldValue;
		} else {
			var newVal = oldValue - 1;
		}
		input.val(newVal);
		input.trigger("change");
	});
}

function gt3_sidebar_products_top(){
	var button = jQuery('.gt3_woocommerce_top_filter_button ');
	var element = jQuery('.gt3_top_sidebar_products');
	if ( jQuery(window).width() < 480) {
		button.on('tap click', function(e){
			e.preventDefault();
			if (element.hasClass('active')) {
				sidebar_close();
			}else{
				sidebar_open();
			}
		});
	} else {
		button.on('tap click', function(e){
			e.preventDefault();
			if (element.hasClass('active')) {
		        sidebar_close();
			}else{
				sidebar_open();
			}
		});
		jQuery(document).on('mouseup', function (e) {
			e.preventDefault();
			if ( element.hasClass('active') && element.has(e.target).length === 0 && button.has(e.target).length === 0 ){
				sidebar_close();
			}
		});
		jQuery(document).keyup(function(e) {
			if (e.keyCode == 27){
				sidebar_close();
			}
		});
	}
	function sidebar_open(){
		button.addClass('active')
		element.addClass('active')
		element.slideDown(300)
	}
	function sidebar_close(){
		button.removeClass('active')
		element.removeClass('active')
		element.slideUp(400)
	}
}
