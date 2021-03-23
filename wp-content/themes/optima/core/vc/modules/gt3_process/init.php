<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if (function_exists('vc_map')) {
    vc_map(array(
        'base' => 'gt3_process',
        'name' => esc_html__('Process', 'optima'),
        "description" => esc_html__("Create processes", "optima"),
        'category' => esc_html__('GT3 Modules', 'optima'),
        'icon' => 'gt3_icon',
        'params' => array(
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Values', 'optima' ),
                'param_name' => 'values',
                'description' => esc_html__( 'Enter values for graph - value, title and color.', 'optima' ),
                'value' => urlencode( json_encode( array(
                    array(
                        'proc_number' => '1',
                        'proc_heading' => esc_html__( 'Step 1', 'optima' ),
                    ),
                    array(
                        'proc_number' => '2',
                        'proc_heading' => esc_html__( 'Step 2', 'optima' ),
                    ),
                    array(
                        'proc_number' => '3',
                        'proc_heading' => esc_html__( 'Step 3', 'optima' ),
                    ),
                ) ) ),
                'params' => array(
                    array(
                        "type"          => "dropdown",
                        "heading"       => esc_html__( 'Icon Type', 'optima' ),
                        "param_name"    => "icon_type",
                        "value"         => array(
                            esc_html__( 'None', 'optima' )      => 'none',
                            esc_html__( 'Font', 'optima' )      => 'font',
                            esc_html__( 'Image', 'optima' )     => 'image',
                        ),
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_html__( 'Icon', 'optima' ),
                        'param_name' => 'proc_icon',
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
                        'param_name' => 'proc_thumb',
                        'value' => '',
                        'description' => esc_html__( 'Select image from media library.', 'optima' ),
                        'dependency' => array(
                            'element' => 'icon_type',
                            'value' => array( 'image' ),
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Step Number (Integer)', 'optima' ),
                        'param_name' => 'proc_number',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Step Heading', 'optima' ),
                        'param_name' => 'proc_heading',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Step Description', 'optima' ),
                        'param_name' => 'proc_descr',
                    ),
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Items Per Line', 'optima'),
                'param_name' => 'per_line',
                'value' => array(
                    esc_html__("1", "optima") => '1',
                    esc_html__("2", "optima") => '2',
                    esc_html__("3", "optima") => '3',
                    esc_html__("4", "optima") => '4',
                ),
                'std' => '3',
            ),
            // Styling
            array(
                "type"          => "dropdown",
                "heading"       => esc_html__( 'Icon Size', 'optima' ),
                "param_name"    => "icon_size",
                "value"         => array(
                    esc_html__( 'Regular', 'optima' )   => 'regular',
                    esc_html__( 'Small', 'optima' )     => 'small',
                    esc_html__( 'Large', 'optima' )     => 'large',
                ),              
                "group"         => esc_html__( "Styling", 'optima' ),
                'save_always' => true,
            ),
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Icon Color', 'optima' ),
                "param_name"    => "icon_color",
                "group"         => esc_html__( "Styling", 'optima' ),
                "value"         => esc_attr(gt3_option("theme-custom-color")),
                'save_always'   => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type"          => "colorpicker",
                "heading"       => esc_html__( 'Step Number Color', 'optima' ),
                "param_name"    => "number_color",
                "group"         => esc_html__( "Styling", 'optima' ),
                "value"         => esc_attr(gt3_option("theme-custom-color")),
                'save_always'   => true,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Process title Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Process Title Font Size', 'optima'),
                'param_name' => 'title_size',
                'value' => '24',
                'description' => esc_html__( 'Enter Process title font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Process title Font Size
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Process Title Font Weight', 'optima'),
                'param_name' => 'title_weight',
                "value"         => array(
                    esc_html__( '300', 'optima' )     => '300',
                    esc_html__( '400', 'optima' )     => '400',
                    esc_html__( '500', 'optima' )     => '500',
                    esc_html__( '600', 'optima' )     => '600',
                ),    
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        ),
    ));

    class WPBakeryShortCode_Gt3_Process extends WPBakeryShortCode { }

}