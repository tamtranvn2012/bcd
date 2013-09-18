<?php
// Template Name:classsified
 ?>

 
<div class="co-9">

 <div class="col-lg-9" >
                <div class="col-lg-3">
                        <h3>Bussinesses</h3>
                        <div class="span3">
                              <ul>
                                <li><a href="#">Lorum Ipsum</a></li>
                                <li><a href="#">Coupon</a></li>
                                <li><a href="#">Discount offers</a></li>
                                <li><a href="#">Franchise</a></li>
                                <li><a href="#">Flight deals</a></li>
                                <li><a href="#">HUD Homes</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Cable and Phone</a></li>
                                <li><a href="#">Hotel discounts</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                            
                              </ul>
                        </div>      
                </div>
                
                
                <div class="col-lg-3">
                        <h3>Marketplace</h3>
                        <div class="span3">
                              <ul>
                                <li><a href="#">Lorum Ipsum</a></li>
                                <li><a href="#">Coupon</a></li>
                                <li><a href="#">Discount offers</a></li>
                                <li><a href="#">Franchise</a></li>
                                <li><a href="#">Flight deals</a></li>
                                <li><a href="#">HUD Homes</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Cable and Phone</a></li>
                                <li><a href="#">Hotel discounts</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                              </ul>
                        </div>      
                </div>
                <div class="col-lg-3">
                        <h3>Classifileds</h3>
                        <div class="span3">
                              <ul>
							  <?php
							  $wp_query = new WP_Query();
									 $properties = array(
										'post_type' =>  'listing',
										'meta_query' => array(),
										'tax_query'=>array(),
									);  

									$properties['meta_query'][] = array(
									'key' => 'featured-cat',
									'value' => '1',
									'compare' => 'LIKE'
									);	
									
								$query = $wp_query->query($properties);	
								foreach ($query as $perres){
									echo '<li><a href="'.$perres->guid.'">'.$perres->post_title.'</a></li>'; 
									}
							  ?>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                              </ul>
                        </div>    
            </div>
            
              <div class="col-lg-3">
                        <h3>Great service</h3>
                        <div class="span3">
                              <ul>
                                <li><a href="#">Lorum Ipsum</a></li>
                                <li><a href="#">Coupon</a></li>
                                <li><a href="#">Discount offers</a></li>
                                <li><a href="#">Franchise</a></li>
                                <li><a href="#">Flight deals</a></li>
                                <li><a href="#">HUD Homes</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Cable and Phone</a></li>
                                <li><a href="#">Hotel discounts</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                              </ul>
                        </div>      
                </div>
                
                
                
                  <div class="col-lg-3">
                        <h3>Deals</h3>
                        <div class="span3">
                              <ul>
                               <li><a href="#">Lorum Ipsum</a></li>
                                <li><a href="#">Coupon</a></li>
                                <li><a href="#">Discount offers</a></li>
                                <li><a href="#">Franchise</a></li>
                                <li><a href="#">Flight deals</a></li>
                                <li><a href="#">HUD Homes</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Cable and Phone</a></li>
                                <li><a href="#">Hotel discounts</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                              </ul>
                        </div>      
                </div>
                
                
                  <div class="col-lg-3">
                        <h3>Home and Estates</h3>
                        <div class="span3">
                              <ul>
                                <li><a href="#">Lorum Ipsum</a></li>
                                <li><a href="#">Coupon</a></li>
                                <li><a href="#">Discount offers</a></li>
                                <li><a href="#">Franchise</a></li>
                                <li><a href="#">Flight deals</a></li>
                                <li><a href="#">HUD Homes</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Cable and Phone</a></li>
                                <li><a href="#">Hotel discounts</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                              </ul>
                        </div>      
                </div>
                
                  <div class="col-lg-3">
                        <h3>Businesses</h3>
                        <div class="span3">
                              <ul>
                                <li><a href="#">Lorum Ipsum</a></li>
                                <li><a href="#">Coupon</a></li>
                                <li><a href="#">Discount offers</a></li>
                                <li><a href="#">Franchise</a></li>
                                <li><a href="#">Flight deals</a></li>
                                <li><a href="#">HUD Homes</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Cable and Phone</a></li>
                                <li><a href="#">Hotel discounts</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                              </ul>
                        </div>      
                </div>
                
                  <div class="col-lg-3">
                        <h3>Announcement</h3>
                        <div class="span3">
                              <ul>
                                <li><a href="#">Lorum Ipsum</a></li>
                                <li><a href="#">Coupon</a></li>
                                <li><a href="#">Discount offers</a></li>
                                <li><a href="#">Franchise</a></li>
                                <li><a href="#">Flight deals</a></li>
                                <li><a href="#">HUD Homes</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Cable and Phone</a></li>
                                <li><a href="#">Hotel discounts</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li><a href="#">Isurance deals</a></li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                              </ul>
                        </div>      
                </div>
                
        <div class="col-12">
			<div class="col-lg-12" style="margin-bottom: 15px;padding-left: 90px;">
				<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/img_logo.png';?>" alt="" style="width: 728px;height: 90px; }"/></a>
		 
			</div><!--end img-->
		</div><!--end logo-->

		<div class="col-12">
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
            <div class="col-10" style="margin-top:20px">
           	    <div class="col-lg-2">
            	<a href="<?php echo $perres->guid;?>"><img src="<?php echo wp_get_attachment_url($imagevalue);?>" alt="" style="width: 88px;height: 80px; }"/></a>
            	</div><!--end col-img-->
             	<div class="col-lg-5">
            	<div class="text-title"><?php echo $perres->post_title; ?></div>
            	<div class="text-post"><?php echo $excerpt;?></div>
            	<span><a href="<?php echo 'http'.$web; ?>"><?php echo $web?></a></span>
            	</div><!--end col-test--->
            	<div class="col-lg-2">
            	<div class="red"><a href="<?php echo $perres->guid;?>">Read more..</a></div>
            	</div><!--end red-->
            	<div class="col-lg-3">
            	<div class="send"> Send message</div>
            	</div><!--end send--> 
				
             </div><!--end Latest Listing-->   
            <?php
        }
        
	?><div class="col-2" style="margin-top: -392px;margin-bottom: 10px;">
	<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_right.png';?>" alt="" style="width: 160px;height: 600px; }"/></a>
		 
	</div>

            
                <div class="col-lg-12" style="margin-bottom:10px;">
					<div class="col-lg-3 col-push-1">
					<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_top.png';?>" alt="" style="width: 180px;height: 150px; "/></a>
	
					</div>
					<div class="col-lg-3 col-push-1">
					<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_post1.jpg';?>" alt="" style="width: 180px;height: 150px; "/></a>
	
					</div>
					<div class="col-lg-3 col-push-1">
					<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_post2.jpg';?>" alt="" style="width: 180px;height: 150px; "/></a>
	
					</div>
				</div><!--end logo-top-->
         
         </div>
         
		 </div>   
        </div>
        <!--end left-->
       
        <!--end right-->
</div>
       <!--end hang-->
       
         
         <!--end hang-->
         
