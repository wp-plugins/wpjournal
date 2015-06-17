<?php
/**
 * Custom Plugin Template
 * File: WPJournal-menabo.php
 *
 */

  
?>
<!DOCTYPE html>
<html  dir="ltr" lang="en-US">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<?php   wp_head();  ?>
<title><?php wp_title( '|', true, 'right' );  ?></title>

</head>

<body class="menabo">
 
<?php
 
$id_currentpost  =   get_the_ID();

if (isset ($_GET['id_Journal'])){
	$id_Journal = $_GET['id_Journal'];
	 
}else{
	$id_Journal 	= get_post_meta( get_the_ID(), 'id_Journal',true);
}
 if ($id_Journal !=''){
			$postArray 		=  get_post_meta( $id_Journal, 'postArray',true);
			$headerimage 	=  get_post_meta( $id_Journal, 'headerimage',true);
			$info			=  get_post_meta( $id_Journal, 'info',true);
			$anno			=  get_post_meta( $id_Journal, 'year',true);
			$numero			=  get_post_meta( $id_Journal, 'issue',true);
			$newstitle 		=  get_the_title( $id_Journal );
			$permalink 		=  get_permalink( $id_Journal );   
 
}
 
if ($headerimage  !=''){
		$image_attributes = wp_get_attachment_image_src( $headerimage, 'thumbnail' );
	} 
function wpjournal_get_the_post_thumbnail_src($img)
{
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
 
?>
 

<?php  if ($id_Journal !=''){ ?>
 
 <nav id="wpjournal_menu">
    <a href="#menu" class="wpjournal_menu-link"><?php echo __( 'MENU' , 'wp-journal'); ?></a>
       <ul>
       <li><a href="<?php echo $permalink;?>"> <?php echo __( 'Home Page / Front Page' , 'wp-journal'); ?></a></li>
       <?php 
	    
       foreach ($postArray  as $id_currentpost_menu) {
		 echo "<li>";
			if ('wpjournal-article' !== get_post_type($id_currentpost_menu)){
					if (strpos($permalink,'?') === false) {$interr = '?';}else{$interr = '&';} 
					$linkpermalink = $permalink.$interr.'id_post='.$id_currentpost_menu;
					}else{
					
					$linkpermalink = get_permalink($id_currentpost_menu);
					}
					if (strpos($linkpermalink,'?') === false) {$interr = '?';}else{$interr = '&';}
				 
					echo "<a href='".$linkpermalink.$interr."id_Journal=".$id_Journal."'>";
			
					echo get_the_title($id_currentpost_menu);
			
			
			echo "</a>";
			
			echo "</li>";
		} 
		
		?>
       
    </ul>
   </nav>
<?php } ?>   
<div id="area-print"></div>
    <!-- Page Content -->
    <div id="content" class="container main-aspect">
    <!-- testata -->
     <div class="row">
  <?php   if ($headerimage  !=''){ ?>
     <div class="col-lg-2">
        
     
     	<img src="<?php echo $image_attributes[0] ?>" HEIGHT="45" WIDTH="45" style="margin-top:15px;" class="img-circle img-responsive">
     
     </div>
     <?php } ?>
<div class="col-lg-<?php if ($headerimage  !=''){ ?>8<?php  }else{ ?>12 <?php } ?> ">       
	<div class="row">
     	<div class="area-titolo">
     
 <h1 id="titolo_wpjournal_internal" style="text-align:center;"><?php  echo $newstitle; ?></h1>

	  	</div>
    </div>
</div>
<?php   if ($headerimage  !=''){ ?>
<div class="col-lg-2">

     	<!-- Silence is golden -->
    
     </div>
<?php } ?>
   <div class="col-lg-12">
     
     <div class="row">    
 		<p class="small_internal_subtitle" >
 				<?php echo $info. " ". $numero. " ".$anno; ?>
 		</p>
 <hr/>
 </div>
 </div>
     </div> 
     <!-- fine testata -->

        <div class="row">

   
            <div class="col-lg-12">
            
            
            
            <?php    
	
			 
			
			 
			$article_author =  get_post_meta( $id_currentpost, 'authorname', true);
			
			 $post = get_post( $id_currentpost  ); 
		   setup_postdata($post);
      
	  if ( has_post_thumbnail($id_currentpost) ) {
      		$image_url = wpjournal_get_the_post_thumbnail_src(get_the_post_thumbnail($id_currentpost, "large"));
	  }else{
		   $placeholder_main = WPJOURNAL_PLUGIN_URL . 'img/WPJournal_placeholder.png' ; 
	  }
	   
		   ?>
<div class="outer" >
  <div class="inner-inside" id="main_article" <?php if (isset($placeholder_main)){echo "style='background: url(\"".$placeholder_main."\")'";} ?>>
  <div class="area-titolo" >
     <h4 class="titolo_main"><?php echo get_the_title($id_currentpost); ?></h4></div>
    
  </div>
</div>
            
       <div class='author'>    
        <?php $article_author =  get_post_meta( $id_currentpost, 'authorname', true); ?>    
       by <?php if ($article_author !=''){ echo $article_author; }else{ echo get_the_author(); } ?>
       </div>         
    <div class='cols3 text-inside'>       
    
     
                   
                   
<?php 
 

$content = strip_shortcodes (get_post_field('post_content',  $id_currentpost));
 
echo $content ; ?>
 
</div>
 

            </div>

           

        </div>   
         
 

        <!-- Footer -->
        <footer>
         <div class="row">  
                <div class="col-lg-12 footer-base" id="footer ">
                 
                    <p id="copyright">Copyright &copy; <?php echo $newstitle; ?></p>
                </div>
           </div>     
           
        </footer>

    </div>
 
      
    	 
       <?php 
		    if (!isset($placeholder_main)) { ?>
            <script type="text/javascript">
				jQuery("#main_article").backstretch("<?php echo $image_url;?>");
			</script>
			<?php } ?>
	 
     
</body>
</html>