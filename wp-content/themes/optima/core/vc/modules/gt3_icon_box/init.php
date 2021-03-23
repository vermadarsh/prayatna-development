<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$header_font = gt3_option('header-font');
$main_font = gt3_option('main-font');

if (function_exists('vc_map')) {
// Add list item
    vc_map(array(
        "name" => esc_html__("Icon Box", 'optima'),
        "base" => "gt3_icon_box",
        "class" => "gt3_icon_box",
        "category" => esc_html__('GT3 Modules', 'optima'),
        "icon" => 'gt3_icon',
        "content_element" => true,
        "description" => esc_html__("Icon Box",'optima'),
        "params" => array(
            // Icon Section
            array(
                "type"          => "dropdown",
                "heading"       => esc_html__( 'Icon Type', 'optima' ),
                "param_name"    => "icon_type",
                "value"         => array(
                    esc_html__( 'None', 'optima' )      => 'none',
                    esc_html__( 'Font', 'optima' )      => 'font',
                    esc_html__( 'Image', 'optima' )     => 'image',
                    esc_html__( 'Number', 'optima' )    => 'number',
                ),
                'save_always' => true,
            ),
            array(
                "type"          => "textfield",
                "heading"       => esc_html__( 'Number', 'optima' ),
                "param_name"    => "number",
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'number',
                ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'optima' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'iconsPerPage' => 200,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'description' => esc_html__( 'Select icon from library.', 'optima' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => 'font',
                ),
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__( 'Image', 'optima' ),
                'param_name' => 'thumbnail',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'optima' ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array( 'image' ),
                ),
            ),
            array(
                "type"          => "dropdown",
                "heading"       => esc_html__( 'Icon Position', 'optima' ),
                "param_name"    => "icon_position",
                "value"         => array(
                    esc_html__( 'Top', 'optima' )               => 'top',
                    esc_html__( 'Left', 'optima' )              => 'left',
                    esc_html__( 'Right', 'optima' )             => 'right',
                    esc_html__('Inline with Title', 'optima')   => 'inline_title'
                ),
                /*'dependency' => array(
                    'element' => 'icon_type',
                    'value_not_equal_to' => array( 'number' ),
                ),*/
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array( 'image', 'font' ),
                ),
                'save_always' => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => esc_html__( 'Content Aligment', 'optima' ),
                "param_name"    => "content_aligment",
                "value"         => array(
                    esc_html__( 'Left', 'optima' )              => 'left',
                    esc_html__( 'Center', 'optima' )             => 'center',
                    esc_html__( 'Right', 'optima' )             => 'right',
                    esc_html__( 'Justify', 'optima' )             => 'justify'
                ),
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array( 'none' ),
                ),
                'save_always' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Heading", 'optima'),
                "param_name" => "heading",
                "description" => esc_html__("Enter text for heading line.", 'optima'),
                'admin_label' => true,
            ),
            array(
                "type" => "textarea",
                "heading" => esc_html__("Text", 'optima'),
                "param_name" => "text",
                "description" => esc_html__("Enter text.", 'optima')
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
                "heading"       => esc_html__( 'Icon in circle', 'optima' ),
                "param_name"    => "icon_circle",
                'save_always' => true,
                /*'dependency' => array(
                    'element' => 'icon_type',
                    'value_not_equal_to' => array( 'number' ),
                ),*/
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array( 'image', 'font' ),
                ),
            ),
             array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Circle Color', 'optima' ),
                "param_name"    => "circle_bg",
                "value"         => '#e9e9e9',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'icon_circle',
                    'value' => "true",
                ),
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__( 'Add Number', 'optima' ),
                "param_name"    => "icon_add_number",
                'save_always' => true,
                /*'dependency' => array(
                    'element' => 'icon_type',
                    'value_not_equal_to' => array( 'number' ),
                ),*/
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array( 'image', 'font' ),
                ),
            ),
            array(
                "type"          => "textfield",
                "heading"       => esc_html__( 'Number', 'optima' ),
                "param_name"    => "icon_number",
                'dependency' => array(
                    'element' => 'icon_add_number',
                    'value' => "true",
                ),
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
                "heading"       => esc_html__( 'Icon Size', 'optima' ),
                "param_name"    => "icon_size",
                "value"         => array(
                    esc_html__( 'Regular', 'optima' )   => 'regular',
                    esc_html__( 'Mini', 'optima' )      => 'mini',
                    esc_html__( 'Small', 'optima' )     => 'small',
                    esc_html__( 'Large', 'optima' )     => 'large',
                    esc_html__( 'Huge', 'optima' )      => 'huge',
                    esc_html__( 'Custom', 'optima')     => 'custom'
                ),              
                "group"         => esc_html__( "Styling", 'optima' ),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array( 'image', 'font', 'number' ),
                ),
            ),
            // Custom icon size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Custom Icon Size', 'optima'),
                'param_name' => 'custom_icon_size',
                'value' => '18',
                'description' => esc_html__( 'Enter Icon size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'dependency' => array(
                    'element' => 'icon_size',
                    'value' => 'custom',
                ),
            ),
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Icon Color', 'optima' ),
                "param_name"    => "icon_color",
                "group"         => esc_html__( "Styling", 'optima' ),
                "value"         => esc_attr(gt3_option("theme-custom-color")),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'icon_type',
                    'value' => array('font','number'),
                ),
            ),
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
                'std'           => "h3",
                'save_always' => true,
                "group"         => esc_html__( "Styling", 'optima' ),
            ),
            // Icon Box title Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Icon Box Title Font Size', 'optima'),
                'param_name' => 'iconbox_title_size',
                'value' => '28',
                'description' => esc_html__( 'Enter Icon Box title font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Iconbox Title Fonts
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for iconbox title?', 'optima' ),
                'param_name' => 'use_theme_fonts_iconbox_title',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_iconbox_title',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_iconbox_title',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            // Icon Box content Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Icon Box Content Font Size', 'optima'),
                'param_name' => 'iconbox_content_size',
                'value' => '14',
                'description' => esc_html__( 'Enter Icon Box content font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Iconbox content Fonts
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for iconbox content?', 'optima' ),
                'param_name' => 'use_theme_fonts_iconbox_content',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_iconbox_content',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_iconbox_content',
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
                "dependency" => Array("element" => "url_text", "not_empty" => true),
            ),
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Link Hover Color', 'optima' ),
                "param_name"    => "link_hover_color",
                "group"         => esc_html__( "Styling", 'optima' ),
                "value"         => esc_attr($header_font['color']),
                'save_always' => true,
                "dependency" => Array("element" => "url_text", "not_empty" => true),
            ),                
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_Gt3_icon_box extends WPBakeryShortCode {
            
        }
    } 
}
