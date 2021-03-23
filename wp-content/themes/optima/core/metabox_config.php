<?php 

if (!class_exists( 'RWMB_Loader' )) {
	return;
}
add_filter( 'rwmb_meta_boxes', 'gt3_portfolio_meta_boxes' );
function gt3_portfolio_meta_boxes( $meta_boxes ) {

  $standard_val = array(    
    0 => array(
      'name' => esc_html__( 'Date', 'optima' ),
      'value' => true,
      'custom_field' => true,
      'custom_field_type' => 'date',
    ),
    1 => array(
      'name' => esc_html__( 'Category', 'optima' ),
      'value' => true,
      'custom_field' => true,
      'custom_field_type' => 'category',
    ),
    2 => array(
      'name' => esc_html__( 'Comments', 'optima' ),
      'value' => true,
      'custom_field' => true,
      'custom_field_type' => 'comments',
    ),
    3 => array(
      'name' => '',
      'description' => '',
      'address' => ''
    )
  );


    $meta_boxes[] = array(
        'title'      => esc_html__( 'Portfolio Options', 'optima' ),
        'post_types' => array( 'portfolio' ),
        'context' => 'advanced',
        'fields'     => array(   
          array(
        'id'   => 'mb_show_portfolio_info',
        'name' => esc_html__( 'Show Portfolio Info', 'optima' ),
        'type' => 'checkbox',
        'std'  => 1,
      ),       
      array(
        'name' => esc_html__( 'Portfolio Info', 'optima' ),
              'id'   => 'mb_portfolio_info',
              'type' => 'social',
              'clone' => true,
              'sort_clone'     => true,
              'options' => array(
          'name'    => array(
            'name' => esc_html__( 'Title', 'optima' ),
            'type_input' => "text"
            ),
          'description' => array(
            'name' => esc_html__( 'Text', 'optima' ),
            'type_input' => "text"
            ),
          'address' => array(
            'name' => esc_html__( 'Url', 'optima' ),
            'type_input' => "text"
            ),
        ),
        'std' => $standard_val,
          ),
	array(
		'id'   => 'mb_show_portfolio_post_footer',
		'name' => esc_html__( 'Portfolio Post Footer', 'optima' ),
		'type' => 'checkbox',
		'std'  => 1,
	),
      array(
        'id'   => 'mb_show_portfolio_facebook',
        'name' => esc_html__( 'Facebook Share', 'optima' ),
        'type' => 'checkbox',
        'std'  => 1,
		  'attributes' => array(
			  'data-dependency' => array(
				  array(
					  array('mb_show_portfolio_post_footer','=','1')
				  ),
			  ),
		  ),
      ),
      array(
        'id'   => 'mb_show_portfolio_google',
        'name' => esc_html__( 'Google Share', 'optima' ),
        'type' => 'checkbox',
        'std'  => 1,
		  'attributes' => array(
			  'data-dependency' => array(
				  array(
					  array('mb_show_portfolio_post_footer','=','1')
				  ),
			  ),
		  ),
      ),
      array(
        'id'   => 'mb_show_portfolio_twitter',
        'name' => esc_html__( 'Twitter Share', 'optima' ),
        'type' => 'checkbox',
        'std'  => 1,
		  'attributes' => array(
			  'data-dependency' => array(
				  array(
					  array('mb_show_portfolio_post_footer','=','1')
				  ),
			  ),
		  ),
      ),
      array(
        'id'   => 'mb_show_portfolio_pinterest',
        'name' => esc_html__( 'Pinterest Share', 'optima' ),
        'type' => 'checkbox',
        'std'  => 1,
		  'attributes' => array(
			  'data-dependency' => array(
				  array(
					  array('mb_show_portfolio_post_footer','=','1')
				  ),
			  ),
		  ),
      ),
        ),
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'gt3_pteam_meta_boxes' );
function gt3_pteam_meta_boxes( $meta_boxes ) {
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Team Options', 'optima' ),
		'post_types' => array( 'team' ),
		'context' => 'advanced',
		'fields'     => array(
			array(
				'name' => esc_html__( 'Member Job', 'optima' ),
				'id'   => 'position_member',
				'type' => 'text',
				'class' => 'field-inputs'
			),
			array(
				'name' => esc_html__( 'Fields', 'optima' ),
				'id'   => 'social_url',
				'type' => 'social',
				'clone' => true,
				'sort_clone'     => true,
				'desc' => esc_html__( 'Description', 'optima' ),
				'options' => array(
					'name'    => array(
						'name' => esc_html__( 'Title', 'optima' ),
						'type_input' => "text"
					),
					'description' => array(
						'name' => esc_html__( 'Text', 'optima' ),
						'type_input' => "text"
					),
					'address' => array(
						'name' => esc_html__( 'Url', 'optima' ),
						'type_input' => "text"
					),
				),
			),
			array(
				'name'     => esc_html__( 'Icons', 'optima' ),
				'id'          => "icon_selection",
				'type'        => 'select_icon',
				'text_option' => true,
				'options'     => function_exists('gt3_get_all_icon') ? gt3_get_all_icon() : '',
				'clone' => true,
				'sort_clone'     => true,
				'placeholder' => esc_html__( 'Select an icon', 'optima' ),
				'multiple'    => false,
				'std'         => 'default',
			),
		),
	);
	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'gt3_blog_meta_boxes' );
function gt3_blog_meta_boxes( $meta_boxes ) {
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format Layout', 'optima' ),
		'post_types' => array( 'post' ),
		'context' => 'advanced',
		'fields'     => array(
			// Standard Post Format
			array(
				'name'             => esc_html__( 'You can use only featured image for this post-format', 'optima' ),
				'id'               => "post_format_standard",
				'type'             => 'static-text',
				'attributes' => array(
					'data-dependency' => array(
						array(
							array('formatdiv','=','0'),
							array('post-format-selector-0','=','standard')
						),
					),
				),
			),
			// Gallery Post Format
			array(
				'name'             => esc_html__( 'Gallery images', 'optima' ),
				'id'               => "post_format_gallery_images",
				'type'             => 'image_advanced',
				'max_file_uploads' => '',
				'attributes' => array(
					'data-dependency' => array(
						array(
							array('formatdiv','=','gallery'),
							array('post-format-selector-0','=','gallery')
						),
					),
				),
			),
			// Video Post Format
			array(
				'name' => esc_html__( 'oEmbed', 'optima' ),
				'id'   => "post_format_video_oEmbed",
				'desc' => esc_html__( 'enter URL', 'optima' ),
				'type' => 'oembed',
				'attributes' => array(
					'data-dependency' => array(
						array(
							array('formatdiv','=','video'),
							array('post-format-selector-0','=','video')
						),
						array(
							array('post_format_video_select','=','oEmbed')
						)
					),
				),
			),
			// Audio Post Format
			array(
				'name' => esc_html__( 'oEmbed', 'optima' ),
				'id'   => "post_format_audio_oEmbed",
				'desc' => esc_html__( 'enter URL', 'optima' ),
				'type' => 'oembed',
				'attributes' => array(
					'data-dependency' => array(
						array(
							array('formatdiv','=','audio'),
							array('post-format-selector-0','=','audio')
						),
						array(
							array('post_format_audio_select','=','oEmbed')
						)
					),
				),
			),
			// Quote Post Format
			array(
				'name'             => esc_html__( 'Quote Author', 'optima' ),
				'id'               => "post_format_qoute_author",
				'type'             => 'text',
				'attributes' => array(
					'data-dependency' => array(
						array(
							array('formatdiv','=','quote'),
							array('post-format-selector-0','=','quote')
						),
					),
				),
			),
			array(
				'name'             => esc_html__( 'Author Image', 'optima' ),
				'id'               => "post_format_qoute_author_image",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'attributes' => array(
					'data-dependency' => array(
						array(
							array('formatdiv','=','quote'),
							array('post-format-selector-0','=','quote')
						),
					),
				),
			),
			array(
				'name'             => esc_html__( 'Quote Content', 'optima' ),
				'id'               => "post_format_qoute_text",
				'type'             => 'textarea',
				'attributes' => array(
					'data-dependency' => array(
						array(
							array('formatdiv','=','quote'),
							array('post-format-selector-0','=','quote')
						),
					),
				),
			),
			// Link Post Format
			array(
				'name'             => esc_html__( 'Link URL', 'optima' ),
				'id'               => "post_format_link",
				'type'             => 'url',
				'attributes' => array(
					'data-dependency' => array(
						array(
							array('formatdiv','=','link'),
							array('post-format-selector-0','=','link')
						),
					),
				),
			),
			array(
				'name'             => esc_html__( 'Link Text', 'optima' ),
				'id'               => "post_format_link_text",
				'type'             => 'text',
				'attributes' => array(
					'data-dependency' => array(
						array(
							array('formatdiv','=','link'),
							array('post-format-selector-0','=','link')
						),
					),
				),
			),
		)
	);
	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'gt3_page_layout_meta_boxes' );
function gt3_page_layout_meta_boxes( $meta_boxes ) {

    $meta_boxes[] = array(
        'title'      => esc_html__( 'Page Layout', 'optima' ),
        'post_types' => array( 'page' , 'post', 'team', 'practice', 'product' ),
        'context' => 'advanced',
        'fields'     => array(
        	array(
				'name'     => esc_html__( 'Page Sidebar Layout', 'optima' ),
				'id'          => "mb_page_sidebar_layout",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'none' => esc_html__( 'None', 'optima' ),
					'left' => esc_html__( 'Left', 'optima' ),
					'right' => esc_html__( 'Right', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
			),
			array(
				'name'     => esc_html__( 'Page Sidebar', 'optima' ),
				'id'          => "mb_page_sidebar_def",
				'type'        => 'select',
				'options'     => gt3_get_all_sidebar(),
				'multiple'    => false,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_sidebar_layout','!=','default'),
						array('mb_page_sidebar_layout','!=','none'),
					)),
				),
			),
        )
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'gt3_logo_meta_boxes' );
function gt3_logo_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => esc_html__( 'Logo Options', 'optima' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'fields'     => array(
        	array(
				'name'     => esc_html__( 'Logo', 'optima' ),
				'id'          => "mb_customize_logo",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'custom' => esc_html__( 'custom', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
			),
			array(
				'name'             => esc_html__( 'Header Logo', 'optima' ),
				'id'               => "mb_header_logo",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_logo','=','custom')
					)),
				),
			),
			array(
				'id'   => 'mb_logo_height_custom',
				'name' => esc_html__( 'Enable Logo Height', 'optima' ),
				'type' => 'checkbox',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_customize_logo','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Set Logo Height', 'optima' ),
				'id'   => "mb_logo_height",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 50,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_logo','=','custom'),
						array('mb_logo_height_custom','=',true)
					)),
				),
			),
			array(
				'name' => esc_html__( 'Don\'t limit maximum height', 'optima' ),
				'id'   => "mb_logo_max_height",
				'type' => 'checkbox',
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_logo','=','custom'),
						array('mb_logo_height_custom','=',true)
					)),
				),
			),
			array(
				'name' => esc_html__( 'Set Sticky Logo Height', 'optima' ),
				'id'   => "mb_sticky_logo_height",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_logo','=','custom'),
						array('mb_logo_height_custom','=',true),
						array('mb_logo_max_height','=',true),
					)),
				),
			),
			array(
				'name'             => esc_html__( 'Sticky Logo', 'optima' ),
				'id'               => "mb_logo_sticky",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_logo','=','custom')
					)),
				),
			),
			array(
				'name'             => esc_html__( 'Mobile Logo', 'optima' ),
				'id'               => "mb_logo_mobile",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_logo','=','custom')
					)),
				),
			),
        )
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'gt3_header_option_meta_boxes' );
function gt3_header_option_meta_boxes( $meta_boxes ) {
	$meta_boxes[] = array(
        'title'      => esc_html__( 'Header Layout and Color', 'optima' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'fields'     => array(
        	array(
				'name'     => esc_html__( 'Header Settings', 'optima' ),
				'id'          => "mb_customize_header_layout",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'custom' => esc_html__( 'custom', 'optima' ),
					'none' => esc_html__( 'none', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
			),
			array(
				'id'   => 'mb_header_shadow',
				'name' => esc_html__( 'Header Bottom Shadow', 'optima' ),
				'type' => 'checkbox',
				'std'  => 1,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom')
					)),
				),
			),
			// Top header settings
			array(
				'name'     => esc_html__( 'Top Header Settings', 'optima' ),
				'id'          => "mb_customize_top_header_layout",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'custom' => esc_html__( 'custom', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Top Header Background', 'optima' ),
				'id'   => "mb_top_header_background",
				'type' => 'color',
				'std'         => '#f5f5f5',
				'js_options' => array(
					'defaultColor' => '#f5f5f5',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_top_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Top Header Background Opacity', 'optima' ),
				'id'   => "mb_top_header_background_opacity",
				'type' => 'number',
				'std'  => 0.44,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_top_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Text Color', 'optima' ),
				'id'   => "mb_top_header_color",
				'type' => 'color',
				'std'         => '#94958d',
				'js_options' => array(
					'defaultColor' => '#94958d',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_top_header_layout','=','custom')
					)),
				),
			),
			array(
				'id'   => 'mb_top_header_bottom_border',
				'name' => esc_html__( 'Set Top Header Bottom Border', 'optima' ),
				'type' => 'checkbox',
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_top_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Top Header Border color', 'optima' ),
				'id'   => "mb_header_top_bottom_border_color",
				'type' => 'color',
				'std'         => '#000000',
				'js_options' => array(
					'defaultColor' => '#000000',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_top_header_layout','=','custom'),
						array('mb_top_header_bottom_border','=',true)
					)),
				),
			),
			array(
				'name' => esc_html__( 'Top Header Border Opacity', 'optima' ),
				'id'   => "mb_header_top_bottom_border_color_opacity",
				'type' => 'number',
				'std'  => 0.1,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_top_header_layout','=','custom'),
						array('mb_top_header_bottom_border','=',true)
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Middle Header Settings', 'optima' ),
				'id'          => "mb_customize_middle_header_layout",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'custom' => esc_html__( 'custom', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom')
					)),
				),
			),

			// Middle header settings
			array(
				'name' => esc_html__( 'Middle Header Background', 'optima' ),
				'id'   => "mb_middle_header_background",
				'type' => 'color',
				'std'         => '#ffffff',
				'js_options' => array(
					'defaultColor' => '#ffffff',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_middle_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Middle Header Background Opacity', 'optima' ),
				'id'   => "mb_middle_header_background_opacity",
				'type' => 'number',
				'std'  => 0.44,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_middle_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Middle Header Text Color', 'optima' ),
				'id'   => "mb_middle_header_color",
				'type' => 'color',
				'std'         => '#000000',
				'js_options' => array(
					'defaultColor' => '#000000',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_middle_header_layout','=','custom')
					)),
				),
			),
			array(
				'id'   => 'mb_middle_header_bottom_border',
				'name' => esc_html__( 'Set Middle Header Bottom Border', 'optima' ),
				'type' => 'checkbox',
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_middle_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Middle Header Border color', 'optima' ),
				'id'   => "mb_header_middle_bottom_border_color",
				'type' => 'color',
				'std'         => '#000000',
				'js_options' => array(
					'defaultColor' => '#000000',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_middle_header_layout','=','custom'),
						array('mb_middle_header_bottom_border','=',true)
					)),
				),
			),
			array(
				'name' => esc_html__( 'Middle Header Border Opacity', 'optima' ),
				'id'   => "mb_header_middle_bottom_border_color_opacity",
				'type' => 'number',
				'std'  => 0.1,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_middle_header_layout','=','custom'),
						array('mb_middle_header_bottom_border','=',true)
					)),
				),
			),

			// Bottom header settings
			array(
				'name'     => esc_html__( 'Bottom Header Settings', 'optima' ),
				'id'          => "mb_customize_bottom_header_layout",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'custom' => esc_html__( 'custom', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Bottom Header Background', 'optima' ),
				'id'   => "mb_bottom_header_background",
				'type' => 'color',
				'std'         => '#ffffff',
				'js_options' => array(
					'defaultColor' => '#ffffff',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_bottom_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Bottom Header Background Opacity', 'optima' ),
				'id'   => "mb_bottom_header_background_opacity",
				'type' => 'number',
				'std'  => 0.44,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_bottom_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Bottom Header Text Color', 'optima' ),
				'id'   => "mb_bottom_header_color",
				'type' => 'color',
				'std'         => '#000000',
				'js_options' => array(
					'defaultColor' => '#000000',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_bottom_header_layout','=','custom')
					)),
				),
			),
			array(
				'id'   => 'mb_bottom_header_bottom_border',
				'name' => esc_html__( 'Set Bottom Header Bottom Border', 'optima' ),
				'type' => 'checkbox',
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_bottom_header_layout','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Bottom Header Border color', 'optima' ),
				'id'   => "mb_header_bottom_bottom_border_color",
				'type' => 'color',
				'std'         => '#000000',
				'js_options' => array(
					'defaultColor' => '#000000',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_bottom_header_layout','=','custom'),
						array('mb_bottom_header_bottom_border','=',true)
					)),
				),
			),
			array(
				'name' => esc_html__( 'Bottom Header Border Opacity', 'optima' ),
				'id'   => "mb_header_bottom_bottom_border_color_opacity",
				'type' => 'number',
				'std'  => 0.1,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_customize_header_layout','=','custom'),
						array('mb_customize_bottom_header_layout','=','custom'),
						array('mb_bottom_header_bottom_border','=',true)
					)),
				),
			),





			//mobile options 
			array(
				'id'   => 'mb_header_on_bg',
				'name' => esc_html__( 'Header Above Content', 'optima' ),
				'type' => 'checkbox',
				'std'  => 0,
			),



			// Mobile Top header settings
			array(
				'name'     => esc_html__( 'Top Mobile Header Settings', 'optima' ),
				'id'          => "mb_customize_top_header_layout_mobile",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'custom' => esc_html__( 'custom', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_header_on_bg','=','1')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Top Mobile Header Background', 'optima' ),
				'id'   => "mb_top_header_background_mobile",
				'type' => 'color',
				'std'         => '#f5f5f5',
				'js_options' => array(
					'defaultColor' => '#f5f5f5',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_header_on_bg','=','1'),
						array('mb_customize_top_header_layout_mobile','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Top Mobile Header Background Opacity', 'optima' ),
				'id'   => "mb_top_header_background_opacity_mobile",
				'type' => 'number',
				'std'  => 1,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_header_on_bg','=','1'),
						array('mb_customize_top_header_layout_mobile','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Top Mobile Header Text Color', 'optima' ),
				'id'   => "mb_top_header_color_mobile",
				'type' => 'color',
				'std'         => '#94958d',
				'js_options' => array(
					'defaultColor' => '#94958d',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_header_on_bg','=','1'),
						array('mb_customize_top_header_layout_mobile','=','custom')
					)),
				),
			),



			// Mobile Middle header settings
			array(
				'name'     => esc_html__( 'Middle Mobile Header Settings', 'optima' ),
				'id'          => "mb_customize_middle_header_layout_mobile",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'custom' => esc_html__( 'custom', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_header_on_bg','=','1')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Middle Mobile Header Background', 'optima' ),
				'id'   => "mb_middle_header_background_mobile",
				'type' => 'color',
				'std'         => '#ffffff',
				'js_options' => array(
					'defaultColor' => '#ffffff',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_header_on_bg','=','1'),
						array('mb_customize_middle_header_layout_mobile','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Middle Mobile Header Background Opacity', 'optima' ),
				'id'   => "mb_middle_header_background_opacity_mobile",
				'type' => 'number',
				'std'  => 1,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_header_on_bg','=','1'),
						array('mb_customize_middle_header_layout_mobile','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Middle Mobile Header Text Color', 'optima' ),
				'id'   => "mb_middle_header_color_mobile",
				'type' => 'color',
				'std'         => '#000000',
				'js_options' => array(
					'defaultColor' => '#000000',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_header_on_bg','=','1'),
						array('mb_customize_middle_header_layout_mobile','=','custom')
					)),
				),
			),


			// Mobile Bottom header settings
			array(
				'name'     => esc_html__( 'Bottom Mobile Header Settings', 'optima' ),
				'id'          => "mb_customize_bottom_header_layout_mobile",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'custom' => esc_html__( 'custom', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_header_on_bg','=','1')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Bottom Mobile Header Background', 'optima' ),
				'id'   => "mb_bottom_header_background_mobile",
				'type' => 'color',
				'std'         => '#ffffff',
				'js_options' => array(
					'defaultColor' => '#ffffff',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_header_on_bg','=','1'),
						array('mb_customize_bottom_header_layout_mobile','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Bottom Mobile Header Background Opacity', 'optima' ),
				'id'   => "mb_bottom_header_background_opacity_mobile",
				'type' => 'number',
				'std'  => 1,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_header_on_bg','=','1'),
						array('mb_customize_bottom_header_layout_mobile','=','custom')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Bottom Mobile Header Text Color', 'optima' ),
				'id'   => "mb_bottom_header_color_mobile",
				'type' => 'color',
				'std'         => '#000000',
				'js_options' => array(
					'defaultColor' => '#000000',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_header_on_bg','=','1'),
						array('mb_customize_bottom_header_layout_mobile','=','custom')
					)),
				),
			),

        )

	);
	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'gt3_page_title_meta_boxes' );
function gt3_page_title_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => esc_html__( 'Page Title Options', 'optima' ),
        'post_types' => array( 'page', 'post', 'team', 'practice', 'product' ),
        'context' => 'advanced',
        'fields'     => array(
			array(
				'name'     => esc_html__( 'Show Page Title', 'optima' ),
				'id'          => "mb_page_title_conditional",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'yes' => esc_html__( 'yes', 'optima' ),
					'no' => esc_html__( 'no', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
			),
			array(
				'name' => esc_html__( 'Page Sub Title Text', 'optima' ),
				'id'   => "mb_page_sub_title",
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_page_title_conditional','!=','no'),
					)),
				),
			),
			array(
				'id'   => 'mb_show_breadcrumbs',
				'name' => esc_html__( 'Show Breadcrumbs', 'optima' ),
				'type' => 'checkbox',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
				'std'  => 1,
			),
			array(
				'name'     => esc_html__( 'Vertical Alignment', 'optima' ),
				'id'       => 'mb_page_title_vertical_align',
				'type'     => 'select_advanced',
				'options'  => array(
					'top' => esc_html__( 'top', 'optima' ),
					'middle' => esc_html__( 'middle', 'optima' ),
					'bottom' => esc_html__( 'bottom', 'optima' ),
				),
				'multiple' => false,
				'std'         => 'middle',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Horizontal Alignment', 'optima' ),
				'id'       => 'mb_page_title_horizontal_align',
				'type'     => 'select_advanced',
				'options'  => array(
					'left' => esc_html__( 'left', 'optima' ),
					'center' => esc_html__( 'center', 'optima' ),
					'right' => esc_html__( 'right', 'optima' ),
				),
				'multiple' => false,
				'std'         => 'left',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Font Color', 'optima' ),
				'id'   => "mb_page_title_font_color",
				'type' => 'color',
				'std'         => '#303638',
				'js_options' => array(
					'defaultColor' => '#303638',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Background Color', 'optima' ),
				'id'   => "mb_page_title_bg_color",
				'type' => 'color',
				'std'  => '#f5f5f5',
				'js_options' => array(
					'defaultColor' => '#f5f5f5',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
			array(
				'name'             => esc_html__( 'Page Title Background Image', 'optima' ),
				'id'               => "mb_page_title_bg_image",
				'type'             => 'file_advanced',
				'max_file_uploads' => 1,
				'mime_type'        => 'image',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Background Repeat', 'optima' ),
				'id'       => 'mb_page_title_bg_repeat',
				'type'     => 'select_advanced',
				'options'  => array(
					'no-repeat' => esc_html__( 'no-repeat', 'optima' ),
					'repeat' => esc_html__( 'repeat', 'optima' ),
					'repeat-x' => esc_html__( 'repeat-x', 'optima' ),
					'repeat-y' => esc_html__( 'repeat-y', 'optima' ),
					'inherit' => esc_html__( 'inherit', 'optima' ),
				),
				'multiple' => false,
				'std'         => 'repeat',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Background Size', 'optima' ),
				'id'       => 'mb_page_title_bg_size',
				'type'     => 'select_advanced',
				'options'  => array(
					'inherit' => esc_html__( 'inherit', 'optima' ),
					'cover' => esc_html__( 'cover', 'optima' ),
					'contain' => esc_html__( 'contain', 'optima' )
				),
				'multiple' => false,
				'std'         => 'cover',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Background Attachment', 'optima' ),
				'id'       => 'mb_page_title_bg_attachment',
				'type'     => 'select_advanced',
				'options'  => array(
					'fixed' => esc_html__( 'fixed', 'optima' ),
					'scroll' => esc_html__( 'scroll', 'optima' ),
					'inherit' => esc_html__( 'inherit', 'optima' )
				),
				'multiple' => false,
				'std'         => 'scroll',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Background Position', 'optima' ),
				'id'       => 'mb_page_title_bg_position',
				'type'     => 'select_advanced',
				'options'  => array(
					'left top' => esc_html__( 'left top', 'optima' ),
					'left center' => esc_html__( 'left center', 'optima' ),
					'left bottom' => esc_html__( 'left bottom', 'optima' ),
					'center top' => esc_html__( 'center top', 'optima' ),
					'center center' => esc_html__( 'center center', 'optima' ),
					'center bottom' => esc_html__( 'center bottom', 'optima' ),
					'right top' => esc_html__( 'right top', 'optima' ),
					'right center' => esc_html__( 'right center', 'optima' ),
					'right bottom' => esc_html__( 'right bottom', 'optima' ),
				),
				'multiple' => false,
				'std'         => 'center center',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Height', 'optima' ),
				'id'   => "mb_page_title_height",
				'type' => 'number',
				'std'  => 200,
				'min'  => 0,
				'step' => 1,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_page_title_conditional','=','yes')
					)),
				),
			),
        ),
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'gt3_footer_meta_boxes' );
function gt3_footer_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => esc_html__( 'Footer Options', 'optima' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'fields'     => array(
        	array(
				'name'     => esc_html__( 'Show Footer', 'optima' ),
				'id'          => "mb_footer_switch",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'yes' => esc_html__( 'yes', 'optima' ),
					'no' => esc_html__( 'no', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
			),
			array(
				'name'     => esc_html__( 'Footer Column', 'optima' ),
				'id'          => "mb_footer_column",
				'type'        => 'select',
				'options'     => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',				
				),
				'multiple'    => false,
				'std'         => '4',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Footer Column 1', 'optima' ),
				'id'          => "mb_footer_sidebar_1",
				'type'        => 'select',
				'options'     => gt3_get_all_sidebar(),
				'multiple'    => false,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Footer Column 2', 'optima' ),
				'id'          => "mb_footer_sidebar_2",
				'type'        => 'select',
				'options'     => gt3_get_all_sidebar(),
				'multiple'    => false,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes'),
						array('mb_footer_column','!=','1')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Footer Column 3', 'optima' ),
				'id'          => "mb_footer_sidebar_3",
				'type'        => 'select',
				'options'     => gt3_get_all_sidebar(),
				'multiple'    => false,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes'),
						array('mb_footer_column','!=','1'),
						array('mb_footer_column','!=','2')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Footer Column 4', 'optima' ),
				'id'          => "mb_footer_sidebar_4",
				'type'        => 'select',
				'options'     => gt3_get_all_sidebar(),
				'multiple'    => false,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes'),
						array('mb_footer_column','!=','1'),
						array('mb_footer_column','!=','2'),
						array('mb_footer_column','!=','3')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Footer Column Layout', 'optima' ),
				'id'          => "mb_footer_column2",
				'type'        => 'select',
				'options'     => array(
					'6-6' => '50% / 50%',
                    '3-9' => '25% / 75%',
                    '9-3' => '75% / 25%',
                    '4-8' => '33% / 66%',
                    '8-3' => '66% / 33%',				
				),
				'multiple'    => false,
				'std'         => '6-6',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes'),
						array('mb_footer_column','=','2')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Footer Column Layout', 'optima' ),
				'id'          => "mb_footer_column3",
				'type'        => 'select',
				'options'     => array(
					'4-4-4' => '33% / 33% / 33%',
                    '3-3-6' => '25% / 25% / 50%',
                    '3-6-3' => '25% / 50% / 25%',
                    '6-3-3' => '50% / 25% / 25%',				
				),
				'multiple'    => false,
				'std'         => '4-4-4',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes'),
						array('mb_footer_column','=','3')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Footer Title Text Align', 'optima' ),
				'id'          => "mb_footer_align",
				'type'        => 'select',
				'options'     => array(
					'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right'			
				),
				'multiple'    => false,
				'std'         => 'left',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Padding Top (px)', 'optima' ),
				'id'   => "mb_padding_top",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 70,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Padding Bottom (px)', 'optima' ),
				'id'   => "mb_padding_bottom",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 70,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Padding Left (px)', 'optima' ),
				'id'   => "mb_padding_left",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Padding Right (px)', 'optima' ),
				'id'   => "mb_padding_right",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'id'   => 'mb_footer_full_width',
				'name' => esc_html__( 'Full Width Footer', 'optima' ),
				'type' => 'checkbox',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Background Color', 'optima' ),
				'id'   => "mb_footer_bg_color",
				'type' => 'color',
				'std'  => '#284358',
				'js_options' => array(
					'defaultColor' => '#284358',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Footer Text Color', 'optima' ),
				'id'   => "mb_footer_text_color",
				'type' => 'color',
				'std'  => '#bdbdbd',
				'js_options' => array(
					'defaultColor' => '#bdbdbd',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Footer Heading Color', 'optima' ),
				'id'   => "mb_footer_heading_color",
				'type' => 'color',
				'std'  => '#fafafa',
				'js_options' => array(
					'defaultColor' => '#fafafa',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name'             => esc_html__( 'Footer Background Image', 'optima' ),
				'id'               => "mb_footer_bg_image",
				'type'             => 'file_advanced',
				'max_file_uploads' => 1,
				'mime_type'        => 'image',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Background Repeat', 'optima' ),
				'id'       => 'mb_footer_bg_repeat',
				'type'     => 'select_advanced',
				'options'  => array(
					'no-repeat' => esc_html__( 'no-repeat', 'optima' ),
					'repeat' => esc_html__( 'repeat', 'optima' ),
					'repeat-x' => esc_html__( 'repeat-x', 'optima' ),
					'repeat-y' => esc_html__( 'repeat-y', 'optima' ),
					'inherit' => esc_html__( 'inherit', 'optima' ),
				),
				'multiple' => false,
				'std'         => 'repeat',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Background Size', 'optima' ),
				'id'       => 'mb_footer_bg_size',
				'type'     => 'select_advanced',
				'options'  => array(
					'inherit' => esc_html__( 'inherit', 'optima' ),
					'cover' => esc_html__( 'cover', 'optima' ),
					'contain' => esc_html__( 'contain', 'optima' )
				),
				'multiple' => false,
				'std'         => 'cover',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Background Attachment', 'optima' ),
				'id'       => 'mb_footer_attachment',
				'type'     => 'select_advanced',
				'options'  => array(
					'fixed' => esc_html__( 'fixed', 'optima' ),
					'scroll' => esc_html__( 'scroll', 'optima' ),
					'inherit' => esc_html__( 'inherit', 'optima' )
				),
				'multiple' => false,
				'std'         => 'scroll',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Background Position', 'optima' ),
				'id'       => 'mb_footer_bg_position',
				'type'     => 'select_advanced',
				'options'  => array(
					'left top' => esc_html__( 'left top', 'optima' ),
					'left center' => esc_html__( 'left center', 'optima' ),
					'left bottom' => esc_html__( 'left bottom', 'optima' ),
					'center top' => esc_html__( 'center top', 'optima' ),
					'center center' => esc_html__( 'center center', 'optima' ),
					'center bottom' => esc_html__( 'center bottom', 'optima' ),
					'right top' => esc_html__( 'right top', 'optima' ),
					'right center' => esc_html__( 'right center', 'optima' ),
					'right bottom' => esc_html__( 'right bottom', 'optima' ),
				),
				'multiple' => false,
				'std'         => 'center center',
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				),
			),

			array(
				'id'   => 'mb_copyright_switch',
				'name' => esc_html__( 'Show Copyright', 'optima' ),
				'type' => 'checkbox',
				'std'  => 1,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				), 
			),
			array(
				'name' => esc_html__( 'Copyright Editor', 'optima' ),
				'id'   => "mb_copyright_editor",
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Copyright Title Text Align', 'optima' ),
				'id'       => 'mb_copyright_align',
				'type'     => 'select',
				'options'  => array(
					'left' => esc_html__( 'left', 'optima' ),
					'center' => esc_html__( 'center', 'optima' ),
					'right' => esc_html__( 'right', 'optima' ),
				),
				'multiple' => false,
				'std'         => 'left',
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Copyright Padding Top (px)', 'optima' ),
				'id'   => "mb_copyright_padding_top",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 20,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Copyright Padding Bottom (px)', 'optima' ),
				'id'   => "mb_copyright_padding_bottom",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 20,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Copyright Padding Left (px)', 'optima' ),
				'id'   => "mb_copyright_padding_left",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Copyright Padding Right (px)', 'optima' ),
				'id'   => "mb_copyright_padding_right",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Copyright Background Color', 'optima' ),
				'id'   => "mb_copyright_bg_color",
				'type' => 'color',
				'std'  => '#284358',
				'js_options' => array(
					'defaultColor' => '#284358',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Copyright Text Color', 'optima' ),
				'id'   => "mb_copyright_text_color",
				'type' => 'color',
				'std'  => '#bdbdbd',
				'js_options' => array(
					'defaultColor' => '#848d95',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'id'   => 'mb_copyright_top_border',
				'name' => esc_html__( 'Set Copyright Top Border?', 'optima' ),
				'type' => 'checkbox',
				'std'  => 1,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Copyright Border Color', 'optima' ),
				'id'   => "mb_copyright_top_border_color",
				'type' => 'color',
				'std'         => '#2b4764',
				'js_options' => array(
					'defaultColor' => '#2b4764',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes'),
						array('mb_copyright_top_border','=',true)
					)),
				),
			),
			array(
				'name' => esc_html__( 'Copyright Border Opacity', 'optima' ),
				'id'   => "mb_copyright_top_border_color_opacity",
				'type' => 'number',
				'std'  => 1,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_copyright_switch','=',true),
						array('mb_footer_switch','=','yes'),
						array('mb_copyright_top_border','=',true)
					)),
				),
			),

			//prefooter
			array(
				'id'   => 'mb_pre_footer_switch',
				'name' => esc_html__( 'Show Pre Footer Area', 'optima' ),
				'type' => 'checkbox',
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
						array('mb_footer_switch','=','yes')
					)),
				), 
			),
			array(
				'name' => esc_html__( 'Pre Footer Editor', 'optima' ),
				'id'   => "mb_pre_footer_editor",
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_pre_footer_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name'     => esc_html__( 'Pre Footer Title Text Align', 'optima' ),
				'id'       => 'mb_pre_footer_align',
				'type'     => 'select',
				'options'  => array(
					'left' => esc_html__( 'left', 'optima' ),
					'center' => esc_html__( 'center', 'optima' ),
					'right' => esc_html__( 'right', 'optima' ),
				),
				'multiple' => false,
				'std'         => 'left',
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_pre_footer_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Pre Footer Padding Top (px)', 'optima' ),
				'id'   => "mb_pre_footer_padding_top",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 20,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_pre_footer_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Pre Footer Padding Bottom (px)', 'optima' ),
				'id'   => "mb_pre_footer_padding_bottom",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 20,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_pre_footer_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Pre Footer Padding Left (px)', 'optima' ),
				'id'   => "mb_pre_footer_padding_left",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_pre_footer_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Pre Footer Padding Right (px)', 'optima' ),
				'id'   => "mb_pre_footer_padding_right",
				'type' => 'number',
				'min'  => 0,
				'step' => 1,
				'std'  => 0,
				'attributes' => array(
				    'data-dependency'  =>  array( array(						
						array('mb_pre_footer_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'id'   => 'mb_pre_footer_bottom_border',
				'name' => esc_html__( 'Set Pre Footer Bottom Border?', 'optima' ),
				'type' => 'checkbox',
				'std'  => 1,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_pre_footer_switch','=',true),
						array('mb_footer_switch','=','yes')
					)),
				),
			),
			array(
				'name' => esc_html__( 'Pre Footer Border Color', 'optima' ),
				'id'   => "mb_pre_footer_bottom_border_color",
				'type' => 'color',
				'std'         => '#f0f0f0',
				'js_options' => array(
					'defaultColor' => '#f0f0f0',
				),
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_pre_footer_switch','=',true),
						array('mb_footer_switch','=','yes'),
						array('mb_pre_footer_bottom_border','=',true)
					)),
				),
			),
			array(
				'name' => esc_html__( 'Pre Footer Border Opacity', 'optima' ),
				'id'   => "mb_pre_footer_bottom_border_color_opacity",
				'type' => 'number',
				'std'  => 1,
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
				'attributes' => array(
				    'data-dependency'  =>  array( array(
				    	array('mb_pre_footer_switch','=',true),
						array('mb_footer_switch','=','yes'),
						array('mb_pre_footer_bottom_border','=',true)
					)),
				),
			),
        ),
     );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'gt3_contact_widget_meta_boxes' );
function gt3_contact_widget_meta_boxes( $meta_boxes ) {

    $meta_boxes[] = array(
        'title'      => esc_html__( 'Contact Widget', 'optima' ),
        'post_types' => array( 'page' , 'post', 'team', 'practice', 'product' ),
        'context' => 'advanced',
        'fields'     => array(
        	array(
				'name'     => esc_html__( 'Display Contact Widget', 'optima' ),
				'id'          => "mb_display_contact_widget",
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'default', 'optima' ),
					'on' => esc_html__( 'On', 'optima' ),
					'off' => esc_html__( 'Off', 'optima' ),
				),
				'multiple'    => false,
				'std'         => 'default',
			),
        )
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'gt3_shortcode_meta_boxes' );
function gt3_shortcode_meta_boxes( $meta_boxes ) {
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Shortcode Above Content', 'optima' ),
		'post_types' => array( 'page' ),
		'context' => 'advanced',
		'fields'     => array(
			array(
				'name' => esc_html__( 'Shortcode', 'optima' ),
				'id'   => "mb_page_shortcode",
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3
			),
		),
     );
    return $meta_boxes;
}
?>