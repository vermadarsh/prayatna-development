"use strict";
var header = jQuery('.main_header'),
	footer = jQuery('.main_footer'),
	main_wrapper = jQuery('.main_wrapper'),
	site_wrapper = jQuery('.site_wrapper'),
	nav = jQuery('nav.main_nav'),
	menu = nav.find('ul.menu'),
	html = jQuery('html'),
	body = jQuery('body'),
	myWindow = jQuery(window);


(function gt3_preloader () {
	setTimeout(function(){
		jQuery('#loading').fadeOut();
	},8000);
}());

jQuery(document).ready(function($) {

	var ie = (function(){

	    var undef,
	        v = 3,
	        div = document.createElement('div'),
	        all = div.getElementsByTagName('i');
	    
	    while (
	        div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
	        all[0]
	    );
	   
	    return v > 4 ? v : undef;
	    
	}());

	if (ie == 9) {
		jQuery('body').addClass('ie_9');
	}

	gt3_search();
	gt3_mobile_menu();
	gt3_menu_line();
	gt3_sticky_header ();
	gt3_message_close();
	gt3_custom_price_button ();
	gt3_back_to_top();

	if (jQuery('.pp_block').size() > 0) {
		html.addClass('pp_page');
	}
	if(jQuery('.gt3_js_bg_img').size() > 0) {
		jQuery('.gt3_js_bg_img').each(function(){
			jQuery(this).css('background-image', 'url('+jQuery(this).attr('data-src')+')');
		});
	}
	if(jQuery('.gt3_js_bg_color').size() > 0) {
		jQuery('.gt3_js_bg_color').each(function(){
			jQuery(this).css('background-color', jQuery(this).attr('data-bgcolor'));
		});
	}
	if(jQuery('.gt3_js_color').size() > 0) {
		jQuery('.gt3_js_color').each(function(){
			jQuery(this).css('color', jQuery(this).attr('data-color'));
		});
	}
	if(jQuery('.gt3_js_transition').size() > 0) {
		jQuery('.gt3_js_transition').each(function(){
			var transition_time = jQuery(this).attr('data-transition') + 'ms';
			jQuery(this).css({'transition-duration': transition_time});
		});
	}

	//Flickr Widget
	if (jQuery('.flickr_widget_wrapper').size() > 0) {
		jQuery('.flickr_badge_image a').each(function() {
			jQuery(this).append('<div class="flickr_fadder"></div>');
		});
	}

	//Blank Anchors
	jQuery('a[href="#"]').on('click', function(e) {
		e.preventDefault();
	});

	// Nivoslider
	if (jQuery('.nivoSlider').size() > 0) {
		jQuery('.nivoSlider').each(function() {
			jQuery(this).nivoSlider({
				directionNav: true,
				controlNav: false,
				effect:'fade',
				pauseTime:4000,
				slices: 1
			});
		});
	}

	// Gt3 Carousel List
	gt3_carousel_list ();

	// // GT3 Testimonials List
	gt3_testimonials_list ();

	// Slick Slider Arrows
	gt3_slick_slider_arrows ();
	var carousel_arrows_tag = jQuery('.gt3_module_featured_posts .carousel_arrows');
	if (carousel_arrows_tag.length) {
		carousel_arrows_tag.each(function() {
			jQuery(this).find('a.left_slick_arrow').on("click", function() {
				jQuery(this).parents('.gt3_module_carousel').find('.slick-prev').trigger('click');
			});
			jQuery(this).find('a.right_slick_arrow').on("click", function() {
				jQuery(this).parents('.gt3_module_carousel').find('.slick-next').trigger('click');
			});
		});
	}

	if (jQuery('.gt3-contact-widget').length) {
		jQuery('.gt3-contact-widget_label').on('click', function () {
			jQuery('.gt3-contact-widget').toggleClass('open');
		})
	}

	// GT3 Countdown
	gt3_countdown_module ();

	// GT3 Flicker Widget
	gt3_flickr_widget ();

	// GT3 Popup Video
	gt3_popup_video ();

	// Typed text
	gt3_text_typed ();

	gt3_includes_js ();

	// Column Separators
	gt3_initRowseparator();

	gt3_portfolio_isotope();
	gt3_team_isotope();

	gt3_portfolio_load_more_init();
	gt3_team_load_more_init();

	// GT3 Progress Bar
	gt3_progress_bar ();

	// GT3 Modal Login
	gt3_modal_login ();

	// GT3 Services Box
	gt3_services_box ();

});


function gt3_includes_js () {
	if (jQuery('.gt3_module_counter').length) {
		// GT3 Counter
		gt3_initCounter();
	}
	// GT3 Button
	if (jQuery('.gt3_btn_customize').length) {
		jQuery('.gt3_btn_customize').each(function() {
			var this_btn = jQuery(this).find('a');
			var body_tag = jQuery('body');

			// Default Attributes
			var btn_default_bg = this_btn.attr('data-default-bg');
			var btn_default_color = this_btn.attr('data-default-color');
			var btn_default_border_color = this_btn.attr('data-default-border');
			var btn_default_icon = jQuery(this).find('.gt3_btn_icon').attr('data-default-icon');

			// Hover Attributes
			var btn_hover_bg = this_btn.attr('data-hover-bg');
			var btn_hover_color = this_btn.attr('data-hover-color');
			var btn_hover_border_color = this_btn.attr('data-hover-border');
			var btn_hover_icon = jQuery(this).find('.gt3_btn_icon').attr('data-hover-icon');

			// Theme Color
			var theme_color = body_tag.attr('data-theme-color');

			this_btn.mouseenter(function(){
				// Button Hover Bg
				if(typeof btn_hover_bg !== 'undefined') {
					this_btn.css({'background-color' : btn_hover_bg});
				} else {
					this_btn.css({'background-color' : '#ffffff'});
				}
				// Button Hover Text Color
				if(typeof btn_hover_color !== 'undefined') {
					this_btn.css({'color' : btn_hover_color});
				} else {
					this_btn.css({'color' : theme_color});
				}
				// Button Hover Border Color
				if(typeof btn_hover_border_color !== 'undefined') {
					this_btn.css({'border-color' : btn_hover_border_color});
				} else {
					this_btn.css({'border-color' : theme_color});
				}
				// Button Hover Icon Color
				if(typeof btn_hover_icon !== 'undefined') {
					this_btn.find('.gt3_btn_icon').css({'color' : btn_hover_icon});
				} else {
					this_btn.find('.gt3_btn_icon').css({'color' : '#ffffff'});
				}
			}).mouseleave(function(){
				// Button Default Bg
				if(typeof btn_default_bg !== 'undefined') {
					this_btn.css({'background-color' : btn_default_bg});
				} else {
					this_btn.css({'background-color' : theme_color});
				}
				// Button Default Text Color
				if(typeof btn_default_color !== 'undefined') {
					this_btn.css({'color' : btn_default_color});
				} else {
					this_btn.css({'color' : '#ffffff'});
				}
				// Button Default Border Color
				if(typeof btn_default_border_color !== 'undefined') {
					this_btn.css({'border-color' : btn_default_border_color});
				} else {
					this_btn.css({'border-color' : theme_color});
				}
				// Button Default Icon Color
				if(typeof btn_default_icon !== 'undefined') {
					this_btn.find('.gt3_btn_icon').css({'color' : btn_default_icon});
				} else {
					this_btn.find('.gt3_btn_icon').css({'color' : '#ffffff'});
				}
			});

		});
	}
}

function gt3_mega_menu(){
	jQuery('.gt3_header_builder > .gt3_header_builder__container .gt3_megamenu_active > .sub-menu, .gt3_header_builder > .sticky_header > .gt3_header_builder__container .gt3_megamenu_active > .sub-menu').each(function(){
		jQuery(this).find('.gt3_megamenu_triangle').css({
			'margin-left':'0px',
		})
		jQuery(this).css({
			'margin-left':'0px',
		})
		var elementWidth = jQuery(this).outerWidth();
		var windowWidth = jQuery(window).width();
		if (elementWidth > (windowWidth - 50) || jQuery(this).hasClass('huge_number_of_column')) {
			elementWidth = windowWidth - 50;
			jQuery(this).addClass('huge_number_of_column');
			var menu_item_width = jQuery(this).children('.menu-item').outerWidth();
			var namber_item_per_row = Math.floor(elementWidth/menu_item_width);	
			var item_count = jQuery(this).children('.menu-item').length;
			var i = 1;
			var last_item_begin_from = (Math.floor(item_count / namber_item_per_row) * namber_item_per_row);
			jQuery(this).children('.menu-item').each(function(){
				i++;
				if (last_item_begin_from < i) {
					jQuery(this).css('max-width',(menu_item_width - 70/*padding value*/)+'px');
				}
				
			})
		}else{
			jQuery(this).removeClass('huge_number_of_column');
		}
		var halfWidth = Math.round(elementWidth/2);

		var leftOffset = jQuery(this).offset().left - halfWidth;
		var rightOffset = windowWidth - (leftOffset + elementWidth);
		if (rightOffset < 25) {
			halfWidth = halfWidth + 25 - rightOffset;
		}
		if (leftOffset < 25) {
			halfWidth = halfWidth - 25 + leftOffset;
		}
		jQuery(this).find('.gt3_megamenu_triangle').css({
			'margin-left':(halfWidth-34)+'px',
		})
		jQuery(this).css({
			'margin-left':-halfWidth+'px',
		})
	})
}

jQuery(window).resize(function() {
	if (jQuery(window).width() >= 1200) {
		gt3_mega_menu();
	}
})


function gt3_popup_video () {
	if (jQuery(".swipebox-video, .swipebox").length) {
		jQuery( '.swipebox-video, .swipebox' ).swipebox( {
			useCSS : true, // false will force the use of jQuery for animations
			useSVG : true, // false to force the use of png for buttons
			initialIndexOnArray : 0, // which image index to init when a array is passed
			hideCloseButtonOnMobile : false, // true will hide the close button on mobile devices
			removeBarsOnMobile : true, // false will show top bar on mobile devices
			hideBarsDelay : 3000, // delay before hiding bars on desktop
			videoMaxWidth : 1140,
			autoplayVideos: false,
			beforeOpen: function() {}, // called before opening
			afterOpen: null, // called after opening
			afterClose: function() {}, // called after closing
			loopAtEnd: false // true will return to the first image after the last image is reached
		} );
	}
}

function gt3_back_to_top(){
	var W_height = jQuery(window).height();
	var element = jQuery('#back_to_top');
	if (element.length) {
		element.on("click", function() {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 500);
			return false;
		});
		var show_back_to_top = function (){
			if (jQuery(document).scrollTop() < W_height) {
	        	element.removeClass('show');
	        }else{
	        	element.addClass('show');
	        }
		}
		show_back_to_top();
		jQuery(window).scroll(function() {
	        show_back_to_top();
	    });
	}	
}

// menu line
function gt3_menu_line(){
	var menu = jQuery('.main-menu.main_menu_container.menu_line_enable > ul');
	if (menu.length) {
		menu.each(function(){
			var menu = jQuery(this);
			var current = '';
			menu.append('<span class="menu_item_line"></span>');
			var menu_item = menu.find('> .menu-item');
			var currentItem = menu.find('> .current-menu-item');
			var currentItemParent = menu.find('> .current-menu-ancestor');
			var line = menu.find('.menu_item_line');
			if (currentItem.length || currentItemParent.length) {
				current = currentItem.length ? currentItem : (currentItemParent.length ? currentItemParent : '');
				line.css({width: current.find('>a').outerWidth()});
				line.css({left: current.find('>a').offset().left - menu.offset().left});
			}

			menu_item.mouseenter(function(){
                line.css({width: jQuery(this).find('> a').outerWidth()});
                line.css({left: jQuery(this).find('> a').offset().left - jQuery(this).parent().offset().left});
            });

            menu.mouseleave(function(){
                if (current.length) {
                    line.css({width: current.find('> a').outerWidth()});
                    line.css({left: current.find('> a').offset().left - menu.offset().left});
                } else {
                	line.css({width:'0'});
                    line.css({left:'100%'});
                }
            });


		})
	}
}

function gt3_sticky_header (){
	if (jQuery(window).width() > 1200) {
		var stickyNumber = jQuery('.gt3_header_builder').height();
		var stickyHeader = jQuery('.gt3_header_builder > .sticky_header');
		var docScroll = jQuery(document).scrollTop();
		var docScrollNext = jQuery(document).scrollTop();
		if (stickyHeader.length) {
			var stickyType = stickyHeader.attr('data-sticky-type');
			if (stickyHeader[0].hasAttribute('data-sticky-number')) {
				stickyNumber = stickyHeader.attr('data-sticky-number');
			}
			var stickyOn = function(){
				docScroll = jQuery(document).scrollTop();
				if (stickyType == 'classic') {
					if (docScroll < stickyNumber) {
						stickyHeader.removeClass('sticky_on')
					}else{
						stickyHeader.addClass('sticky_on')
					}
				}else{
					if (( docScrollNext < docScroll) || (docScroll < stickyNumber) ) {
						stickyHeader.removeClass('sticky_on')
					}else{
						stickyHeader.addClass('sticky_on')
					}				
				}	
				docScrollNext = jQuery(document).scrollTop();		

			}
			stickyOn();
			jQuery(window).scroll(function() {
	            stickyOn();
	        });
		}
	}

}

// mobile menu
function gt3_mobile_menu(){
	var windowW = jQuery(window)
	var loaded = false;
	var main_menu = jQuery('.mobile_menu_container .main-menu > ul');
	var sub_menu = jQuery('.mobile_menu_container .main-menu > ul ul');
	var mobile_toggle = jQuery('.mobile-navigation-toggle');
	if (windowW.width() <= 1200) {
		sub_menu.hide().removeClass('showsub')
		main_menu.hide().addClass('mobile_view_on');
		loaded = true;
		gt3_mobile_menu_switcher(main_menu)		
	}else{
		sub_menu.show();
		main_menu.show();
	}

	jQuery(window).resize(function() {
		if (windowW.width() <= 1200) {
			if (!mobile_toggle.hasClass('is-active')) {
				sub_menu.hide().removeClass('showsub')
				main_menu.hide().removeClass('showsub').addClass('mobile_view_on');
				mobile_toggle.removeClass('is-active')
			}
			if (loaded == false) {
				loaded = true;
				gt3_mobile_menu_switcher(main_menu)
			}		
		}else{
			sub_menu.show().removeClass('showsub');
			main_menu.show().removeClass('showsub').removeClass('mobile_view_on');
			mobile_toggle.removeClass('is-active')
		}
	});
}
// end mobile menu 

function gt3_mobile_menu_switcher(main_menu){
	if (jQuery(main_menu).find('.menu-item-has-children > .mobile_sitcher').length == 0) {
		jQuery(main_menu).find('.menu-item-has-children').append('<div class="mobile_sitcher"></div>')
	}
	jQuery('.mobile-navigation-toggle').on("tap click", function() {
		var element = jQuery(this);
		if (element.hasClass('is-active')) {
			main_menu.removeClass('showsub').slideUp(200)
			element.removeClass('is-active')
		}else{
			main_menu.addClass('showsub').slideDown(200)
			element.addClass('is-active')
		}
	});

	jQuery(main_menu).find('.menu-item-has-children > .mobile_sitcher , .menu-item-has-children > a[href*=#]').on("tap click", function(e) {
		e.preventDefault();
		var element = jQuery(this);
		if (element.hasClass('is-active')) {
			element.prev('ul.sub-menu').removeClass('showsub').slideUp(200)
			element.next('ul.sub-menu').removeClass('showsub').slideUp(200)
			element.removeClass('is-active')
		}else{
			element.prev('ul.sub-menu').addClass('showsub').slideDown(200)
			element.next('ul.sub-menu').addClass('showsub').slideDown(200)
			element.addClass('is-active')
		}
	});
}

function gt3_search(){
	var top_search = jQuery('.header_search');

	if (top_search.size() > 0) {
		top_search.each(function () {

			var $ctsearch = jQuery(this),
				$ctsearchinput = $ctsearch.find('input.search_text'),
				$body = jQuery('html, body'),
				openSearch = function () {
					$ctsearch.data('open', true).addClass('ct-search-open');
					$ctsearchinput.focus();
					return false;
				},
				closeSearch = function () {
					$ctsearch.data('open', false).removeClass('ct-search-open');
				};

			$ctsearchinput.on('click', function (e) {
				e.stopPropagation();
				$ctsearch.data('open', true);
			});

			$ctsearch.on('click', function (e) {
				e.stopPropagation();
				if (!$ctsearch.data('open')) {
					openSearch();
					$body.on('click', function (e) {
						closeSearch();
					});
				}
				else {
					if ($ctsearchinput.val() === '') {
						closeSearch();
						return false;
					}
				}
			});

			top_search.on('click', function(){
				var element = jQuery(this);
				if (element.hasClass('ct-search-hover')) {
					element.removeClass('ct-search-hover');
				}else{
					element.addClass('ct-search-hover');
					setTimeout(function(){
						element.find('input.search_text').focus();
					}, 100);
				}
			})

		});
	}

	jQuery(".search_form .search_submit").on("mouseover", function(){
		jQuery(this).parents('.search_form').addClass("button-hover");
	})
	jQuery(".search_form .search_submit").on("mouseleave", function(){
		jQuery(this).parents('.search_form').removeClass("button-hover");
	})
}

function gt3_message_close(){
	jQuery(".gt3_message_box-closable").each(function(){
		var element = jQuery(this);
		element.find('.gt3_message_box__close').on('click',function(){
			element.slideUp(300);
		})
	})
}

jQuery(window).resize(function() {
	// Slick Slider Arrows
	gt3_slick_slider_arrows ();
	// Blog Isotope reLayout
	gt3_blog_isotope_update_js ();
	// GT3 Services Box
	gt3_services_box ();
});

jQuery(window).load(function() {
	gt3_isotope_team ();
	// Blog Isotope reLayout
	/*gt3_blog_isotope_update_js ();*/
	gt3_blog_isotope_js ();
	resize_visual ();
	jQuery('#loading').fadeOut();
});

function resize_visual () {
	if (jQuery('.vc_row-o-full-height').length) {
		var w = window.innerWidth;
		var leftPosition = jQuery('.vc_row-o-full-height')[0].style.left;
		if (leftPosition.length) {
			var re = /\d+/i;
			var found = leftPosition.match(re);
			var found = parseInt(found[0], 10) + 9;

			jQuery('.vc_row-o-full-height')[0].style.width = w + "px";
			jQuery('.vc_row-o-full-height')[0].style.left = -found + "px";
		}		
	}
}

// Slick Slider Arrows
function gt3_slick_slider_arrows () {
	var carousel_arrows_tag = jQuery('.gt3_module_featured_posts .carousel_arrows');
	if (carousel_arrows_tag.length) {
		carousel_arrows_tag.each(function() {
			if (jQuery(this).parents('.gt3_module_carousel').find('.slick-arrow').length) {
				jQuery(this).removeClass('hidden_block');
			} else {
				jQuery(this).addClass('hidden_block');
			}
		});
	}
}

// -------------------- //
// --- GT3 COMPOSER --- //
// -------------------- //

// GT3 Counter
function gt3_initCounter() {
	if (jQuery('.gt3_module_counter').length) {
		if (jQuery(window).width() > 760) {       
			jQuery('.gt3_module_counter').each(function(){
				if (jQuery(this).offset().top < jQuery(window).height()) {
						var cur_this = jQuery(this);
					if (!jQuery(this).hasClass('done')) {
						var stat_count = cur_this.find('.stat_count'),
							set_count = stat_count.attr('data-value'),
							counter_suffix = stat_count.attr('data-suffix'),
							counter_prefix = stat_count.attr('data-prefix');

						jQuery(this).find('.stat_temp').stop().animate({width: set_count}, {duration: 3000, step: function(now) {
								var data = Math.floor(now);
								stat_count.text(counter_prefix + data + counter_suffix);
							}
						}); 
						jQuery(this).addClass('done');
					}                           
				} else {
					var cur_this = jQuery(this);
					jQuery(this).waypoint(function(){
						if (!cur_this.hasClass('done')) {
							var stat_count = cur_this.find('.stat_count'),
								set_count = stat_count.attr('data-value'),
								counter_suffix = stat_count.attr('data-suffix'),
								counter_prefix = stat_count.attr('data-prefix');
							cur_this.find('.stat_temp').stop().animate({width: set_count}, {duration: 3000, step: function(now) {
									var data = Math.floor(now);
									stat_count.text(counter_prefix + data + counter_suffix);
								}
							}); 
							cur_this.addClass('done');
						}
					},{offset: 'bottom-in-view'});                              
				}                                                       
			});
		} else {
			jQuery('.gt3_module_counter').each(function(){
				var stat_count = jQuery(this).find('.stat_count'),
					set_count = stat_count.attr('data-value'),
					counter_suffix = stat_count.attr('data-suffix'),
					counter_prefix = stat_count.attr('data-prefix');
				jQuery(this).find('.stat_temp').stop().animate({width: set_count}, {duration: 3000, step: function(now) {
						var data = Math.floor(now);
						stat_count.text(counter_prefix + data + counter_suffix);
					}
				}); 
			},{offset: 'bottom-in-view'});  
		}
	}
}

function gt3_isotope_team () {
	if (jQuery(".isotope").length) {
		jQuery(".isotope").isotope({
			itemSelector: ".item-team-member, .gt3_practice_list__item"
		});
		setTimeout(function(){
			jQuery(".isotope").addClass('isotope_loaded');
		},100);
		
	}
	jQuery(window).on('resize', function() {
		jQuery(".isotope").each(function () {
			jQuery(this).isotope({
				itemSelector: ".item-team-member, .gt3_practice_list__item"
			})
		})
	})
	jQuery(".isotope-filter a").on("click", function (e){
		e.preventDefault();
		var data_filter = this.getAttribute("data-filter");
		jQuery(this).siblings().removeClass("active");
		jQuery(this).addClass("active");
		var grid = this.parentNode.nextElementSibling;
		jQuery(grid).isotope({ filter: data_filter });
	});
}
function gt3_custom_price_button () {
	jQuery(".shortcode_button").each(function(){
		if (jQuery(this).attr('data-btn-color')) {
			var curent_color = jQuery(this).attr('data-btn-color');
			this.style.borderColor = curent_color;
			this.style.backgroundColor = curent_color;
			this.style.color = "#ffffff";
			jQuery(this).on({
				mouseenter: function() {
				    this.style.backgroundColor = "#ffffff";
				    this.style.color = curent_color;
				}, mouseleave: function() {
				    this.style.backgroundColor = curent_color;
				    this.style.color = "#ffffff";
				}
			})
		}
	})

	jQuery(".shortcode_button.alt").each(function(){
		if (jQuery(this).attr('data-btn-color')) {
			var curent_color = jQuery(this).attr('data-btn-color');
			this.style.borderColor = curent_color;
			this.style.backgroundColor = "#ffffff";
			this.style.color = curent_color;
			jQuery(this).on({
				mouseenter: function() {
				    this.style.backgroundColor = curent_color;
				    this.style.color = "#ffffff";
				}, mouseleave: function() {
				    this.style.backgroundColor = "#ffffff";
				    this.style.color = curent_color;
				}
			})
		}
	})
}

// Blog Isotope
function gt3_blog_isotope_js () {
	if (jQuery(".isotope_blog_items").length) {
		jQuery('.isotope_blog_items').isotope({
			itemSelector: '.element'
		});
	}
}

// Blog Isotope reLayout
function gt3_blog_isotope_update_js () {
	if (jQuery(".isotope_blog_items").length) {
		jQuery('.isotope_blog_items').isotope('layout');
	}
}

// Gt3 Carousel List
function gt3_carousel_list () {
	var carousel_tag = jQuery('.gt3_carousel_list');
	if (carousel_tag.length) {
		carousel_tag.each(function(){
			jQuery(this).slick({
			});
		});
	}
}

// Gt3 Testimonials
function gt3_testimonials_list () {
	if (jQuery('.module_testimonial.type4').length) {
		jQuery('.module_testimonial.type4').each(function(){
			var cur_img = jQuery(this).find('.testimonials_photo');
			var wrapper_img = '<span class=\"testimonials-photo-wrapper\">';
			for (var i=0; i < cur_img.length; i++) {
				wrapper_img += cur_img[i].outerHTML;
				console.log(cur_img[i].outerHTML)
			}
			wrapper_img += '</span>';
			jQuery(this).prepend(wrapper_img);
			console.log(wrapper_img);
		})
	}
	if (jQuery('.module_testimonial.active-carousel').length) {
		jQuery('.module_testimonial.active-carousel').each(function(){
			var dots_bool = false;
			var arrows_bool = false;
			if (jQuery(this).hasClass('arrows')) {
				arrows_bool = true;
			}
			if (jQuery(this).hasClass('dots')) {
				dots_bool = true;
			}
			var cur_slidesToShow = jQuery(this).attr('data-slides-per-line')*1;
			var cur_sliderAutoplay = jQuery(this).attr('data-autoplay-time')*1;
			var cur_fade = jQuery(this).attr('data-slider-fade') == 1;
			jQuery(this).find('.testimonials_rotator').slick({
				slidesToShow: cur_slidesToShow,
				slidesToScroll: cur_slidesToShow,
				autoplay: true,
				autoplaySpeed: cur_sliderAutoplay,
				speed: 500,
				dots: dots_bool,
				fade: cur_fade,
				focusOnSelect: true,
				arrows: arrows_bool,
				infinite: true,
				asNavFor: jQuery(this).find('.testimonials-photo-wrapper'),
				responsive: [
				{
					breakpoint: 800,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
				]
			});
			jQuery(this).find('.testimonials-photo-wrapper').slick({
				slidesToShow: 3,
				slidesToScroll: 1,
				asNavFor: jQuery(this).find('.testimonials_rotator'),
				dots: false,
				centerMode: true,
				focusOnSelect: true
			})
		});
	}
}

// GT3 Countdown
function gt3_countdown_module () {
	if (jQuery('.gt3-countdown').length) {
		jQuery('.gt3-countdown').each(function () {
			var year = jQuery(this).attr('data-year');
			var month = jQuery(this).attr('data-month');
			var day = jQuery(this).attr('data-day');
			var hours = jQuery(this).attr('data-hours');
			var min = jQuery(this).attr('data-min');

			var austDay = new Date();
			austDay = new Date(+year, +month-1, +day, +hours, +min);
			jQuery(this).countdown({
				until: austDay,
				padZeroes: true,
				labels: [jQuery(this).attr('data-label_years'),jQuery(this).attr('data-label_months'),jQuery(this).attr('data-label_weeks'),jQuery(this).attr('data-label_days'),jQuery(this).attr('data-label_hours'),jQuery(this).attr('data-label_minutes'),jQuery(this).attr('data-label_seconds')],
				labels1:[jQuery(this).attr('data-label_year'),jQuery(this).attr('data-label_month'),jQuery(this).attr('data-label_week'),jQuery(this).attr('data-label_day'),jQuery(this).attr('data-label_hour'),jQuery(this).attr('data-label_minute'),jQuery(this).attr('data-label_second')]
			});
		});
	}
}

// GT3 Flicker Widget
function gt3_flickr_widget () {
	if (jQuery('.flickr_widget_wrapper').length) {
		jQuery('.flickr_widget_wrapper').each(function () {
			var flickrid = jQuery(this).attr('data-flickrid');
			var widget_id = jQuery(this).attr('data-widget_id');
			var widget_number = jQuery(this).attr('data-widget_number');
			jQuery(this).addClass('flickr_widget_wrapper_'+flickrid);

			jQuery.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id="+widget_id+"&lang=en-us&format=json&jsoncallback=?", function(data){
				jQuery.each(data.items, function(i,item){
					if(i<widget_number){
						jQuery("<img/>").attr("src", item.media.m).appendTo(".flickr_widget_wrapper_"+flickrid).wrap("<div class=\'flickr_badge_image\'><a href=\'" + item.link + "\' target=\'_blank\' title=\'Flickr\'></a></div>");
					}
				});
			});
		});
	}
}

// Post Like
jQuery(document).on("click", ".post_likes_add", function(event) {
	var post_likes_this = jQuery(this);
	if (!jQuery.cookie(post_likes_this.attr('data-modify')+post_likes_this.attr('data-postid'))) {
		jQuery.post(object_name.gt3_ajaxurl, {
			action:'add_like_attachment',
			attach_id:jQuery(this).attr('data-postid')
		}, function (response) {
			console.log(response);
			jQuery.cookie(post_likes_this.attr('data-modify')+post_likes_this.attr('data-postid'), 'true', { expires: 7, path: '/' });
			post_likes_this.addClass('already_liked');
			post_likes_this.find('span.like_count').text(response);
			var title_text = '';
			if (typeof post_likes_this.attr('title') != 'undefined') {
				title_text = post_likes_this.attr('title').split(/[0-9]+/);
			}
			post_likes_this.attr('title',response+title_text[1])
		});
	}
});

// Typed text
function gt3_text_typed () {
	if (jQuery('.gt3_typed').length) {
		var count = jQuery('.gt3_typed_text').data('count');
		var text = [];
		for (var x = 0; x < count; x++) {
			var data = jQuery('.gt3_typed_text').data('text-'+x);
			if (data != undefined) {
				text.push(data);
			}
		}
		var typed = new Typed('.gt3_typed_text', {
			strings: text,
			typeSpeed: 100,
			backSpeed: 50,
			smartBackspace: true,
			loop: true
		});
	}
}

// Column Separators
function gt3_initRowseparator() {
	var row_has_column_separator_tag = jQuery('.row_has_column_separator');
	if (row_has_column_separator_tag.length) {
		row_has_column_separator_tag.each(function () {
			var border_color = jQuery(this).attr('data-separator-color');
			jQuery(this).find('.wpb_column > .vc_column-inner > .wpb_wrapper').addClass('column_separator_wrap').css("border-color", border_color).parent().addClass('column_separator_parent');
		});
	}
}

// Portfolio
function gt3_portfolio_isotope(){
	jQuery('.gt3_portfolio_list__posts-container').each(function(){
		var element = jQuery(this);
		var layoutMode = element.hasClass('isotope_packery') ? 'masonry' : 'fitRows';

		element.find('.gt3_portfolio_list__item:not(.image_loaded)').each(function(){
			var element_item = jQuery(this);
			element_item.find('img').imagesLoaded().always(function(instance ){
				jQuery(instance.elements).parents('.gt3_portfolio_list__item').addClass('image_loaded');
			})
		})

		element.isotope({
			itemSelector: '.gt3_portfolio_list__item',
			percentPosition: true,
			masonry: {
				columnWidth: '.gt3_portfolio_list__grid-sizer',
				gutter: '.gt3_portfolio_list__grid-gutter'
			}
		});

		element.imagesLoaded(function(){
			element.isotope({
				itemSelector: '.gt3_portfolio_list__item',
				percentPosition: true,
				masonry: {
					columnWidth: '.gt3_portfolio_list__grid-sizer',
					gutter: '.gt3_portfolio_list__grid-gutter'
				}
			});
		});

		element.parent('.gt3_portfolio_list').find(".gt3_portfolio_list__filter.isotope-filter a").on( 'click', function(){
			var filter_item = jQuery(this);
			filter_item.siblings().removeClass('active');
			filter_item.addClass("active");
			var selector = filter_item.attr('data-filter');
			element.isotope({
				filter: selector,
			});
			return false;
		});

	})
}

// team
function gt3_team_isotope(){
	jQuery('.gt3_team_list__posts-container').each(function(){
		var element = jQuery(this);
		var layoutMode = element.hasClass('isotope_packery') ? 'masonry' : 'fitRows';

		element.find('.gt3_team_list__item:not(.image_loaded)').each(function(){
			var element_item = jQuery(this);
			element_item.find('img').imagesLoaded().always(function(instance ){
				jQuery(instance.elements).parents('.gt3_team_list__item').addClass('image_loaded');
			})
		})

		element.isotope({
			itemSelector: '.gt3_team_list__item',
			percentPosition: true,
			masonry: {
				columnWidth: '.gt3_team_list__grid-sizer',
				gutter: '.gt3_team_list__grid-gutter'
			}
		});

		element.imagesLoaded(function(){
			element.isotope({
				itemSelector: '.gt3_team_list__item',
				percentPosition: true,
				masonry: {
					columnWidth: '.gt3_team_list__grid-sizer',
					gutter: '.gt3_team_list__grid-gutter'
				}
			});
		});

		element.parent('.gt3_team_list').find(".gt3_team_list__filter.isotope-filter a").on( 'click', function(){
			var filter_item = jQuery(this);
			filter_item.siblings().removeClass('active');
			filter_item.addClass("active");
			var selector = filter_item.attr('data-filter');
			element.isotope({
				filter: selector,
			});
			return false;
		});
	})
}

function gt3_portfolio_load_more_init (){
	var gt3_portfolio_list = jQuery('.gt3_portfolio_list');
	if (gt3_portfolio_list.length) {
		gt3_portfolio_list.each(function(){
			var element = jQuery(this);
			var loadMoreButton = element.find('.gt3_portfolio_load_more');
			var portfolioContainer = element.find('.gt3_portfolio_list__posts-container');
			var nextPage = 2;
			var max_num_pages = 3;
			if (typeof portfolioContainer.data('max_num_pages') !== 'undefined' && portfolioContainer.data('max_num_pages') !== false) {
				max_num_pages = portfolioContainer.data('max_num_pages');
			}

			loadMoreButton.on('click', function (e) {
				loadMoreButton.addClass('loading');
				e.preventDefault();
				e.stopPropagation();
				if (nextPage <= max_num_pages) {
					var ajaxData = {
						action: 'gt3_get_practice_item_from_ajax',
						build_query: portfolioContainer.attr('data-build_query'),
						portfolio_style: portfolioContainer.attr('data-portfolio_style'),
						portfolio_layout: portfolioContainer.attr('data-portfolio_layout'),
						columns_with_spaces: portfolioContainer.attr('data-columns_with_spaces'),
						rounded_images: portfolioContainer.attr('data-rounded_images'),
						posts_per_line: portfolioContainer.attr('data-posts_per_line'),
						image_proportional: portfolioContainer.attr('data-image_proportional'),
						items_load: portfolioContainer.attr('data-items_load'),
						post_count: portfolioContainer.attr('data-post_count'),
					};
					ajaxData['next_page'] = nextPage;
					jQuery.ajax({
						type: 'POST',
						data: ajaxData,
						url: ajaxurl,
						success: function (data) {
							loadMoreButton.removeClass('loading');
							if (data != '') {
								var response = jQuery.parseJSON(data);
								var responseHtml = response.html;
								var img_loader = imagesLoaded( portfolioContainer );
								img_loader.on( "always", function (){
									setTimeout(function() {
										portfolioContainer
											.append( jQuery(responseHtml) )
											.isotope( 'appended', jQuery(responseHtml) )
											.isotope('reloadItems');
										portfolioContainer.find('.gt3_portfolio_list__item:not(.image_loaded)').each(function(){
											jQuery(this).imagesLoaded().always(function(instance ){
												jQuery(instance.elements).addClass('image_loaded');
											})
										})
										setTimeout(function(){
											portfolioContainer.isotope({sortby: 'original-order'});
										},100)
									},200);
								});
								if (Number(response.items_left) <= '0') {
									loadMoreButton.hide(300);
								}
								portfolioContainer.attr('data-post_count',Number(ajaxData.post_count) + Number(ajaxData.items_load));
							}
						}
					});
				}
			})
		})
	}
}

function gt3_team_load_more_init (){
	var gt3_team_list = jQuery('.gt3_team_list');
	if (gt3_team_list.length) {
		gt3_team_list.each(function(){
			var element = jQuery(this);
			var loadMoreButton = element.find('.gt3_team_load_more');
			var teamContainer = element.find('.gt3_team_list__posts-container');
			var nextPage = 2;
			var max_num_pages = 3;
			if (typeof teamContainer.data('max_num_pages') !== 'undefined' && teamContainer.data('max_num_pages') !== false) {
				max_num_pages = teamContainer.data('max_num_pages');
			}

			loadMoreButton.on('click', function (e) {
				loadMoreButton.addClass('loading');
				e.preventDefault();
				e.stopPropagation();
				if (nextPage <= max_num_pages) {
					var ajaxData = {
						action: 'gt3_get_team_item_from_ajax',
						build_query: teamContainer.attr('data-build_query'),
						team_style: teamContainer.attr('data-team_style'),
						posts_per_line: teamContainer.attr('data-posts_per_line'),
						items_load: teamContainer.attr('data-items_load'),
						post_count: teamContainer.attr('data-post_count'),
					};
					ajaxData['next_page'] = nextPage;
					jQuery.ajax({
						type: 'POST',
						data: ajaxData,
						url: ajaxurl,
						success: function (data) {
							loadMoreButton.removeClass('loading');
							if (data != '') {
								var response = jQuery.parseJSON(data);
								var responseHtml = response.html;
								var img_loader = imagesLoaded( teamContainer );
								img_loader.on( "always", function (){
									setTimeout(function() {
										teamContainer
											.append( jQuery(responseHtml) )
											.isotope( 'appended', jQuery(responseHtml) )
											.isotope('reloadItems');
										teamContainer.find('.gt3_team_list__item:not(.image_loaded)').each(function(){
											jQuery(this).imagesLoaded().always(function(instance ){
												jQuery(instance.elements).addClass('image_loaded');
											})
										})
										setTimeout(function(){
											teamContainer.isotope({sortby: 'original-order'});
										},100)
									},200);
								});
								if (Number(response.items_left) <= '0') {
									loadMoreButton.hide(300);
								}
								teamContainer.attr('data-post_count',Number(ajaxData.post_count) + Number(ajaxData.items_load));
							}
						}
					});
				}
			})
		})
	}
}

// GT3 Progress Bar
function gt3_progress_bar () {
	var progress_bar_tag = jQuery('.vc_progress_bar .vc_single_bar');
	if(progress_bar_tag.size() > 0) {
		progress_bar_tag.each(function(){
			jQuery(this).find('.vc_bar').attr('data-units', jQuery(this).find('.vc_label_units').html());
		});
	}
}

// GT3 Modal Login
function gt3_modal_login(){
	var element = jQuery('.gt3_header_builder__login-modal');
	jQuery('.gt3_header_builder_login_component,.gt3_header_builder__login-modal-close,.gt3_header_builder__login-modal-cover').on('click',function(){
		if (element.hasClass('active')) {
			element.removeClass('active');
		}else{
			element.addClass('active');
		}
	})
}

// GT3 Services Box
function gt3_services_box () {
	jQuery(".gt3_services_box").each(function(){
		if (jQuery(this).find('.text_wrap').length) {
			var text_h = jQuery(this).find('.text_wrap').height();
			jQuery(this).find('.fake_space').height(text_h);
		}
	});
}


// Smooth Scroll jQuery
// Select all »a« elements with a parent class »links« and add a function that is executed on click
jQuery(".sub-tabbing ul li a").on( 'click', function(e){
	var href = jQuery(this).attr( 'href' );
	jQuery( 'html, body' ).animate({
		  scrollTop: jQuery( href ).offset().top - 100
	}, '500' );
	e.preventDefault();
});