<div class="row" style="margin-top:20px;">

<?php
            $wp_query = new WP_Query();
            $properties = array(
                    'post_type' =>  'logo_sponsors',
                    'posts_per_page' => 16,
                    'meta_query' => array(),
                    'tax_query' => array(),
             );
             
             $properties['meta_query'][] = array(
            'key' => 'show_header',
            'value' => '1',
            'compare' => 'LIKE'
            );
                       
            $query = $wp_query->query($properties);   
?>
</div>
 
<ul class="col-lg-11 list-inline" style="margin-top:20px;">
	<?php
            for($i=0;$i<4;$i++){
                $pID=$query[$i]->ID;
                $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
                $web_url=get_post_meta($pID,'website_url',true);
                echo '<li class="col-lg-1"></li>';
                echo '<li class="col-lg-2">';
                echo '<a href="http://'.$web_url.'"><img src="'.wp_get_attachment_url($imagevalue).'" alt="" style="width: 88px;height: 31px; }"/></a>';
                echo '</li>';
            } 
	?>
</ul><!--end span1-->

<ul class="col-lg-11 list-inline" style="margin-top:20px;">
	<?php
            for($i=4;$i<8;$i++){
                $pID=$query[$i]->ID;
                $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
                $web_url=get_post_meta($pID,'website_url',true);
                
                echo '<li class="col-lg-2">';
                echo '<a href="http://'.$web_url.'"><img src="'.wp_get_attachment_url($imagevalue).'" alt="" style="width: 88px;height: 31px; }"/></a>';
                echo '</li>';
                echo '<li class="col-lg-1"></li>';
            } 
	?>
</ul><!--end span2-->

<ul class="col-lg-11 list-inline" style="margin-top:20px;">
	<?php
            for($i=8;$i<12;$i++){
                $pID=$query[$i]->ID;
                $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
                $web_url=get_post_meta($pID,'website_url',true);
                echo '<li class="col-lg-1"></li>';
                echo '<li class="col-lg-2">';
                echo '<a href="http://'.$web_url.'"><img src="'.wp_get_attachment_url($imagevalue).'" alt="" style="width: 88px;height: 31px; }"/></a>';
                echo '</li>';
            } 
	?>
	
</ul><!--end span2-->

<ul class="col-lg-11 list-inline" style="margin-top:20px; margin-bottom:20px;">
	<?php
            for($i=12;$i<16;$i++){
                $pID=$query[$i]->ID;
                $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
                $web_url=get_post_meta($pID,'website_url',true);
                
                echo '<li class="col-lg-2">';
                echo '<a href="http://'.$web_url.'"><img src="'.wp_get_attachment_url($imagevalue).'" alt="" style="width: 88px;height: 31px; }"/></a>';
                echo '</li>';
                echo '<li class="col-lg-1"></li>';
                
            } 
	?>
    
	<div class="col-lg-4 pull-right" style="margin-top: 10px;">

<a href="<?php echo get_home_url().'/sponsors/' ?>"><button type="button" class="btn btn-danger">View All Sponsors</button></a>
</div> <!--ens button view-->
</ul><!--end span4-->
        