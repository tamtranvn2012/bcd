
<div class="col-xs-10">
    <div class="span7">
<?php

$wp_query = new WP_Query();
//truy van noi dung
if($_GET['desc']!=null){
    $properties = array(
        'post_type' =>  'listing',
        'post_content' => $_GET['desc'],
        'paged' => 1,
        'orderby' => 'post_title',
        'meta_query' => array(),
        'tax_query' => array(),
        'order'    => 'desc' //desc
        
    );
}else{
     $properties = array(
        'post_type' =>  'listing',
        'paged' => 1,
        'orderby' => 'post_title',
        'meta_query' => array(),
        'tax_query'=>array(),
        'order'    => 'desc', //Asc
    );   
}

//vi tri
if($_GET['country']!=null){
$properties['meta_query'][] = array(
	'key' => 'address',
	'value' => $_GET['country'],
	'compare' => 'LIKE'
);
}


//so dien thoai
if($_GET['phone']!=null){
$properties['meta_query'][] = array(
	'key' => 'phone',
	'value' => $_GET['phone'],
	'compare' => 'LIKE'
);    
}

//price
if($_GET['price']!=null){
$properties['meta_query'][] = array(
	'key' => 'price',
	'value' => $_GET['price'],
	'compare' => 'LIKE'
);    
}

//catalogry
if($_GET['cat']!=null){
$properties['tax_query']=array(
    array(
        'taxonomy' => 'listing_category',
        'terms' => $_GET['cat'],
        'field' => 'slug',
    )
);
}


$query = $wp_query->query($properties);
$meta1 = get_post_meta($query[1]->ID);

?>
<div class="col-lg-12">
<h2 class="list-title">List Product- Search: contry "<?php echo $_GET['country']; ?>"</h2>

<?php
 $user_id = get_current_user_id();
foreach ($query as $perres){

    $pID=$perres->ID;
    $pName="'".$perres->post_title."'";
    $pUrl="'".get_home_url()."'";
    
    $address=get_post_meta($pID,'address',true);
    $phone=get_post_meta($pID,'phone',true);
    $price=get_post_meta($pID,'price',true);
    $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
    $author_id=$perres->post_author;
    
    $sen_id_author=get_home_url().'/user/'.$author_id;

    if($user_id==$perres->post_author|$user_id==1){
        $st_view='<a href="'.get_home_url().'/listings/edit/'.$pID.'"><div class="bntp">Edit</div></a><div class="bntp" onclick="delete_product('.$pID.','.$pName.','.$author_id.','.$pUrl.')">Delete</div>';
    }else{
         $st_view='';
    }
    
    //echo 'anh:'.$extend_values;
    echo '<div class="home-p">';
    echo '<h3>'.$perres->post_title.'</h3><br/>';
    echo '<a href="'.$perres->guid.'"><img src="'.wp_get_attachment_url($imagevalue).'"></a>';
    echo '<ul>';
    echo '<li>Address:<b>'.$address.'</b></li>';
    echo '<li>Phone:<b>'.$phone.'</b></li>';
    echo '</ul><ul>';
    echo '<li>price:<i>'.$price.' $</i></li>';
    echo '<li>Manager by:<a href="'.$sen_id_author.'">'.get_the_author_meta('display_name' , $author_id).'</a></li>';
    echo '</ul>';
    echo '<div class="m"><a href="'.$perres->guid.'"><div class="bntp">View</div></a><a href="'.$sen_id_author.'"><div class="bntp">Product More</div></a>'.$st_view.'</div>';
    echo '<samp><b>descriptions:</b>'.$perres->post_content.'</samp>';
    echo '</div>'; 

}
?>
</div>


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
</div>
</div>




<div class="span3">
<?php get_sidebar('right'); ?>
</div>

</div>