<?php
// Template Name:Video Test
 $arr_post=array(1, 2, 3,4,5,6);
 $count_post=0;
 ?>
 
<div class="col-xs-10">
    <p class="title-page">Video Ads</p>
    

<!--- colum left ---!>
<div class="col-lg-4" style="padding-left:38px;margin-top: 20px;">
    <?php
            $args=array(
			'taxonomy' => 'album_video',
			'hierarchical' => '1',
			'hide_empty' => '0',
			'pad_counts' => '1',
			'orderby' => 'term_order'
			);
            
			$categories=get_categories($args);
			foreach($categories as $category){ 
   
            $wp_query = new WP_Query();
            $properties = array(
                'post_type' =>  'post_video',
                'posts_per_page' => 3,
                'meta_query' => array(),
                'tax_query' => array(),
             );
                                
             $properties['tax_query']=array(
                array(
                    'taxonomy' => 'album_video',
                    'terms' => $category->slug,
                    'field' => 'slug',
                )
             );
             $query = $wp_query->query($properties);
             $web_top=get_post_meta($query[0]->ID,'url',true);
             
                if(!in_array($category->slug,$arr_post)){
                    ?>
                        <div class="span3" style="margin-left: 0;">
                        <p style="color: #00457d;font-weight: bold;"><?php echo $category->name;?></p>
						<embed  type="application/x-shockwave-flash" width="90%" height="226" wmode="transparent" src="<?php echo $web_top;?>" allowfullscreen="true"/>
						<div class="text">
                            <?php 
                            foreach ($query as $perres){
                            $pID=$perres->ID;
                                echo '<p style="color: #5d5d5d;"><a href="'.$perres->guid.'">'.$perres->post_title.'</a></p>';
                            }
                            ?>
                        </div>
						</div>
                    <?php
                }
			} 
?>

</div>
 <div class="col-lg-4" style="padding: 0;">
 <!--- colum midle ---!>
<div style="width: 100%;">
<?php
            $args=array(
			'taxonomy' => 'album_video',
			'hierarchical' => '1',
			'hide_empty' => '0',
			'pad_counts' => '1',
            'number'	=> 1,
			'orderby' => 'term_order',
            'meta_key' => 'show_top',
            'meta_value' => true
			);
            
			$categories=get_categories($args);
			foreach($categories as $category){ 
   
            $wp_query = new WP_Query();
            $properties = array(
                'post_type' =>  'post_video',
                'posts_per_page' => 3,
                'meta_query' => array(),
                'tax_query' => array(),
             );
                                
             $properties['tax_query']=array(
                array(
                    'taxonomy' => 'album_video',
                    'terms' => $category->slug,
                    'field' => 'slug',
                )
             );
             $query = $wp_query->query($properties);
             $web_top=get_post_meta($query[0]->ID,'url',true);
                    ?>
                        <p style="color: #00457d;font-weight: bold;"><?php echo $category->name;?></p>
						<embed  type="application/x-shockwave-flash" class="top-video-a1" width="100%" height="226" wmode="transparent" src="<?php echo $web_top;?>" allowfullscreen="true"/>
                        <p style="width: 100%;text-align: center;font-weight:bold;border: solid 1px black;padding: 3px;background-color: ghostwhite;"><a href="<?php echo $web_top;?>">Full link video</a></p>
						<div class="text">
                            <?php 
                            foreach ($query as $perres){
                            $pID=$perres->ID;
                                echo '<p class="video-txt"><a href="'.$perres->guid.'">'.$perres->post_title.'</a></p>';
                            }
                            ?>
                        </div>
                    <?php
			} 
?>
</div><!-- end midle --!>
       <div class="span3" style="margin-left: 0;">
<?php

            $args=array(
			'taxonomy' => 'album_video',
			'hierarchical' => '1',
			'hide_empty' => '0',
			'pad_counts' => '1',
            'number'	=> 2,
			'orderby' => 'term_order'
			);
            
			$categories=get_categories($args);
			foreach($categories as $category){ 
            $arr_post[$count_post]=$category->slug;
            
            $count_post++;
                $wp_query = new WP_Query();
                $properties = array(
                    'post_type' =>  'post_video',
                    'post_content' => $_GET['desc'],
                    'posts_per_page' => 3,
                    'meta_query' => array(),
                    'tax_query' => array(),
                 );
                                    
                 $properties['tax_query']=array(
                    array(
                        'taxonomy' => 'album_video',
                        'terms' => $category->slug,
                        'field' => 'slug',
                    )
                 );
                 $query = $wp_query->query($properties);
                 $web_top=get_post_meta($query[0]->ID,'url',true);
                        ?>
                            <div class="col-lg-12">
                            <p style="color: #00457d;font-weight: bold;"><?php echo $category->name;?></p>
    						<embed  type="application/x-shockwave-flash" width="100%" height="226" wmode="transparent" src="<?php echo $web_top;?>" allowfullscreen="true"/>
    						<div class="text">
                                <?php 
                                foreach ($query as $perres){
                                $pID=$perres->ID;
                                    echo '<p style="color: #5d5d5d;"><a href="'.$perres->guid.'">'.$perres->post_title.'</a></p>';
                                }
                                ?>
                            </div>
    						</div>
                        <?php
			} 
?>
</div><!-- end right --!>


 </div>

<!--- colum right ---!>
<div class="col-lg-4 "  style="padding: 0;margin-top: 20px;">
    <div class="span3 pull-right">
<?php
            $args=array(
			'taxonomy' => 'album_video',
			'hierarchical' => '1',
			'hide_empty' => '0',
			'pad_counts' => '1',
            'number'	=> 4,
			'orderby' => 'term_order'
			);
            
			$categories=get_categories($args);
			foreach($categories as $category){ 
   
            $wp_query = new WP_Query();
            $properties = array(
                'post_type' =>  'post_video',
                'posts_per_page' => 3,
                'meta_query' => array(),
                'tax_query' => array(),
             );
                                
             $properties['tax_query']=array(
                array(
                    'taxonomy' => 'album_video',
                    'terms' => $category->slug,
                    'field' => 'slug',
                )
             );
             $query = $wp_query->query($properties);
             $web_top=get_post_meta($query[0]->ID,'url',true);
             
                if(!in_array($category->slug,$arr_post)){
                    $arr_post[$count_post]=$category->slug;
                    $count_post++;
                    ?>
                        <div class="col-lg-12">
                        <p style="color: #00457d;font-weight: bold;"><?php echo $category->name;?></p>
						<embed  type="application/x-shockwave-flash" width="90%" height="100%" wmode="transparent" src="<?php echo $web_top;?>" allowfullscreen="true"/>
						<div class="text">
                            <?php 
                            foreach ($query as $perres){
                            $pID=$perres->ID;
                                echo '<p style="color: #5d5d5d;"><a href="'.$perres->guid.'">'.$perres->post_title.'</a></p>';
                            }
                            ?>
                        </div>
						</div>
                    <?php
                }
			} 
?>
</div>
    
</div><!-- end right --!>

</div><!-- col 9 --!>

