<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$main_font = gt3_option("main-font");
$theme_custom_color3 = gt3_option("theme-custom-color3");

if (function_exists('vc_map')) {
// Add list item
    vc_map(array(
        "name" => esc_html__("Twitter", "optima"),
        "base" => "gt3_twitter",
        "class" => "gt3_twitter",
        "category" => esc_html__('GT3 Modules', 'optima'),
        "icon" => 'gt3_icon',
        "content_element" => true,
        "description" => esc_html__("Twitter","optima"),
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Twitter Username", "optima"),
                "param_name" => "name",
                "description" => esc_html__("Enter twitter profile name", "optima"),
                "value" => "",
                'save_always' => true,
                'admin_label' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Tweets Count', 'optima' ),
                'param_name' => 'count',
                "value"         => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                    '17' => '17',
                    '18' => '18',
                    '19' => '19',
                    '20' => '20'
                ),
                'save_always' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Start display from', 'optima' ),
                'param_name' => 'count_begin',
                "value"         => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                    '17' => '17',
                    '18' => '18',
                    '19' => '19',
                    '20' => '20'
                ),
                'save_always' => true,
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Spacing between tweet component', 'optima'),
                'param_name' => 'spacing',
                'value' => '15',
                'description' => esc_html__( 'Enter spacing in pixels.', 'optima' ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Font Size', 'optima'),
                'param_name' => 'font_size',
                'value' => '',
                'description' => esc_html__( 'Enter font-size in pixels.', 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
                'save_always' => true,
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Line Height', 'optima'),
                'param_name' => 'line_height',
                'value' => '160',
                'description' => esc_html__( 'Enter line height in %.', 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
                'save_always' => true,
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Text Color", "optima"),
                "param_name" => "text_color",
                "value" => esc_attr($main_font['color']),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Link Color", "optima"),
                "param_name" => "link_color",
                "value" => esc_attr($theme_custom_color3),
                'edit_field_class' => 'vc_col-sm-6',
            ),                    
        )
    ));
    
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_Gt3_twitter extends WPBakeryShortCode {
            
        }
    } 
}
