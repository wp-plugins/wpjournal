<div class="wrap">
	<p>
    	<h2 class="WPJournal_logo_WPJournal"><span class="wpjournal_plugin_name">WP Journal </span><span class="wpjournal_plugin_motto">
        <?php echo __( 'Manage your Pubblications' , 'wp-journal'); ?></span></h2>  
 	</p>

<div id="blocco_tab">
 
	<div id="loading-elenco" >
    	<div id="loading-elenco-im"></div>
	</div>  
    
<div id="tab-elenco" style="display:none;">


	<dl class="neoaccordion">
	
    
 


 <dt class="neoaccordion__title active">
 		<?php echo __( 'Published Journals' , 'wp-journal'); ?>
 			 (<?php   echo $count_posts = wp_count_posts( 'wpjournal' )->publish; ;   ?>)</dt>
  <dd class="neoaccordion__content" id="contenuti_pg_1">
  
  
  <div class="grid whole wpjournal_extra_margin" > 
  <div class="advice-small" ><?php echo __( 'Journal Posts written' , 'wp-journal'); ?> 
  		<span class="numberology"><?php   echo $count_posts = wp_count_posts( 'wpjournal-article' )->publish;     ?></span> 
        <a href='<?php   echo admin_url( 'post-new.php?post_type=wpjournal-article');?>'  class="add-journal-post" >
        	<?php echo __( 'Write a new Journal Post' , 'wp-journal'); ?>
        </a>
        </div>
  <h3><?php echo __( 'Published Journals' , 'wp-journal'); ?> (<?php   echo $count_posts = wp_count_posts( 'wpjournal' )->publish; ;   ?>) 
  		<button class="button nessuna_WPJournal_aggiungi" style="float:right; font-weight:300">
			<?php echo __( 'Add a new Journal' , 'wp-journal'); ?>
        </button> 
   </h3> 
  <hr/>
 <div class="grid"> 
  <?php 
// Published Journals   
$type = 'wpjournal';
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1
  );
 
$WPJournal_query = new WP_Query($args);
if( $WPJournal_query->have_posts() ) {
 while ($WPJournal_query->have_posts()){ 
    $WPJournal_query->the_post();    ?>
    <div class="unit one-quarter"  style="text-align:center;">
	 <div >
     <img src="<?php echo WPJOURNAL_PLUGIN_URL . 'img/WPJournal_layout_1.png' ; ?>"><br/> 
    	<a href="<?php the_permalink() ?>" rel="bookmark" target="_blank" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
        <?php 
		
         $info=  get_post_meta( get_the_ID(), 'info',true);
 $anno=  get_post_meta( get_the_ID(), 'year',true);
 $numero=  get_post_meta( get_the_ID(), 'issue',true);
 echo "<br/><span style='font-size:75%; text-transform:uppercase'>".$anno." <b>".$numero."</b>&nbsp;</span>"; ?>
    <br / > 
     <a class="WPJournal-button WPJournal_edit" id="post_<?php echo get_the_ID() ;?>"><span class="dashicons dashicons-edit"></span><?php echo __( 'Edit' , 'wp-journal'); ?> </a>
    <a class="WPJournal-button WPJournal_delete" id="<?php echo get_the_ID() ;?>"><span class="dashicons dashicons-trash"></span>
    	<?php echo __( 'Delete' , 'wp-journal'); ?> 
    </a>
    </div> 
    </div>
    <?php 
 	}
  }else{
	
	?>
    <div class="grid whole"  style="margin:1.2em;"> 
    <h3><?php echo __( 'No Journal was published' , 'wp-journal'); ?></h3> 
            <p><?php echo __( 'Here you can manage all yours Journals' , 'wp-journal'); ?></p> 
     </div>       
    <?php
 }  

wp_reset_query();   


// Drafts   
$type = 'wpjournal';
$args=array(
  'post_type' => $type,
  'post_status' => 'draft',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1
  );
 
$WPJournal_query2 = new WP_Query($args);
if( $WPJournal_query2->have_posts() ) { ?>
</div>
 <div class="grid"> 
  <h3><?php echo __( 'Drafts' , 'wp-journal'); ?> (<?php   echo $count_posts = wp_count_posts( 'wpjournal' )->draft; ;   ?>) 
  		 
    
     		<button class="button WPJournal_delete_drafts" style="float:right; font-weight:300">
			<?php echo __( 'Delete drafts' , 'wp-journal'); ?>
        </button> 
  </h3>
  <hr/>
<?php	
 while ($WPJournal_query2->have_posts()){ 
    $WPJournal_query2->the_post();    ?>
    <div class="unit one-quarter"  style="text-align:center;">
	 <div>
     <img src="<?php echo WPJOURNAL_PLUGIN_URL . 'img/WPJournal_layout_1.png' ; ?>"><br/> 
    	<?php the_title(); ?><br/>
        <?php 
		
         $info=  get_post_meta( get_the_ID(), 'info',true);
 $anno=  get_post_meta( get_the_ID(), 'year',true);
 $numero=  get_post_meta( get_the_ID(), 'issue',true);
 
 if (trim($anno)!='' || trim($numero) !='')
 echo "<span style='font-size:75%; text-transform:uppercase'>".$anno." <b>".$numero."</b>&nbsp;</span><br/>"; ?>
    
       <a class="WPJournal-button WPJournal_edit" id="post_<?php echo get_the_ID() ;?>"><span class="dashicons dashicons-edit"></span><?php echo __( 'Edit' , 'wp-journal'); ?> </a>
        
    <a class="WPJournal-button " href="<?php the_permalink() ?>" rel="bookmark" target="_blank" title="Permanent Link to <?php the_title_attribute(); ?>"><span class="dashicons dashicons-welcome-view-site"></span></a>
    <a class="WPJournal-button WPJournal_delete" id="<?php echo get_the_ID() ;?>"><span class="dashicons dashicons-trash"></span>
    	<?php echo __( 'Delete' , 'wp-journal'); ?> 
    </a>
    </div> 
    </div>
    <?php 
 	}
  }
 wp_reset_query();   
?>
  </div>
  </div>
  <div class="grid whole"  style="margin:1.2em;"> 
 
 
   <hr/> 
            <button class="button nessuna_WPJournal_aggiungi">
				<?php echo __( 'Add a new Journal' , 'wp-journal'); ?>
            </button> 
 </div>
  	
 </dd>
  <dt class="neoaccordion__title" id="container_wizard"><?php echo __( 'Add a Journal' , 'wp-journal'); ?></dt>
  <dd class="neoaccordion__content" id="contenuti_pg_2" >
    <div id="block_cancel">
  		<div id="area_cancel">
        		<a class="cancel-new-Journal">
				<?php echo __( 'Cancel' , 'wp-journal'); ?><div class="dashicons dashicons-no remove"></div>
                </a>
         </div>
    </div>    
    <div class="grid">
 
           
            <div class="unit one-quarter WPJournal-step active custom_selected" id="uno">
               <span class="numberology">1</span>
               <?php echo __( 'Choose the title' , 'wp-journal'); ?>  
            </div>
            <div class="unit one-quarter WPJournal-step" id="due">  
              <span class="numberology">2</span>
              <?php echo __( 'Select frontpage layout' , 'wp-journal'); ?>  
            </div>
            <div class="unit one-quarter WPJournal-step" id="tre"> 
             <span class="numberology">3</span>
             	 <?php echo __( 'Place posts in frontpage' , 'wp-journal'); ?>   
            </div>
            <div class="unit one-quarter WPJournal-step" id="quattro"> 
             <span class="numberology">4</span>
             	<?php echo __( 'Complete pubblication' , 'wp-journal'); ?>   
            </div>
          
    </div>
  <div class="overflow-scrolling grid whole wpjournal_margin " >  
  <div id="area_alert"></div>
 
  			    
    <form method="post" action="#" id="WPJournal_form" > 
<!-- First Step --->     
    <div id="base-settings" class="wizard_WPjournal uno">
      <div id="name_WPJournal" >
      
        <div class="grid">
   		<h3><?php echo __( 'Your new Journal' , 'wp-journal'); ?></h3>
  		<hr/>

        <div class="unit three-quarters">
        
        <table width="90%" border="0" cellspacing="1" cellpadding="1">
          <tbody>
            <tr>
              <td><label><?php echo __( 'Journal Name' , 'wp-journal'); ?>: </label><br/></td>
              <td><p><input type="text" name="nome_WPJournal_nuova_WPJournal" id="nome_WPJournal_nuova_WPJournal" class="nome_WPJournal" value="" placeholder="<?php echo __( 'Journal Name' , 'wp-journal'); ?>">*</p></td>
            </tr>
            <tr>
              <td><label><?php echo __( 'Issue' , 'wp-journal'); ?>: </label><br/></td>
              <td><p><input type="text" name="numero_WPJournal_nuova_WPJournal" id="numero_WPJournal_nuova_WPJournal" class="numero_WPJournal" value="" placeholder="<?php echo __( 'Issue' , 'wp-journal'); ?>"></p>
                 </td>
            </tr>
            <tr>
              <td><label><?php echo __( 'Year' , 'wp-journal'); ?>: </label> </td>
              <td><p><input type="text" name="anno_WPJournal_nuova_WPJournal" id="anno_WPJournal_nuova_WPJournal" class="anno_WPJournal" value="" placeholder="<?php echo __( 'Year' , 'wp-journal'); ?>"> <?php echo __( 'eg:' , 'wp-journal'); ?> <i><?php echo __( 'Year XII' , 'wp-journal'); ?></i></p>
              </td>
            </tr>
            <tr>
              <td><label><?php echo __( 'Other notes' , 'wp-journal'); ?>:<br/></label></td>
              <td>
              	<p><input type="text" name="voci_WPJournal_nuova_WPJournal" id="voci_WPJournal_nuova_WPJournal" class="voci_WPJournal" value="" placeholder="<?php echo __( 'Other notes' , 'wp-journal'); ?>"> <?php echo __( 'eg:' , 'wp-journal'); ?> 
                	<i><?php echo __( 'September - Monthly by the Proudly Team' , 'wp-journal'); ?></i>
                    </p>
        </td>
            </tr>
          </tbody>
        </table>
         
         
        </div>
         <div class="unit one-quarter">
         
     			 <div id="dest_new"></div>
     			<input id="nuova_new" class="button WPJournal_upload" type="button" value="<?php echo __( 'Insert your logo in header' , 'wp-journal'); ?>">
       			
      </div>
         
 
         </div>
 <div id="bottom_step_uno">
 <hr/>
 <div class="grid" style="text-align:right;">
 	<button class="button" id="nuova_WPJournal"><?php echo __( 'Continue' , 'wp-journal'); ?></button>
 </div>
 
 </div>
 </div>
 
 

  </div>
<!-- END First Step --->  
<!-- Second Step --->
  <div id="nuovo_layout" class="wizard_WPjournal due">
  
  <h3><?php echo __( 'Choose a layout for the front page' , 'wp-journal'); ?></h3>
  <hr/>
  <section class="demo">
 
 
  
  <div class="grid">
      <div class="unit one-quarter">
         <div  id="layout1"  class="block_layout"> 
        	<img src="<?php echo WPJOURNAL_PLUGIN_URL . 'img/WPJournal_layout_1.png'; ?>">
             <br/>
            Layout 1 <br/>
            <?php echo __( 'Two columns + three columns' , 'wp-journal'); ?>
          </div>
      </div>
      <div class="unit one-quarter">
          <div class="block_layout_not_avaiable"> 
        			<img src="<?php echo WPJOURNAL_PLUGIN_URL . 'img/WPJournal_layout_soon.png'; ?>">
         </div>
      </div>
      <div class="unit one-quarter">
          <div class="block_layout_not_avaiable">  
      	<img src="<?php echo WPJOURNAL_PLUGIN_URL . 'img/WPJournal_layout_soon.png'; ?>">
        </div>
      </div>
      <div class="unit one-quarter">
          <div class="block_layout_not_avaiable"> 
        	<img src="<?php echo WPJOURNAL_PLUGIN_URL . 'img/WPJournal_layout_soon.png'; ?>">
        </div>
      </div>
    </div>
    </section>
  
  </div>
<!-- END Second Step --->  
<!-- Third Step --->   
  <div id="layout_scelto" class="tre wizard_WPjournal">
  
  <div id="ancora"></div>
  
  <h3><?php echo __( 'Place the posts in layout areas' , 'wp-journal'); ?></h3>
  <hr/>
 
  
	<input type="hidden" id="chosenlayout" name="chosenlayout" value="" />
 	<input type="hidden" id="frontpage-order" name="frontpage-order"  value="" /> 
 
  
   
 

 
  <div class="grid">
     
	<div class="unit half" id="postJournalSlots" >
    
    
      <input type="hidden" id="hidden_id_WPjournal"  name="hidden_id_WPjournal" value="" />
      <input type="hidden" id="status_WPjournal"  name="status_WPjournal" value="" />
      <input type="hidden" id="hidden_url_draft" name="hidden_url_draft" value="" /> 
      <div id="area_load">
      <div class="grid">
      	<?php echo __( 'Loading...' , 'wp-journal');?>
      </div>
      </div>
        
	<div id="area_check">
      <div class="grid"> 
      	<div class="unit whole">
        	<span id="WPJournal-advise">
         	<h3><?php echo __( 'Frontpage complete!' , 'wp-journal');?></h3> 
            <p><?php echo __( 'and saved as draft' , 'wp-journal');?> </p>
            </span>
            <span id="WPJournal-edit-advise">
            <p class="WPJournal-advise-text"><?php echo __( 'Frontpage and summary are automatically updated' , 'wp-journal');?>!<br/>
            <?php echo __( 'Click on "Complete pubblication" to re-edit your summary then on "Update"' , 'wp-journal');?> </p>
            </span>
        </div> 
      </div>
      <div class="grid">
      <div class="unit one-third">
         <a id="wpjournal-draft"  class="WPJournal-button"><span class="dashicons dashicons-welcome-view-site"></span><?php echo __( 'Preview' , 'wp-journal');?>
         </a>  
 
      </div>
      <div class="unit two-thirds" style="text-align:right;">
          <a class='WPJournal-button inside-articles'><span class="dashicons dashicons-yes"></span><?php echo __( 'Complete pubblication' , 'wp-journal');?>
          </a> 
      </div>
    </div>
        
        	
	</div>
       
        
     <h4><?php echo __( 'LAYOUT CHOSEN' , 'wp-journal'); ?></h4>
     <i><?php echo __( 'Drag and drop the posts in the boxes below' , 'wp-journal'); ?></i>
     <div class="grid">
     		<div class="unit three-quarters padder">
				<div id="PrimoPiano" class="area-drop ui-droppable ">
                <?php echo __( 'Featured article' , 'wp-journal'); ?>
                </div>
            </div>
            <div class="unit one-quarter padder">
				<div id="area2" class="area-drop ui-droppable "><?php echo __( 'area' , 'wp-journal'); ?> 2</div>
            </div>
      </div>  
       <div class="grid"> 
       		<div class="unit one-third padder">   
			<div id="area3" class="area-drop ui-droppable"><?php echo __( 'area' , 'wp-journal'); ?> 3</div>
            </div>
            <div class="unit one-third padder"> 
			<div id="area4" class="area-drop ui-droppable"><?php echo __( 'area' , 'wp-journal'); ?> 4</div>
            </div>
            <div class="unit one-third padder"> 
			<div id="area5" class="area-drop ui-droppable"><?php echo __( 'area' , 'wp-journal'); ?> 5</div>
            </div>
       </div>    
       
            	  <span id='area_small_warning'></span> 	
        </div>
                
                
        
        
    
      
      
      
      <div class="postJournalPile unit one-quarter" id="loop-articles">
      
         <h4><?php echo __( 'Journal POSTS' , 'wp-journal'); ?></h4>
         <div class="show-published-articles"><span class="dashicons dashicons-visibility"></span> 
         		<?php echo __( 'Show published posts' , 'wp-journal'); ?>
         	</div>
         <span id="article-area">
         <?php
		 
		 $args = array(
  			'post_type' => 'wpjournal-article',
			 'post_status' => 'publish' 
  		);
			query_posts($args );
 		if ( have_posts() ) {
			while ( have_posts() ) : the_post();
				$id = get_the_ID();
				$title = get_the_title();
				 
				$published = get_post_meta( $id, 'published_onWPJournal',true);
 				if ($published == '1'){ $class = "hide darker"; }else{ $class = ""; } 
				 
				$url_edit = get_admin_url( null, 'post.php?post='.$id.'&action=edit' );
				echo'<div id="postJournal'.$id.'" class="ui-draggable ui-draggable-handle block-menabo '.$class.'" data-origin="loop-articles"><span class="article-title">'.$title.'</span><br/><a href="'.$url_edit.'"  class="WPJournal-button edit-menabo edit-menabo-article" target="_blank"><span class="dashicons dashicons-edit"></span>edit</a><span id="refresh-id-'.$id.' "></span></div>';	
				
		endwhile;
 }else{
			?><h4><?php echo __( 'No article was added' , 'wp-journal'); ?></h4>
            <?php 
			 
		
	 
	 
 }
			wp_reset_query(); 
			
			
	
		
		
	  ?>
      </span>
      <p>
       <a href="<?php echo admin_url( 'post-new.php?post_type=wpjournal-article');?>"  id='add-menabo-article' target='_blank'>
       
       		<?php echo __( 'Write' , 'wp-journal'); ?></a> 
      <?php echo __( 'new posts' , 'wp-journal'); ?><p>
       
       <span id="old-article-area">
      
      </span>
      <span id="new-article-area">
      
      </span>
         
         
      </div>
      <div class="postJournalPile unit one-quarter" id="loop-posts">
        <h4><?php echo __( 'LOOP POSTS' , 'wp-journal'); ?></h4>
        
			<ul>
 
    
         <?php  
		 $args = array(
  'post_type' => 'post',
   'post_status' => 'publish' 
  
  );

 
query_posts($args );
 
while ( have_posts() ) : the_post();

				$id = get_the_ID();
				$title = get_the_title();
				$url_edit = get_admin_url( null, 'post.php?post='.$id.'&action=edit' );
				$published = get_post_meta( $id, 'published_onWPJournal',true);
 			 
				echo'<div id="postJournal'.$id.'" class="ui-draggable ui-draggable-handle block-menabo " data-origin="loop-posts"><span class="article-title">'.$title.'</span><br/><a href="'.$url_edit.'" class="edit-menabo edit-menabo-post WPJournal-button" target="_blank"><span class="dashicons dashicons-edit"></span>edit</a><span id="refresh-id-'.$id.'"></span></div>';	
	 
endwhile;

 
wp_reset_query();
 
?>

</ul>
      </div>
      
      
      
       

      
      
    </div>
     <div id="bottom_step_tre">

    <div id="next-inside-pages">
    <hr/>
      		 <button class="button inside-articles"><?php echo __( 'Complete pubblication' , 'wp-journal');?></button>
     </div>
    
   </div>  
  
  </div>
<!-- END Third Step ---> 
<!-- Fourth Step --->  
  <div id="inside-pages" class="grid quattro wizard_WPjournal" >
 
  <h3><?php echo __( 'Manage all posts - Summary' , 'wp-journal'); ?></h3>
  <hr/>
  
  
  
      		 <div id="published-articles" class="unit one-third">
             	<h4><?php echo __( 'POST ORDER' , 'wp-journal'); ?></h4>
             	<div class="front-page-block"><?php echo __( 'Front page' , 'wp-journal'); ?></div>
                <div id="published-area" class="ui-droppable-order-article"></div>
           		<p><?php echo __( 'Click on and drag a post to order the summary' , 'wp-journal'); ?></p>
             </div>
             <div id="no-published-articles" class="unit one-third">
             <h4><?php echo __( 'Journal POSTS AVAILABLE' , 'wp-journal'); ?></h4>
             <div class="show-published-articles"><span class="dashicons dashicons-visibility"></span>
			 <?php echo __( 'Show published posts' , 'wp-journal'); ?></span></div>
					<?php
				 
                    $args = array(
                    'post_type' => 'wpjournal-article',
                     'post_status' => 'publish' 
                    );
                    
                   
                    query_posts($args );
                    
                   
                    while ( have_posts() ) : the_post();
                    
                    $id = get_the_ID();
                    $title = get_the_title();
                    $url_edit = get_admin_url( null, 'post.php?post='.$id.'&action=edit' );
					$published = get_post_meta( $id, 'published_onWPJournal',true);
 					if ($published == '1'){ $class = "hide darker"; }else{ $class = ""; } 
                    
                    echo'<div id="id_article_selected'.$id.'" class="ui-draggable ui-draggable-order-article sort-block-menabo single-inside-article '.$class.'" data-origin="articles">'.$title.'</div>';	
                    
                    endwhile;
                    
                   
                    wp_reset_query();
                     
                    ?>
             </div>
            
             <div id="no-published-posts" class="unit one-third">
             
             <h4><?php echo __( 'POSTS AVAILABLE' , 'wp-journal'); ?></h4>
					<?php  
                    $args = array(
                    'post_type' => 'post',
					'post_status' => 'publish' 
                    
                    );
                    
              
                    query_posts($args );
                    
                    
                    while ( have_posts() ) : the_post();
                    
                        $id = get_the_ID();
                        $title = get_the_title();
                    $url_edit = get_admin_url( null, 'post.php?post='.$id.'&action=edit' );
                    
                    echo'<div id="id_article_selected'.$id.'" class="ui-draggable ui-draggable-order-article sort-block-menabo single-inside-article" data-origin="posts">'.$title.'</div>';	
                    
                    endwhile;
                    
                   
                    wp_reset_query();
                     
                    ?>
                     
             </div>
             
     </div>
     <!-- END Fourth  Step --->  
 <div id="addDelButtons">
  </div>
 
        
      
    <div id="dest_nuova_WPJournal" class="grid mesortable">  
 
	</div>
    
 
   
    
    
 <div id="final-save">
 <hr/>
    
 <button id="salva_WPJournal_nuova_WPJournal" class="button button-primary salva_WPJournal" disabled>
 
 <?php echo __( 'Publish!' , 'wp-journal'); ?>
 </button>

 </div>
 <div id="final-update">
 <hr/>
 <div class="grid">
 <div class="unit half">
 
 </div>
 <div class="unit half">
 <div id="WPjournal-advise-update">
 	<?php echo __( 'Edits will not take effect unless you click "Update"' , 'wp-journal'); ?>

 <button id="update_WPJournal" class="button button-primary salva_WPJournal" disabled>
 <?php echo __( 'Update' , 'wp-journal'); ?>
 </button> 
 </div>
 </div>
 </div>
 </div>  
    </form>
    

    <div id="saveResult"></div>
    <div id="saveMessage"></div>
    
 	</div>
  </dd>
  
 
 </dl>    
      <div id="cover">       
      </div>
</div>
</div>
</div>