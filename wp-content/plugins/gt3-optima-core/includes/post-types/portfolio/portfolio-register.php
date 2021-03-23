<?php


/**
* Portfolio Register
*/
class gt3PortfolioRegister{

	public $cpt;
	public $dest_taxonomy;
    private $tag_taxonomy;
	private $slug;
	
	function __construct(){
		$this->cpt = 'portfolio';
		$this->taxonomy = 'portfolio-category';
        $this->tag = 'portfolio-tag';
		$this->slug =  'portfolio';
        if (function_exists('gt3_option')) {
            $slug_option = gt3_option('portfolio_slug');
        }else{
            $slug_option = '';
        }

        if (empty($slug_option)) {
            $this->slug = 'portfolio';
        }else{
            $this->slug = sanitize_title( $slug_option );
        }
	}

	public function register(){
		$this->registerPostType();
		$this->registerTax();         
	}

	private function registerPostType(){

        register_post_type($this->cpt,
            array(
                'labels' 		=> array(
                    'name' 				=> __('Portfolio','gt3_core' ),
                    'singular_name' 	=> __('Portfolio','gt3_core' ),
                    'add_item'			=> __('New Portfolio','gt3_core'),
                    'add_new_item' 		=> __('Add New Portfolio','gt3_core'),
                    'edit_item' 		=> __('Edit Portfolio','gt3_core')
                ),
                'public'		=>	true,
                'has_archive' => true,
                'rewrite' 		=> 	array('slug' => $this->slug),
                'menu_position' => 	5,
                'show_ui' => true,
                'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes','comments'),
                'menu_icon'  =>  'dashicons-format-gallery'
            )
        );

	}

	private function registerTax() {
        $labels = array(
            'name' => __( 'Portfolio Categories', 'gt3_core' ),
            'singular_name' => __( 'Portfolio Category', 'gt3_core' ),
            'search_items' =>  __( 'Search Portfolio Categories','gt3_core' ),
            'all_items' => __( 'All Portfolio Categories','gt3_core' ),
            'parent_item' => __( 'Parent Portfolio Category','gt3_core' ),
            'parent_item_colon' => __( 'Parent Portfolio Category:','gt3_core' ),
            'edit_item' => __( 'Edit Portfolio Category','gt3_core' ),
            'update_item' => __( 'Update Portfolio Category','gt3_core' ),
            'add_new_item' => __( 'Add New Portfolio Category','gt3_core' ),
            'new_item_name' => __( 'New Portfolio Category Name','gt3_core' ),
            'menu_name' => __( 'Categories','gt3_core' ),
        );

        register_taxonomy($this->taxonomy, array($this->cpt), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => $this->slug.__('-category','gt3_core') ),
        ));

        $labels = array(
            'name' => __( 'Portfolio Tags', 'gt3_core' ),
            'singular_name' => __( 'Portfolio Tag', 'gt3_core' ),
            'search_items' =>  __( 'Search Portfolio Tags','gt3_core' ),
            'all_items' => __( 'All Portfolio Tags','gt3_core' ),
            'parent_item_colon' => __( 'Parent Portfolio Tag:','gt3_core' ),
            'edit_item' => __( 'Edit Portfolio Tag','gt3_core' ),
            'update_item' => __( 'Update Portfolio Tag','gt3_core' ),
            'add_new_item' => __( 'Add New Portfolio Tag','gt3_core' ),
            'new_item_name' => __( 'New Portfolio Tag Name','gt3_core' ),
            'menu_name' => __( 'Tags','gt3_core' ),
        );

        register_taxonomy($this->tag, array($this->cpt), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => $this->slug.__('-tag','gt3_core') ),
        ));
    }

    public function registerSingleTemplate($single){
        global $post;
        if($post->post_type == $this->cpt) {
            if(!file_exists(get_template_directory().'/single-'.$this->cpt.'.php')) {
                return plugin_dir_path( dirname( __FILE__ ) ) .'portfolio/templates/single-'.$this->cpt.'.php';
            }
        }
        return $single;  
    }

    public function registerArchiveTemplate($archive){
        global $post;
        if($post->post_type == $this->cpt && is_archive()) {
            if(!file_exists(get_template_directory().'/archive-'.$this->cpt.'.php')) {
                return plugin_dir_path( dirname( __FILE__ ) ) .'portfolio/templates/archive-'.$this->cpt.'.php';
            }
        }

        return $archive;  
    }

}
?>