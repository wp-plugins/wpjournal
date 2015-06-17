<?php
/*
Plugin Name: WPJournal
Plugin URI:  
Description: Create immediatly your online journal as a WP spin-off. Choose a layout and publish your articles in a ready to print Journal-like template. 
Version: 1.1
Author: Mediabeta
Author URI: http://www.mediabeta.com
License: GPL2
*/

 
 

if(!class_exists('WPJournal_Template'))
{
	class WPJournal_Template
	{
		 
		public function __construct()
		{
			 
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));
			$WPJournal_Template_Settings = new WPJournal_Template_Settings();
 
			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
		}  

 
		public static function activate()
		{	 
		}  

 
		public static function deactivate()
		{ 
		}  

		 
		function plugin_settings_link($links)
		{
			$settings_link = '<a href="options-general.php?page=WPJournal_template">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}


	}  
}  

if(class_exists('WPJournal_Template'))
{
	 
	register_activation_hook(__FILE__, array('WPJournal_Template', 'activate'));
	register_deactivation_hook(__FILE__, array('WPJournal_Template', 'deactivate'));

	$WPJournal_template = new WPJournal_Template();

}


 
function WPJournal_admin_enqueue_scripts() {
  
	if ( ! did_action( 'wp_enqueue_media' ) )
	
	
		wp_enqueue_media();
	 	wp_enqueue_script('jquery');
		wp_enqueue_script('media-upload');   
		wp_enqueue_script('thickbox'); 		 
		wp_enqueue_script('jquery-ui-sortable' );
		wp_enqueue_script('jquery-ui-draggable' );
		wp_enqueue_script('jquery-ui-droppable' );
		wp_register_script(
			'WPJournal-plugin-js',
		 	plugins_url('js/WPJournal-plugin_admin_script.js', __FILE__), 
			array('jquery','media-upload','thickbox'),'',true);
		wp_enqueue_script('WPJournal-plugin-js');	
		wp_register_style('WPJournal-admin-style', plugins_url('css/WPJournal-plugin_style.css', __FILE__) );
		wp_enqueue_style('WPJournal-admin-style' );
		wp_enqueue_script( 
			'wpjournal_move-it', 
			plugins_url('js/WPJournal-moveit.js', __FILE__ ),  
				array( 'jquery-ui-sortable', 'jquery-ui-droppable', 'jquery-ui-draggable', 'jquery' )  );
    
}
add_action('admin_enqueue_scripts', 'WPJournal_admin_enqueue_scripts');


 
function WPJournal_scripts() {
	wp_enqueue_script(
		'script-WPJournal-plugin',
		plugins_url('js/WPJournal-public_script.js', __FILE__ ),  
		array( 'jquery' )
	);
 
}

add_action( 'wp_enqueue_scripts', 'WPJournal_scripts' );  

 

add_filter( 'template_include', 'WPJournal_custom_menabo' );
function WPJournal_custom_menabo( $menabo )
{
		if( isset( $_GET['mod']) && 'yes' == $_GET['mod'] ){
			 $menabo = plugin_dir_path( __FILE__ ) . 'WPJournal-menabo.php';
			
		 
		}
		if ( is_singular( 'wpjournal' ) )  {
			$menabo = plugin_dir_path( __FILE__ ) . 'WPJournal-menabo.php';
		
		
				
		} 
		if ( is_singular( 'wpjournal-article' ) )  {
			$menabo = plugin_dir_path( __FILE__ ) . 'WPJournal-internalpage.php';
		}
		return $menabo;
}

add_action( 'init', 'create_post_type_wpjournal' );
function create_post_type_wpjournal() {
	  register_post_type( 'wpjournal',
		array(
		  'labels' => array(
			'name' => __( 'Journals' , 'wp-journal'),
			'singular_name' => __( 'Journal' , 'wp-journal')
		  ),
		  'menu_position' => 2,
		  'supports' => array('title','thumbnail','trackbacks','custom-fields','comments','revisions','page-attributes'),
		  'public' => true,
		  'hierarchical' => false,
		  '_builtin' => false,
		  'capability_type' => 'post',
		  'rewrite' => array('slug' => 'wpjournal','with_front' => FALSE)
	
		));
  	flush_rewrite_rules();
}



add_action( 'init', 'create_post_type_art_wpjournal' );
function create_post_type_art_wpjournal() {
	  register_post_type( 'wpjournal-article',
		array(
		  'labels' => array(
			'name' 					=> __( 'Journal Posts' , 'wp-journal'),
			'singular_name' 			=> __( 'Journal Post' , 'wp-journal'),
			'all_items'           	=> __( 'All Posts', 'wp-journal'),
			'view_item'           	=> __( 'View Posts' , 'wp-journal'),
			'add_new_item'        	=> __( 'Add New' , 'wp-journal'),			
			'add_new'             	=> __( 'Add New', 'wp-journal'),	
			'edit_item'           	=> __( 'Edit' , 'wp-journal'),
			'update_item'         	=> __( 'Update' , 'wp-journal'),
			'search_items'        	=> __( 'Search' , 'wp-journal'),
			'not_found'           	=> __( 'Not found', 'wp-journal'),
			'not_found_in_trash'  	=> __( 'Not found in Trash' , 'wp-journal')
		  ),
		  'menu_position' => 2,
		  'supports' => array('title','thumbnail','editor'),
		  'public' => true,
		  'hierarchical' => false,
		  '_builtin' => false,
		  'menu_icon'           => 'dashicons-media-spreadsheet',
		  'capability_type' => 'post',
		  'rewrite' => array('slug' => 'wpjournal-article','with_front' => FALSE)
	
		));
  	flush_rewrite_rules();
}

 
function remove_those_menu_items( $menu_order ){
		global $menu;
		
		foreach ( $menu as $mkey => $m ) {
		$key = array_search( 'edit.php?post_type=wpjournal', $m );
		
		if ( $key )
			unset( $menu[$mkey] );
		}
	return $menu_order;
}
add_filter( 'menu_order', 'remove_those_menu_items' ) ;
	
add_action("admin_init", "wpjournal_admin_init");

function wpjournal_admin_init(){
	add_meta_box("NeoAuthor-meta", __('Author', 'wp-journal') , "wpjournal_meta_options", "wpjournal-article", "side", "high");
}  

function wpjournal_meta_options(){
	global $post;
	$custom = get_post_custom($post->ID);
	$authorname = $custom["authorname"][0];
	?><input name="authorname" value="<?php echo $authorname; ?>"  style="width:100%;" /><?php
}  

add_action('save_post', 'wpjournal_save_authorname');
function wpjournal_save_authorname(){
	global $post;
	update_post_meta($post->ID, "authorname", $_POST["authorname"]);
}


function wpjournal_link_to_manage_Journals() {
    global $pagenow ,$post;

    if( $post->post_type == 'wpjournal-article' && $pagenow == 'edit.php' ) {

        $output = '<p class="pressthis">';
        $output .= '<a href="'.get_admin_url( '', "/options-general.php?page=WPJournal_template" ).'"   style="padding:8px; cursor:pointer;" ><i class="dashicons dashicons-admin-settings"></i>'. __( "Gestisci giornalini" ,"wp-journal").'</a>' ; 
        $output .= '</p>';

        echo $output;
    }
}
add_action('admin_notices','wpjournal_link_to_manage_Journals');


function wpjournal_public_js(){
	if ( is_singular( 'wpjournal' )  || is_singular( 'wpjournal-article' ) )  {
		wp_enqueue_script('wpjournal_bootstrap', WPJOURNAL_PLUGIN_URL . 'js/bootstrap.min.js',array( 'jquery' ));
		wp_enqueue_script('wpjournal_backstretch', WPJOURNAL_PLUGIN_URL . 'js/jquery.backstretch.min.js',array( 'jquery' ));
		wp_enqueue_script('wpjournal_quickfit', WPJOURNAL_PLUGIN_URL . 'js/jquery.quickfit.js',array( 'jquery' ));
		wp_enqueue_script('wpjournal_colorbox-min', WPJOURNAL_PLUGIN_URL . 'js/jquery.colorbox-min.js',array( 'jquery' ));
		wp_enqueue_script('wpjournal_public_script', WPJOURNAL_PLUGIN_URL . 'js/WPJournal-public_script.js',array( 'jquery' ),'',true);
	}
}
add_action('wp_enqueue_scripts', 'wpjournal_public_js');

 
function wpjournal_plugin_styles() {
	if ( is_singular( 'wpjournal' )  || is_singular( 'wpjournal-article' ) )  {
		wp_register_style( 'wpjournal_style_bootstrap',  WPJOURNAL_PLUGIN_URL . 'css/bootstrap.min.css');
		wp_enqueue_style ( 'wpjournal_style_bootstrap' );
		wp_register_style( 'wpjournal_plugin_public_style',   WPJOURNAL_PLUGIN_URL . 'css/WPJournal-plugin_public_style.css');
		wp_enqueue_style ( 'wpjournal_plugin_public_style');
		wp_register_style( 'wpjournal_style_colorbox',   WPJOURNAL_PLUGIN_URL . 'css/colorbox.css');
		wp_enqueue_style ( 'wpjournal_style_colorbox');
	}
}
add_action( 'wp_enqueue_scripts', 'wpjournal_plugin_styles' );

function wpjournal_add_google_fonts() {
	if ( is_singular( 'wpjournal' )  || is_singular( 'wpjournal-article' ) )  {
				wp_register_style('wpjournal_googleFonts', 'http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic');
				wp_enqueue_style( 'wpjournal_googleFonts');	
	}
}
add_action('wp_print_styles', 'wpjournal_add_google_fonts');

?>