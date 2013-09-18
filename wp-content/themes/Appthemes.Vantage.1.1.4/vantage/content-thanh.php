<div style="padding: 20px;">
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
        'order'    => 'ASC' //desc
        
    );
}else{
     $properties = array(
        'post_type' =>  'listing',
        'paged' => 1,
        'orderby' => 'post_title',
        'meta_query' => array(),
        'tax_query'=>array(),
        'order'    => 'ASC', //desc
    );   
}

//vi tri
if($_GET['location']!=null){
    if($_GET['location']!='Address'){
        $properties['meta_query'][] = array(
        	'key' => 'address',
        	'value' => $_GET['location'],
        	'compare' => 'LIKE'
        );
    }
}


//so dien thoai
if($_GET['phone']!=null){
    if($_GET['phone']!='Phone'){
    $properties['meta_query'][] = array(
    	'key' => 'phone',
    	'value' => $_GET['phone'],
    	'compare' => 'LIKE'
        );
    }    
}

//price
if($_GET['price']!=null){
    if($_GET['price']!='Price'){
        $properties['meta_query'][] = array(
        	'key' => 'price',
        	'value' => $_GET['price'],
        	'compare' => 'LIKE'
        );    
    }
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

foreach ($query as $perres){
    $pID=$perres->ID;
    $address=get_post_meta($pID,'address',true);
    $phone=get_post_meta($pID,'phone',true);
    $price=get_post_meta($pID,'price',true);
    $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
    
    $extend_values = get_post_meta($pID, 'featured_attachment', true);

    echo '<a href="'.$perres->guid.'"><img  src="'.wp_get_attachment_url($imagevalue).'" width="60px" height="60px" align="left" style="margin:5px;border:solid 1px gray;"></a>';
    echo '<div><h2>'.$perres->post_title.'</h2><br/>';
    echo 'Address:<i>'.$address.'</i><br/>';
    echo 'Phone:<i>'.$phone.'</i><br/>';
    echo 'price:<i>'.$price.' $</i><br/>';
    echo '<div style="width:200px">'.$extend_values .'<br/></div>';
    echo '<font style="font-size:18px;color:blue;" >descriptions:</font>'.$perres->post_content.'<br/></div>';
    echo '<hr/>';   
}
?>

</div>