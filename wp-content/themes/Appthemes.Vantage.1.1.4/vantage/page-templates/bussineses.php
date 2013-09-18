<?php
// Template Name:Business
 ?>

 
<div class="col-xs-10">
    <p class="title-page">Bussiness</p>
     <div class="span7 text-center" style="margin: 0;">
         <div class="row" style="margin-left: 35px;">
                <ul class="col-xs-12 list-inline">
				<li class="col-lg-6"  style="margin-top:10px; margin-bottom:10px;">
				<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/img_logo.png';?>" alt="" class="col-xs-11" style="height: 90px;"/></a>
				    <ul class="col-xs-11" style="list-style: none;">
                        <li ><h4>lorem ipsum is dmmy test</h4> </li>
                        <li><p>80 off when you by up to $50000</p></li>
                        <li class="col-lg-7 more_col">More Details</li>
                        <li class="col-lg-5 visit_col">Visit Site</li>
                    </ul>	
			</li><!--end col6-->
			<li class="col-lg-6"  style="margin-top:10px; margin-bottom:10px;">
				<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/img_logo.png';?>" alt="" class="col-xs-11" style="height: 90px;"/></a>
				    <ul class="col-xs-11" style="list-style: none;">
                        <li ><h4>lorem ipsum is dmmy test</h4> </li>
                        <li><p>80 off when you by up to $50000</p></li>
                        <li class="col-lg-7 more_col">More Details</li>
                        <li class="col-lg-5 visit_col">Visit Site</li>
                    </ul>	
			</li><!--end col6-->
		</ul>      
   
       
  </div>  
        
         <!--------------------------->
                         		 

            <div class="col-xs-12" style="margin-bottom: 15px;">
                                <?php
                        	       $pID=897;
                                    $imagevalue=get_post_meta($pID,'image',true);
                                ?>
                				<img src="<?php echo wp_get_attachment_url($imagevalue) ;?>" alt="" style="height: 90px;margin-top: 20px ;" class="col-xs-11" />
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
                
                		         <div class="col-xs-11">
                                        <?php 
                                        	   $pID=895;
                                              $imagevalue=get_post_meta($pID,'image',true);
                                        ?>
                						<img src="<?php echo wp_get_attachment_url($imagevalue) ;?>" alt="" />
                					</div><!--end logo-->
    </div>
        <div class="span3 pull-right" >
            <?php get_sidebar('right'); ?>
            </div>
</div>



         
