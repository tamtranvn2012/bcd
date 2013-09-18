<?php
// Template Name:Show Marketplace page
 ?>
 
 <?php
 
    if($_GET){
             $wp_query = new WP_Query();
             $properties = array(
            'post_type' =>  'marketplace',
            'paged' => 1,
            'orderby' => 'post_title',
            'meta_query' => array(),
            'tax_query'=>array(),
            'order'    => 'desc', //Asc
         );
         
         
         $properties['tax_query']=array(
                array(
                    'taxonomy' => 'marketplace_cat',
                    'terms' => $_GET['cat'],
                    'field' => 'slug',
                )
         ); 
         
         $query = $wp_query->query($properties);
         foreach ($query as $perres){
            $pID=$perres->ID;
            $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
            
            echo '<a href="'.$perres->guid.'"><img src="'.wp_get_attachment_url($imagevalue).'"></a>';
            echo 'post id:'.$pID.'<br/>';
            echo 'post title:'.$perres->post_title.'<br/>';
            echo 'post content:'.$perres->post_content.'<br/>';
            echo '<hr/>';
         }

    }else{
        echo 'khong co du lieu';
    } 
 ?>