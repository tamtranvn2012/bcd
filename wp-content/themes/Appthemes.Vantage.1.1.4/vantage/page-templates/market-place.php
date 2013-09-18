<?php
// Template Name:maketplace
 ?>

 
<div class="col-xs-10">
<div class="span7">
   <p class="title-page">Marketplace</p>    
 <div class="col-xs-12" >
        <div class="row" style="margin-left:20px;">
		<?php		
	function get_excerpt_by_id($post_id){
		$the_post = get_post($post_id); //Gets post ID
		$the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
		$excerpt_length = 5; //Sets excerpt length by word count
		$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
		$words = explode(' ', $the_excerpt, $excerpt_length + 1);
		if(count($words) > $excerpt_length) :
		array_pop($words);
		array_push($words, '…');
		$the_excerpt = implode(' ', $words);
		endif;
		$the_excerpt = '<p>' . $the_excerpt . '</p>';
		return $the_excerpt;
	}

		$wp_query = new WP_Query();

     $properties = array(
        'post_type' =>  'listing',
		'posts_per_page' => 8,
        'orderby' => 'post_title',
        'meta_query' => array(),
        'tax_query'=>array(),
        'order'    => 'desc', //Asc
    );   


	$properties['meta_query'][] = array(
		'key' => 'featured-home_duration',
		'value' => 0,
		'compare' => '>'
	);


	$query = $wp_query->query($properties);
	foreach ($query as $perres){
	 $pID=$perres->ID;
	 $post = get_post($post_id);
	 $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
    $web=get_post_meta($pID,'website',true);

	?>
			<ul class="col-xs-5" style="margin-top:10px; margin-bottom:10px;margin-left: 5px;">
				<a href="#"><img src="<?php echo get_home_url().'/timthumb.php?src='.wp_get_attachment_url($imagevalue).'&amp;w=200&amp;h=90;q=80';?>" alt="" style="width:200px;height: 90px;border:solid 1px black;"/></a>
				<ul class="list-inline">
                    <li class="col-xs-11"> <h4><?php echo $perres->post_title;?></h4></li>
                    <li class="col-xs-11"><p><?php echo get_excerpt_by_id($pID);?></p></li>
                    <li class="col-lg-7 more_col">More Details</li>
                        <li class="col-lg-5 visit_col">Visit Site</li>
                </ul>
               
			
				
				
			</ul><!--end col-6-->
	<?php
	}
	?>
			

			
		</div>
		 </div>
		 <!------------------------------------------------------------------>
		 
	
	           <div class="col-xs-12" style="margin-bottom: 15px;">
                    <?php
                        	       $pID=897;
                                    $imagevalue=get_post_meta($pID,'image',true);
                    ?>
                				<img src="<?php echo wp_get_attachment_url($imagevalue) ;?>" alt="" style="height: 90px;margin-top: 20px;width: 100%;" />
              	</div><!--end img-->
                        
                 <div class="col-xs-11" style="border: 1px solid #C3A0A0;border-radius: 4px;margin-bottom: 15px;margin-top: 20px;">         
                    <!----box logo sponsors !--->
                  <?php get_sidebar('sponsors');?>  
                 </div>
                  
                  
                		<div class="col-xs-12">
                                   <?php
                    //Latest Listings
                        $wp_query = new WP_Query();
                        //truy van noi dung
                        $properties = array(
                                'post_type' =>  'listing',
                                'post_content' => $_GET['desc'],
                                'posts_per_page'=>5,
                                'orderby' => 'post_title',
                                'meta_query' => array(),
                                'tax_query' => array(),
                                'order'    => 'desc' //desc
                                
                        );
                        
                        $query = $wp_query->query($properties);
                        foreach ($query as $perres){
                            $pID=$perres->ID;
                            $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
                            $web=get_post_meta($pID,'website',true);
                            
                              $excerpt = $perres->post_content;
                              $excerpt = strip_tags($excerpt);
                              $excerpt = substr($excerpt, 0,200);
                              $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
                              $excerpt = $excerpt.'...';
                              
                            ?>
                                   <ul class="col-xs-11 list-inline" style="margin-top: 20px;margin-bottom: 20px;">
                                   	    <li class="col-lg-2">
                                    	<a href="<?php echo $perres->guid;?>"><img src="<?php echo get_home_url().'/timthumb.php?src='.wp_get_attachment_url($imagevalue).'&amp;w=88&amp;h=80;q=80';?>" alt="" style="width: 88px;height: 80px; }"/></a>
                                    	</li><!--end col-img-->
                                     	<li class="col-lg-5">
                                    	<div class="text-title"><?php echo $perres->post_title; ?></div>
                                    	<div class="text-post"><?php echo $excerpt;?></div>
                                    	<span><a href="<?php echo 'http://'.$web; ?>"><?php echo $web?></a></span>
                                    	</li><!--end col-test--->
                                    	<li class="col-lg-2">
                                    	<div class="red"><a href="<?php echo $perres->guid;?>">Read more..</a></div>
                                    	</li><!--end red-->
                                    	<li class="col-lg-3">
                                    	<div class="send"> Send message</div>
                                    	</li><!--end send--> 
                                     </ul>
                            <?php
                        }
                        
                	?>
                	
                </div><!--ensd Logo-->
                      

</div>               
      
<div class="span3 pull-right" >
    <?php get_sidebar('right'); ?>
</div>        
</div>


         
