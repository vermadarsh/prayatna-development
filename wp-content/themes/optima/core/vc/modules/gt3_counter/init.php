<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if (function_exists('vc_map')) {
    // Add list item
    vc_map(array(
        "name" => esc_html__("Counter", "optima"),
        "base" => "gt3_counter",
        "class" => "gt3_counter",
        "category" => esc_html__('GT3 Modules', 'optima'),
        "icon" => 'gt3_icon',
        "content_element" => true,
        "description" => esc_html__("Adds your milestones, achievements, etc.","optima"),
        "params" => array(
            // Icon Type
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => esc_html__("Icon Type", "optima"),
                "param_name" => "icon_type",
                "value" => array(
                    esc_html__("Font","optima") => "font",
                    esc_html__("Image","optima") => "image",
                    esc_html__("None","optima") => "none",
                ),
                "description" => esc_html__("Use an existing font icon or upload a custom image.", "optima")
            ),
            // None
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Text Align', 'optima'),
                'param_name' => 'text_align',
                'value' => array(
                    esc_html__("Center", "optima") => 'center',
                    esc_html__("Left", "optima") => 'left',
                    esc_html__("Right", "optima") => 'right',
                ),
                "dependency" => Array("element" => "icon_type","value" => array("none")),
            ),
            // Icon
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'optima'),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'iconsPerPage' => 200, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                "dependency" => Array("element" => "icon_type","value" => array("font")),
                'description' => esc_html__( 'Select icon from library.', 'optima' ),
            ),
            // Image
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Image', 'optima'),
                'param_name' => 'image',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'optima' ),
                "dependency" => Array("element" => "icon_type","value" => array("image")),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Image Width', 'optima'),
                'param_name' => 'img_width',
                'value' => '60',
                'description' => esc_html__( 'Enter image width in pixels.', 'optima' ),
                "dependency" => Array("element" => "icon_type","value" => array("image")),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Image Proportions', 'optima'),
                'param_name' => 'image_proportions',
                'value' => array(
                    esc_html__("Original", "optima") => 'original',
                    esc_html__("Square", "optima") => 'square',
                    esc_html__("Circle", "optima") => 'circle',
                ),
                "dependency" => Array("element" => "img_width", "not_empty" => true),
            ),
            // General Params
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Icon Position', 'optima'),
                'param_name' => 'icon_position',
                'value' => array(
                    esc_html__("Left", "optima") => 'left',
                    esc_html__("Top", "optima") => 'top',
                    esc_html__("Right", "optima") => 'right',
                    esc_html__("Bottom", "optima") => 'bottom',
                ),
                "dependency" => Array("element" => "icon_type","value" => array("image", "font")),
            ),
             array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Counter Title ", "optima"),
                "param_name" => "counter_title",
                "admin_label" => true,
                "value" => "",
                "description" => esc_html__("Enter title for stats counter block", "optima")
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Counter Value", "optima"),
                "param_name" => "counter_value",
                "value" => "2001",
                "description" => esc_html__("Enter number for counter without any special character. You may enter a decimal number. Eg 12.76", "optima")
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Counter Value Prefix", "optima"),
                "param_name" => "counter_prefix",
                "value" => "",
                "description" => esc_html__("Enter prefix for counter value", "optima")
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Counter Value Suffix", "optima"),
                "param_name" => "counter_suffix",
                "value" => "",
                "description" => esc_html__("Enter suffix for counter value", "optima")
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Display Inline', 'optima' ),
                'param_name' => 'display_inline',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
            ),
            vc_map_add_css_animation( true ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", "optima"),
                "param_name" => "item_el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "optima")
            ),
            // Counter Title Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Counter Title Font Size', 'optima'),
                'param_name' => 'counter_title_size',
                'value' => '18',
                'description' => esc_html__( 'Enter counter title font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Counter Title Fonts
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for counter title?', 'optima' ),
                'param_name' => 'use_theme_fonts_counter_title',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_counter_title',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_counter_title',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            // Counter Value Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Counter Value Font Size', 'optima'),
                'param_name' => 'counter_value_size',
                'value' => '48',
                'description' => esc_html__( 'Enter counter value font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Counter Value Fonts
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for counter value?', 'optima' ),
                'param_name' => 'use_theme_fonts_counter_value',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_counter_value',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_counter_value',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Icon Color", "optima"),
                "param_name" => "icon_color",
                "value" => "#27323d",
                "description" => esc_html__("Select color for this item.", "optima"),
                "dependency" => Array("element" => "icon_type","value" => array("font")),
                "group" => esc_html__( "Styling", 'optima' ),
                'save_always' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Icon Size', 'optima' ),
                'param_name' => 'icon_size',
                "value"         => array(
                    esc_html__( 'Mini', 'optima' )      => 'mini',
                    esc_html__( 'Small', 'optima' )     => 'small',
                    esc_html__( 'Normal', 'optima' )   => 'normal',
                    esc_html__( 'Large', 'optima' )     => 'large',
                    esc_html__( 'Extra Large', 'optima' )      => 'extralarge'
                ),
                "dependency" => Array("element" => "icon_type","value" => array("font")),
                "group" => esc_html__( "Styling", 'optima' ),
                'save_always' => true,
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Counter Value Color", "optima"),
                "param_name" => "counter_value_color",
                "value" => "#27323d",
                "description" => esc_html__("Select color for this item.", "optima"),
                "group" => esc_html__( "Styling", 'optima' ),
                'save_always' => true,
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Title Color", "optima"),
                "param_name" => "title_color",
                "value" => "#848d95",
                "description" => esc_html__("Select color for this item.", "optima"),
                "group" => esc_html__( "Styling", 'optima' ),
                'save_always' => true,
            ),
            
        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_Gt3_Counter extends WPBakeryShortCode {
        }
    }
}