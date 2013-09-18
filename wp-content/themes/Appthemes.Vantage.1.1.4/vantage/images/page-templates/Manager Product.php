<?php
// Template Name:Manager Product
?>
<?php
$author=intval(get_query_var( 'id' ));
if($_GET!=null || $author!=null)
{
    
$author=intval(get_query_var( 'id' ));
    $wp_query = new WP_Query();
    $properties = array(
        'post_type' =>  'listing',
        'paged' => 1,
        'meta_query' => array(),
        'tax_query' => array(),
        'author'   => $author,
    );
    $count_p=0;
    $query = $wp_query->query($properties);
     foreach ($query as $perres){
        $count_p=$count_p+1;
     }
     
     $user_id = get_current_user_id();
     $user_view_acc='';
     if($author==$user_id||$user_id==1){
        $user_view_acc=$user_view_acc.'<div class="bntp">Edit</div><div class="bntp" >Delete</div><a href="'.get_home_url().'/add"><div class="bntp">Add product</div><div class="bntp"></a>upgrading</div>';      
     }



?>
            <div class="authors">
            <h2>Information Account:</h2><br />
            <a style="float: left;width:100px;margin:5px;" title="<?php the_author_meta( 'display_name', $author); ?>"><?php echo get_avatar($author); ?></a>
			<a style="font-size: 15px;text-decoration:none;" href="<?php echo get_author_posts_url( $author ); ?>" title="<?php the_author_meta( 'display_name', $author ); ?>"><?php the_author_meta( 'display_name', $author ); ?></a><br />
            Company:<b style="font-size: 15px;"><?php the_author_meta( 'company', $author); ?></b><br />
             <?php echo $user_view_acc?><br /><br />
            Email:<i><?php the_author_meta( 'user_email', $author ); ?></i><br />
            <b>Product : <?php echo $count_p ?>/10</b>
            </div>
            <br />
            <hr style="width:60%;float:left;margin-left:20px;"  />
           
            
   <div class="authors">
         <h2>Manager producs:</h2>    
<?php
    $wp_query = new WP_Query();
    $properties = array(
        'post_type' =>  'listing',
        'paged' => 1,
        'meta_query' => array(),
        'tax_query' => array(),
        'author'   => $author,
    );
    

    
    $query = $wp_query->query($properties);
    foreach ($query as $perres){
    //echo var_dump($perres);
    $pID=$perres->ID;
    $pName="'".$perres->post_title."'";
    $pUrl="'".get_home_url()."'";
    $author_id=$perres->post_author;
    

     $user_view_app=''; 
     
     if($author==$user_id||$user_id==1){
        $user_view_app=$user_view_app.'<a href="'.get_home_url().'/listings/edit/'.$pID.'"><div class="bntdelete">Edit</div></a><div class="bntdelete" onclick="delete_product('.$pID.','.$pName.','.$author_id.','.$pUrl.')">Delete</div>';        
     }
    
    $address=get_post_meta($pID,'address',true);
    $phone=get_post_meta($pID,'phone',true);
    $price=get_post_meta($pID,'price',true);
    $imagevalue=get_post_meta($pID,'_thumbnail_id',true);
    $author_id=$perres->post_author;
    
    $sen_id_author=get_home_url().'/user/'.$author_id;
    
    $extend_values = get_post_meta($pID, 'featured_attachment', true);

    echo '<div class="product">';
    echo '<h2 style="font-size:18px">'.$perres->post_title.'</h2><br/>';
    echo  '<a href="'.$perres->guid.'"><img src="'.wp_get_attachment_url($imagevalue).'" width="60px"></a><br/>';
    echo 'price:<i style="color:red;">'.$price.' $</i><br/>';
    echo $user_view_app;
    echo '</div>';
    }
    
    ?>
    </div>
    <?php
}else{
    
    echo '<p align="center"><h2>No Account</h2></p>';
}
?>