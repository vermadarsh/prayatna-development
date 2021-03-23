<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$header_font = gt3_option('header-font');
$main_font = gt3_option('main-font');

if (function_exists('vc_map')) {
    vc_map(array(
        'base' => 'gt3_featured_posts',
        'name' => esc_html__('Featured Blog Posts', 'optima'),
        "description" => esc_html__("Display the featured blog posts", "optima"),
        'category' => esc_html__('GT3 Modules', 'optima'),
        'icon' => 'gt3_icon',
        'params' => array(
            array(
                'type' => 'loop',
                'heading' => esc_html__('Blog Items', 'optima'),
                'param_name' => 'build_query',
                'settings' => array(
                    'size' => array('hidden' => false, 'value' => 4 * 3),
                    'order_by' => array('value' => 'date'),
                    'post_type' => array('value' => 'post', 'hidden' => true),
                    'categories' => array('hidden' => false),
                    'tags' => array('hidden' => false)
                ),
                'description' => esc_html__('Create WordPress loop, to populate content from your site.', 'optima')
            ),
            // Module Title
            array(
                "type" => "textfield",
                'heading' => esc_html__('Module title', 'optima'),
                "param_name" => "module_title",
                "value" => "",
                "description" => esc_html__("Enter text used as module title (Note: located above content element).", "optima")
            ),
            // Link Text
            array(
                "type" => "textfield",
                "heading" => esc_html__("Module Link Text", "optima"),
                "param_name" => "external_link_text",
                "value" => "",
                "description" => esc_html__("Text on the module link.", "optima"),
            ),
            // Link Setts
            array(
                'type' => 'vc_link',
                'heading' => esc_html__( 'Module Link', 'optima' ),
                'param_name' => 'external_link',
                "dependency" => Array("element" => "external_link_text", "not_empty" => true),
            ),
            // View Type
            array(
                'type' => 'gt3_dropdown',
                'class' => '',
                'heading' => esc_html__('Style select', 'optima'),
                'param_name' => 'view_type',
                'fields' => array(
                    'type1' => array(
                        'image' => get_template_directory_uri() . '/img/gt3_composer_addon/blog_type1.jpg',
                        'descr' => esc_html__('Type 1', 'optima')),
                    'type2' => array(
                        'image' => get_template_directory_uri() . '/img/gt3_composer_addon/blog_type2.jpg',
                        'descr' => esc_html__('Type 2', 'optima')),
                    'type3' => array(
                        'image' => get_template_directory_uri() . '/img/gt3_composer_addon/blog_type3.jpg',
                        'descr' => esc_html__('Type 3', 'optima')),
                    'type4' => array(
                        'image' => get_template_directory_uri() . '/img/gt3_composer_addon/blog_type4.jpg',
                        'descr' => esc_html__('Type 4', 'optima')),
                ),
                'value' => 'type4',
            ),
            // Post meta
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Allow uppercase post-meta text?', 'optima' ),
                'param_name' => 'post_meta_uppercase',
                'description' => esc_html__( 'If checked, allow uppercase post-meta text.', 'optima' ),
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                /*'std' => 'yes'*/
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show post-meta author?', 'optima' ),
                'param_name' => 'meta_author',
                'description' => esc_html__( 'If checked, post-meta will have author.', 'optima' ),
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'std' => 'yes',
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show post-meta comments?', 'optima' ),
                'param_name' => 'meta_comments',
                'description' => esc_html__( 'If checked, post-meta will have comments.', 'optima' ),
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'std' => 'yes',
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show post-meta categories?', 'optima' ),
                'param_name' => 'meta_categories',
                'description' => esc_html__( 'If checked, post-meta will have categories.', 'optima' ),
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'std' => 'yes',
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show post-meta date?', 'optima' ),
                'param_name' => 'meta_date',
                'description' => esc_html__( 'If checked, post-meta will have date.', 'optima' ),
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'std' => 'yes',
                'edit_field_class' => 'vc_col-sm-3',
            ),
            // Post Format Label
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show post-format label?', 'optima' ),
                'param_name' => 'pf_post_icon',
                'description' => esc_html__( 'If checked, post-format label is visible.', 'optima' ),
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'edit_field_class' => 'vc_col-sm-4',
                "dependency" => Array("element" => "view_type","value" => array("type4"))
            ),
            // Post Read More Link
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Show post read more link?', 'optima' ),
                'param_name' => 'post_read_more_link',
                'description' => esc_html__( 'If checked, post read more link is visible.', 'optima' ),
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'edit_field_class' => 'vc_col-sm-4',
                "dependency" => Array("element" => "view_type","value" => array("type4"))
            ),
            // Image Proportions
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Image Proportions', 'optima' ),
                'param_name' => 'image_proportions',
                "value"         => array(
                    esc_html__( '4/3', 'optima' ) => '4_3',
                    esc_html__( 'Horizontal', 'optima' ) => 'horizontal',
                    esc_html__( 'Vertical', 'optima' ) => 'vertical',
                    esc_html__( 'Square', 'optima' ) => 'square',
                    esc_html__( 'Original', 'optima' ) => 'original'
                ),
                "description" => esc_html__("Select image proportions.", "optima"),
                "dependency" => Array("element" => "view_type","value" => array("type3", "type4")),
            ),
            // Items per line
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Items Per Line', 'optima' ),
                'param_name' => 'items_per_line',
                "value"         => array(
                    esc_html__( '1', 'optima' ) => '1',
                    esc_html__( '2', 'optima' ) => '2',
                    esc_html__( '3', 'optima' ) => '3',
                    esc_html__( '4', 'optima' ) => '4'
                ),
                "description" => esc_html__("Select post items per line.", "optima"),
                "dependency" => Array("element" => "view_type","value" => array("type3", "type4")),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Items Per Line', 'optima' ),
                'param_name' => 'items_per_line_type2',
                "value"         => array(
                    esc_html__( '1', 'optima' ) => '1',
                    esc_html__( '2', 'optima' ) => '2'
                ),
                "description" => esc_html__("Select post items per line.", "optima"),
                "dependency" => Array("element" => "view_type","value" => array("type2")),
            ),
            // Spacing beetween items
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Spacing beetween items', 'optima' ),
                'param_name' => 'spacing_beetween_items',
                "value"         => array(
                    esc_html__( '30px', 'optima' )      => '30',
                    esc_html__( '25px', 'optima' )      => '25',
                    esc_html__( '20px', 'optima' )      => '20',
                    esc_html__( '15px', 'optima' )      => '15',
                    esc_html__( '10px', 'optima' )      => '10',
                    esc_html__( '5px', 'optima' )      => '5'
                ),
                "description" => esc_html__("Select spacing beetween items.", "optima"),
                "dependency" => Array("element" => "view_type","value" => array("type2", "type3", "type4")),
            ),
            // Post meta position
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Post meta position', 'optima' ),
                'param_name' => 'meta_position',
                "value"         => array(
                    esc_html__( 'Before Title', 'optima' ) => 'before_title',
                    esc_html__( 'After Title', 'optima' ) => 'after_title'
                ),
                "description" => esc_html__("Select post-meta position.", "optima"),
                "dependency" => Array("element" => "view_type","value" => array("type1","type2", "type3", "type4")),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Make first post with image', 'optima' ),
                'param_name' => 'first_post_image',
                'description' => esc_html__( 'If checked, make first post with image.', 'optima' ),
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                "dependency" => Array("element" => "view_type","value" => array("type1")),
                'save_always' => true,
                'std' => 'yes'
            ),
            // Content alignment
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Content alignment', 'optima' ),
                'param_name' => 'content_alignment',
                "value"         => array(
                    esc_html__( 'Left', 'optima' ) => 'left',
                    esc_html__( 'Center', 'optima' ) => 'center',
                    esc_html__( 'Right', 'optima' ) => 'right',
                    esc_html__( 'Justify', 'optima' ) => 'justify'
                ),
                "description" => esc_html__("Select content alignment.", "optima"),
                "dependency" => Array("element" => "view_type","value" => array("type3", "type4")),
            ),
            // Content Letter Count
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Content Letter Count', 'optima'),
                'param_name' => 'content_letter_count',
                'value' => '85',
                'description' => esc_html__( 'Enter content letter count.', 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // --- CAROUSEL GROUP --- //
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use blog-posts carousel?', 'optima' ),
                'param_name' => 'use_carousel',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                "group" => esc_html__( "Carousel", 'optima' )
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Autoplay carousel', 'optima' ),
                'param_name' => 'autoplay_carousel',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'std' => 'yes',
                'dependency' => array(
                    'element' => 'use_carousel',
                    "value" => array("yes")
                ),
                "group" => esc_html__( "Carousel", 'optima' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Autoplay time.', 'optima' ),
                'param_name' => 'auto_play_time',
                'value' => '3000',
                'description' => esc_html__( 'Enter autoplay time in milliseconds.', 'optima' ),
                'dependency' => array(
                    'element' => 'autoplay_carousel',
                    'value' => array("yes"),
                ),
                "group" => esc_html__( "Carousel", 'optima' ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Single slide to scroll', 'optima' ),
                'param_name' => 'scroll_items',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                "group" => esc_html__( "Carousel", 'optima' ),
                'dependency' => array(
                    'element' => 'use_carousel',
                    "value" => array("yes")
                ),
                'std' => 'yes',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Infinite Scroll', 'optima' ),
                'param_name' => 'infinite_scroll',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'std' => 'yes',
                'dependency' => array(
                    'element' => 'use_carousel',
                    "value" => array("yes")
                ),
                "group" => esc_html__( "Carousel", 'optima' ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Hide Pagination control', 'optima' ),
                'param_name' => 'use_pagination_carousel',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'dependency' => array(
                    'element' => 'use_carousel',
                    "value" => array("yes")
                ),
                "group" => esc_html__( "Carousel", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Hide prev/next buttons', 'optima' ),
                'param_name' => 'use_prev_next_carousel',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'dependency' => array(
                    'element' => 'use_carousel',
                    "value" => array("yes")
                ),
                "group" => esc_html__( "Carousel", 'optima' ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Adaptive Height', 'optima' ),
                'param_name' => 'adaptive_height',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'std' => 'yes',
                'dependency' => array(
                    'element' => 'use_carousel',
                    "value" => array("yes")
                ),
                "group" => esc_html__( "Carousel", 'optima' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Items Per Column', 'optima' ),
                'param_name' => 'items_per_column',
                "value"         => array(
                    esc_html__( '1', 'optima' ) => '1',
                    esc_html__( '2', 'optima' ) => '2',
                    esc_html__( '3', 'optima' ) => '3',
                    esc_html__( '4', 'optima' ) => '4'
                ),
                "description" => esc_html__("Select post items per column.", "optima"),
                'dependency' => array(
                    'element' => 'use_carousel',
                    "value" => array("yes")
                ),
                "group" => esc_html__( "Carousel", 'optima' ),
            ),
            // --- CUSTOM GROUP --- //
            // Blog Font
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for blog?', 'optima' ),
                'param_name' => 'use_theme_fonts_blog',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Custom", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_blog',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_blog',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
            ),
            // Blog Headings Font
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for blog headings?', 'optima' ),
                'param_name' => 'use_theme_fonts_blog_headings',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Custom", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_blog_headings',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_blog_headings',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default blog style?', 'optima' ),
                'param_name' => 'use_theme_blog_style',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use default blog style from the theme.', 'optima' ),
                "group" => esc_html__( "Custom", 'optima' ),
                'std' => 'yes',
            ),
            // Custom blog style
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Custom Theme Color", "optima"),
                "param_name" => "custom_theme_color",
                "value" => esc_attr(gt3_option("theme-custom-color")),
                "description" => esc_html__("Select custom theme color.", "optima"),
                'dependency' => array(
                    'element' => 'use_theme_blog_style',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Custom Headings Color", "optima"),
                "param_name" => "custom_headings_color",
                "value" => esc_attr($header_font['color']),
                "description" => esc_html__("Select custom headings color.", "optima"),
                'dependency' => array(
                    'element' => 'use_theme_blog_style',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Custom Content Color", "optima"),
                "param_name" => "custom_content_color",
                "value" => esc_attr($main_font['color']),
                "description" => esc_html__("Select custom content color.", "optima"),
                'dependency' => array(
                    'element' => 'use_theme_blog_style',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-4',
            ),
            // Heading Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Heading Font Size', 'optima'),
                'param_name' => 'heading_font_size',
                'value' => '18',
                'description' => esc_html__( 'Enter heading font-size in pixels.', 'optima' ),
                'dependency' => array(
                    'element' => 'use_theme_blog_style',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Heading Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Content Font Size', 'optima'),
                'param_name' => 'content_font_size',
                'value' => '16',
                'description' => esc_html__( 'Enter content font-size in pixels.', 'optima' ),
                'dependency' => array(
                    'element' => 'use_theme_blog_style',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            vc_map_add_css_animation( true ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", "optima"),
                "param_name" => "item_el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "optima")
            ),
        ),

    ));

    class WPBakeryShortCode_Gt3_Featured_Posts extends WPBakeryShortCode
    {
    }
}