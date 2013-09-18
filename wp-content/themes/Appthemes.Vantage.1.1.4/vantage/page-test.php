<?php 
$wp_query = new WP_Query();

     $properties = array(
        'post_type' =>  'listing',
        'paged' => 1,
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
    var_dump(get_post_meta($perres->ID,false));
    $pID=$perres->ID;
    $pName="'".$perres->post_title."'";
    $pUrl="'".get_home_url()."'";
    
    $address=get_post_meta($pID,'address',true);
    $phone=get_post_meta($pID,'phone',true);
    $price=get_post_meta($pID,'price',true);
    $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
    $author_id=$perres->post_author;
    
    $sen_id_author=get_home_url().'/user/'.$author_id;

    
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