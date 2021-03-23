<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if (function_exists('vc_map')) {
    vc_map(array(
        'base' => 'gt3_testimonials',
        'name' => esc_html__('Testimonials', 'optima'),
        'description' => esc_html__('Display testimonials', 'optima'),
        'category' => esc_html__('GT3 Modules', 'optima'),
        'icon' => 'gt3_icon',
        'js_view' => 'VcColumnView',
        "as_parent" => array('only' => 'gt3_testimonial_item'),
        "content_element" => true,
        'show_settings_on_create' => false,
        'params' => array(
            array(
                'type' => 'gt3_dropdown',
                'class' => '',
                'heading' => esc_html__('Style select', 'optima'),
                'param_name' => 'view_type',
                'fields' => array(
                    'type3' => array(
                        'image' => get_template_directory_uri() . '/img/gt3_composer_addon/img2.jpg', 
                        'descr' => esc_html__('Type 1', 'optima')),
                    'type4' => array(
                        'image' => get_template_directory_uri() . '/img/gt3_composer_addon/img1.jpg', 
                        'descr' => esc_html__('Type 2', 'optima')),
                ),
                'value' => 'type1',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use testimonials carousel?', 'optima' ),
                'param_name' => 'use_carousel',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'std' => 'yes',
                'dependency' => array(
                    'element' => 'view_type',
                    'value_not_equal_to' => array("type4"),
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Carousel navigation', 'optima'),
                'param_name' => 'carousel_arrows',
                'value' => array(
                    esc_html__("Arrows", "optima") => 'arrows',
                    esc_html__("Dots", "optima") => 'dots',
                ),
                'dependency' => array(
                    'element' => 'use_carousel',
                    "value" => array("yes")
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Autoplay time.', 'optima' ),
                'param_name' => 'auto_play_time',
                'value' => '3000',
                'description' => esc_html__( 'Enter autoplay time in milliseconds.', 'optima' ),
                'dependency' => array(
                    'element' => 'use_carousel',
                    "value" => array("yes")
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Items Per Line', 'optima'),
                'param_name' => 'posts_per_line',
                'value' => array(
                    esc_html__("1", "optima") => '1',
                    esc_html__("2", "optima") => '2',
                    esc_html__("3", "optima") => '3',
                    esc_html__("4", "optima") => '4',
                ),
                'dependency' => array(
                    'element' => 'view_type',
                    'value_not_equal_to' => array("type4"),
                ),
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", "optima"),
                "param_name" => "item_el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "optima")
            ),
            // Testimonials Text Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Testimonials Text Font Size', 'optima'),
                'param_name' => 'testimonilas_text_size',
                'value' => '24',
                'description' => esc_html__( 'Enter testimonials text font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Testimonials Text Fonts
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Text Color", "optima"),
                "param_name" => "text_color",
                "value" => "",
                "description" => esc_html__("Select text color for this item.", "optima"),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Testimonials Author Font Size', 'optima'),
                'param_name' => 'testimonilas_author_size',
                'value' => '16',
                'description' => esc_html__( 'Enter testimonials author font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_html__("Sign Color", "optima"),
                "param_name" => "sign_color",
                "value" => "",
                "description" => esc_html__("Select sign color for this item.", "optima"),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            // Image setting section
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Image Width', 'optima' ),
                'param_name' => 'img_width',
                'value' => '85',
                'description' => esc_html__( 'Enter image width in pixels.', 'optima' ),
                "group" => "Styling",
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Image Height', 'optima' ),
                'param_name' => 'img_height',
                'value' => '85',
                'description' => esc_html__( 'Enter image height in pixels.', 'optima' ),
                "group" => "Styling",
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Circular Images?', 'optima' ),
                'param_name' => 'round_imgs',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'std' => 'yes',
                "group" => "Styling",
            ),
        )
    ));
    
    // Testimonial item options
    vc_map(array(
        "name" => esc_html__("Testimonial item", "optima"),
        "base" => "gt3_testimonial_item",
        "class" => "gt3_info_list",
        "category" => esc_html__('GT3 Modules', 'optima'),
        "icon" => site_url(str_replace(ABSPATH, '', __DIR__ . '/')) . 'icon.png',
        "content_element" => true,
        "as_child" => array('only' => 'gt3_testimonials'),
        "params" => array(
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Author name", "optima"),
                "param_name" => "tstm_author",
                "value" => "",
                "description" => esc_html__("Provide a title for this list item.", "optima"),
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Author status", "optima"),
                "param_name" => "author_status",
                "value" => "",
                'admin_label' => true,
            ),
            // Image Section
            array(
                'type' => 'attach_image',
                'heading' => esc_html__( 'Image', 'optima' ),
                'param_name' => 'image',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'optima' ),
                'admin_label' => true,
            ),
            array(
                "type" => "textarea_html",
                "class" => "",
                "heading" => esc_html__("Description", "optima"),
                "param_name" => "content",
                "value" => "",
                "description" => esc_html__("Description about this list item", "optima")
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Select Rate', 'optima'),
                'param_name' => 'select_rate',
                'value' => array(
                    esc_html__("none", "optima") => 'none',
                    esc_html__("1", "optima") => '1',
                    esc_html__("2", "optima") => '2',
                    esc_html__("3", "optima") => '3',
                    esc_html__("4", "optima") => '4',
                    esc_html__("5", "optima") => '5',
                ),
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Extra Class", "optima"),
                "param_name" => "item_el_class",
                "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "optima")
            )
        )
    ));

    /*class WPBakeryShortCode_Gt3_Testimonials extends WPBakeryShortCode
    {
    }*/
    if (class_exists('WPBakeryShortCodesContainer')) {
        class WPBakeryShortCode_Gt3_Testimonials extends WPBakeryShortCodesContainer
        {
        }
    }
    if (class_exists('WPBakeryShortCode')) {
        class WPBakeryShortCode_Gt3_Testimonial_Item extends WPBakeryShortCode
        {
        }
    }
}