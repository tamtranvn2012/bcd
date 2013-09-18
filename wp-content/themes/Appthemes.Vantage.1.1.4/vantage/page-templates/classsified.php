<?php
// Template Name:classsified
 ?>

 
<div class="col-xs-10" >
  <p class="title-page">Classifieds</p>
    <div class="col-xs-12">
 	<?php
				$args=array(
			'taxonomy' => 'listing_category',
			'hierarchical' => '1',
			'hide_empty' => '0',
			'pad_counts' => '1',
			'orderby' => 'term_order'
			);
			$categories=get_categories($args);
            echo '<ul class="col-xs-12 list-inline " style="margin-left: 30px;">';
			foreach($categories as $category) { 
				if($category->parent == 0 ){
				    
				    echo  '<li class="col-lg-4">';
        
                    echo '<h3>'. $category->name.'</h3>';
                   
                    echo '<div class="span3 scroll thienthanh"><ul>';
					$categoryID =  $category->term_id;
					
					$args=array(
						'taxonomy' => 'listing_category',
						'child_of' => $categoryID,
						'hide_empty' => '0',
						'orderby' => 'term_order'
					);
					$categories=get_categories($args);
					foreach($categories as $category) { 
					   echo '<li><a href="'.get_home_url().'/show-find/?cat='.$category->slug.'" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '">'.$category->name.'</a></li>';
					}
                    
                    echo '</ul></div></li>';
                
				}
               
                
			} 
             echo '</ul>';
   ?>
 </div>
 <div class="col-xs-12">
			<div style="margin-bottom: 15px;padding-left: 90px;">
                <?php
        	       $pID=897;
                    $imagevalue=get_post_meta($pID,'image',true);
                ?>
				<img src="<?php echo wp_get_attachment_url($imagevalue);?>" alt="" class="col-xs-11" style="padding-top: 20px;"/>
		 
			</div><!--end img-->
</div><!--end logo-->

    <div class="col-xs-12" >
        
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
       echo '<div class="col-xs-9">';
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
       echo ' </div>';
        
	?>
    <div class="col-xs-3" style="padding: 0; margin-top: 20px;margin-bottom: 20px;">
	<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_right.png';?>" alt="" class="col-xs-12" style="height: 600px;"/></a>
		 
	</div>

    </div>
            
                <div class="col-xs-12" >
                <div style="margin-bottom:10px;margin-top: 20px;">
                    <?php
                    $wp_query = new WP_Query();
                    $properties = array(
                            'post_type' =>  'logo_sponsors',
                            'posts_per_page' =>3,
                            'meta_query' => array(),
                            'tax_query' => array(),
                     );
                     
                     $properties['meta_query'][] = array(
                    'key' => 'show_header',
                    'value' => '1',
                    'compare' => 'LIKE'
                    );
                               
                    $query = $wp_query->query($properties);
                    
                    foreach ($query as $perres){
                        $pID=$perres->ID;
                        $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
                        $web_url=get_post_meta($pID,'website_url',true);
                        echo '<div class="col-xs-4">';
                        echo '<a href="http://'.$web_url.'"><img src="'.wp_get_attachment_url($imagevalue).'"  alt="" style="width: 180px;height: 150px; "/></a>';
                        echo '</div>';
                    }
                    ?>
				</div><!--end logo-top-->
                </div>
         
         </div>
         