<?php
// Template Name:Sponsors
 ?>
 
<div class="col-xs-10">
 <p class="title-page">Sponsors</p>
    <div class="span7 text-center" style="margin: 0;">
 
<div class="middle-spon">
                                <?php
            $wp_query = new WP_Query();
            $properties = array(
                    'post_type' =>  'logo_sponsors',
                    'posts_per_page' => 100,
                    'meta_query' => array(),
                    'tax_query' => array(),
             );
             
             $properties['meta_query'][] = array(
            'key' => 'show_header',
            'value' => '1',
            'compare' => 'LIKE'
            );
                       
            $query = $wp_query->query($properties);
            echo '<ul class="list-inline">';
            foreach ($query as $perres){
                $pID=$perres->ID;
                $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
                $web_url=get_post_meta($pID,'website_url',true);

                echo '<li>'.'<a href="'.$web_url.'"><img class="span2" src="'.wp_get_attachment_url($imagevalue).'" alt="" /></a>'.'</li>';
            }
            echo '</ul>';

        ?>

                   
                    
              </div>
                <div class="col-xs-12">
			<div class="col-lg-12" style="margin-bottom: 10px;margin-top:10px;">
				<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/img_logo.png';?>" alt="" style="width:100%;height: 90px;"/></a>
		 
			</div><!--end img-->
		</div><!--end logo-->
		
<div class="col-xs-11" style="border: 1px solid #C3A0A0;border-radius: 4px;margin-bottom: 15px;margin-left: 20px;"> 
    <!----box logo sponsors !--->
  <?php get_sidebar('sponsors');?>  
</div><!--ensd Logo-->




                <ul class="col-xs-12 list-inline" style="margin-bottom:10px;">
					<li class="span2" style="margin-left: 5px !important;">
					<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_top.png';?>" alt="" style="width: 180px;height: 150px; "/></a>
	
					</li>
					<li  class="span2"style="margin-left: 5px !important;" >
					<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_post1.jpg';?>" alt="" style="width: 180px;height: 150px; "/></a>
	
					</li>
					<li  class="span2"style="margin-left: 5px !important;">
					<a href="#"><img src="<?php echo  get_stylesheet_directory_uri().'/images/logo_post2.jpg';?>" alt="" style="width: 100%;height: 150px; "/></a>
	
					</li>
				</ul><!--end logo-top-->
                
                
                </div>
              
<div class="span3 pull-right" >
    <?php get_sidebar('right'); ?>
</div>
</div>