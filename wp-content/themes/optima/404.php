<?php get_header();?>
	<div class="wrapper_404 height_100percent">
		<div class="container_vertical_wrapper">
			<div class="container a-center">
				<h1 class="number_404">404</h1>
				<h2><?php echo esc_html__('Oops! Page Not Found!', 'optima'); ?></h2>
				<p><?php echo esc_html__('Either Something Get Wrong or the Page Doesn\'t Exist Anymore.', 'optima'); ?></p>
				<div class="gt3_404_search">
					<?php get_search_form(); ?>
				</div>
				<div class="gt3_module_button  button_alignment_inline">
					<a class="button_size_normal text-uppercase" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Take me home', 'optima'); ?></a>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>