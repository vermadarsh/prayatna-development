<?php


/**
* 
*/
class gt3Practice{

    private $shortcodeName;

    public function __construct() {
        $this->shortcodeName = 'gt3_portfolio_list';
    }

    public function shortcode_render(){
        add_action('vc_before_init', array($this, 'shortcodesMap'));
        $this->addShortcode();
    }

	public function shortcodesMap(){
        if (function_exists('vc_map')) {
            vc_map( array(
                "name" => esc_html__("Portfolio List", 'gt3_core'),
                "base" => $this->shortcodeName,
                "class" => $this->shortcodeName,
                "category" => esc_html__('GT3 Modules', 'gt3_core'),
                "icon" => 'gt3_icon',
                "content_element" => true,
                "description" => esc_html__("Portfolio List",'gt3_core'),
                "params" => array(
                    array(
                        'type' => 'loop',
                        'heading' => esc_html__('Project Items', 'gt3_core'),
                        'param_name' => 'build_query',
                        'settings' => array(
                            'size' => array('hidden' => false, 'value' => 4 * 3),
                            'order_by' => array('value' => 'date'),
                            'post_type' => array('value' => 'team', 'hidden' => true),
                            'categories' => array('hidden' => true),
                            'tags' => array('hidden' => true),
                        ),
                        'description' => esc_html__('Create WordPress loop, to populate content from your site.', 'gt3_core')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Style', 'gt3_core'),
                        'param_name' => 'portfolio_style',
                        'value' => array(
                            esc_html__("Content on Image", 'gt3_core') => 'content_on_image',
                            esc_html__("Content below the image", 'gt3_core') => 'content_below',
                        ),
                        'std' => 'content_below',
                        'edit_field_class' => 'vc_col-sm-6',
                        'dependency' => array(
                            'element' => 'portfolio_layout',
                            'value_not_equal_to' => 'multisize',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Content', 'gt3_core'),
                        'param_name' => 'portfolio_content',
                        'value' => array(
                            esc_html__("Title + Categories", 'gt3_core') => 'title_cat',
                            esc_html__("Titile + Exerpt + Link", 'gt3_core') => 'title_exerpt',
                        ),
                        'std' => 'title_exerpt',
                        'edit_field_class' => 'vc_col-sm-6',
                        'dependency' => array(
                            'element' => 'portfolio_style',
                            'value' => 'content_below',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Content Letter Count', 'gt3_wize_core'),
                        'param_name' => 'content_letter_count',
                        'value' => '85',
                        'description' => esc_html__( 'Enter content letter count.', 'gt3_wize_core' ),
                        'edit_field_class' => 'vc_col-sm-6',
                        'dependency' => array(
                            'element' => 'portfolio_style',
                            'value' => 'content_below',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Layout', 'gt3_core'),
                        'param_name' => 'portfolio_layout',
                        'value' => array(
                            esc_html__("Grid", 'gt3_core') => 'grid',
                            esc_html__("Masonry", 'gt3_core') => 'masonry',
                            esc_html__("Packery multisize", 'gt3_core') => 'multisize',
                        ),
                        'std' => 'grid',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Columns with Spaces', 'gt3_core' ),
                        'param_name' => 'columns_with_spaces',
                        'value' => array( esc_html__( 'Yes', 'gt3_core' ) => 'yes' ),
                        'std' => 'yes',
                        'save_always' => true,
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Rounded images', 'gt3_core' ),
                        'param_name' => 'rounded_images',
                        'value' => array( esc_html__( 'Yes', 'gt3_core' ) => 'yes' ),
                        'std' => 'yes',
                        'save_always' => true,
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Items Per Line', 'gt3_core'),
                        'param_name' => 'posts_per_line',
                        'admin_label' => true,
                        'value' => array(
                            esc_html__("1", 'gt3_core') => '1',
                            esc_html__("2", 'gt3_core') => '2',
                            esc_html__("3", 'gt3_core') => '3',
                            esc_html__("4", 'gt3_core') => '4',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                        'dependency' => array(
                            'element' => 'portfolio_layout',
                            'value_not_equal_to' => 'multisize',
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Portfolio in Full width Section', 'gt3_core' ),
                        'param_name' => 'show_on_full_width',
                        'value' => array( esc_html__( 'Yes', 'gt3_core' ) => 'yes' ),
                        'std' => 'not',
                        'save_always' => true,
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Image Proportional', 'gt3_core'),
                        'param_name' => 'image_proportional',
                        'admin_label' => true,
                        'value' => array(
                            esc_html__("Native", 'gt3_core') => 'native',
                            esc_html__("Square", 'gt3_core') => 'square',
                            esc_html__("Landscape", 'gt3_core') => 'landscape',
                            esc_html__("Portred", 'gt3_core') => 'portred',
                        ),
                        'std' => 'native'
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Show Filter', 'gt3_core' ),
                        'param_name' => 'show_filter',
                        'value' => array( esc_html__( 'Yes', 'gt3_core' ) => 'yes' ),
                        'std' => 'not',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Filter Style', 'gt3_core'),
                        'param_name' => 'filter_style',
                        'save_always' => true,
                        'value' => array(
                            esc_html__('Links', 'gt3_core') => "links",
                            esc_html__('Isotope', 'gt3_core') => "isotope",
                        ),
                        'dependency' => array(
                            'element' => 'show_filter',
                            "value" => "yes"
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Show Pagination', 'gt3_core' ),
                        'param_name' => 'show_pagination',
                        'value' => array( esc_html__( 'Yes', 'gt3_core' ) => 'yes' ),
                        'std' => 'not',
                        'dependency' => array(
                            'element' => 'view_style',
                            "value" => "standard"
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Pagination Style', 'gt3_core'),
                        'param_name' => 'pagination_style',
                        'save_always' => true,
                        'value' => array(
                            esc_html__('Pagination', 'gt3_core') => "pagination",
                            esc_html__('Load More Button', 'gt3_core') => "load_more",
                        ),
                        'dependency' => array(
                            'element' => 'show_pagination',
                            "value" => "yes"
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Items on load', 'gt3_core'),
                        'param_name' => 'items_load',
                        'value' => '4',
                        'save_always' => true,
                        'description' => esc_html__( 'Items load by load more button.', 'gt3_core' ),
                        'dependency' => array(
                            'element' => 'pagination_style',
                            "value" => "load_more"
                        )
                    ),



                    // Portfolio Font
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Use theme default font family for Title?', 'gt3_wize_core' ),
                        'param_name' => 'use_theme_fonts_title',
                        'value' => array( esc_html__( 'Yes', 'gt3_wize_core' ) => 'yes' ),
                        'description' => esc_html__( 'Use font family from the theme.', 'gt3_wize_core' ),
                        "group" => esc_html__( "Styling", 'gt3_wize_core' ),
                        'std' => 'yes',
                    ),
                    array(
                        'type' => 'google_fonts',
                        'param_name' => 'google_fonts_title',
                        'value' => '',
                        'settings' => array(
                            'fields' => array(
                                'font_family_description' => esc_html__( 'Select font family.', 'gt3_wize_core' ),
                                'font_style_description' => esc_html__( 'Select font styling.', 'gt3_wize_core' ),
                            ),
                        ),
                        'dependency' => array(
                            'element' => 'use_theme_fonts_title',
                            'value_not_equal_to' => 'yes',
                        ),
                        "group" => esc_html__( "Styling", 'gt3_wize_core' ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Use theme default font family for categories?', 'gt3_wize_core' ),
                        'param_name' => 'use_theme_fonts_categories',
                        'value' => array( esc_html__( 'Yes', 'gt3_wize_core' ) => 'yes' ),
                        'description' => esc_html__( 'Use font family from the theme.', 'gt3_wize_core' ),
                        "group" => esc_html__( "Styling", 'gt3_wize_core' ),
                        'std' => 'yes',
                    ),
                    array(
                        'type' => 'google_fonts',
                        'param_name' => 'google_fonts_categories',
                        'value' => '',
                        'settings' => array(
                            'fields' => array(
                                'font_family_description' => esc_html__( 'Select font family.', 'gt3_wize_core' ),
                                'font_style_description' => esc_html__( 'Select font styling.', 'gt3_wize_core' ),
                            ),
                        ),
                        'dependency' => array(
                            'element' => 'use_theme_fonts_categories',
                            'value_not_equal_to' => 'yes',
                        ),
                        "group" => esc_html__( "Styling", 'gt3_wize_core' ),
                    ),
                    // Portfolio Headings Font
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__( 'Use theme default portfolio style?', 'gt3_wize_core' ),
                        'param_name' => 'use_theme_portfolio_style',
                        'value' => array( esc_html__( 'Yes', 'gt3_wize_core' ) => 'yes' ),
                        'description' => esc_html__( 'Use default portfolio style from the theme.', 'gt3_wize_core' ),
                        "group" => esc_html__( "Styling", 'gt3_wize_core' ),
                        'save_always' => true,
                        'std' => 'yes',
                    ),
                    // Custom portfolio style
                    array(
                        "type" => "colorpicker",
                        "class" => "",
                        "heading" => esc_html__("Custom Title Color", 'gt3_wize_core'),
                        "param_name" => "custom_title_color",
                        "value" => '#222328',
                        "description" => esc_html__("Select custom title color.", 'gt3_wize_core'),
                        'dependency' => array(
                            'element' => 'use_theme_portfolio_style',
                            'value_not_equal_to' => 'yes',
                        ),
                        "group" => esc_html__( "Styling", 'gt3_wize_core' ),
                        'save_always' => true,
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    // Heading Font Size
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title Font Size', 'gt3_wize_core'),
                        'param_name' => 'title_font_size',
                        'value' => '24',
                        'description' => esc_html__( 'Enter title font-size in pixels.', 'gt3_wize_core' ),
                        'dependency' => array(
                            'element' => 'use_theme_portfolio_style',
                            'value_not_equal_to' => 'yes',
                        ),
                        "group" => esc_html__( "Styling", 'gt3_wize_core' ),
                        'save_always' => true,
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        "type" => "colorpicker",
                        "class" => "",
                        "heading" => esc_html__("Custom Category Color", 'gt3_wize_core'),
                        "param_name" => "custom_category_color",
                        "value" => '#3a405b',
                        "description" => esc_html__("Select custom category color.", 'gt3_wize_core'),
                        'dependency' => array(
                            'element' => 'use_theme_portfolio_style',
                            'value_not_equal_to' => 'yes',
                        ),
                        "group" => esc_html__( "Styling", 'gt3_wize_core' ),
                        'save_always' => true,
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    // Heading Font Size
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Category Font Size', 'gt3_wize_core'),
                        'param_name' => 'category_font_size',
                        'value' => '14',
                        'description' => esc_html__( 'Enter Category font-size in pixels.', 'gt3_wize_core' ),
                        'dependency' => array(
                            'element' => 'use_theme_portfolio_style',
                            'value_not_equal_to' => 'yes',
                        ),
                        "group" => esc_html__( "Styling", 'gt3_wize_core' ),
                        'save_always' => true,
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    vc_map_add_css_animation( true ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Extra Class", 'gt3_wize_core'),
                        "param_name" => "item_el_class",
                        "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'gt3_wize_core')
                    ),
                )
            ));
        }
    }

    public function addShortcode(){
        add_shortcode($this->shortcodeName, array($this, 'render'));
    }

    public function render($atts, $content = null){

        include_once OPTIMA_PLUGIN_DIR . '/includes/class-gt3_google_fonts_render.php';

        $args = array(
            'query_args' => '',
            'build_query' => '',
            'portfolio_style' => 'content_below',
            'portfolio_content' => 'title_exerpt',
            'content_letter_count' => '85',
            'portfolio_layout' => 'grid',
            'columns_with_spaces' => '',
            'rounded_images' => 'yes',
            "posts_per_line" => 1,
            'show_on_full_width' => '',
            'image_proportional' => 'native',
            "show_filter" => "",
            'filter_style' => '',
            'show_pagination' => '',
            'pagination_style' => '',
            'items_load' => 4,
            'use_theme_portfolio_style' => '',
            'custom_title_color' => '',
            'title_font_size' => '',
            'custom_category_color' => '',
            'category_font_size' => ''
        );
        
        $parameters = shortcode_atts($args, $atts);
        extract($parameters);

        if ($parameters['portfolio_layout'] == 'multisize') {
            $parameters['posts_per_line'] = 4;
            $parameters['image_proportional'] = 'square';
            $parameters['portfolio_style'] = 'content_on_image';
        }

        // Render Google Fonts
        $obj = new GoogleFontsRender();
        $shortc = $this->shortcodeName;
        extract( $obj->getAttributes( $atts, $this, $shortc, array('google_fonts_title', 'google_fonts_categories'), true));

        $portfolio_styling_out = array();
        if (!empty($styles_google_fonts_title)) {
            $portfolio_styling_out['styles_google_fonts_title'] = $styles_google_fonts_title;
        }

        if (!empty($styles_google_fonts_categories)) {
            $portfolio_styling_out['styles_google_fonts_categories'] = $styles_google_fonts_categories;
        }

        if ($use_theme_portfolio_style == '') {
            if (!empty($custom_title_color)) {
                $portfolio_styling_out['custom_title_color'] = $custom_title_color;
            }
            if (!empty($title_font_size)) {
                $portfolio_styling_out['title_font_size'] = $title_font_size;
            }
            if (!empty($custom_category_color)) {
                $portfolio_styling_out['custom_category_color'] = $custom_category_color;
            }
            if (!empty($category_font_size)) {
                $portfolio_styling_out['category_font_size'] = $category_font_size;
            }
        }
        $parameters['portfolio_styling_out'] = $portfolio_styling_out;
        if (empty($query_args)) {
            list($query_args) = vc_build_loop_query($build_query);
        }

        $portfolio_term_id = get_query_var( 'portfolio_term_id' );
        $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $query_args['post_type'] = 'portfolio';

        ob_start();
        if ( $show_filter == 'yes') {               
            echo '<div class="'.esc_attr($this->shortcodeName).'__filter'.($filter_style == "isotope" ? ' isotope-filter' : '').'">';
                echo $this->getCategoriesOut($query_args,$portfolio_term_id);
            echo '</div>'; 
        }
        $filter = ob_get_clean();

        $parameters['query_args'] = $query_args;
        if (!empty($portfolio_term_id)) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'portfolio-category',
                    'field'    => 'term_id',
                    'terms'    => $portfolio_term_id,
                ),
            );
        }
        $query_results = new WP_Query($query_args);

        $parameters['post_count'] = $query_results->post_count;
        
        $item_class = $this->grid_class($parameters);

        $out = '';
        $out .= '<div class="'.esc_attr($this->shortcodeName).'">';
            $out .= $filter;            
            $out .= '<div class="'.esc_attr($this->shortcodeName).'__posts-container row '.
            ($portfolio_layout == "multisize" ? 'isotope_packery' : '' ).
            ($columns_with_spaces != 'yes' ? ' no_spaces' : '').
            ($rounded_images != 'yes' ? ' no_image_rounds' : '').'"'.$this->get_data_attr($parameters).'>';
            $out .= '<div class="'.esc_attr($this->shortcodeName).'__grid-sizer '.gt3Practice::grid_class($parameters).'"></div>';
            $out .= '<div class="'.esc_attr($this->shortcodeName).'__grid-gutter"></div>';
            if($query_results->have_posts()):
                $count_id = 1;   
                while ( $query_results->have_posts() ) : $query_results->the_post();
                    $out .= gt3_get_practice_item($parameters, $item_class,$count_id);
                    $count_id++;
                    if ($count_id > 8) {
                        $count_id = 1;
                    }
                endwhile;
            else:
                $out .= '<p>'. _e( 'Sorry, no posts matched your criteria.', 'gt3_core' ) .'</p>';
            endif;  
            $out .= '</div>';

            wp_reset_postdata();

            if ((bool) $show_pagination && $pagination_style == 'pagination') {
                global $wp_query, $paged;

                if(empty($paged)){
                    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
                }
                $wp_query = $query_results;
                $out .= gt3_get_theme_pagination();
            }

            if (!empty($query_args['posts_per_page']) && ($query_args['posts_per_page'] >= 0) && $query_args['posts_per_page'] <= $query_results->found_posts && $pagination_style == 'load_more' ) {
                $out .= $this->loadMorePractice ($parameters);
            }
        $out .= '</div>';   
        return $out;
    }

    public function get_data_attr($parameters){
        $data_attrs = '';
        $ajax_parameters = array(
            'build_query',
            'portfolio_style',
            'portfolio_content',
            'content_letter_count',
            'portfolio_layout',
            'columns_with_spaces',
            'rounded_images',
            'posts_per_line',
            'show_on_full_width',
            'image_proportional',
            'items_load',
            'custom_title_color',
            'title_font_size',
            'custom_category_color',
            'category_font_size',
            'post_count',
        );
        foreach ($parameters as $parameter => $value) {
            if (!empty($value) && in_array($parameter, $ajax_parameters)) {
                $data_attrs .= ' data-'.esc_attr($parameter).'="'.esc_attr($value).'"';
            }
        }
        return $data_attrs;
    }

    public function grid_class ($parameters) {
        switch ($parameters['posts_per_line']) {
            case 1:
                $item_class = 'span12';
                break;
            case 2:
                $item_class = 'span6';
                break;
            case 3:
                $item_class = 'span4';
                break;
            case 4:
                $item_class = 'span3';
                break;
            default:
                $item_class = 'span12';
        }
        return $item_class;
    }

    public static function getImgUrl ($parameters, $wp_get_attachment_url, $image_extra_size, $natural_ratio) {
        if (strlen($wp_get_attachment_url)) {
            if (!empty($parameters['image_proportional']) && $parameters['image_proportional'] != 'native') {
                switch ($parameters['image_proportional']) {
                    case 'square':
                        $ration = 1;
                        break;
                    case 'landscape':
                        $ration = 0.8;
                        break;
                    case 'portred':
                        $ration = 1.25;
                        break;                    
                    default:
                        $ration = null;
                        break;
                }
            }else{
                $ration = null;
            }

            switch ($parameters['posts_per_line']) {
                case "1":
                    if (function_exists('gt3_get_image_srcset')) {
                        if ($parameters['columns_with_spaces'] != 'yes') {
                            $responsive_dimensions = array(
                                array('1200','1200'),
                                array('992','992'),
                                array('768','768')
                            );
                        }else{
                            $responsive_dimensions = array(
                                array('1200','1170'),
                                array('992','950'),
                                array('768','728')
                            ); 
                        }   
                        if ($parameters['show_on_full_width'] == 'yes') {
                            array_unshift($responsive_dimensions, array('1600','1600'),array('1900','1900'));
                        }                    
                        $gt3_featured_image_url = gt3_get_image_srcset($wp_get_attachment_url,$ration,$responsive_dimensions);
                    }else{
                       $gt3_featured_image_url = 'src="'.aq_resize($wp_get_attachment_url, "1170", null, true, true, true).'"'; 
                    }
                    
                    break;
                case "2":
                    if (function_exists('gt3_get_image_srcset')) {
                        if ($parameters['columns_with_spaces'] != 'yes') {
                            $responsive_dimensions = array(
                                array('1200','585'),
                                array('992','475'),
                                array('768','364')
                            );
                            if ($parameters['show_on_full_width'] == 'yes') {
                                array_unshift($responsive_dimensions, array('1600','800'),array('1900','950'));
                            } 
                        }else{
                            $responsive_dimensions = array(
                                array('1200','570'),
                                array('992','460'),
                                array('768','349')
                            );
                            if ($parameters['show_on_full_width'] == 'yes') {
                                array_unshift($responsive_dimensions, array('1630','800'),array('1930','950'));
                            } 
                        }                        
                        $gt3_featured_image_url = gt3_get_image_srcset($wp_get_attachment_url,$ration,$responsive_dimensions);
                    }else{
                        $gt3_featured_image_url = 'src="'.aq_resize($wp_get_attachment_url, "570", "570", true, true, true).'"';
                    }
                    break;
                case "3":
                    if (function_exists('gt3_get_image_srcset')) {
                        if ($parameters['columns_with_spaces'] != 'yes') {
                            $responsive_dimensions = array(
                                array('1200','390'),
                                array('992','317'),
                                array('768','243')
                            );
                            if ($parameters['show_on_full_width'] == 'yes') {
                                array_unshift($responsive_dimensions, array('1590','530'),array('1890','630'));
                            } 
                        }else{
                            $responsive_dimensions = array(
                                array('1200','370'),
                                array('992','297'),
                                array('768','223')
                            );
                            if ($parameters['show_on_full_width'] == 'yes') {
                                array_unshift($responsive_dimensions, array('1620','530'),array('1920','630'));
                            }
                        } 
                        $gt3_featured_image_url = gt3_get_image_srcset($wp_get_attachment_url,$ration,$responsive_dimensions);
                    }else{
                        $gt3_featured_image_url = 'src="'.aq_resize($wp_get_attachment_url, "370", "370", true, true, true).'"';
                    }
                    break;
                case "4":
                    if (function_exists('gt3_get_image_srcset')) {
                        if ($parameters['columns_with_spaces'] != 'yes') {
                            $responsive_dimensions = array(
                                array('1200','293'),
                                array('992','238'),
                                array('768','182')
                            );
                            if ($parameters['show_on_full_width'] == 'yes') {
                                array_unshift($responsive_dimensions, array('1600','400'),array('1900','475'));
                            }
                        }else{
                            $responsive_dimensions = array(
                                array('1200','270'),
                                array('992','215'),
                                array('768','160')
                            );
                            if ($parameters['show_on_full_width'] == 'yes') {
                                array_unshift($responsive_dimensions, array('1630','400'),array('1920','475'));
                            }
                        }  
                        if (!empty($image_extra_size)) {
                            switch ($image_extra_size) {
                                case 'large_width_height':
                                    if ($parameters['columns_with_spaces'] != 'yes') {
                                        $responsive_dimensions = array(
                                            array('1200','585'),
                                            array('992','475'),
                                            array('768','364')
                                        );
                                        if ($parameters['show_on_full_width'] == 'yes') {
                                            array_unshift($responsive_dimensions, array('1600','800'),array('1900','950'));
                                        }
                                    }else{
                                        $responsive_dimensions = array(
                                            array('1200','570'),
                                            array('992','460'),
                                            array('768','349')
                                        );
                                        if ($parameters['show_on_full_width'] == 'yes') {
                                            array_unshift($responsive_dimensions, array('1630','800'),array('1920','950'));
                                        }
                                    } 
                                    $ration = 1;
                                    break;

                                case 'large_height':
                                    if ($parameters['columns_with_spaces'] != 'yes') {
                                        $responsive_dimensions = array(
                                            array('1200','293'),
                                            array('992','238'),
                                            array('768','182')
                                        );
                                        $ration = 2.114;
                                        if ($parameters['show_on_full_width'] == 'yes') {
                                            $ration = 2;
                                            array_unshift($responsive_dimensions, array('1600','400'),array('1900','475'));
                                        }
                                    }else{
                                        $responsive_dimensions = array(
                                            array('1200','270'),
                                            array('992','215'),
                                            array('768','160')
                                        );
                                        $ration = 2.114;
                                        if ($parameters['show_on_full_width'] == 'yes') {
                                            $ration = 2.075;
                                            array_unshift($responsive_dimensions, array('1630','400'),array('1920','475'));
                                        }
                                    } 
                                    break;

                                case 'large_width':
                                    if ($parameters['columns_with_spaces'] != 'yes') {
                                        $responsive_dimensions = array(
                                            array('1200','585'),
                                            array('992','475'),
                                            array('768','364')
                                        );
                                        if ($parameters['show_on_full_width'] == 'yes') {
                                            array_unshift($responsive_dimensions, array('1600','800'),array('1900','950'));
                                        }
                                    }else{
                                        $responsive_dimensions = array(
                                            array('1200','570'),
                                            array('992','460'),
                                            array('768','349')
                                        );
                                        if ($parameters['show_on_full_width'] == 'yes') {
                                            array_unshift($responsive_dimensions, array('1630','800'),array('1920','950'));
                                        }
                                    } 
                                    $ration = 0.5;
                                    break;
                                
                                default:
                                    break;
                            }
                        }                 
                        $gt3_featured_image_url = gt3_get_image_srcset($wp_get_attachment_url,$ration,$responsive_dimensions);
                    }else{
                        $gt3_featured_image_url = 'src="'.aq_resize($wp_get_attachment_url, "270", "270", true, true, true).'"';
                    }
                    break;
                default:
                    $gt3_featured_image_url = 'src="'.aq_resize($wp_get_attachment_url, "1170", $ration, true, true, true).'"'; 
            }


            if ($ration == null && !empty($natural_ratio)) {
                $ration = $natural_ratio;
            }

            $mainColor = getSolidColorFromImage($wp_get_attachment_url);
            
            $featured_image = '<div class="gt3_portfolio_list__image-placeholder" style="padding-bottom:'.(100*$ration).'%;margin-bottom:-'.(100*$ration).'%;background-color:#'.$mainColor.';"></div>';
            $featured_image .= '<img ' . $gt3_featured_image_url . ' alt="" />';
        } else {
            $featured_image = '';
        }
        return $featured_image;
    }

    public function getCategoriesOut($parameters,$portfolio_term_id){
        $gt3_wp_query_in_shortcodes = new WP_Query($parameters);
        $data_category = isset($parameters['tax_query']) ? $parameters['tax_query'] : array();
        $include = array();
        $exclude = array();
        if (!is_tax()) {
            if (!empty($data_category) && $data_category[0]['operator'] === 'IN') {
                foreach ($data_category[0]['terms'] as $key => $value) {
                    array_push($include, $value);
                }
            } elseif (!empty($data_category) && $data_category[0]['operator'] === 'NOT IN') {
                foreach ($data_category[0]['terms'] as $key => $value) {
                    array_push($exclude, $value);
                }
            }    
        }
        $permalink = get_permalink();  
        $cats = get_terms(array(
                'taxonomy' => 'portfolio-category',
                'include' => $include,
                'exclude' => $exclude
            ));
        $out = '<a href="'.esc_url($permalink).'" data-filter=".gt3_portfolio_list__item "'.(empty($portfolio_term_id) ? ' class="active"' : '' ).'>'.esc_html('All','gt3').'</a>';
        foreach ($cats as $cat) {
            $permalink = esc_url(add_query_arg("portfolio_term_id", $cat->term_id, $permalink));
            $out .= '<a href="'.esc_url($permalink).'" data-filter=".'.$cat->slug.'"'.($portfolio_term_id == $cat->term_id ? ' class="active"' : '').'>';
            $out .= $cat->name;
            $out .= '</a>';
        }
        wp_reset_postdata();
        return $out;
    }

    public function loadMorePractice ($parameters) {
        extract($parameters);
        $x = json_encode($parameters);
        $x = esc_attr($x);
        $compile = '';
        $compile .= '<div class="text-center gt3_module_button button_alignment_center"><a href="' . esc_js("javascript:void(0)") . '" class="gt3_portfolio_load_more shortcode_button button_size_normal">' . esc_html__("Load More", 'gt3_core') . '</a></div>';

        $posts_per_page = 2;
        return $compile;
    }
}

function getSolidColorFromImage($filepath) {
    $attach_id = get_post_thumbnail_id(get_the_ID());
    $attach_path = get_attached_file( $attach_id );
    $upload_dir = wp_upload_dir();        
    $attach_file = str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $attach_path);
    
    if (empty($attach_id) || ($attach_file != $filepath) ){
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $filepath ));
        if (!empty($attachment[0])) {
            $attach_id = $attachment[0];
        }
    }

    $solid_color = get_post_meta( $attach_id, 'solid_color', true);

    if (empty($attach_id)) {
        return '#D3D3D3';
    }else{
        $filepath = get_attached_file( $attach_id );
    }

    if (!empty($solid_color)) {
        return $solid_color;
    }

    $type = wp_check_filetype($filepath); // [] if you don't have exif you could use getImageSize()
    if (!empty($type) && is_array($type) && !empty($type['ext']) && file_exists($filepath)) {
        $type = $type['ext'];
    }else{
        return '#D3D3D3';
    }
    $allowedTypes = array(
        'gif',  // [] gif
        'jpg',  // [] jpg
        'png',  // [] png
        'bmp'   // [] bmp
    );
    if (!in_array($type, $allowedTypes)) {
        return '#D3D3D3';
    }
    $im = false;
    switch ($type) {
        case 'gif' :
            if (function_exists('imageCreateFromGif')) {
                $im = imageCreateFromGif($filepath);
            }
        break;
        case 'jpg' :
            if (function_exists('imageCreateFromJpeg')) {
                $im = imageCreateFromJpeg($filepath);
            }
        break;
        case 'png' :
            if (function_exists('imageCreateFromPng')) {
                $im = imageCreateFromPng($filepath);
            }
        break;
        case 'bmp' :
            if (function_exists('imageCreateFromBmp')) {
                $im = imageCreateFromBmp($filepath);
            }
        break;
    }

    if ($im) {
        $thumb=imagecreatetruecolor(1,1);
        imagecopyresampled($thumb,$im,0,0,0,0,1,1,imagesx($im),imagesy($im));
        $mainColor=strtoupper(dechex((int)imagecolorat($thumb,0,0)));
        if (strlen($mainColor) < 6) {
            $mainColor = '0' . $mainColor;
        }
        update_post_meta( $attach_id, 'solid_color', $mainColor );
        return $mainColor;
    }else{
        return '#D3D3D3';
    }
} 

if (!function_exists('exif_imagetype')) {
    function exif_imagetype($filename){
        $img = getimagesize( $filename );
        if ( !empty( $img[2] ) )
          return  $img[2];
        return false;
    }
}


add_action('wp_ajax_gt3_get_practice_item_from_ajax', 'gt3_get_practice_item_from_ajax');
add_action('wp_ajax_nopriv_gt3_get_practice_item_from_ajax', 'gt3_get_practice_item_from_ajax');
function gt3_get_practice_item_from_ajax() {
    $build_query = $_POST['build_query'];
    $portfolio_style = esc_attr($_POST['portfolio_style']);
    $portfolio_content = esc_attr($_POST['portfolio_content']);
    $content_letter_count = esc_attr($_POST['content_letter_count']);
    $portfolio_layout = esc_attr($_POST['portfolio_layout']);
    $columns_with_spaces = esc_attr($_POST['columns_with_spaces']);
    $rounded_images = esc_attr($_POST['rounded_images']);
    $posts_per_line = esc_attr($_POST['posts_per_line']);
    $image_proportional = esc_attr($_POST['image_proportional']);
    $items_load = esc_attr($_POST['items_load']);
    $post_count = esc_attr($_POST['post_count']);

    list($query_args) = vc_build_loop_query($build_query);

    $query_args['post_type'] = 'portfolio';
    $query_args['post_status'] = 'publish';
    $query_args['offset'] = $post_count;
    $query_args['posts_per_page'] = $items_load;

    $query_results = new WP_Query($query_args);
    $out = '';
    $parameters = $posts_param_str;
    $parameters = array(
        'portfolio_style' => $portfolio_style,
        'portfolio_content' => $portfolio_content,
        'content_letter_count' => $content_letter_count,
        'portfolio_layout' => $portfolio_layout,
        'columns_with_spaces' => $columns_with_spaces,
        'rounded_images' => $rounded_images,
        'posts_per_line' => $posts_per_line,
        'image_proportional' => $image_proportional,
        'image_proportional' => $image_proportional,
    );
    $item_class = gt3Practice::grid_class($parameters);
    $items_left = $query_results->found_posts - ($post_count + $items_load);

    if (!empty($post_count)) {
        $count_id = $post_count - ((int)($post_count/8))*8;
        $count_id++;
    }

    if($query_results->have_posts()):
        /*$count_id = 1; */
        while ( $query_results->have_posts() ) : $query_results->the_post(); 
            $out .= gt3_get_practice_item($parameters, $item_class,$count_id);
            if ($count_id == 8) {
                $count_id = 1;
            }else{
                $count_id++;
            }
        endwhile;
    else:
        wp_reset_postdata();
        echo json_encode( array(
            'html' => '',
            'items_left' => $items_left,
            'count_id' => $count_id,
            'post_count' => $post_count
        ));
        wp_die();
    endif; 
    wp_reset_postdata();
    echo json_encode( array(
        'html' => $out,
        'items_left' => $items_left,
        'count_id' => $count_id,
        'post_count' => $post_count
    ));
    wp_die();
}

function gt3_get_practice_item ($parameters, $item_class, $count_id) {
    $out = '';
    $post_cats = wp_get_post_terms(get_the_id(), 'portfolio-category');
    $post_cats_out = '';
    $post_cats_str = '';
        for ($i=0; $i<count( $post_cats ); $i++) {
            $post_cat_term = $post_cats[$i];
            $post_cat_name = $post_cat_term->slug;
            if (!empty($post_cats_out)) {
                $post_cats_out .= '<span class="gt3_portfolio_list__categories_delimiter">, </span>';
            }
            $post_cats_out .= '<a href="'.esc_url(get_term_link($post_cat_term->term_id,'portfolio-category')).'">'.$post_cat_term->name.'</a>';
            $post_cats_str .= ' '.$post_cat_name;
        }
    $item_class .= $post_cats_str;

    if (!empty($parameters['portfolio_style'])) {
        $item_class .= $parameters['portfolio_style'] == 'content_on_image' ? ' content_on_image' : '';
    }
    if (!empty($parameters['image_proportional'])) {
        $item_class .= ' gt3_portfolio_list__item--image_'.$parameters['image_proportional'];
    }
    if (!empty($count_id)) {
        $item_class .= ' gt3_portfolio_list__item--'.$count_id;
    }

    if (!empty($parameters['portfolio_styling_out'])) {
        //title style
        $portfolio_styling_out = $parameters['portfolio_styling_out'];
        $custom_portfolio_title_style = '';
        $custom_portfolio_categories_style = '';
        $custom_portfolio_title_style .= !empty($portfolio_styling_out['custom_title_color']) ? 'color:'.$portfolio_styling_out['custom_title_color'].';' : '';
        $custom_portfolio_title_style .= !empty($portfolio_styling_out['title_font_size']) ? 'font-size:'.$portfolio_styling_out['title_font_size'].'px;' : '';
        $custom_portfolio_title_style .= !empty($portfolio_styling_out['styles_google_fonts_title']) ? $portfolio_styling_out['styles_google_fonts_title'] : '';
        // category style
        $custom_portfolio_categories_style .= !empty($portfolio_styling_out['custom_category_color']) ? 'color:'.$portfolio_styling_out['custom_category_color'].';' : '';
        $custom_portfolio_categories_style .= !empty($portfolio_styling_out['category_font_size']) ? 'font-size:'.$portfolio_styling_out['category_font_size'].'px;' : '';
        $custom_portfolio_categories_style .= !empty($portfolio_styling_out['styles_google_fonts_categories']) ? $portfolio_styling_out['styles_google_fonts_categories'] : '';

    }else{
        $custom_portfolio_title_style = '';
    }
    $custom_portfolio_title_style = !empty($custom_portfolio_title_style) ? ' style="'.$custom_portfolio_title_style.'"' : '';
    $custom_portfolio_categories_style = !empty($custom_portfolio_categories_style) ? ' style="'.$custom_portfolio_categories_style.'"' : '';

    // set post options
    $p_id = get_the_ID();

    $content_post = get_post($p_id);
    // Letter Count

    
    $image_array = image_downsize(get_post_thumbnail_id($p_id), 'full');
    if (!empty($image_array) && is_array($image_array)) {
        $wp_get_attachment_url = !empty($image_array[0]) ? $image_array[0] : wp_get_attachment_url(get_post_thumbnail_id($p_id), 'full');
        if (!empty($image_array[1]) && !empty($image_array[2])) {
            $ratio = $image_array[2] / $image_array[1];
        }
    }else{
        $wp_get_attachment_url = wp_get_attachment_url(get_post_thumbnail_id($p_id), 'full');
        $ratio = null;
    }

    if (!empty($parameters['portfolio_layout']) && $parameters['portfolio_layout'] == 'multisize') {
        $image_extra_size = gt3_get_practice_item_image_size($count_id);
        $item_class .= ' gt3_portfolio_list__item--' . $image_extra_size;
    }else{
        $image_extra_size = 'normal';
    }    

    $image_out = gt3Practice::getImgUrl($parameters, $wp_get_attachment_url, $image_extra_size, $ratio);


    /** likes */
    if (gt3_option('portfolio_likes')) {
        $all_likes = gt3pb_get_option("likes");
        wp_enqueue_script('jquery.cookie');
        if (isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()] == 1) {
            $likes_text_label = esc_html__('Like', 'gt3_wize_core');
        } else {
            $likes_text_label = esc_html__('Likes', 'gt3_wize_core');
        }
        ob_start();
        ?>
        <div class="gt3_list__post_likes likes_block post_likes_add<?php echo isset($_COOKIE['like_post'.get_the_ID()]) ? ' already_liked' : ''; ?>" data-postid="<?php echo esc_attr(get_the_ID()); ?>" data-modify="like_post" title="<?php echo (isset($all_likes[get_the_ID()]) ? $all_likes[get_the_ID()] : 0 ). ' ' . $likes_text_label; ?>">
            <span class="gt3_post_likes__icon fa fa-heart-o"></span>
        </div><?php
        $post_likes = ob_get_clean();
    }else{
        $post_likes = '';
    }

    $out .= '<article class="gt3_portfolio_list__item '.esc_attr($item_class).'">';
        $out .= '<div class="gt3_portfolio_list__image-holder">';
            $out .= '<a href="'.get_permalink().'" class="gt3_portfolio_list__image_link">';
                if (!empty($image_out)) {
                    $out .= $image_out;
                }else{
                    $out .= '<div class="gt3_portfolio_list__image_placeholder"></div>';
                }
            $out .= '</a>';
            wp_enqueue_script('gt3_swipebox_js', get_template_directory_uri() . '/js/swipebox/js/jquery.swipebox.min.js', array(), false, false);
            wp_enqueue_style('gt3_swipebox_style', get_template_directory_uri() . '/js/swipebox/css/swipebox.min.css');
            if (!empty($parameters['portfolio_style']) && $parameters['portfolio_style'] == 'content_on_image') {
                
                $out .= '<div class="gt3_portfolio_list__content">';
                $out .= !empty($post_cats_out) ? '<div class="gt3_portfolio_list__categories"'.(!empty($custom_portfolio_categories_style) ? $custom_portfolio_categories_style : '').'>'.$post_cats_out.'</div>' : '';
                $out .= '<a href="'.get_permalink().'" class="gt3_portfolio_list__title_link">';
                    $out .= '<h3 class="gt3_portfolio_list__title"'.(!empty($custom_portfolio_title_style) ? $custom_portfolio_title_style : '').'>'.get_the_title().'</h3>';
                $out .= '</a>';
                $out .= '<div class="content_on_image_links_block">';
                if (strlen($wp_get_attachment_url) > 0) {
                    $out .= '<a class="swipebox links_block_title" rel="gallery'.esc_html(get_the_title()).'" href="'. esc_url($wp_get_attachment_url) .'" title="'. esc_html(get_the_title()) .'">'.esc_html__('Zoom', 'gt3_wize_core').'</a>';
                }
                $out .= '<a class="links_block_title" href="'.esc_url(get_permalink()).'">'.esc_html__('View More', 'gt3_wize_core').'</a>';
                $out .= '</div>';
            $out .= '</div>';
            }
            $out .= $post_likes;
        $out .= '</div>';
        if (empty($parameters['portfolio_style']) || ( !empty($parameters['portfolio_style']) && $parameters['portfolio_style'] != 'content_on_image') ) {
            $out .= '<div class="gt3_portfolio_list__content">';
                $out .= '<a href="'.get_permalink().'" class="gt3_portfolio_list__title_link">';
                    $out .= '<h3 class="gt3_portfolio_list__title">'.get_the_title().'</h3>';
                $out .= '</a>';
                if (!empty($parameters['portfolio_content']) && $parameters['portfolio_content'] == 'title_exerpt') {
                    $content_letter_count = !empty($parameters['content_letter_count']) && $parameters['content_letter_count'] != '' ? $parameters['content_letter_count'] : '';
                    if (has_excerpt()) {
                        $post_excerpt = get_the_excerpt();
                    } else {
                        $post_excerpt = get_the_content();
                    }
                    
                    $post_excerpt = preg_replace( '~\[[^\]]+\]~', '', $post_excerpt);
                    $post_excerpt_without_tags = strip_tags($post_excerpt);
                    
                    if ($content_letter_count != '') {
                        $post_descr = gt3_smarty_modifier_truncate($post_excerpt_without_tags, $content_letter_count, "...");
                    } else {
                        $post_descr = $post_excerpt_without_tags;
                    }
                    $out .= !empty($post_descr) ? '<div class="gt3_portfolio_list__desc">'.esc_html($post_descr).'</div>' : '';
                    $out .= !empty($post_cats_out) ? '<div class="gt3_portfolio_list__learn_more"><a href="'.esc_url(get_permalink()).'">'.esc_html__('Learn More', 'gt3_wize_core').'</a></div>' : '';
                }else{
                    $out .= !empty($post_cats_out) ? '<div class="gt3_portfolio_list__categories">'.$post_cats_out.'</div>' : '';
                }
                
            $out .= '</div>';
        }
    $out .= '</article>';
    return $out;
}

function gt3_get_practice_item_image_size($count_id){
    switch ($count_id) {
        case 1:
            return 'large_width_height';
            break;
        case 2:
            return 'normal';
            break;
        case 3:
            return 'large_height';
            break;
        case 4:
            return 'normal';
            break;
        case 5:
            return 'large_height';
            break;
        case 6:
            return 'normal';
            break;
        case 7:
            return 'large_width_height';
            break;
        case 8:
            return 'normal';
            break;        
        default:
            return 'normal';
            break;
    }

}