                  <div class="row-fluid" >
                        <div class="col-lg-12 images1 ">
                            <?php 
                            	   $pID=901;
                                  $imagevalue=get_post_meta($pID,'image',true);
                            ?>
							
    						<img src="<?php echo get_home_url().'/timthumb.php?src='.wp_get_attachment_url($imagevalue).'&amp;w=300&amp;h=600;q=80';?>" style="height: 600px;width: 100%;" alt="" />
                        </div>
						<div class="video">
                        <?php 
                        	$wp_query = new WP_Query();
                        
                             $properties = array(
                                'post_type' =>  'post_video',
                        		'posts_per_page' => 1,
                                'meta_query' => array(),
                                'tax_query'=>array(),
                            );   
                        
                        
                        	$query = $wp_query->query($properties);
                        	foreach ($query as $perres){
                        	   $pID=$perres->ID;
                               $web=get_post_meta($pID,'url',true);
                        ?>
						<embed height="300" width="100%" type="application/x-shockwave-flash"  wmode="transparent" src="<?php echo $web;?>" allowfullscreen="true" style="margin-top:10px;"/>
                        <?php
                        }
                        ?>
				
							 
							<div class="post">
								<p> PostedBy:<strong class="str"> ThomasJhnson</strong></p>
								<p><span>Aug14,2013:</span> <strong class="str">Views3,47</strong></p>
							</div><!--end post-->
						</div><!--end video-->
						<div class="imageslogo">
                    <?php
                    $wp_query = new WP_Query();
                    $properties = array(
                            'post_type' =>  'logo_sponsors',
                            'posts_per_page' =>1,
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
                        echo '<div class="col-lg-3 col-push-1">';
                        echo '<a href="http://'.$web_url.'"><img src="'.wp_get_attachment_url($imagevalue).'"  alt="" style="width: 180px;height: 150px; margin-left:10px}"/></a>';
                        echo '</div>';
                    }
                    ?>                    
                        </div>
                    </div>