<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if (function_exists('vc_map')) {
    vc_map(array(
        'base' => 'gt3_price_block',
        'name' => esc_html__('Price Block', 'optima'),
        "description" => esc_html__("Create price table", 'optima'),
        'category' => esc_html__('GT3 Modules', 'optima'),
        'icon' => 'gt3_icon',
        'params' => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Package Name / Title", 'optima'),
                "param_name" => "title",
                "description" => esc_html__("Enter title of price block.", 'optima')
            ),
            array(
                "type" => "attach_image",
                "heading" => esc_html__("Section Icon", 'optima'),
                "param_name" => "header_img",
                "description" => esc_html__("Select section icon.", 'optima')
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Active package', 'optima'),
                'param_name' => 'package_is_active',
                'admin_label' => true,
                'value' => array(
                    esc_html__("No", 'optima') => 'no',
                    esc_html__("Yes", 'optima') => 'yes',
                ),
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Package Price", 'optima'),
                "param_name" => "price",
                "description" => esc_html__("Enter the price for this package. e.g. '157'", 'optima')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Price Prefix", 'optima'),
                "param_name" => "price_prefix",
                "description" => esc_html__("Enter the price prefix for this package. e.g. '$'", 'optima')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Package Suffix", 'optima'),
                "param_name" => "price_suffix",
                "description" => esc_html__("Enter the price suffix for this package. e.g. '/ person'", 'optima')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Package description", 'optima'),
                "param_name" => "price_description",
                "description" => esc_html__("Enter the price block short description", 'optima')
            ),
            array(
                "type" => "vc_link",
                "heading" => esc_html__("Link", 'optima'),
                "param_name" => "button_link",
            ),
            array(
                "type" => "textarea_html",
                "heading" => esc_html__("Price field", 'optima'),
                "param_name" => "content",
            ),
            
            // General Params
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", 'optima'),
                "param_name" => "item_el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'optima')
            ),
            array(
                'type' => 'css_editor',
                'heading' => esc_html__( 'CSS box', 'optima' ),
                'param_name' => 'css',
                'group' => esc_html__( 'Design Options', 'optima' ),
                'edit_field_class' => '',
            ),
            // Price Title Fonts
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for price table header?', 'optima' ),
                'param_name' => 'use_theme_fonts_price_header',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_price_header',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_price_header',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for price table content?', 'optima' ),
                'param_name' => 'use_theme_fonts_price_content',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_price_content',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_price_content',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            // Button COLOR
            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Section color", 'optima'),
                "param_name" => "section_color",
                "value" => esc_attr(gt3_option("theme-custom-color")),
                "description" => esc_html__("Select custom color for section.", 'optima'),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use alternative button style?', 'optima' ),
                'param_name' => 'use_alt_button_style',
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => '',
            ),
        ),


    ));

    class WPBakeryShortCode_Gt3_Price_block extends WPBakeryShortCode { }

}