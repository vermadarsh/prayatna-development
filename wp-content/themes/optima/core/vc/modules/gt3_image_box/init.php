<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$header_font = gt3_option('header-font');
$main_font = gt3_option('main-font');

if (function_exists('vc_map')) {
// Add list item
    vc_map(array(
        "name" => esc_html__("Image Box", "optima"),
        "base" => "gt3_image_box",
        "class" => "gt3_image_box",
        "category" => esc_html__('GT3 Modules', 'optima'),
        "icon" => 'gt3_icon',
        "content_element" => true,
        "description" => esc_html__("Image Box","optima"),
        "params" => array(
            // Image selection
            array(
                'type' => 'attach_image',
                'heading' => esc_html__( 'Image', 'optima' ),
                'param_name' => 'thumbnail',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'optima' ),
            ),
            array(
                "type"          => "dropdown",
                "heading"       => esc_html__( 'Image Position', 'optima' ),
                "param_name"    => "image_position",
                "value"         => array(
                    esc_html__( 'Top', 'optima' )               => 'top',
                    esc_html__( 'Left', 'optima' )              => 'left',
                    esc_html__( 'Right', 'optima' )             => 'right'
                ),
                'save_always' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Image Border Radius', 'optima' ),
                'param_name' => 'border_radius',
                "value"         => array(
                    esc_html__( 'None', 'optima' )      => '0px',
                    esc_html__( '1px', 'optima' )      => '1px',
                    esc_html__( '2px', 'optima' )      => '2px',
                    esc_html__( '3px', 'optima' )      => '3px',
                    esc_html__( '4px', 'optima' )      => '4px',
                    esc_html__( '5px', 'optima' )      => '5px',
                    esc_html__( '10px', 'optima' )      => '10px',
                    esc_html__( '15px', 'optima' )      => '15px',
                    esc_html__( '20px', 'optima' )      => '20px',
                    esc_html__( '25px', 'optima' )      => '25px',
                    esc_html__( '30px', 'optima' )      => '30px',
                    esc_html__( '35px', 'optima' )      => '35px'
                ),
                'std' => '10px'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Heading", "optima"),
                "param_name" => "heading",
                "description" => esc_html__("Enter text for heading line.", "optima"),
                'admin_label' => true,
            ),
            array(
                "type" => "textarea",
                "heading" => esc_html__("Text", "optima"),
                "param_name" => "text",
                "description" => esc_html__("Enter text.", "optima")
            ),            
            array(
                "type"          => "textfield",
                "heading"       => esc_html__( 'Link', 'optima' ),
                "param_name"    => "url",
            ),
            array(
                "type"          => "textfield",
                "heading"       => esc_html__( 'Link Text', 'optima' ),
                "param_name"    => "url_text",
            ),            
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Open in New Tab', 'optima' ),
                "param_name"    => "new_tab",
                'save_always' => true,
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Add divider after Heading', 'optima' ),
                "param_name"    => "add_divider",
                'std' => '',
            ),
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Divider Color', 'optima' ),
                "param_name"    => "divider_color",
                "value"         => esc_attr(gt3_option("theme-custom-color")),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'add_divider',
                    'value' => "true",
                ),
            ),
            vc_map_add_css_animation( true ),
            // Styling
            array(
                "type"          => "dropdown",
                "heading"       => esc_html__( 'Title Tag', 'optima' ),
                "param_name"    => "title_tag",
                "value"         => array(
                    esc_html__( 'H2', 'optima' )    => 'h2',
                    esc_html__( 'H3', 'optima' )    => 'h3',
                    esc_html__( 'H4', 'optima' )    => 'h4',
                    esc_html__( 'H5', 'optima' )    => 'h5',
                    esc_html__( 'H6', 'optima' )    => 'h6',
                ),
                'save_always' => true,
                "group"         => esc_html__( "Styling", 'optima' ),
            ),
            // Image Box title Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Image Box Title Font Size', 'optima'),
                'param_name' => 'imagebox_title_size',
                'value' => '28',
                'description' => esc_html__( 'Enter Image Box title font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Imagebox Title Fonts
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for iamgebox title?', 'optima' ),
                'param_name' => 'use_theme_fonts_imagebox_title',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_imagebox_title',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_imagebox_title',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            // Image Box content Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Image Box Content Font Size', 'optima'),
                'param_name' => 'imagebox_content_size',
                'value' => '16',
                'description' => esc_html__( 'Enter Image Box content font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Imagebox content Fonts
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for imagebox content?', 'optima' ),
                'param_name' => 'use_theme_fonts_imagebox_content',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_imagebox_content',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_imagebox_content',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Title Color', 'optima' ),
                "param_name"    => "title_color",
                "group"         => esc_html__( "Styling", 'optima' ),
                "value"         => esc_attr($header_font['color']),
                'save_always' => true,
            ),
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Text Color', 'optima' ),
                "param_name"    => "text_color",
                "group"         => esc_html__( "Styling", 'optima' ),
                "value"         => esc_attr($main_font['color']),
                'save_always' => true,
            ),
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Link Color', 'optima' ),
                "param_name"    => "link_color",
                "group"         => esc_html__( "Styling", 'optima' ),
                "value"         => esc_attr(gt3_option("theme-custom-color")),
                'save_always' => true,
            ),
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Link Hover Color', 'optima' ),
                "param_name"    => "link_hover_color",
                "group"         => esc_html__( "Styling", 'optima' ),
                "value"         => esc_attr($header_font['color']),
                'save_always' => true,
            ),                
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_Gt3_image_box extends WPBakeryShortCode {
            
        }
    } 
}
