<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

if (function_exists('vc_map')) {
    vc_map(array(
        'base' => 'gt3_video_popup',
        'name' => esc_html__('Video Popup', 'optima'),
        "description" => esc_html__("Video Popup Widget", "optima"),
        'category' => esc_html__('GT3 Modules', 'optima'),
        'icon' => 'gt3_icon',
        'params' => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__("Title", "optima"),
                "param_name" => "video_title",
                "description" => esc_html__("Enter title.", "optima")
            ),
            array(
                "type" => "attach_image",
                "heading" => esc_html__("Background Image Video", "optima"),
                "param_name" => "bg_image",
                "description" => esc_html__("Select video background image.", "optima")
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Video Link", "optima"),
                "param_name" => "video_link",
                "description" => esc_html__("Enter video link from youtube or vimeo.", "optima")
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Button Prefix", "optima"),
                "param_name" => "button_prefix",
                "description" => esc_html__("Enter Button Prefix.", "optima")
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Button Suffix", "optima"),
                "param_name" => "button_suffix",
                "description" => esc_html__("Enter Button Suffix.", "optima")
            ),

            /* styling video popup */
            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Title color", "optima"),
                "param_name" => "title_color",
                "value" => esc_attr(gt3_option("theme-custom-color")),
                "description" => esc_html__("Select custom color for title.", "optima"),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Button color", "optima"),
                "param_name" => "btn_color",
                "value" => esc_attr(gt3_option("theme-custom-color")),
                "description" => esc_html__("Select custom color for button.", "optima"),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            array(
                "type" => "colorpicker",
                "heading" => esc_html__("Button Background color", "optima"),
                "param_name" => "btn_bg_color",
                "value" => '#ffffff',
                "description" => esc_html__("Select custom background color for button.", "optima"),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            // Video Popup Title Fonts
            array(
                'type' => 'checkbox',
                'heading' => esc_html__( 'Use theme default font family for Video Popup title?', 'optima' ),
                'param_name' => 'use_theme_fonts_vpopup_title',
                'value' => array( esc_html__( 'Yes', 'optima' ) => 'yes' ),
                'description' => esc_html__( 'Use font family from the theme.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'std' => 'yes',
            ),
            array(
                'type' => 'google_fonts',
                'param_name' => 'google_fonts_vpopup_title',
                'value' => '',
                'settings' => array(
                    'fields' => array(
                        'font_family_description' => esc_html__( 'Select font family.', 'optima' ),
                        'font_style_description' => esc_html__( 'Select font styling.', 'optima' ),
                    ),
                ),
                'dependency' => array(
                    'element' => 'use_theme_fonts_vpopup_title',
                    'value_not_equal_to' => 'yes',
                ),
                "group" => esc_html__( "Styling", 'optima' ),
            ),
            // Icon Box content Font Size
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Video Popup Content Font Size', 'optima'),
                'param_name' => 'title_size',
                'value' => '24',
                'description' => esc_html__( 'Enter Video Popup Title font-size in pixels.', 'optima' ),
                "group" => esc_html__( "Styling", 'optima' ),
                'edit_field_class' => 'vc_col-sm-6',
            ),

            
        ),


    ));

    class WPBakeryShortCode_Gt3_Video_Popup extends WPBakeryShortCode { }

}