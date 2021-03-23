<?php
/**
 * Extension-Boilerplate
 *
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * GT3 Header Builder - Modified For ReduxFramework
 *
 * @package     GT3 Header Builder - Extension for building header
 * @author      gt3themes
 * @version     1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_gt3_header_builder' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_gt3_header_builder extends ReduxFramework {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
        
            
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                if (trailingslashit( str_replace( '\\', '/', ABSPATH ) ) == '/') {
                    $this->extension_url = site_url( $this->extension_dir );
                }else{
                    $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
                } 
                $this->extension_url = plugin_dir_url(__FILE__);
            }  


            /*if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }    

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );   */         
        
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {
        
            // HTML output goes here



            if ( ! is_array( $this->value ) && isset( $this->field['options'] ) ) {
                $this->value = $this->field['options'];
            }

            

            $sortlists = $this->value;

            $side_row = '';

            echo '<fieldset id="' . esc_attr($this->field['id']) . '" class="redux-sorter-container redux-sorter">';
            echo "<div class='gt3_header_builder__setttings has_settings' data-settings-id='main_header_settings'><div class='gt3_header_builder__setting-icon'><span>".__( 'Main Header Settings', 'gt3_wize_core' )."</span><i class='fa fa-pencil' aria-hidden='true'></i></div></div>";

            if (!empty($sortlists)) {            

                foreach ($sortlists as $group => $sortlist) {

                    $container_layout = !empty($sortlist['layout']) ? ' '.$sortlist['layout'] : '';

                    
                    $full_position = explode('_', $group, 2);
                    $level = !empty($full_position[0]) ? $full_position[0] : '';
                    $position = !empty($full_position[1]) ? $full_position[1] : '';

                    $class_header_builder = '';
                    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                        $class_header_builder .= ' woo_active';
                    }
                    if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                        $class_header_builder .= ' wpml_active';
                    }

                    if ($side_row != $level) {
                        echo $side_row != '' ? "</div></div>" : '';
                        echo "<div class='gt3_header_builder__side gt3_header_builder__side--".$level.$class_header_builder."''><div class='gt3_header_builder__side-header has_settings' data-settings-id='side_".$level."'><div class='gt3_header_builder__setting-icon'><i class='fa fa-pencil' aria-hidden='true'></i></div></div><div>";
                    }

                    $side_row = $level;

                    echo '<ul id="' . esc_attr($this->field['id'] . '_' . $group) . '" class="sortlist_' . esc_attr($this->field['id']) . $container_layout . '" data-id="' . esc_attr($this->field['id']) . '" data-group-id="' . esc_attr($group) . '">';

                    if (!empty($sortlist['title']) || (!empty($sortlist['has_settings']) && $sortlist['has_settings'])) {
                        $section_class = ( !empty($sortlist['has_settings']) && (bool)$sortlist['has_settings'] ) ? ' has_settings' : '' ;
                        $section_attr = ( !empty($sortlist['has_settings']) && (bool)$sortlist['has_settings'] ) ? ' data-settings-id="'.$group.'"' : '';
                        echo "<div class='gt3_header_builder__part_header".$section_class."'".$section_attr.">";
                        if ( !empty($sortlist['layout'])) {
                            echo '<input class="layout ' . esc_attr($this->field['class']) . '" type="hidden" name="' . esc_attr($this->field['name'] . '[' . $group . '][layout]' . $this->field['name_suffix']) . '" value="' . esc_attr($sortlist['layout']) . '">';
                        }

                        if (!empty($sortlist['title'])) {
                            echo '<input class="title ' . esc_attr($this->field['class']) . '" type="hidden" name="' . esc_attr($this->field['name'] . '[' . $group . '][title]' . $this->field['name_suffix']) . '" value="' . esc_attr($sortlist['title']) . '">';
                            echo '<h3>' . esc_html($sortlist['title']) . '</h3>';
                        }
                        if ( !empty($sortlist['has_settings']) && (bool)$sortlist['has_settings'] ) {
                            echo '<input class="has_settings ' . esc_attr($this->field['class']) . '" type="hidden" name="' . esc_attr($this->field['name'] . '[' . $group . '][has_settings]' . $this->field['name_suffix']) . '" value="' . esc_attr($sortlist['has_settings']) . '">';
                            echo "<div class='gt3_header_builder__setting-icon'><i class='fa fa-pencil' aria-hidden='true'></i></div>";
                        }
                        echo "</div>";
                    }
                    

                    if ( ! isset( $sortlist['content']['placebo'] ) ) {
                        $sortlist['content']['placebo'] = 'placebo';
                    }

                    //var_dump($sortlist['content']);

                    foreach ( $sortlist['content'] as $key => $list ) {

                        echo '<input class="sorter-placebo" type="hidden" name="' . esc_attr($this->field['name']) . '[' . $group . '][content][placebo]' . esc_attr($this->field['name_suffix']) . '" value="placebo">';

                        if ( $key != "placebo" &&  !empty($list['title'])) {

                            $item_class = !empty($list['has_settings']) && $list['has_settings'] ? ' has_settings' : '';
                            $item_attr = !empty($list['has_settings']) && $list['has_settings'] ? ' data-settings-id="' . esc_attr($key) . '"' : '';

                            echo '<li id="sortee-' . esc_attr($key) . '" class="sortee'.$item_class.'"'.$item_attr.' data-id="' . esc_attr($key) . '">';
                                echo '<input class="position ' . esc_attr($this->field['class']) . '" type="hidden" name="' . esc_attr($this->field['name'] . '[' . $group . '][content][' . $key . '][title]' . $this->field['name_suffix']) . '" value="' . esc_attr($list['title']) . '">';
                                echo esc_html($list['title']);
                                if ( !empty($list['has_settings']) && $list['has_settings'] ) {
                                    echo '<input class="has_settings ' . esc_attr($this->field['class']) . '" type="hidden" name="' . esc_attr($this->field['name'] . '[' . $group . '][content][' . $key . '][has_settings]' . $this->field['name_suffix']) . '" value="' . esc_attr($list['has_settings']) . '">';
                                    echo "<div class='gt3_header_builder__setting-icon'><i class='fa fa-pencil' aria-hidden='true'></i></div>";
                                }

                            echo '</li>';
                        }
                    }

                    echo '</ul>';
                }
            } //end if
            echo "</div></div>";
            echo '</fieldset>';


        }
    
        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {
        
            wp_enqueue_script(
                'redux-field_gt3_header_builder-js', 
                $this->extension_url . '/field_gt3_header_builder.js', 
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field_gt3_header_builder-css', 
                $this->extension_url . '/field_gt3_header_builder.css',
                time(),
                true
            );
        
        }

        /*function localize( $field, $value = "" ) {

            $params = array();

            if ( empty( $value ) ) {
                $value = $this->value;
            }
            $params['val'] = $value;

            return $params;
        }*/
        
        /**
         * Output Function.
         *
         * Used to enqueue to the front-end
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */        
        public function output() {

            if ( $this->field['enqueue_frontend'] ) {

            }
            
        }        
        
    }
}
