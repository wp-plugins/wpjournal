<?php
if(!class_exists('WPJournal_Template_Settings'))
{
	class WPJournal_Template_Settings
	{
		
		public function __construct()
		{
			
            add_action('admin_init', array(&$this, 'admin_init'));
        	add_action('admin_menu', array(&$this, 'wpjournal_add_menu'));
		} 
		
     
        public function admin_init()
        {
			

        	add_settings_section(
        	    'WPJournal_template-section', 
        	    __('New Journal', 'wp-journal'),
        	    array(&$this, 'settings_section_WPJournal_template'), 
        	    'WPJournal_template'
        	);
            
        }  
        
		
		 
        public function settings_section_WPJournal_template()
        {
           
			echo __('Your online newspaper in few steps.', 'wp-journal');
        }
        

        public function wpjournal_add_menu()
        {
          
        	add_options_page(
        	    'WPJournal Settings', 
        	    'WPJournal', 
        	    'manage_options', 
        	    'WPJournal_template', 
        	    array(&$this, 'wpjournal_plugin_settings_page')
        	);
        }  
    
       
        public function wpjournal_plugin_settings_page()
        {
        	if(!current_user_can('manage_options'))
        	{
        		wp_die(__('You do not have sufficient permissions to access this page.', 'wp-journal'));
        	}
	
        	 
        	include(sprintf("%s/templates/plugin-admin-settings-page.php", dirname(__FILE__)));
        }   
    } 
}  
 
 
define( 'WPJOURNAL_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); 

 
function wpjournal_this_title_refresh() {

	$result = "NO";
    if ( isset($_REQUEST) ) {
		$getpostid	= $_REQUEST['getpostid'];
		$result 		= get_the_title($getpostid); 
	}
	echo   $result;
 	die();
}
 
add_action( 'wp_ajax_wpjournal_this_title_refresh', 'wpjournal_this_title_refresh' );



function wpjournal_new_articles_check() {
	
	$result = "NO";
    if ( isset($_REQUEST) ) {
		$result = get_the_title($getpostid); 
	}
	echo  $result;

 die();
}
 
add_action( 'wp_ajax_wpjournal_new_articles_check', 'wpjournal_new_articles_check' );



function WPJournal_save_data() {
	
/* Save --------------- */
    
	
	if ( isset($_REQUEST) ) {
		
			$post_id_draft		= $_REQUEST['post_id'];
			$Journalname		= $_REQUEST['Journalname'];
			$chosenlayout		= $_REQUEST['chosenlayout'];
			$frontpageorder		= $_REQUEST['frontpageorder'];
			$postArray			= $_REQUEST['postArray'];
			$issue 				= $_REQUEST['issue'];
			$status 				= $_REQUEST['status'];
			$year 		 		= $_REQUEST['year']; 			 
			$info  				= $_REQUEST['info'];		 
			$headerimage 		= $_REQUEST['headerimage'];
			if ($post_id_draft == ''){
				
				/* First SAVE */				
							
				
							$WPJournal_array = array (
								"name"  				=> $Journalname,
								"chosenlayout" 		=> $chosenlayout,
								"frontpageorder" 	=> $frontpageorder,
								"postArray" 		 	=> $postArray
							);
									
				
							update_option( 'WPJournals', $WPJournal_array );
							 
							$post_id = -1;
							$user_id = get_current_user_id();
							$title = $Journalname;
							$post_id = wp_insert_post(
								array(
									'comment_status'	=>	'closed',
									'ping_status'		=>	'closed',
									'post_author'		=>	$user_id ,
									'post_title'		=>	$title,
									'post_status'		=>	$status ,
									'post_type'			=>	'wpjournal'
								));
				
							add_post_meta( $post_id , 'chosenlayout', $chosenlayout ); 
							add_post_meta( $post_id , 'frontpageorder', $frontpageorder ); 
							add_post_meta( $post_id , 'postArray', $postArray ); 
							add_post_meta( $post_id ,'issue', $issue ); 
							add_post_meta( $post_id ,'year',  $year ); 			 
							add_post_meta( $post_id ,'info', $info ); 		 
							add_post_meta( $post_id ,'headerimage', $headerimage ); 
				  
							 foreach ($postArray  as $id_post_menu) {
										update_post_meta( $id_post_menu ,'published_onWPJournal', '1' ); 	
										update_post_meta( $id_post_menu ,'id_Journal', $post_id ); 		
							 }
			 
			 
			 
			 				 
			}else{
		 
			
					$user_id = get_current_user_id();
					$title = $Journalname;
					wp_update_post(array(
							'ID'           		=>	$post_id_draft,
							'comment_status'	=>	'closed',
							'ping_status'		=>	'closed',
							'post_author'		=>	$user_id ,
							'post_title'		=>	$title,
							'post_status'		=>	'publish',
							'post_type'			=>	'wpjournal'
					));
					
					update_post_meta( $post_id_draft ,	'chosenlayout', $chosenlayout ); 
					update_post_meta( $post_id_draft ,	'frontpageorder', $frontpageorder ); 
					update_post_meta( $post_id_draft ,	'postArray', $postArray ); 
					update_post_meta( $post_id_draft ,	'issue', $issue ); 
					update_post_meta( $post_id_draft ,	'year',  $year ); 			 
					update_post_meta( $post_id_draft ,	'info', $info ); 		 
					update_post_meta( $post_id_draft ,	'headerimage', $headerimage ); 
					
					foreach ($postArray  as $id_post_menu) {
						update_post_meta( $id_post_menu ,'published_onWPJournal', '1' ); 	
						update_post_meta( $id_post_menu ,'id_Journal', $post_id_draft ); 		
					}
					
			$post_id = $post_id_draft;
		//	echo  $post_id_draft;
			}
		if ($status == "draft"){
			 $permalink = get_permalink( $post_id );
			 echo json_encode(array('success' => true, 'post_id' => $post_id, 'permalink' => $permalink));
			 
		}else{
			
			// echo "OK";	
		}
		
		
		
	}
 
 die();
}
 
add_action( 'wp_ajax_WPJournal_save_data', 'WPJournal_save_data' );


function WPJournal_remove() {
	
	$result = "NO";
    if ( isset($_REQUEST) ) {
 
         $id_timestamp 			= $_REQUEST['id_timestamp'];
		 $WPJournals_generate  =	 get_option( 'WPJournals_generate');
		 
		function wpjournal_removeElementWithValue($array, $key, $value){
			 foreach($array as $subKey => $subArray){
				  if($subArray[$key] == $value){
					   unset($array[$subKey]);
				  }
			 }
			 return $array;
		}
		$WPJournals_generate = wpjournal_removeElementWithValue($WPJournals_generate,  "0" , $id_timestamp);
		update_option( 'WPJournals_generate', $WPJournals_generate );
		
		$result = "OK";
	}
	
	echo $result;

 die();
}
 
add_action( 'wp_ajax_WPJournal_remove', 'WPJournal_remove' );



 
function WPJournal_refresh_article_area() {
	$result = "NO"; 
    if ( isset($_REQUEST) ) {
		$refresh_postArray  = $_REQUEST['refresh_postArray'];
 
		$args = array(
			'post_type' 		=> 'wpjournal-article',
			'post_status' 	=> 'publish',
			'post__not_in' 	=> $refresh_postArray
		);
		query_posts($args );
		if ( have_posts() ) {
			while ( have_posts() ) : the_post();
				$id = get_the_ID();
				$title = get_the_title();
				 
				$published = get_post_meta( $id, 'published_onWPJournal',true);
				if ($published == '1'){ $class = "hide darker"; }else{ $class = ""; } 
				 
				$url_edit = get_admin_url( null, 'post.php?post='.$id.'&action=edit' );
				echo'<div id="postJournal'.$id.'" class="ui-draggable ui-draggable-handle block-menabo '.$class.'" data-origin="loop-articles"><span class="article-title">'.$title.'</span><br/><a href="'.$url_edit.'"  class="WPJournal-button edit-menabo edit-menabo-article" target="_blank"><span class="dashicons dashicons-edit"></span>edit</a><span id="refresh-id-'.$id.'"></span></div>';	
				
			endwhile;
		}else{
			echo "<h4>No posts were written.</h4>"; 
		
		}
		wp_reset_query(); 
	}	
	wp_die();
}
 
add_action( 'wp_ajax_WPJournal_refresh_article_area', 'WPJournal_refresh_article_area' );


function WPJournal_delete() {
	$result = "NO"; 
    if ( isset($_REQUEST) ) {
         $id_to_be_deleted			= $_REQUEST['id_to_be_deleted'];
		 wp_delete_post( $id_to_be_deleted, true );
		 echo "OK";
	}
	
	 wp_die();
}
add_action( 'wp_ajax_WPJournal_delete', 'WPJournal_delete' );


function WPJournal_edit() {
	$result = "NO"; 
    if ( isset($_REQUEST) ) {
					$id_Journal				= $_REQUEST['post_id_edit'];
					$postArray 				= get_post_meta( $id_Journal, 'postArray',true);
					$chosenpostsArray 				= get_post_meta( $id_Journal, 'postArray',true);
					$chosenlayout			= get_post_meta( $id_Journal, 'chosenlayout',true);
					$frontpageorder 		= get_post_meta( $id_Journal, 'frontpageorder',true);
					$headerimage 			= get_post_meta( $id_Journal, 'headerimage',true);
					$info					= get_post_meta( $id_Journal, 'info',true);
					$anno					= get_post_meta( $id_Journal, 'year',true);
					$numero					= get_post_meta( $id_Journal, 'issue',true);
					$newstitle 				= get_the_title( $id_Journal );
					$permalink 				= get_permalink( $id_Journal ); 
					$status 				= get_post_status ( $id_Journal );
					if ($headerimage  !=''){
							$image_attributes = wp_get_attachment_image_src( $headerimage, 'thumbnail' );
					} 
			 $recreate_summary ='';
			 foreach ($frontpageorder as $order_post) {
	  				$displacement_array [$order_post['area']] = $order_post['id_post']; 
					$retrievetitle = get_the_title($order_post['id_post']);
					
					$url_edit = get_admin_url( null, 'post.php?post='.$order_post['id_post'].'&action=edit' );
			 
					$post_type = get_post_type( $order_post['id_post'] );
					switch ($post_type){
						case "post":
							$data_origin = "loop-posts";
						break;
						case "wpjournal-article":
							$data_origin = "loop-articles";
						break;		
						
					}
					
					$recreate_layout[$order_post['area']] = '<div id="postJournal'.$order_post['id_post'].'" class="ui-draggable ui-draggable-handle block-menabo correct ui-draggable-disabled ui-state-disabled" data-origin="'.$data_origin.'" aria-disabled="true" style="position: relative; z-index: 10; left: 0px; top: 0px;"><span class="article-title">'.$retrievetitle.'</span><br><a href="'.$url_edit.'" class="edit-menabo edit-menabo-post WPJournal-button" target="_blank"><span class="dashicons dashicons-edit"></span>edit</a><span id="refresh-id-'.$order_post['id_post'].'"></span><a class="WPJournal-button btnDels"><span class=" dashicons dashicons-redo"></span>undo</a></div>';
					 
					if(($key = array_search($order_post['id_post'], $postArray)) !== false) {
    						unset($postArray[$key]);
					}
					
					
					 
				}
			$count = 0;
			foreach ($postArray as $summary_post_id) {
					
					
					$post_type = get_post_type( $summary_post_id );
					$retrievetitle = get_the_title($summary_post_id);
					switch ($post_type){
						case "post":
							$data_origin = "posts";
						break;
						case "wpjournal-article":
							$data_origin = "articles";
						break;		
						
					}
					$count++;
					$recreate_summary .= '<div id="id_article_selected'.$summary_post_id.'" class="ui-draggable ui-draggable-order-article sort-block-menabo single-inside-articlecorrect ui-draggable-disabled ui-state-disabled" data-origin="'.$data_origin.'" style="position: relative; display: block; z-index: '.$count.'; left: 0px; top: 0px;" aria-disabled="true">'.$retrievetitle.'<a class="WPJournal-button btnBack"><span class=" dashicons dashicons-redo"></span></a></div>';
					 
			 }
			 
			 
			 
			 
					 echo json_encode(
					 		array(	'success' 			=> true, 
									'post_id' 			=> $id_Journal, 
									'newstitle' 		=> $newstitle,
									'chosenlayout'		=> $chosenlayout, 
									'postArray' 		=> $postArray,
									'chosenpostsArray'	=> $chosenpostsArray,
									'frontpageorder' 	=> $frontpageorder,
									'displacement_array'=> $displacement_array,
									'recreate_layout' 	=> $recreate_layout,
									'recreate_summary' 	=> $recreate_summary,
									'headerimage' 		=> $headerimage, 	
									'image_attributes' 	=> $image_attributes[0], 
									'info' 				=> $info	,
									'anno' 				=> $anno	,
									'numero' 			=> $numero,
									'permalink' 		=> $permalink,
									'status' 			=> $status
									) 
							);
	}
	
	wp_die();
}
add_action( 'wp_ajax_WPJournal_edit', 'WPJournal_edit' );

function WPJournal_delete_drafts() {
  	
			$args = array(
			'numberposts' => -1,
			'post_type' =>'wpjournal',
			'post_status' => 'draft'
		);
		$posts = get_posts( $args );
		if (is_array($posts)) {
		   foreach ($posts as $post) {
		// what you want to do;
			   wp_delete_post( $post->ID, true);
			   echo "Deleted Post: ".$post->title."\r\n";
		   }
		}
	 wp_die();
}
add_action( 'wp_ajax_WPJournal_delete_drafts', 'WPJournal_delete_drafts' );

 
function wpjournal_hidemenu_scripts($hook) {
 	remove_menu_page( 'edit.php?post_type=wpjournal' );
	if( $hook != 'nav-menus.php' ) 
		return;
	wp_enqueue_script( 'hidemenu-js', plugins_url( 'js/hidemenu.js' , dirname( plugin_basename( __FILE__ ) ) ) );
}
add_action('admin_enqueue_scripts', 'wpjournal_hidemenu_scripts');
 
 
function wpjournal_load_textdomain() {
	load_plugin_textdomain( 'wp-journal', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' ); 
}
add_action( 'plugins_loaded', 'wpjournal_load_textdomain' );
 




?>