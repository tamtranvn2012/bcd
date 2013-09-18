 <div class="col-12">
 <!---LOGO--->
	
	<div class="col-1g-12" style="margin-bottom:10px;margin-top:10px;">
        <?php
            $wp_query = new WP_Query();
            $properties = array(
                    'post_type' =>  'logo_header',
                    'posts_per_page' => 5,
                    'paged' => 1,
                    'meta_query' => array(),
                    'tax_query' => array(),
             );
             
             $properties['meta_query'][] = array(
            'key' => 'show_header',
            'value' => '1',
            'compare' => 'LIKE'
            );
                       
            $query = $wp_query->query($properties);
            $meta1 = get_post_meta($query[1]->ID);
            
            foreach ($query as $perres){
                $pID=$perres->ID;
                $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
                $web_url=get_post_meta($pID,'website_url',true);
                echo '<div class="col-lg-1 ">';
                echo '<a href="'.$web_url.'"><img src="'.wp_get_attachment_url($imagevalue).'" alt="" style="width: 88px;height: 31px; }"/></a>';
                echo '</div><div class="col-lg-1 "></div>';
            }

        ?>
	</div>
 </div><!--end logo-->