        </div><!-- .main_wrapper -->
	</div><!-- .site_wrapper -->
	<?php
		$gt3_show_contact = gt3_option('show_contact_widget');

		if (class_exists( 'RWMB_Loader' )) {
		 	$gt3_meta_show_contact = rwmb_meta('mb_display_contact_widget');
		} else {
		 	$gt3_meta_show_contact = '';
		}
		

		switch ($gt3_meta_show_contact) {
			case "default":
				break;
			case "on":
				$gt3_show_contact = true;
				break;
			case "off":
				$gt3_show_contact = false;
				break;
		}

		if (isset($gt3_show_contact) && $gt3_show_contact) {
			$gt3_contact_shortcode = gt3_option('shortcode_contact_widget');
			$gt3_contact_title = gt3_option('title_contact_widget');
			$gt3_contact_icon = gt3_option('label_contact_icon');
			$gt3_contact_icon = !empty($gt3_contact_icon) ? $gt3_contact_icon['url'] : '';
			$gt3_contact_label_color = gt3_option('label_contact_widget_color');

			echo '<div class="gt3-contact-widget">
				<div class="gt3-contact-widget_label'.(!empty($gt3_contact_icon) ? ' with-icon' : '').(empty($gt3_contact_title) ? ' empty-title' : '').'" style="background-color:'.esc_attr($gt3_contact_label_color["rgba"]).'">'.$gt3_contact_title.''.(!empty($gt3_contact_icon) ? '<span class="gt3-contact-widget_icon"><img src="'.esc_url($gt3_contact_icon).'" alt="icon"></span>' : '') .'</div>
				<div class="gt3-contact-widget_body">
					'.do_shortcode($gt3_contact_shortcode).'
				</div>
			</div>';
		}

		gt3_footer_area(); 
		if(gt3_option('back_to_top') == '1'){
			echo "<a href='#' id='back_to_top'></a>";
		}
		?>
    <?php 		
		wp_footer();
    ?>    
</body>
</html>