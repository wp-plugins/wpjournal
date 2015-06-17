<?php
/**
 * Custom WPJournal Template
 * File: WPJournal-menabo.php
 *
 */

function wpjournal_get_the_post_thumbnail_src($img)
{
	 return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
function wpjournal_tokenTruncate($string, $your_desired_width) {
	  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
	  $parts_count = count($parts);
	
	  $length = 0;
	  $last_part = 0;
	  for (; $last_part < $parts_count; ++$last_part) {
		$length += strlen($parts[$last_part]);
		if ($length > $your_desired_width) { break; }
	  }
	
	  return implode(array_slice($parts, 0, $last_part));
}
?>

<!DOCTYPE html>
<html  dir="ltr" lang="en-US">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<?php   wp_head();  ?>
<title><?php wp_title( '|', true, 'right' ); ?></title>

</head>

<body class="menabo">

<?php
$permalink 				= get_permalink( get_the_ID());
$id_Journal 				= get_the_ID();
$postArray 				= get_post_meta( $id_Journal, 'postArray',true);
$frontpageorder 		= get_post_meta( $id_Journal, 'frontpageorder',true);
$displacement_array  	= (array) null; 

?>
   <nav id="wpjournal_menu">
			<a href="#menu" class="wpjournal_menu-link">MENU</a>
			   <ul>
			   <li><a href="<?php echo $permalink;?>"><?php echo __( 'Home Page / Front Page' , 'wp-journal'); ?></a></li>
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

<?php

if (isset ($_GET['id_post'])){
		/* we are reading an article */	 
 
		$id_currentpost = $_GET['id_post'];
		$headerimage 	=  get_post_meta( $id_Journal, 'headerimage',true);
		$info			=  get_post_meta( $id_Journal, 'info',true);
		$anno			=  get_post_meta( $id_Journal, 'year',true);
		$numero			=  get_post_meta( $id_Journal, 'issue',true);
		$newstitle 		=  get_the_title( $id_Journal);
		$permalink 		=  get_permalink( $id_Journal ); 
		if ($headerimage  !=''){
				$image_attributes = wp_get_attachment_image_src( $headerimage, 'thumbnail' );
		} 
 
		 
?>
 	
 
		<div id="area-print"></div>
			 
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
			 
			  
				<!-- -->
			
			 </div>
			  <?php } ?>
		   <div class="col-lg-12">
			 
			 <div class="row">    
		 <p class="small_internal_subtitle">
			<?php echo $info. " ". $numero. " ".$anno?>
		 </p>
		 <hr/>
		 </div>
		 </div>
			 </div> 
			 <!-- fine testata -->
		
				<div class="row">
		
		   
					<div class="col-lg-12">
					
					
					
					<?php    
					 
					
					
					 $post = get_post( $id_currentpost  ); 
				   setup_postdata($post);
			  // echo get_the_post_thumbnail( $post->ID, "large" );
			  if ( has_post_thumbnail($id_currentpost) ) {
					$image_url = wpjournal_get_the_post_thumbnail_src(get_the_post_thumbnail($id_currentpost, "large"));
			  }else{
				    $placeholder_main = WPJOURNAL_PLUGIN_URL . 'img/WPJournal_placeholder.png' ;  
			  }
			   
				   ?>
		<div class="outer" >
		  <div class="inner-inside" id="main_article" <?php if (isset($placeholder_main)){echo "style='background: url(\"".$placeholder_main."\")'";} ?>>
		  <div class="area-titolo" >
			 <h4 class="titolo_main_internal"><?php echo get_the_title($id_currentpost); ?></h4></div>
			
		  </div>
		</div>
					<?php $article_author =  get_post_meta( $id_currentpost, 'authorname', true); ?>
			   <div class='author'>      
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
 
			  
			 
              
                <script type="text/javascript">
					
					<?php   if (!isset($placeholder_main)) { ?> jQuery("#main_article").backstretch("<?php echo $image_url;?>");<?php } ?>
                </script>
<?php  
}else{
		/* frontpage */
		
		foreach ($frontpageorder as $order_post) {
	  		$displacement_array [$order_post['area']] = $order_post['id_post'];  
		}
		
			$headerimage 	=  get_post_meta( $id_Journal, 'headerimage',true);
			$info			=  get_post_meta( $id_Journal, 'info',true);
			$anno			=  get_post_meta( $id_Journal, 'year',true);
			$numero			=  get_post_meta( $id_Journal, 'issue',true);
			$newstitle		=  get_the_title();

			if ($headerimage  !=''){
					$image_attributes = wp_get_attachment_image_src( $headerimage, 'thumbnail' );
				} 

			
			?>
 
			  
			<div id="area-print"></div>
			
            <div id="content" class="container main-aspect">
				 <div class="row">
			<?php   if ($headerimage  !=''){ ?>
                     <div class="col-lg-2">
                     <img src="<?php echo $image_attributes[0] ?>" HEIGHT="100" WIDTH="100" style="margin-top:15px;" class="img-circle img-responsive">
                     </div>
            <?php } ?>
				  <div class="col-lg-<?php if ($headerimage  !=''){ ?>8<?php  }else{ ?>12 <?php } ?> ">  
				 
				 <div class="row">
				 <div class="area-titolo">
				 
			 <h1 id="titolo_wpjournal" style="text-align:center;"><?php the_title(); ?></h1>
			
				  </div>
				</div>
				 </div>
				 <?php   if ($headerimage  !=''){ ?>
				  <div class="col-lg-2">
 
				 </div>
				  <?php } ?>
			   <div class="col-lg-12">
				 
				 <div class="row">    
			 <p style="text-align:center;">
				<?php echo $info. " ". $numero. " ".$anno?>
			 </p>
			 <hr/>
			 </div>
			 </div>
				 </div>
			
					<div class="row">
			 
						<div class="col-lg-9">
						
						
						
						<?php    
							$id_post = $displacement_array ['PrimoPiano'];
							$post = get_post( $id_post ); 
							setup_postdata($post);
							 
							if ( has_post_thumbnail($id_post) ) {
								$image_url = wpjournal_get_the_post_thumbnail_src(get_the_post_thumbnail($id_post, "large"));
							}else{
							   $placeholder_main = WPJOURNAL_PLUGIN_URL . 'img/WPJournal_placeholder.png' ; 
							}
					   ?>
			<div class="outer" >
			  <div class="inner" id="main_article" <?php if (isset($placeholder_main)){ echo "style='background: url(\"".$placeholder_main."\")'";} ?>>
			  <div class="area-titolo" >
				 <h4 class="titolo_main"><?php echo get_the_title($id_post); ?></h4></div>
				
			  </div>
			</div>
						<?php $article_author =  get_post_meta( $id_post, 'authorname', true); ?>
				   <div class='author'>      
				   by <?php if ($article_author !=''){ echo $article_author; }else{ echo get_the_author($id_post); } ?>
				   </div>         
				<div class='cols3'>           
							   
			<div class="wpjournal-content">					   
			<?php 
			
			$content = strip_tags( strip_shortcodes (get_post_field('post_content', $post_id)));
			
			
			$content = wpjournal_tokenTruncate($content, 1000);
			if ('wpjournal-article' !== get_post_type($id_post)){
						if (strpos($permalink,'?') === false) {$interr = '?';}else{$interr = '&';} 
						$linkpermalink = $permalink.$interr.'id_post='.$id_post;
			}else{
				
						$linkpermalink = get_permalink($id_post);
			}
			if (strpos($linkpermalink,'?') === false) {$interr = '?';}else{$interr = '&';}
			echo $content ."(...)<br/> <div class='continue'><a href='".$linkpermalink.$interr."id_Journal=".$id_Journal."'>".__('Continue', 'wp-journal')." </a></div>";
		 ?>
			
			</div>
				</div>			 
 
 
			
						</div>
			
						 
						<div class="col-md-3">
			 
						<!-- area 2 -->
							<div class="area-titolo-right">
						  
							   <?php    
									$id_post = $displacement_array ['area2'];
									$post = get_post( $id_post ); 
									setup_postdata($post);
									// $image_url = wpjournal_get_the_post_thumbnail_src(get_the_post_thumbnail($id_post, "large"))
								?>
							
								<h4 class="titolo_homepage" style="margin-top:0; padding-top:0;"><?php echo get_the_title($id_post); ?></h4>
							  </div>  
							   <div class='author'><?php $article_author =  get_post_meta( $id_post, 'authorname', true); ?>   
									by <?php if ($article_author !=''){ echo $article_author; }else{ echo get_the_author($id_post); } ?>
								</div>  
							  <div class="wpjournal-content">	
							  <?php 
									$content = strip_tags( strip_shortcodes (get_post_field('post_content', $post_id)));
									$content = wpjournal_tokenTruncate($content, 720);
									
								if ('wpjournal-article' !== get_post_type($id_post)){
								if (strpos($permalink,'?') === false) {$interr = '?';}else{$interr = '&';} 
								$linkpermalink = $permalink.$interr.'id_post='.$id_post;
								}else{
								
								$linkpermalink = get_permalink($id_post);
								}
								if (strpos($linkpermalink,'?') === false) {$interr = '?';}else{$interr = '&';}
								if (strpos(get_permalink($id_post),'?') === false) {$interr = '?';}else{$interr = '&';}
								echo $content ."(...) <a href='".$linkpermalink.$interr."id_Journal=".$id_Journal."'> ".__('Continue', 'wp-journal')."</a> ";  ?>
								 
							
							 
							  </div>
							<!-- end area 2 -->
						</div>
			
					</div>   <hr />
					 
					
					<div class="row">
						<div class="col-md-4">
						<!-- area 3 -->
								<?php    
									$id_post = $displacement_array ['area3'];
									$post = get_post( $id_post ); 
									setup_postdata($post);
									if ( has_post_thumbnail($id_post) ) {
										$image_url_3 = wpjournal_get_the_post_thumbnail_src(get_the_post_thumbnail($id_post, "large"));
									}else{
										$placeholder_small_3 = WPJOURNAL_PLUGIN_URL . 'img/WPJournal_placeholder.png' ;  
										  
									}
								?>
			
			<div class="outer" >
			  <div class="inner-base" id="post_3" <?php if (isset($placeholder_small_3)){ echo "style='background: url(\"".$placeholder_small_3."\")'";} ?>>
			  <div class="area-titolo" >
				 <h4 class="titolo_piccolo"><?php echo get_the_title($id_post); ?></h4></div>
				
			  </div>
			</div>
								<div class='author'> 
                                  
                                 <?php $article_author =  get_post_meta( $id_post, 'authorname', true); ?>     
									by <?php if ($article_author !=''){ echo $article_author; }else{ echo get_the_author($id_post); } ?>
								</div> 
								<div class="wpjournal-content">	
								<?php 
									$content = strip_tags( strip_shortcodes (get_post_field('post_content', $post_id)));
									$content = wpjournal_tokenTruncate($content, 414);
														if ('wpjournal-article' !== get_post_type($id_post)){
								if (strpos($permalink,'?') === false) {$interr = '?';}else{$interr = '&';} 
								$linkpermalink = $permalink.$interr.'id_post='.$id_post;
								}else{
								
								$linkpermalink = get_permalink($id_post);
								}
								if (strpos($linkpermalink,'?') === false) {$interr = '?';}else{$interr = '&';}
								if (strpos(get_permalink($id_post),'?') === false) {$interr = '?';}else{$interr = '&';}
								echo $content ."(...) <a href='".$linkpermalink.$interr."id_Journal=".$id_Journal."'>  ".__('Continue', 'wp-journal')." </a> ";  ?>
			
							 	</div>
					<!-- end area 3 -->
					</div>
					  <div class="col-md-4">
						<!-- area 4 -->
								<?php    
									$id_post = $displacement_array ['area4'];
									$post = get_post( $id_post ); 
									setup_postdata($post);
									if ( has_post_thumbnail($id_post) ) {
										$image_url_4 = wpjournal_get_the_post_thumbnail_src(get_the_post_thumbnail($id_post, "large"));
									}else{
										$placeholder_small_4 = WPJOURNAL_PLUGIN_URL . 'img/WPJournal_placeholder.png' ;  
									}
									 
								?>
			
							<div class="outer" >
			  <div class="inner-base" id="post_4" <?php if (isset($placeholder_small_4)){ echo "style='background: url(\"".$placeholder_small_4."\")'";} ?>>
			  <div class="area-titolo" >
				 <h4 class="titolo_piccolo"><?php echo get_the_title($id_post); ?></h4></div>
				
			  </div>
			</div>
								<div class='author'>      
                                 <?php $article_author =  get_post_meta( $id_post, 'authorname', true); ?>  
									by <?php if ($article_author !=''){ echo $article_author; }else{ echo get_the_author($id_post); } ?>
								</div>  
                                <div class="wpjournal-content">	
								<?php 
									$content = strip_tags( strip_shortcodes (get_post_field('post_content', $post_id)));
									$content = wpjournal_tokenTruncate($content, 370);
														if ('wpjournal-article' !== get_post_type($id_post)){
								if (strpos($permalink,'?') === false) {$interr = '?';}else{$interr = '&';} 
								$linkpermalink = $permalink.$interr.'id_post='.$id_post;
								}else{
								
								$linkpermalink = get_permalink($id_post);
								}
								if (strpos($linkpermalink,'?') === false) {$interr = '?';}else{$interr = '&';}
								if (strpos(get_permalink($id_post),'?') === false) {$interr = '?';}else{$interr = '&';}
								echo $content ."(...) <a href='".$linkpermalink.$interr."id_Journal=".$id_Journal."'>  ".__('Continue', 'wp-journal')." </a> ";  ?>
			
								 </div>
						<!-- end area 4 -->
					 </div>
					  <div class="col-md-4">
						<!-- area 5 -->
								<?php    
									$id_post = $displacement_array ['area5'];
									$post = get_post( $id_post ); 
									setup_postdata($post);
									
									if ( has_post_thumbnail($id_post) ) {
										$image_url_5 = wpjournal_get_the_post_thumbnail_src(get_the_post_thumbnail($id_post, "large"));
									}else{
										$placeholder_small_5 = WPJOURNAL_PLUGIN_URL . 'img/WPJournal_placeholder.png' ;  
									}
								?>
			
				<div class="outer" >
			  <div class="inner-base" id="post_5" <?php if (isset($placeholder_small_5)){ echo "style='background: url(\"".$placeholder_small_5."\")'";} ?>>
			  <div class="area-titolo" >
				 <h4 class="titolo_piccolo"><?php echo get_the_title($id_post); ?></h4></div>
				
			  </div>
			</div>
								<div class='author'>    
                                 <?php $article_author =  get_post_meta( $id_post, 'authorname', true); ?>    
									by <?php if ($article_author !=''){ echo $article_author; }else{ echo get_the_author($id_post); } ?>
								</div>  
                                <div class="wpjournal-content">	
								<?php 
									$content = strip_tags( strip_shortcodes (get_post_field('post_content', $post_id)));
									$content = wpjournal_tokenTruncate($content, 370);
													if ('wpjournal-article' !== get_post_type($id_post)){
								if (strpos($permalink,'?') === false) {$interr = '?';}else{$interr = '&';} 
								$linkpermalink = $permalink.$interr.'id_post='.$id_post;
								}else{
								
								$linkpermalink = get_permalink($id_post);
								}
								if (strpos($linkpermalink,'?') === false) {$interr = '?';}else{$interr = '&';}
								if (strpos(get_permalink($id_post),'?') === false) {$interr = '?';}else{$interr = '&';}
								echo $content ."(...) <a href='".$linkpermalink.$interr."id_Journal=".$id_Journal."'>".__('Continue', 'wp-journal')."</a> ";  ?>
			</div>
								 
						<!-- end area 5 -->
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
            
			    	 
					 
			<script type="text/javascript">
                <?php   
                  if (!isset($placeholder_main)) { ?>jQuery("#main_article").backstretch("<?php echo $image_url;?>"); <?php }  
                  if (isset($image_url_3)) { ?> jQuery("#post_3").backstretch("<?php echo $image_url_3;?>");<?php }     
                  if (isset($image_url_4)) { ?> jQuery("#post_4").backstretch("<?php echo $image_url_4;?>"); <?php }  
                  if (isset($image_url_5)) { ?> jQuery("#post_5").backstretch("<?php echo $image_url_5; ?>"); <?php } ?>
            </script>
	 
 						
<?php 
	} 
?>
</body>
</html>