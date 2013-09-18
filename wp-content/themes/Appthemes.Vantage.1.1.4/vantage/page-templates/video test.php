<?php
// Template Name:Video
 ?>


<div class="col-9">
                      <p class="title_content">VIDEO ADS</p>
<div class="top-video-a">

 <?php 
 $arr_post=array(1, 2, 3,4,5,6);
 $count_post=0;
                        	$wp_query = new WP_Query();
                        
                             $properties = array(
                                'post_type' =>  'post_video',
                        		'posts_per_page' => 2,
                                'meta_query' => array(),
                                'tax_query'=>array(),
                            );   
                        
                        	$query = $wp_query->query($properties);
                        	foreach ($query as $perres){
                        	   $arr_post[$count_post]=$perres->ID;
                               $count_post++;
                        	   $pID=$perres->ID;
                               $web=get_post_meta($pID,'url',true);
?>
							<div class="o-video">
						<embed  type="application/x-shockwave-flash" width="226" height="226" wmode="transparent" src="<?php echo $web;?>" allowfullscreen="true"/>
						<div class="text">
                            <p style="color: #00457d;font-weight: bold;"><?php echo $perres->post_title;?></p>
                            <p style="color: #5d5d5d;"><?php echo $perres->post_date;?></p>
                            <p style="color: #393939;font-weight: bold;"><?php echo $perres->post_content;?></p>
                        </div>
						</div>
						
<?php
}
?>
</div>

<div class="top-video-a midle">
 <?php 
                        	$wp_query = new WP_Query();
                        
                             $properties = array(
                                'post_type' =>  'post_video',
                        		'posts_per_page' => 1,
                                'meta_query' => array(),
                                'tax_query'=>array(),
                            );   
                             $properties['meta_query'][] = array(
                            'key' => 'show_top',
                            'value' => '1',
                            'compare' => 'LIKE'
                            );
                        	$query = $wp_query->query($properties);
                        	foreach ($query as $perres){
                        	   $pID=$perres->ID;
                               $web=get_post_meta($pID,'url',true);
?>
						
						<embed class="top-video-a1"  type="application/x-shockwave-flash" width="226" height="226" wmode="transparent" src="<?php echo $web;?>" allowfullscreen="true"/>
						<div class="text">
                            <p style="color: #00457d;font-weight: bold;"><?php echo $perres->post_title;?></p>
                            <p style="color: #5d5d5d;"><?php echo $perres->post_date;?></p>
                            <p style="color: #393939;font-weight: bold;"><?php echo $perres->post_content;?></p>
                        </div>
					
						<div class="video-txt">video txt1</div>
						<div class="video-txt">video txt2</div>
						<div class="video-txt">video txt3</div>                        						
<?php
}
?>

</div>

<div class="top-video-a">
 <?php 
                     	$wp_query = new WP_Query();
                        
                             $properties = array(
                                'post_type' =>  'post_video',
                        		'posts_per_page' => 4,
                                'meta_query' => array(),
                                'tax_query'=>array(),
                            );   
                        
                        	$query = $wp_query->query($properties);
                        	foreach ($query as $perres){
                        	   $pID=$perres->ID;
                                 if(!in_array($pID,$arr_post)){
                                $arr_post[$count_post]=$perres->ID;
                                $count_post++;   
                               $web=get_post_meta($pID,'url',true);
?>
							<div class="o-video">
						<embed  type="application/x-shockwave-flash" width="226" height="226" wmode="transparent" src="<?php echo $web;?>" allowfullscreen="true"/>
						<div class="text">
                            <p style="color: #00457d;font-weight: bold;"><?php echo $perres->post_title;?></p>
                            <p style="color: #5d5d5d;"><?php echo $perres->post_date;?></p>
                            <p style="color: #393939;font-weight: bold;"><?php echo $perres->post_content;?></p>
                        </div>
						</div>
						
<?php
}}
?>	
</div>
                        <?php 
                        	$wp_query = new WP_Query();
                        
                             $properties = array(
                                'post_type' =>  'post_video',
                        		'posts_per_page' => 15,
                                'meta_query' => array(),
                                'tax_query'=>array(),
                            );   
                        
                        
                        	$query = $wp_query->query($properties);
                        	foreach ($query as $perres){
                     	    $pID=$perres->ID;
                              if(!in_array($pID,$arr_post)){
                        	  
                               $web=get_post_meta($pID,'url',true);
                               
                        ?>
						<div class="o-video">
						<embed  type="application/x-shockwave-flash" width="226" height="226" wmode="transparent" src="<?php echo $web;?>" allowfullscreen="true"/>
						<div class="text">
                            <p style="color: #00457d;font-weight: bold;"><?php echo $perres->post_title;?></p>
                            <p style="color: #5d5d5d;"><?php echo $perres->post_date;?></p>
                            <p style="color: #393939;font-weight: bold;"><?php echo $perres->post_content;?></p>
                        </div>
						</div>
                        <?php
                        }}
                        ?>
                        
					<div class="col-lg-12">
                <?php
        	       $pID=897;
                    $imagevalue=get_post_meta($pID,'image',true);
                ?>
				<img src="<?php echo wp_get_attachment_url($imagevalue) ;?>" alt=""/>
					</div><!--end logo-->
                </div>
         
				
					<?php //get_sidebar('right'); ?>