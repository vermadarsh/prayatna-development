<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$header_font = gt3_option('header-font');
$h1_font = gt3_option('h1-font');

if (function_exists('vc_map')) {
// Add list item
    vc_map(array(
        "name" => esc_html__("Animated Text", "optima"),
        "base" => "gt3_typed",
        "class" => "gt3_typed",
        "category" => esc_html__('GT3 Modules', 'optima'),
        "icon" => 'gt3_icon',
        "content_element" => true,
        "description" => esc_html__("Gt3 Animated Text","optima"),
        "params" => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Text Prefix', 'optima' ),
                'param_name' => 'pref_text',
                'admin_label' => true,
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Typed Text', 'optima' ),
                'param_name' => 'values',
                'description' => esc_html__( 'Enter values for graph - value, title and color.', 'optima' ),
                'value' => urlencode( json_encode( array(
                    array(
                        'text' => esc_html__( 'Text 1', 'optima' ),
                    ),
                    array(
                        'text' => esc_html__( 'Text 2', 'optima' ),
                    ),
                    array(
                        'text' => esc_html__( 'Text 3', 'optima' ),
                    ),
                ) ) ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Text', 'optima' ),
                        'param_name' => 'text',
                        'admin_label' => true,
                    ),
                ),
            ),
            array(
                "type"          => "dropdown",
                "heading"       => esc_html__( 'Typed Text Decoration', 'optima' ),
                "param_name"    => "text_decor",
                "value"         => array(
                    esc_html__( 'None', 'optima' )            => 'none',
                    esc_html__( 'Underline', 'optima' )       => 'underline',
                    esc_html__( 'Overline', 'optima' )        => 'overline',
                    esc_html__( 'Line Through', 'optima' )    => 'line-through',
                ),
            ),
            // Styling
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Text Color', 'optima' ),
                "param_name"    => "text_color",
                "group"         => esc_html__( "Styling", 'optima' ),
                "value"         => esc_attr($header_font['color']),
                'save_always' => true,
            ), 
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Font Size', 'optima'),
                'param_name' => 'font_size',
                'value' => (int)$h1_font['font-size'],
                'description' => esc_html__( 'Enter font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Line Height', 'optima'),
                'param_name' => 'line_height',
                'value' => '140',
                'description' => esc_html__( 'Enter line height in %.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Font Weight', 'optima'),
                'param_name' => 'font_weight',
                'value' => '600',
                'description' => esc_html__( 'Enter font-weight.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Set Resonsive Font Size', 'optima' ),
                'param_name' => 'responsive_font',
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Font Size for small Desktops', 'optima'),
                'param_name' => 'font_size_sm_desctop',
                'description' => esc_html__( 'Enter font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'responsive_font',
                    "value" => "true"
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Font Size for Tablets', 'optima'),
                'param_name' => 'font_size_tablet',
                'description' => esc_html__( 'Enter font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'responsive_font',
                    "value" => "true"
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Font Size for Mobile', 'optima'),
                'param_name' => 'font_size_mobile',
                'description' => esc_html__( 'Enter font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
                'dependency' => array(
                    'element' => 'responsive_font',
                    "value" => "true"
                ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family?', 'optima' ),
                'param_name' => 'use_theme_fonts',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_text',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Styling", 'optima' ),
            ),               
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_Gt3_typed extends WPBakeryShortCode {
            
        }
    } 
}
