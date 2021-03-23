<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if (function_exists('vc_map')) {
    // Add button
    vc_map(array(
        "name" => esc_html__("Button", "optima"),
        "base" => "gt3_button",
        "class" => "gt3_button",
        "category" => esc_html__('GT3 Modules', 'optima'),
        "icon" => 'gt3_icon',
        "content_element" => true,
        "description" => esc_html__("Add custom button","optima"),
        "params" => array(
            // Text
            array(
                "type" => "textfield",
                "heading" => esc_html__("Text", "optima"),
                "param_name" => "button_title",
                "value" => esc_html__("Text on the button", "optima"),
                'admin_label' => true,
            ),
            // Link
            array(
                'type' => 'vc_link',
                'heading' => esc_html__( 'Link', 'optima' ),
                'param_name' => 'link',
                "description" => esc_html__("Add link to button.", "optima")
            ),
            // Size
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Size', 'optima' ),
                'param_name' => 'button_size',
                "value"         => array(
                    esc_html__( 'Normal', 'optima' )   => 'normal',
                    esc_html__( 'Mini', 'optima' )      => 'mini',
                    esc_html__( 'Small', 'optima' )     => 'small',
                    esc_html__( 'Large', 'optima' )     => 'large'
                ),
                "description" => esc_html__("Select button display size.", "optima")
            ),
            // Alignment
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Alignment', 'optima' ),
                'param_name' => 'button_alignment',
                "value"         => array(
                    esc_html__( 'Inline', 'optima' )      => 'inline',
                    esc_html__( 'Left', 'optima' )     => 'left',
                    esc_html__( 'Right', 'optima' )   => 'right',
                    esc_html__( 'Center', 'optima' )     => 'center',
                    esc_html__( 'Block', 'optima' )      => 'block'
                ),
                "description" => esc_html__("Select button alignment.", "optima")
            ),
            // Button Border
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Button Border Radius', 'optima' ),
                'param_name' => 'btn_border_radius',
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
                'std' => '30px'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Button Border Style', 'optima' ),
                'param_name' => 'btn_border_style',
                "value"         => array(
                    esc_html__( 'Solid', 'optima' )     => 'solid',
                    esc_html__( 'Dashed', 'optima' )   => 'dashed',
                    esc_html__( 'Dotted', 'optima' )     => 'dotted',
                    esc_html__( 'Double', 'optima' )      => 'double',
                    esc_html__( 'Inset', 'optima' )      => 'inset',
                    esc_html__( 'Outset', 'optima' )      => 'outset',
                    esc_html__( 'None', 'optima' )      => 'none'
                ),
                'dependency' => array(
                    'callback' => 'gt3ButtonDependency',
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Button Border Width', 'optima' ),
                'param_name' => 'btn_border_width',
                "value"         => array(
                    esc_html__( '1px', 'optima' )      => '1px',
                    esc_html__( '2px', 'optima' )      => '2px',
                    esc_html__( '3px', 'optima' )      => '3px',
                    esc_html__( '4px', 'optima' )      => '4px',
                    esc_html__( '5px', 'optima' )      => '5px',
                    esc_html__( '6px', 'optima' )      => '6px',
                    esc_html__( '7px', 'optima' )      => '7px',
                    esc_html__( '8px', 'optima' )      => '8px',
                    esc_html__( '9px', 'optima' )      => '9px',
                    esc_html__( '10px', 'optima' )      => '10px'
                ),
                'dependency' => array(
                    'element' => 'btn_border_style',
                    'value_not_equal_to' => 'none',
                ),
            ),
            // --- ICON GROUP --- //
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => esc_html__("Icon Type", "optima"),
                "param_name" => "btn_icon_type",
                "value" => array(
                    esc_html__("None","optima") => "none",
                    esc_html__("Font","optima") => "font",
                    esc_html__("Image","optima") => "image",
                ),
                'group' => esc_html__( 'Icon', 'optima' ),
                "description" => esc_html__("Use an existing font icon or upload a custom image.", "optima"),
                'dependency' => array(
                    'callback' => 'gt3ButtonDependency',
                ),
            ),
            // Icon
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'optima'),
                'param_name' => 'btn_icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'iconsPerPage' => 200, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                "dependency" => Array("element" => "btn_icon_type","value" => array("font")),
                'description' => esc_html__( 'Select icon from library.', 'optima' ),
                'group' => esc_html__( 'Icon', 'optima' ),
            ),
            // Image
            array(
                'type' => 'attach_image',
                'heading' => esc_html__('Image', 'optima'),
                'param_name' => 'btn_image',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'optima' ),
                "dependency" => Array("element" => "btn_icon_type","value" => array("image")),
                'group' => esc_html__( 'Icon', 'optima' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Image Width', 'optima'),
                'param_name' => 'btn_img_width',
                'value' => '',
                'description' => esc_html__( 'Enter image width in pixels.', 'optima' ),
                "dependency" => Array("element" => "btn_icon_type","value" => array("image")),
                'edit_field_class' => 'vc_col-sm-6',
                'group' => esc_html__( 'Icon', 'optima' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Icon Position', 'optima'),
                'param_name' => 'btn_icon_position',
                'value' => array(
                    esc_html__("Left", "optima") => 'left',
                    esc_html__("Right", "optima") => 'right'
                ),
                "dependency" => Array("element" => "btn_icon_type","value" => array("image", "font")),
                'group' => esc_html__( 'Icon', 'optima' ),
            ),
            // Icon Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Icon Font Size', 'optima'),
                'param_name' => 'icon_font_size',
                'value' => '18',
                'description' => esc_html__( 'Enter icon font-size in pixels.', 'optima' ),
                "dependency" => Array("element" => "btn_icon_type","value" => array("font")),
                "group" => esc_html__( "Icon", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // --- TYPOGRAPHY GROUP --- //
            // Button Font
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for button?', 'optima' ),
                'param_name' => 'use_theme_fonts_button',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Typography", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_button',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_button',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Typography", 'optima' ),
            ),
            // Button Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Button Font Size', 'optima'),
                'param_name' => 'btn_font_size',
                'value' => '12',
                'description' => esc_html__( 'Enter button font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Typography", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // --- SPACING GROUP --- //
            array(
                'type' => 'css_editor',
                'param_name' => 'css',
                'group' => esc_html__( 'Spacing', 'optima' ),
            ),
            vc_map_add_css_animation( true ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", "optima"),
                "param_name" => "item_el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "optima")
            ),
            // --- CUSTOM GROUP --- //
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default button?', 'optima' ),
                'param_name' => 'use_theme_button',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use button from the theme.', 'optima' ),
                "group" => esc_html__( "Custom", 'optima' ),
                'std' => 'yes',
            ),
            // Button Bg
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Background", "optima"),
                "param_name" => "btn_bg_color",
                "value" => esc_attr(gt3_option("theme-custom-color")),
                "description" => esc_html__("Select custom background for button.", "optima"),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'use_theme_button',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button text-color
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Text Color", "optima"),
                "param_name" => "btn_text_color",
                "value" => "#ffffff",
                "description" => esc_html__("Select custom text color for button.", "optima"),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'use_theme_button',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Hover Bg
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Button Hover Background", "optima"),
                "param_name" => "btn_bg_color_hover",
                "value" => "#ffffff",
                "description" => esc_html__("Select custom background for hover button.", "optima"),
                'dependency' => array(
                    'element' => 'use_theme_button',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Hover text-color
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Button Hover Text Color", "optima"),
                "param_name" => "btn_text_color_hover",
                "value" => esc_attr(gt3_option("theme-custom-color")),
                "description" => esc_html__("Select custom text color for hover button.", "optima"),
                'dependency' => array(
                    'element' => 'use_theme_button',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button icon-color
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Icon Color", "optima"),
                "param_name" => "btn_icon_color",
                "value" => "#ffffff",
                "description" => esc_html__("Select icon color for button.", "optima"),
                'dependency' => array(
                    'element' => 'use_theme_button',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Hover icon-color
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Button Hover Icon Color", "optima"),
                "param_name" => "btn_icon_color_hover",
                "value" => "#ffffff",
                "description" => esc_html__("Select icon color for hover button.", "optima"),
                'dependency' => array(
                    'element' => 'use_theme_button',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button border-color
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Button Border Color", "optima"),
                "param_name" => "btn_border_color",
                "value" => esc_attr(gt3_option("theme-custom-color")),
                "description" => esc_html__("Select custom border color for button.", "optima"),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'use_theme_button',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Custom", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Button Hover border-color
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Button Hover Border Color", "optima"),
                "param_name" => "btn_border_color_hover",
                "value" => esc_attr(gt3_option("theme-custom-color")),
                "description" => esc_html__("Select custom border color for hover button.", "optima"),
                "group" => esc_html__( "Custom", 'optima' ),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'use_theme_button',
                    'value_not_equal_to' => 'yes',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),


        )
    ));

    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_Gt3_Button extends WPBakeryShortCode {
        }
    }
}