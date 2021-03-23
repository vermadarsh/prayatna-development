<?php
 
    if ( !class_exists( 'Gt3_wize_core' ) ) {
        return;
    }

    $theme = wp_get_theme(); 
    $opt_name = 'optima';

    $args = array(
        'opt_name'             => $opt_name,
        'display_name'         => $theme->get( 'Name' ),
        'display_version'      => $theme->get( 'Version' ),
        'menu_type'            => 'menu',
        'allow_sub_menu'       => true,
        'menu_title'           => esc_html__('Theme Options', 'optima' ),
        'page_title'           => esc_html__('Theme Options', 'optima' ),
        'google_api_key'       => '',
        'google_update_weekly' => false,
        'async_typography'     => true,
        'admin_bar'            => true,
        'admin_bar_icon'       => 'dashicons-admin-generic',
        'admin_bar_priority'   => 50,
        'global_variable'      => '',
        'dev_mode'             => false,
        'update_notice'        => true,
        'customizer'           => false,
        'page_priority'        => null,
        'page_parent'          => 'themes.php',
        'page_permissions'     => 'manage_options',
        'menu_icon'            => 'dashicons-admin-generic',
        'last_tab'             => '',
        'page_icon'            => 'icon-themes',
        'page_slug'            => '',
        'save_defaults'        => true,
        'default_show'         => false,
        'default_mark'         => '',
        'show_import_export'   => true,
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        'output_tag'           => true,
        'database'             => '',
        'use_cdn'              => true,
    );


    Redux::setArgs( $opt_name, $args );

    // -> START Basic Fields
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'General', 'optima' ),
        'id'               => 'general',
        'customizer_width' => '400px',
        'icon'             => 'el el-home',
        'fields'           => array(
            array(
                'id'       => 'responsive',
                'type'     => 'switch',
                'title'    => esc_html__( 'Responsive', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'page_comments',
                'type'     => 'switch',
                'title'    => esc_html__( 'Page Comments', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'preloader',
                'type'     => 'switch',
                'title'    => esc_html__( 'Preloader', 'optima' ),
                'default'  => false,
            ),
            array(
                'id'       => 'preloader_background',
                'type'     => 'color_gradient',
                'title'    => esc_html__('Preloader Background', 'optima'),
                'subtitle' => esc_html__( 'Set Preloader Background', 'optima' ),
                'validate' => 'color',
                'default'  => array(
                    'from' => '#57d9d7',
                    'to'   => '#1766b0', 
                ),
                'required' => array( 'preloader', '=', '1' ),
            ),
            array(
                'id'       => 'preloader_item_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Preloader Item Color', 'optima' ),
                'subtitle' => esc_html__( 'Set Plreloader Item Color', 'optima' ),
                'default'  => '#ffffff',
                'transparent' => false,
                'required' => array( 'preloader', '=', '1' ),
            ),
            array(
                'id'       => 'back_to_top',
                'type'     => 'switch',
                'title'    => esc_html__( 'Back to Top', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'custom_js',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom JS', 'optima' ),
                'subtitle' => esc_html__( 'Paste your JS code here.', 'optima' ),
                'mode'     => 'javascript',
                'theme'    => 'chrome',
                'default'  => "jQuery(document).ready(function(){\n\n});"
            ),
            array(
                'id'       => 'header_custom_js',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom JS', 'optima' ),
                'subtitle' => esc_html__( 'Code to be added inside HEAD tag', 'optima' ),
                'mode'     => 'html',
                'theme'    => 'chrome',
                'default'  => "<script type='text/javascript'>\njQuery(document).ready(function(){\n\n});\n</script>"
            ),
        ),
    ) );

    // HEADER
            function gt3_getMenuList(){
                $menus = wp_get_nav_menus();
                $menu_list = array();
                
                foreach ($menus as $menu => $menu_obj) {
                    $menu_list[$menu_obj->slug] = $menu_obj->name;
                }
                return $menu_list;
            }      

            $options = array(
                array(
                    'id'   => 'gt3_header_builder_id',
                    'type' => 'gt3_header_builder',
                    'full_width' => true,
                    'options' => array(
                        'all_item' => array(
                            'title' => 'All Item', 
                            'layout' => 'all',
                            'content' => array(
                                'search' => array(
                                    'title' => 'Search', 
                                    'has_settings' => false,
                                ),
                                'login' => array(
                                    'title' => 'Login', 
                                    'has_settings' => false,
                                ),
                                'wpml' => array(
                                    'title' => 'WPML', 
                                    'has_settings' => false,
                                ),
                                'cart' => array(
                                    'title' => 'Cart', 
                                    'has_settings' => false,
                                ),
                                'text1' => array(
                                    'title' => 'Text/HTML 1', 
                                    'has_settings' => true,
                                ),
                                'text2' => array(
                                    'title' => 'Text/HTML 2', 
                                    'has_settings' => true,
                                ),
                                
                                'text3' => array(
                                    'title' => 'Text/HTML 3', 
                                    'has_settings' => true,
                                ),
                                'text4' => array(
                                    'title' => 'Text/HTML 4', 
                                    'has_settings' => true,
                                ),
                                
                                'text5' => array(
                                    'title' => 'Text/HTML 5', 
                                    'has_settings' => true,
                                ),
                                'text6' => array(
                                    'title' => 'Text/HTML 6', 
                                    'has_settings' => true,
                                ),
                                'delimiter1' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter2' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter3' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter4' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter5' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter6' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                            ),
                        ),
                        'top_left' => array(
                            'title' => 'Top Left', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(
                            ),
                        ),
                        'top_center' => array(
                            'title' => 'Top Center', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(                                    
                            ),
                        ),
                        'top_right' => array(
                            'title' => 'Top Right', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(
                            ),
                        ),
                        'middle_left' => array(
                            'title' => 'Middle Left', 
                            'has_settings' => true,
                            'layout' => 'one-thirds clear-item',
                            'content' => array(
                                'logo' => array(
                                    'title' => 'Logo', 
                                    'has_settings' => true,
                                ),
                            ),
                        ),
                        'middle_center' => array(
                            'title' => 'Middle Center', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(

                            ),
                        ),
                        'middle_right' => array(
                            'title' => 'Middle Right', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(
                                'menu' => array(
                                    'title' => 'Menu', 
                                    'has_settings' => true,
                                ),
                            ),
                        ),
                        'bottom_left' => array(
                            'title' => 'Bottom Left', 
                            'has_settings' => true,
                            'layout' => 'one-thirds clear-item',
                            'content' => array(

                            ),
                        ),
                        'bottom_center' => array(
                            'title' => 'Bottom Center', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(

                            ),
                        ),
                        'bottom_right' => array(
                            'title' => 'Bottom Right', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(

                            ),
                        ),
                    ),
                    'default' => array(
                        'all_item' => array(
                            'title' => 'All Item', 
                            'layout' => 'all',
                            'content' => array(
                                'search' => array(
                                    'title' => 'Search', 
                                    'has_settings' => false,
                                ),
                                'login' => array(
                                    'title' => 'Login', 
                                    'has_settings' => false,
                                ),
                                'wpml' => array(
                                    'title' => 'WPML', 
                                    'has_settings' => false,
                                ),
                                'cart' => array(
                                    'title' => 'Cart', 
                                    'has_settings' => false,
                                ),
                                'text1' => array(
                                    'title' => 'Text/HTML 1', 
                                    'has_settings' => true,
                                ),
                                'text2' => array(
                                    'title' => 'Text/HTML 2', 
                                    'has_settings' => true,
                                ),
                                
                                'text3' => array(
                                    'title' => 'Text/HTML 3', 
                                    'has_settings' => true,
                                ),
                                'text4' => array(
                                    'title' => 'Text/HTML 4', 
                                    'has_settings' => true,
                                ),
                                
                                'text5' => array(
                                    'title' => 'Text/HTML 5', 
                                    'has_settings' => true,
                                ),
                                'text6' => array(
                                    'title' => 'Text/HTML 6', 
                                    'has_settings' => true,
                                ),
                                'delimiter1' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter2' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter3' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter4' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter5' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                                'delimiter6' => array(
                                    'title' => '|', 
                                    'has_settings' => false,
                                ),
                            ),
                        ),
                        'top_left' => array(
                            'title' => 'Top Left', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(
                            ),
                        ),
                        'top_center' => array(
                            'title' => 'Top Center', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(                                    
                            ),
                        ),
                        'top_right' => array(
                            'title' => 'Top Right', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(
                            ),
                        ),
                        'middle_left' => array(
                            'title' => 'Middle Left', 
                            'has_settings' => true,
                            'layout' => 'one-thirds clear-item',
                            'content' => array(
                                'logo' => array(
                                    'title' => 'Logo', 
                                    'has_settings' => true,
                                ),
                            ),
                        ),
                        'middle_center' => array(
                            'title' => 'Middle Center', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(

                            ),
                        ),
                        'middle_right' => array(
                            'title' => 'Middle Right', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(
                                'menu' => array(
                                    'title' => 'Menu', 
                                    'has_settings' => true,
                                ),
                            ),
                        ),
                        'bottom_left' => array(
                            'title' => 'Bottom Left', 
                            'has_settings' => true,
                            'layout' => 'one-thirds clear-item',
                            'content' => array(

                            ),
                        ),
                        'bottom_center' => array(
                            'title' => 'Bottom Center', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(

                            ),
                        ),
                        'bottom_right' => array(
                            'title' => 'Bottom Right', 
                            'has_settings' => true,
                            'layout' => 'one-thirds',
                            'content' => array(
                            ),
                        ),
                    ),
                ),

                // MAIN HEADER SETTINGS
                array(
                    'id'       => 'main_header_settings-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Header Main Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'header_full_width',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Full Width Header', 'optima' ),
                    'subtitle' => esc_html__( 'Set header content in full width layout', 'optima' ),
                    'default'  => false,
                ),
                array(
                    'id'       => 'header_shadow',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Header Bottom Shadow', 'optima' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'header_sticky',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Sticky Header', 'optima' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'header_sticky_appearance_style',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Sticky Appearance Style', 'optima' ),
                    'options'  => array(
                        'classic' => esc_html__( 'Classic', 'optima' ),
                        'scroll_top' => esc_html__( 'Appearance only on scroll top', 'optima' ),
                    ),
                    'required' => array( 'header_sticky', '=', '1' ),
                    'default'  => 'classic'
                ),
                array(
                    'id'       => 'header_sticky_appearance_from_top',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Sticky Header Appearance From Top of Page', 'optima' ),
                    'options'  => array(
                        'auto' => esc_html__( 'Auto', 'optima' ),
                        'custom' => esc_html__( 'Custom', 'optima' ),
                    ),
                    'required' => array( 'header_sticky', '=', '1' ),
                    'default'  => 'auto'
                ),
                array(
                    'id'             => 'header_sticky_appearance_number',
                    'type'           => 'dimensions',
                    'units'          => false, 
                    'units_extended' => false,
                    'title'          => esc_html__( 'Set the distance from the top of the page', 'optima' ),
                    'height'         => true,
                    'width'          => false,
                    'default'        => array(
                        'height' => 300,
                    ),
                    'required' => array( 'header_sticky_appearance_from_top', '=', 'custom' ),
                ),
                array(
                    'id'       => 'header_sticky_shadow',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Sticky Header Bottom Shadow', 'optima' ),
                    'default'  => true,
                    'required' => array( 'header_sticky', '=', '1' ),
                ),
                array(
                    'id'     => 'main_header_settings-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),



                // TOP LEFT SIDE SETTINGS
                array(
                    'id'       => 'top_left-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Top Left Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'top_left-align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Item Align', 'optima' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'optima' ),
                        'center' => esc_html__( 'Center', 'optima' ),
                        'right' => esc_html__( 'Right', 'optima' ),
                    ),
                    'default'  => 'left',
                ),
                array(
                    'id'     => 'top_left-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                // TOP CENTER SIDE SETTINGS
                array(
                    'id'       => 'top_center-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Top Center Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'top_center-align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Item Align', 'optima' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'optima' ),
                        'center' => esc_html__( 'Center', 'optima' ),
                        'right' => esc_html__( 'Right', 'optima' ),
                    ),
                    'default'  => 'center',
                ),
                array(
                    'id'     => 'top_center-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                // TOP RIGHT SIDE SETTINGS
                array(
                    'id'       => 'top_right-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Top Right Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'top_right-align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Item Align', 'optima' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'optima' ),
                        'center' => esc_html__( 'Center', 'optima' ),
                        'right' => esc_html__( 'Right', 'optima' ),
                    ),
                    'default'  => 'right',
                ),
                array(
                    'id'     => 'top_right-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                // MIDDLE LEFT SIDE SETTINGS
                array(
                    'id'       => 'middle_left-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Middle Left Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'middle_left-align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Item Align', 'optima' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'optima' ),
                        'center' => esc_html__( 'Center', 'optima' ),
                        'right' => esc_html__( 'Right', 'optima' ),
                    ),
                    'default'  => 'left',
                ),
                array(
                    'id'     => 'middle_left-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                // MIDDLE CENTER SIDE SETTINGS
                array(
                    'id'       => 'middle_center-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Middle Center Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'middle_center-align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Item Align', 'optima' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'optima' ),
                        'center' => esc_html__( 'Center', 'optima' ),
                        'right' => esc_html__( 'Right', 'optima' ),
                    ),
                    'default'  => 'center',
                ),
                array(
                    'id'     => 'middle_center-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                // MIDDLE RIGHT SIDE SETTINGS
                array(
                    'id'       => 'middle_right-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Top Middle Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'middle_right-align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Item Align', 'optima' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'optima' ),
                        'center' => esc_html__( 'Center', 'optima' ),
                        'right' => esc_html__( 'Right', 'optima' ),
                    ),
                    'default'  => 'right',
                ),
                array(
                    'id'     => 'middle_right-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),


                // BOTTOM LEFT SIDE SETTINGS
                array(
                    'id'       => 'bottom_left-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Bottom Left Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'bottom_left-align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Item Align', 'optima' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'optima' ),
                        'center' => esc_html__( 'Center', 'optima' ),
                        'right' => esc_html__( 'Right', 'optima' ),
                    ),
                    'default'  => 'left',
                ),
                array(
                    'id'     => 'bottom_left-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                // BOTTOM CENTER SIDE SETTINGS
                array(
                    'id'       => 'bottom_center-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Bottom Center Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'bottom_center-align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Item Align', 'optima' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'optima' ),
                        'center' => esc_html__( 'Center', 'optima' ),
                        'right' => esc_html__( 'Right', 'optima' ),
                    ),
                    'default'  => 'center',
                ),
                array(
                    'id'     => 'bottom_center-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                // BOTTOM RIGHT SIDE SETTINGS
                array(
                    'id'       => 'bottom_right-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Bottom Right Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'bottom_right-align',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Item Align', 'optima' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'optima' ),
                        'center' => esc_html__( 'Center', 'optima' ),
                        'right' => esc_html__( 'Right', 'optima' ),
                    ),
                    'default'  => 'right',
                ),
                array(
                    'id'     => 'bottom_right-end',
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),





                //LOGO SETTINGS
                array(
                    'id'       => 'logo-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Logo Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'header_logo',
                    'type'     => 'media',
                    'title'    => esc_html__( 'Header Logo', 'optima' ),
                ),
                array(
                    'id'       => 'logo_height_custom',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Logo Height', 'optima' ),
                    'default'  => false,
                ),
                array(
                    'id'             => 'logo_height',
                    'type'           => 'dimensions',
                    'units'          => false,    
                    'units_extended' => false,
                    'title'          => esc_html__( 'Set Logo Height' , 'optima' ),
                    'height'         => true,
                    'width'          => false,
                    'default'        => array(
                        'height' => 100,
                    ),
                    'required' => array( 'logo_height_custom', '=', '1' ),
                ),
                array(
                    'id'       => 'logo_max_height',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Don\'t limit maximum height', 'optima' ),
                    'default'  => false,
                    'required' => array( 'logo_height_custom', '=', '1' ),
                ),
                array(
                    'id'             => 'sticky_logo_height',
                    'type'           => 'dimensions',
                    'units'          => false,    
                    'units_extended' => false,
                    'title'          => esc_html__( 'Set Sticky Logo Height' , 'optima' ),
                    'height'         => true,
                    'width'          => false,
                    'default'        => array(
                        'height' => '',
                    ),
                    'required' => array(
                        array( 'logo_height_custom', '=', '1' ),
                        array( 'logo_max_height', '=', '1' ),
                    ),
                ),
                array(
                    'id'       => 'logo_sticky',
                    'type'     => 'media',
                    'title'    => esc_html__( 'Sticky Logo', 'optima' ),
                ),
                array(
                    'id'       => 'logo_mobile',
                    'type'     => 'media',
                    'title'    => esc_html__( 'Mobile Logo', 'optima' ),
                ),
                array(
                    'id'       => 'logo_limit_on_mobile',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Limit Logo on Mobile', 'optima' ),
                    'default'  => true,
                ),
                array(
                    'id'     => 'logo-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                // MENU
                array(
                    'id'       => 'menu-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Menu Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'menu_select',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Select Menu', 'optima' ),
                    'options'  => gt3_getMenuList(),
                    'default'  => 'left',
                ),
                array(
                    'id'       => 'menu_ative_top_line',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Active Menu Item Marker', 'optima' ),
                    'default'  => false,
                ),
                array(
                    'id'       => 'sub_menu_background',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Sub Menu Background', 'optima' ),
                    'subtitle' => esc_html__( 'Set sub menu background color', 'optima' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba'  => 'rgba(255,255,255,1)'
                    ),
                    'mode'     => 'background',
                ),
                array(
                    'id'       => 'sub_menu_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Sub Menu Text Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set sub menu header text color', 'optima' ),
                    'default'  => '#303638',
                    'transparent' => false,
                ),
                array(
                    'id'     => 'menu-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),


                //TOP SIDE
                array(
                    'id'       => 'side_top-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Top Header Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'side_top_background',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Background', 'optima' ),
                    'subtitle' => esc_html__( 'Set background color', 'optima' ),
                    'default'  => array(
                        'color' => '#f5f5f5',
                        'alpha' => '1',
                        'rgba'  => 'rgba(245,245,245,1)'
                    ),
                    'mode'     => 'background',
                ),
                array(
                    'id'       => 'side_top_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set text color', 'optima' ),
                    'default'  => '#727e85',
                    'transparent' => false,
                ),
                array(
                    'id'             => 'side_top_height',
                    'type'           => 'dimensions',
                    'units'          => false, 
                    'units_extended' => false,
                    'title'          => esc_html__( 'Height', 'optima' ),
                    'height'         => true,
                    'width'          => false,
                    'default'        => array(
                        'height' => 40,
                    )
                ),
                array(
                    'id'       => 'side_top_border',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Set Bottom Border', 'optima' ),
                    'default'  => false,
                ),
                array(
                    'id'       => 'side_top_border_color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Border Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set border color', 'optima' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '.15',
                        'rgba'  => 'rgba(255,255,255,0.15)'
                    ),
                    'mode'     => 'background',
                    'required' => array( 'side_top_border', '=', '1' ),
                ),
                array(
                    'id'       => 'side_top_sticky',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Section in Sticky Header?', 'optima' ),
                    'default'  => false,
                    'required' => array( 'header_sticky', '=', '1' ),
                ),
                array(
                    'id'       => 'side_top_background_sticky',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Sticky Header Background', 'optima' ),
                    'subtitle' => esc_html__( 'Set background color', 'optima' ),
                    'default'  => array(
                        'color' => '#f5f5f5',
                        'alpha' => '1',
                        'rgba'  => 'rgba(245,245,245,1)'
                    ),
                    'mode'     => 'background',
                    'required' => array( 'side_top_sticky', '=', '1' ),
                ),
                array(
                    'id'       => 'side_top_color_sticky',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Sticky Header Text Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set text color', 'optima' ),
                    'default'  => '#727e85',
                    'transparent' => false,
                    'required' => array( 'side_top_sticky', '=', '1' ),
                ),
                array(
                    'id'             => 'side_top_height_sticky',
                    'type'           => 'dimensions',
                    'units'          => false, 
                    'units_extended' => false,
                    'title'          => esc_html__( 'Sticky Header Height', 'optima' ),
                    'height'         => true,
                    'width'          => false,
                    'default'        => array(
                        'height' => 38,
                    ),
                    'required' => array( 'side_top_sticky', '=', '1' ),
                ),
                array(
                    'id'       => 'side_top_mobile',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Section in Mobile Header?', 'optima' ),
                    'default'  => false,
                ),
                array(
                    'id'     => 'side_top-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),


                // Middle SIDE
                array(
                    'id'       => 'side_middle-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Middle Header Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'side_middle_background',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Background', 'optima' ),
                    'subtitle' => esc_html__( 'Set background color', 'optima' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba'  => 'rgba(255,255,255,1)'
                    ),
                    'mode'     => 'background',
                ),
                array(
                    'id'       => 'side_middle_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set text color', 'optima' ),
                    'default'  => '#000000',
                    'transparent' => false,
                ),
                array(
                    'id'             => 'side_middle_height',
                    'type'           => 'dimensions',
                    'units'          => false, 
                    'units_extended' => false,
                    'title'          => esc_html__( 'Height', 'optima' ),
                    'height'         => true,
                    'width'          => false,
                    'default'        => array(
                        'height' => 100,
                    )
                ),
                array(
                    'id'       => 'side_middle_border',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Set Bottom Border', 'optima' ),
                    'default'  => false,
                ),
                array(
                    'id'       => 'side_middle_border_color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Border Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set border color', 'optima' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '.15',
                        'rgba'  => 'rgba(255,255,255,0.15)'
                    ),
                    'mode'     => 'background',
                    'required' => array( 'side_middle_border', '=', '1' ),
                ),
                array(
                    'id'       => 'side_middle_sticky',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Section in Sticky Header?', 'optima' ),
                    'default'  => true,
                    'required' => array( 'header_sticky', '=', '1' ),
                ),
                array(
                    'id'       => 'side_middle_background_sticky',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Sticky Header Background', 'optima' ),
                    'subtitle' => esc_html__( 'Set background color', 'optima' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba'  => 'rgba(255,255,255,1)'
                    ),
                    'mode'     => 'background',
                    'required' => array( 'side_middle_sticky', '=', '1' ),
                ),
                array(
                    'id'       => 'side_middle_color_sticky',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Sticky Header Text Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set text color', 'optima' ),
                    'default'  => '#000000',
                    'transparent' => false,
                    'required' => array( 'side_middle_sticky', '=', '1' ),
                ),
                array(
                    'id'             => 'side_middle_height_sticky',
                    'type'           => 'dimensions',
                    'units'          => false, 
                    'units_extended' => false,
                    'title'          => esc_html__( 'Sticky Header Height', 'optima' ),
                    'height'         => true,
                    'width'          => false,
                    'default'        => array(
                        'height' => 90,
                    ),
                    'required' => array( 'side_middle_sticky', '=', '1' ),
                ),
                array(
                    'id'       => 'side_middle_mobile',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Section in Mobile Header?', 'optima' ),
                    'default'  => true,
                ),
                array(
                    'id'     => 'side_middle-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),


                // Bottom SIDE
                array(
                    'id'       => 'side_bottom-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Bottom Header Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'       => 'side_bottom_background',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Background', 'optima' ),
                    'subtitle' => esc_html__( 'Set background color', 'optima' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba'  => 'rgba(255,255,255,1)'
                    ),
                    'mode'     => 'background',
                ),
                array(
                    'id'       => 'side_bottom_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set text color', 'optima' ),
                    'default'  => '#000000',
                    'transparent' => false,
                ),
                array(
                    'id'             => 'side_bottom_height',
                    'type'           => 'dimensions',
                    'units'          => false, 
                    'units_extended' => false,
                    'title'          => esc_html__( 'Height', 'optima' ),
                    'height'         => true,
                    'width'          => false,
                    'default'        => array(
                        'height' => 38,
                    )
                ),
                array(
                    'id'       => 'side_bottom_border',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Set Bottom Border', 'optima' ),
                    'default'  => false,
                ),
                array(
                    'id'       => 'side_bottom_border_color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Border Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set border color', 'optima' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '.15',
                        'rgba'  => 'rgba(255,255,255,0.15)'
                    ),
                    'mode'     => 'background',
                    'required' => array( 'side_bottom_border', '=', '1' ),
                ),
                array(
                    'id'       => 'side_bottom_sticky',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Section in Sticky Header?', 'optima' ),
                    'default'  => false,
                    'required' => array( 'header_sticky', '=', '1' ),
                ),
                array(
                    'id'       => 'side_bottom_background_sticky',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Sticky Header Background', 'optima' ),
                    'subtitle' => esc_html__( 'Set background color', 'optima' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1',
                        'rgba'  => 'rgba(255,255,255,1)'
                    ),
                    'mode'     => 'background',
                    'required' => array( 'side_bottom_sticky', '=', '1' ),
                ),
                array(
                    'id'       => 'side_bottom_color_sticky',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Sticky Header Text Color', 'optima' ),
                    'subtitle' => esc_html__( 'Set text color', 'optima' ),
                    'default'  => '#000000',
                    'transparent' => false,
                    'required' => array( 'side_bottom_sticky', '=', '1' ),
                ),
                array(
                    'id'             => 'side_bottom_height_sticky',
                    'type'           => 'dimensions',
                    'units'          => false, 
                    'units_extended' => false,
                    'title'          => esc_html__( 'Sticky Header Height', 'optima' ),
                    'height'         => true,
                    'width'          => false,
                    'default'        => array(
                        'height' => 38,
                    ),
                    'required' => array( 'side_bottom_sticky', '=', '1' ),
                ),
                array(
                    'id'       => 'side_bottom_mobile',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Section in Mobile Header?', 'optima' ),
                    'default'  => false,
                ),
                array(
                    'id'     => 'side_bottom-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),


                //TEXT SETTINGS
                array(
                    'id'       => 'text1-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Text / HTML 1 Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'      => 'text1_editor',
                    'type'    => 'editor',
                    'title'   => esc_html__( 'Text Editor', 'optima' ),
                    'default' => '',
                    'args'    => array(
                        'wpautop'       => false,
                        'media_buttons' => false,
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'quicktags'     => true,
                    ),
                ),
                array(
                    'id'     => 'text1-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                //2
                array(
                    'id'       => 'text2-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Text / HTML 2 Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'      => 'text2_editor',
                    'type'    => 'editor',
                    'title'   => esc_html__( 'Text Editor', 'optima' ),
                    'default' => '',
                    'args'    => array(
                        'wpautop'       => false,
                        'media_buttons' => false,
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'quicktags'     => true,
                    ),
                ),
                array(
                    'id'     => 'text2-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                //3
                array(
                    'id'       => 'text3-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Text / HTML 3 Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'      => 'text3_editor',
                    'type'    => 'editor',
                    'title'   => esc_html__( 'Text Editor', 'optima' ),
                    'default' => '',
                    'args'    => array(
                        'wpautop'       => false,
                        'media_buttons' => false,
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'quicktags'     => true,
                    ),
                ),
                array(
                    'id'     => 'text3-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                //4
                array(
                    'id'       => 'text4-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Text / HTML 4 Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'      => 'text4_editor',
                    'type'    => 'editor',
                    'title'   => esc_html__( 'Text Editor', 'optima' ),
                    'default' => '',
                    'args'    => array(
                        'wpautop'       => false,
                        'media_buttons' => false,
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'quicktags'     => true,
                    ),
                ),
                array(
                    'id'     => 'text4-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                //5
                array(
                    'id'       => 'text5-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Text / HTML 5 Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'      => 'text5_editor',
                    'type'    => 'editor',
                    'title'   => esc_html__( 'Text Editor', 'optima' ),
                    'default' => '',
                    'args'    => array(
                        'wpautop'       => false,
                        'media_buttons' => false,
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'quicktags'     => true,
                    ),
                ),
                array(
                    'id'     => 'text5-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),

                //6
                array(
                    'id'       => 'text6-start',
                    'type'     => 'gt3_section',
                    'title'    => esc_html__( 'Text / HTML 6 Settings', 'optima' ),
                    'indent'   => false,
                    'section_role' => 'start'
                ),
                array(
                    'id'      => 'text6_editor',
                    'type'    => 'editor',
                    'title'   => esc_html__( 'Text Editor', 'optima' ),
                    'default' => '',
                    'args'    => array(
                        'wpautop'       => false,
                        'media_buttons' => false,
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'quicktags'     => true,
                    ),
                ),
                array(
                    'id'     => 'text6-end', 
                    'type'   => 'gt3_section',
                    'indent' => false, 
                    'section_role' => 'end'
                ),
            );

    Redux::setSection( $opt_name, array(
        'id'     => 'gt3_header_builder_section',
        'title'  =>  esc_html__( 'GT3 Header Builder', 'optima' ),
        'desc'   => esc_html__( 'This is GT3 Header Builder', 'optima' ),
        'icon'   => 'el el-screen',
        'fields' => $options
    ) );
    // END HEADER

    // -> START Page Title Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Page Title', 'optima' ),
        'id'               => 'page_title',
        'customizer_width' => '450px',
        'icon'             => 'el-icon-screen',
        'fields'           => array(
            array(
                'id'       => 'page_title_conditional',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Page Title', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'blog_title_conditional',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Blog Post Title', 'optima' ),
                'default'  => false,
                'required' => array( 'page_title_conditional', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_title_conditional',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Portfolio Post Title', 'optima' ),
                'default'  => false,
                'required' => array( 'page_title_conditional', '=', '1' ),
            ),
            array(
                'id'       => 'team_title_conditional',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Team Post Title', 'optima' ),
                'default'  => false,
                'required' => array( 'page_title_conditional', '=', '1' ),
            ),
            array(
                'id'       => 'team_title_conditional',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Team Single Title', 'optima' ),
                'default'  => true,
                'required' => array( 'page_title_conditional', '=', '1' ),
            ),
            array(
                'id'       => 'page_title-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Page Title Settings', 'optima' ),
                'indent'   => true,
                'required' => array( 'page_title_conditional', '=', '1' ),
            ),
            array(
                'id'       => 'page_title_breadcrumbs_conditional',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Breadcrumbs', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'page_title_vert_align',
                'type'     => 'select',
                'title'    => esc_html__( 'Vertical Align', 'optima' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'optima' ),
                    'middle' => esc_html__( 'Middle', 'optima' ),
                    'bottom' => esc_html__( 'Bottom', 'optima' )
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'page_title_horiz_align',
                'type'     => 'select',
                'title'    => esc_html__( 'Page Title Text Align?', 'optima' ),
                'options'  => array(
                    'left' =>  esc_html__( 'Left', 'optima' ),
                    'center' => esc_html__( 'Center', 'optima' ),
                    'right' => esc_html__( 'Right', 'optima' )
                ),
                'default'  => 'center'
            ),
            array(
                'id'       => 'page_title_font_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Page Title Font Color', 'optima' ),
                'default'  => '#42474c',
                'transparent' => false
            ),
            array(
                'id'       => 'page_title_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Page Title Background Color', 'optima' ),
                'default'  => '#ffffff',
                'transparent' => false
            ),
            array(
                'id'       => 'page_title_bg_image',
                'type'     => 'media',
                'title'    => esc_html__( 'Page Title Background Image', 'optima' ),
            ),
            array(
                'id'       => 'page_title_bg_image',
                'type'     => 'background',
                'background-color' => false,
                'preview_media' => true,
                'preview' => false,
                'title'    => esc_html__( 'Page Title Background Image', 'optima' ),
                'default'  => array(
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '#1e73be',
                )
            ),
            array(
                'id'             => 'page_title_height',
                'type'           => 'dimensions',
                'units'          => false, 
                'units_extended' => false,
                'title'          => esc_html__( 'Page Title Height', 'optima' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => 250,
                )
            ),
            array(
                'id'       => 'page_title_bottom_margin',
                'type'     => 'spacing',
                // An array of CSS selectors to apply this font style to
                'mode'     => 'margin',
                'all'      => false,
                'bottom'   => true,
                'top'   => false,
                'left'   => false,
                'right'   => false,
                'title'    => esc_html__( 'Page Title Bottom Margin', 'optima' ),
                'default'  => array(
                    'margin-bottom' => '0px',                
                    )
            ),
            array(
                'id'     => 'page_title-end',
                'type'   => 'section',
                'indent' => false, 
                'required' => array( 'page_title_conditional', '=', '1' ),
            ),
            
        )
    ) );

    // -> START Footer Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Footer', 'optima' ),
        'id'               => 'footer-option',
        'customizer_width' => '400px',
        'icon' => 'el-icon-screen',
        'fields'           => array(
            array(
                'id'       => 'footer_full_width',
                'type'     => 'switch',
                'title'    => esc_html__( 'Full Width Footer', 'optima' ),
                'default'  => false,
            ),
            array(
                'id'       => 'footer_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Footer Background Color', 'optima' ),
                'default'  => '#f6f8f9',
                'transparent' => false
            ),
            array(
                'id'       => 'footer_text_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Footer Text color', 'optima' ),
                'default'  => '#5c656d',
                'transparent' => false
            ),
            array(
                'id'       => 'footer_heading_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Footer Heading color', 'optima' ),
                'default'  => '#42474c',
                'transparent' => false
            ),
            array(
                'id'       => 'footer_bg_image',
                'type'     => 'background',
                'background-color' => false,
                'preview_media' => true,
                'preview' => false,
                'title'    => esc_html__( 'Footer Background Image', 'optima' ),
                'default'  => array(
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '#1e73be',
                )
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer Content', 'optima' ),
        'id'               => 'footer_content',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'footer_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Footer', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'footer-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Footer Settings', 'optima' ),
                'indent'   => true,
                'required' => array( 'footer_switch', '=', '1' ),
            ),
            array(
                'id'       => 'footer_column',
                'type'     => 'select',
                'title'    => esc_html__( 'Footer Column', 'optima' ),
                'options'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                ),
                'default'  => '4'
            ),
            array(
                'id'       => 'footer_column2',
                'type'     => 'select',
                'title'    => esc_html__( 'Footer Column Layout', 'optima' ),
                'options'  => array(
                    '6-6' => '50% / 50%',
                    '3-9' => '25% / 75%',
                    '9-3' => '25% / 75%',
                    '4-8' => '33% / 66%',
                    '8-3' => '66% / 33%',
                ),
                'default'  => '6-6',
                'required' => array( 'footer_column', '=', '2' ),
            ),
            array(
                'id'       => 'footer_column3',
                'type'     => 'select',
                'title'    => esc_html__( 'Footer Column Layout', 'optima' ),
                'options'  => array(
                    '4-4-4' => '33% / 33% / 33%',
                    '3-3-6' => '25% / 25% / 50%',
                    '3-6-3' => '25% / 50% / 25%',
                    '6-3-3' => '50% / 25% / 25%',
                ),
                'default'  => '4-4-4',
                'required' => array( 'footer_column', '=', '3' ),
            ),
            array(
                'id'       => 'footer_align',
                'type'     => 'select',
                'title'    => esc_html__( 'Footer Title Text Align', 'optima' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'optima' ),
                    'center' => esc_html__( 'Center', 'optima' ),
                    'right' => esc_html__( 'Right', 'optima' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'footer_spacing',
                'type'     => 'spacing',
                'output'   => array( '.gt3-footer' ),
                // An array of CSS selectors to apply this font style to
                'mode'     => 'padding',
                'all'      => false,
                'title'    => esc_html__( 'Footer Padding (px)', 'optima' ),
                'default'  => array(
                    'padding-top'    => '70px',
                    'padding-right'  => '0px',
                    'padding-bottom' => '70px',
                    'padding-left'   => '0px'
                )
            ),
            array(
                'id'     => 'footer-end',
                'type'   => 'section',
                'indent' => false, 
                'required' => array( 'footer_switch', '=', '1' ),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Copyright', 'optima' ),
        'id'               => 'copyright',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'copyright_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Copyright', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'      => 'copyright_editor',
                'type'    => 'editor',
                'title'   => esc_html__( 'Copyright Editor', 'optima' ),
                'default' => '',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => false,
                    'textarea_rows' => 2,
                    'teeny'         => false,
                    'quicktags'     => true,
                ),
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'       => 'copyright_align',
                'type'     => 'select',
                'title'    => esc_html__( 'Copyright Title Text Align', 'optima' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'optima' ),
                    'center' => esc_html__( 'Center', 'optima' ),
                    'right' => esc_html__( 'Right', 'optima' ),
                ),
                'default'  => 'left',
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'       => 'copyright_spacing',
                'type'     => 'spacing',
                'mode'     => 'padding',
                'all'      => false,
                'title'    => esc_html__( 'Copyright Padding (px)', 'optima' ),
                'default'  => array(
                    'padding-top'    => '14px',
                    'padding-right'  => '0px',
                    'padding-bottom' => '14px',
                    'padding-left'   => '0px'
                ),
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'       => 'copyright_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Copyright Background Color', 'optima' ),
                'default'  => '#f0f3f4',
                'transparent' => true,
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'       => 'copyright_text_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Copyright Text Color', 'optima' ),
                'default'  => '#42474c',
                'transparent' => false,
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'       => 'copyright_top_border',
                'type'     => 'switch',
                'title'    => esc_html__( 'Set Copyright Top Border', 'optima' ),
                'default'  => false,
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'       => 'copyright_top_border_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Copyright Border Color', 'optima' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '0.1',
                    'rgba'  => 'rgba(255,255,255,0.1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'copyright_top_border', '=', '1' ),
                    array( 'copyright_switch', '=', '1' )
                ), 
            ),
        )
    ));

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Pre footer area', 'optima' ),
        'id'               => 'pre_footer',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'pre_footer_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Pre Footer Area', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'      => 'pre_footer_editor',
                'type'    => 'editor',
                'title'   => esc_html__( 'Pre Footer Editor', 'optima' ),
                'default' => '',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => false,
                    'textarea_rows' => 2,
                    'teeny'         => false,
                    'quicktags'     => true,
                ),
                'required' => array( 'pre_footer_switch', '=', '1' ),
            ),
            array(
                'id'       => 'pre_footer_align',
                'type'     => 'select',
                'title'    => esc_html__( 'Pre Footer Title Text Align', 'optima' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'optima' ),
                    'center' => esc_html__( 'Center', 'optima' ),
                    'right' => esc_html__( 'Right', 'optima' ),
                ),
                'default'  => 'left',
                'required' => array( 'pre_footer_switch', '=', '1' ),
            ),
            array(
                'id'       => 'pre_footer_spacing',
                'type'     => 'spacing',
                'mode'     => 'padding',
                'all'      => false,
                'title'    => esc_html__( 'Pre Footer Area Padding (px)', 'optima' ),
                'default'  => array(
                    'padding-top'    => '20px',
                    'padding-right'  => '0px',
                    'padding-bottom' => '20px',
                    'padding-left'   => '0px'
                ),
                'required' => array( 'pre_footer_switch', '=', '1' ),
            ),
            array(
                'id'       => 'pre_footer_bottom_border',
                'type'     => 'switch',
                'title'    => esc_html__( 'Set Pre Footer Bottom Border', 'optima' ),
                'default'  => false,
                'required' => array( 'pre_footer_switch', '=', '1' ),
            ),
            array(
                'id'       => 'pre_footer_bottom_border_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Pre Footer Border Color', 'optima' ),
                'default'  => array(
                    'color' => '#f6f8f9',
                    'alpha' => '1',
                    'rgba'  => 'rgba(246,249,249,1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'pre_footer_bottom_border', '=', '1' ),
                    array( 'pre_footer_switch', '=', '1' )
                ), 
            ),
        )
    ));

    // -> START Blog Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Blog', 'optima' ),
        'id'               => 'blog-option',
        'customizer_width' => '400px',
        'icon' => 'el-icon-th-list',
        'fields'           => array(
            array(
                'id'       => 'related_posts',
                'type'     => 'switch',
                'title'    => esc_html__( 'Related Posts', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'author_box',
                'type'     => 'switch',
                'title'    => esc_html__( 'Author Box on Single Post', 'optima' ),
                'default'  => false,
            ),
            array(
                'id'       => 'post_comments',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post Comments', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'post_pingbacks',
                'type'     => 'switch',
                'title'    => esc_html__( 'Trackbacks and Pingbacks', 'optima' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_post_likes',
                'type'     => 'switch',
                'title'    => esc_html__( 'Likes on Posts', 'optima' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_post_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Share on Posts', 'optima' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_post_listing_content',
                'type'     => 'switch',
                'title'    => esc_html__( 'Cut Off Text in Blog Listing', 'optima' ),
                'default'  => false,
            ),
        )
    ) );

    // -> START Portfolio Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Portfolio', 'optima' ),
        'id'               => 'portfolio-option',
        'customizer_width' => '400px',
        'icon' => 'el el-picture',
        'fields'           => array(
            array(
                'id'       => 'portfolio_comments',
                'type'     => 'switch',
                'title'    => esc_html__( 'Portfolio Comments', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'portfolio_likes',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Likes on Portfolio', 'optima' ),
                'default'  => true,
            ),
            array(
                'id'       => 'portfolio_post_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Share on Portfolio', 'optima' ),
                'default'  => true,
            ),
            array(
                'id' => 'portfolio_slug',
                'type' => 'text',
                'title' => esc_html__('Portfolio Slug', 'optima' ),
                'default' => 'portfolio'
            ),
            
        )
    ) );

    // -> START Team Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Team', 'optima' ),
        'id'               => 'team-option',
        'customizer_width' => '400px',
        'icon' => 'el el-picture',
        'fields'           => array(
            array(
                'id' => 'team_slug',
                'type' => 'text',
                'title' => esc_html__('Team Slug', 'optima' ),
                'default' => 'team'
            ),
            
        )
    ) );

    // -> START Layout Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Sidebars', 'optima' ),
        'id'               => 'layout_options',
        'customizer_width' => '400px',
        'icon' => 'el el-website',
        'fields'           => array(
            array(
                'id'       => 'page_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Page Sidebar Layout', 'optima' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'page_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Page Sidebar', 'optima' ),
                'data'     => 'sidebars',
                'required' => array( 'page_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'blog_single_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Blog Single Sidebar Layout', 'optima' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'blog_single_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Blog Single Sidebar', 'optima' ),
                'data'     => 'sidebars',
                'required' => array( 'blog_single_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'portfolio_single_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Portfolio Single Sidebar Layout', 'optima' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'portfolio_single_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Portfolio Single Sidebar', 'optima' ),
                'data'     => 'sidebars',
                'required' => array( 'portfolio_single_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'team_single_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Team Single Sidebar Layout', 'optima' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'team_single_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Team Single Sidebar', 'optima' ),
                'data'     => 'sidebars',
                'required' => array( 'team_single_sidebar_layout', '!=', 'none' ),
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Sidebar Generator', 'optima' ),
        'id'               => 'sidebars_generator_section',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'=>'sidebars', 
                'type' => 'multi_text',
                'validate' => 'no_html',
                'add_text' => esc_html__('Add Sidebar', 'optima' ),
                'title' => esc_html__('Sidebar Generator', 'optima' ),
                'default' => array('Main Sidebar'),
            ),
        )
    ) );   


    // -> START Styling Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Color Options', 'optima' ),
        'id'               => 'color_options',
        'customizer_width' => '400px',
        'icon' => 'el-icon-brush'
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Colors', 'optima' ),
        'id'               => 'color_options_color',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'        => 'theme-custom-color',
                'type'      => 'color',
                'title'     => esc_html__('Theme Color 1', 'optima' ),
                'transparent' => false,
                'default'   => '#4eaac8',
                'validate'  => 'color',
            ),
            array(
                'id'        => 'theme-custom-color2',
                'type'      => 'color',
                'title'     => esc_html__('Theme Color 2', 'optima' ),
                'transparent' => false,
                'default'   => '#271d57',
                'validate'  => 'color',
            ),
            array(
                'id'        => 'theme-custom-color3',
                'type'      => 'color',
                'title'     => esc_html__('Theme Color 3', 'optima' ),
                'transparent' => false,
                'default'   => '#dd3333',
                'validate'  => 'color',
            ),
            array(
                'id'        => 'body-background-color',
                'type'      => 'color',
                'title'     => esc_html__('Body Background Color', 'optima' ),
                'transparent' => false,
                'default'   => '#ffffff',
                'validate'  => 'color',
                ),
        )
    ));

    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Colors Gradient', 'optima' ),
        'id'               => 'color_options_gradient',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'theme-color-gradient1',
                'type'     => 'color_gradient',
                'title'    => esc_html__('Gradient Color Option 1', 'optima'),
                'validate' => 'color',
                'default'  => array(
                    'from' => '#83c3d8',
                    'to'   => '#3d3272',
                ),
            ),
            array(
                'id'       => 'theme-color-gradient2',
                'type'     => 'color_gradient',
                'title'    => esc_html__('Gradient Color Option 2', 'optima'),
                'validate' => 'color',
                'default'  => array(
                    'from' => '#57d9d7',
                    'to'   => '#1766b0', 
                ),
            ),
        )
    ));



    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Typography', 'optima' ),
        'id'               => 'typography_options',
        'customizer_width' => '400px',
        'icon' => 'el-icon-font',
        'fields'           => array(
            array(
                'id'          => 'menu-font',
                'type'        => 'typography',
                'title'       => esc_html__( 'Menu Font', 'optima' ),
                'google' => true,
                'font-style'    => true,
                'color' => false,
                'line-height' => true,
                'font-size' => true,
                'font-backup' => false,
                'text-align' => false,
                'all_styles'  => true,
                'default'     => array(
                    'font-family' => 'Lato',
                    'google'      => true,
                    'font-size'   => '16px',
                    'font-weight' => '400',
                    'line-height' => '20px'
                ),
            ),

            array(
                'id' => 'main-font',
                'type' => 'typography',
                'title' => esc_html__('Main Font', 'optima' ),
                'google' => true,
                'font-backup' => false,
                'font-size' => true,
                'line-height' => true,
                'color' => true,
                'word-spacing' => false,
                'letter-spacing' => false,
                'text-align' => false,
                'all_styles'  => true,
                'default' => array(
                    'font-size' => '16px',
                    'line-height' => '24px',
                    'color' => '#5c656d',
                    'google' => true,
                    'font-family' => 'Lato',
                    'font-weight' => '400',
                ),
            ),
            array(
                'id' => 'header-font',
                'type' => 'typography',
                'title' => esc_html__('Headers Font', 'optima' ),
                'google' => true,
                'font-backup' => false,
                'font-size' => false,
                'line-height' => false,
                'color' => true,
                'word-spacing' => false,
                'letter-spacing' => false,
                'text-align' => false,
                'text-transform' => false,
                'default' => array(
                    'color' => '#42474c',
                    'google' => true,
                    'font-family' => 'Lato',
                    'font-weight' => '300',
                ),
            ),
            array(
                'id' => 'h1-font',
                'type' => 'typography',
                'title' => esc_html__('H1', 'optima' ),
                'google' => true,
                'font-backup' => false,
                'font-size' => true,
                'line-height' => true,
                'color' => false,
                'word-spacing' => false,
                'letter-spacing' => false,
                'text-align' => false,
                'text-transform' => false,
                'default' => array(
                    'font-size' => '42px',
                    'line-height' => '53px',
                    'google' => true,
                ),
            ),
            array(
                'id' => 'h2-font',
                'type' => 'typography',
                'title' => esc_html__('H2', 'optima' ),
                'google' => true,
                'font-backup' => false,
                'font-size' => true,
                'line-height' => true,
                'color' => false,
                'word-spacing' => false,
                'letter-spacing' => false,
                'text-align' => false,
                'text-transform' => false,
                'default' => array(
                    'font-size' => '34px',
                    'line-height' => '38px',
                    'google' => true,
                ),
            ),
            array(
                'id' => 'h3-font',
                'type' => 'typography',
                'title' => esc_html__('H3', 'optima' ),
                'google' => true,
                'font-backup' => false,
                'font-size' => true,
                'line-height' => true,
                'color' => false,
                'word-spacing' => false,
                'letter-spacing' => false,
                'text-align' => false,
                'text-transform' => false,
                'default' => array(
                    'font-size' => '30px',
                    'line-height' => '36px',
                    'google' => true,
                ),
            ),
            array(
                'id' => 'h4-font',
                'type' => 'typography',
                'title' => esc_html__('H4', 'optima' ),
                'google' => true,
                'font-backup' => false,
                'font-size' => true,
                'line-height' => true,
                'color' => false,
                'word-spacing' => false,
                'letter-spacing' => false,
                'text-align' => false,
                'text-transform' => false,
                'default' => array(
                    'font-size' => '24px',
                    'line-height' => '26px',
                    'google' => true,
                ),
            ),
            array(
                'id' => 'h5-font',
                'type' => 'typography',
                'title' => esc_html__('H5', 'optima' ),
                'google' => true,
                'font-backup' => false,
                'font-size' => true,
                'line-height' => true,
                'color' => false,
                'word-spacing' => false,
                'letter-spacing' => false,
                'text-align' => false,
                'text-transform' => false,
                'default' => array(
                    'font-size' => '18px',
                    'line-height' => '24px',
                    'google' => true,
                ),
            ),
            array(
                'id' => 'h6-font',
                'type' => 'typography',
                'title' => esc_html__('H6', 'optima' ),
                'google' => true,
                'font-backup' => false,
                'font-size' => true,
                'line-height' => true,
                'color' => false,
                'word-spacing' => false,
                'letter-spacing' => true,
                'text-align' => false,
                'text-transform' => false,
                'default' => array(
                    'font-size' => '16px',
                    'line-height' => '24px',
                    'google' => true,
                ),
            ),
        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Contact Widget', 'optima' ),
        'id'               => 'contact_widget_options',
        'customizer_width' => '400px',
        'icon' => 'el el-envelope',
        'fields'           => array(
            array(
                'title'    => esc_html__( 'Display on All Pages', 'optima' ),
                'id'       => 'show_contact_widget',
                'type'     => 'switch',
                'default'  => false,
            ),
            array(
                'id' => 'title_contact_widget',
                'type' => 'text',
                'title' => esc_html__('Label Text', 'optima' ),
            ),
            array(
                'id'       => 'label_contact_icon',
                'type'     => 'media',
                'title'    => esc_html__( 'Label\'s Image', 'optima' ),
            ),
            array(
                'id'       => 'label_contact_widget_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Label Color', 'optima' ),
                'subtitle' => esc_html__( 'Set label\'s color of Contact Widget', 'optima' ),
                'default'  => array(
                    'color' => '#2d628f',
                    'alpha' => '1',
                    'rgba'  => 'rgba(45,98,143,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id' => 'shortcode_contact_widget',
                'type' => 'text',
                'title' => esc_html__('Contact Form 7 Shortcode', 'optima' ),
            ),
        )
    ) );

    /*
     * <--- END SECTIONS
     */

    // -> START Layout Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Shop', 'optima' ),
        'id'               => 'woocommerce_layout_options',
        'customizer_width' => '400px',
        'icon' => 'el el-shopping-cart',
        'fields'           => array(

        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Products Page', 'optima' ),
        'id'               => 'products_page_settings',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'products_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Products Page Sidebar Layout', 'optima' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'products_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Products Page Sidebar', 'optima' ),
                'data'     => 'sidebars',
                'required' => array( 'products_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id' => 'products_per_page',
                'type' => 'text',
                'title' => esc_html__('Products Per Page', 'optima' ),
                'default' => '9'
            ),
            array(
                'id'       => 'woocommerce_def_columns',
                'type'     => 'select',
                'title'    => esc_html__( 'Default Number of Columns', 'optima' ),
                'desc'  => esc_html__( 'Select the number of columns in products page.', 'optima' ),
                'options'  => array(
                    '2' => esc_html__( '2', 'optima' ),
                    '3' => esc_html__( '3', 'optima' ),
                    '4' => esc_html__( '4', 'optima' ),
                ),
                'default'  => '4'
            ),
            array(
                'id'       => 'woocommerce_out_of_stock',
                'type'     => 'switch',
                'title'    => esc_html__( 'Display out of stock products', 'optima' ),
                'default'  => false,
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__('Single Product Page', 'optima' ),
        'id'               => 'product_page_settings',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'product_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Single Product Page Sidebar Layout', 'optima' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => esc_url(ReduxFramework::$_url) . 'assets/img/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'product_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Single Product Page Sidebar', 'optima' ),
                'data'     => 'sidebars',
                'required' => array( 'product_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'shop_title_conditional',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Single Product Title Area', 'optima' ),
                'default'  => false,
                'required' => array( 'page_title_conditional', '=', '1' ),
            ),
            array(
                'id'       => 'next_prev_product',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Next and Previous products.', 'optima' ),
                'default'  => false,
            ),
            array(
                'id'        => 'share_social',
                'type'      => 'switch',
                'title'     => esc_html__( 'Show Social links', 'optima' ),
                'default'   => false,
            ),
            array(
                'id'        =>'share_social_select',
                'type'      => 'select',
                'multi'     => true,
                'title'     => esc_html__('Select Social links', 'optima' ),
                'options'   => array(
                    'facebook'      => esc_html__( 'Facebook', 'optima' ),
                    'twitter'       => esc_html__( 'Twitter', 'optima' ),
                    'pinterest'     => esc_html__( 'Pinterest', 'optima' ),
                    'google'        => esc_html__( 'Google plus', 'optima' ),
                    'tumblr'        => esc_html__( 'Tumblr', 'optima' ),
                    'mail'          => esc_html__( 'Mail', 'optima' ),
                    'reddit'        => esc_html__( 'Reddit', 'optima' ),
                ),
                'required'  => array( 'share_social', '=', true ),
            ),
            array(
                'id'        => 'share_social-facebook',
                'type'      => 'text',
                'title'     => esc_html__('Title for Facebook icon', 'optima' ),
                'default'   => '',
                'required'  => array( 'share_social_select', '=', 'facebook' ),
            ),
            array(
                'id'        => 'share_social-twitter',
                'type'      => 'text',
                'title'     => esc_html__('Title for Twitter icon', 'optima' ),
                'default'   => '',
                'required'  => array( 'share_social_select', '=', 'twitter' ),
            ),
            array(
                'id'        => 'share_social-pinterest',
                'type'      => 'text',
                'title'     => esc_html__('Title for Pinterest icon', 'optima' ),
                'default'   => '',
                'required'  => array( 'share_social_select', '=', 'pinterest' ),
            ),
            array(
                'id'        => 'share_social-google',
                'type'      => 'text',
                'title'     => esc_html__('Title for Google plus icon', 'optima' ),
                'default'   => '',
                'required'  => array( 'share_social_select', '=', 'google' ),
            ),
            array(
                'id'        => 'share_social-linkedin',
                'type'      => 'text',
                'title'     => esc_html__('Title for LinkedIn icon', 'optima' ),
                'default'   => '',
                'required'  => array( 'share_social_select', '=', 'linkedin' ),
            ),
            array(
                'id'        => 'share_social-vk',
                'type'      => 'text',
                'title'     => esc_html__('Title for VK icon', 'optima' ),
                'default'   => '',
                'required'  => array( 'share_social_select', '=', 'vk' ),
            ),
            array(
                'id'        => 'share_social-tumblr',
                'type'      => 'text',
                'title'     => esc_html__('Title for Tumblr icon', 'optima' ),
                'default'   => '',
                'required'  => array( 'share_social_select', '=', 'tumblr' ),
            ),
            array(
                'id'        => 'share_social-mail',
                'type'      => 'text',
                'title'     => esc_html__('Title for E-mail icon', 'optima' ),
                'default'   => '',
                'required'  => array( 'share_social_select', '=', 'mail' ),
                'subtitle'  => esc_html__( 'Send this article via e-mail to a friend', 'optima' ),
            ),
            array(
                'id'        => 'share_social-reddit',
                'type'      => 'text',
                'title'     => esc_html__('Title for Reddit icon', 'optima' ),
                'default'   => '',
                'required'  => array( 'share_social_select', '=', 'reddit' ),
            ),
        )
    ) );
