<?php
// Template Name: Marketplace page
?>
<?php
    $args=array(
        'taxonomy' => 'marketplace_cat',
        'hierarchical' => '1',
        'hide_empty' => '0',
        'pad_counts' => '1',
        'orderby' => 'term_order'
    );
    $categories=get_categories($args);
    foreach($categories as $category) { 
        if($category->parent == 0 ){
            echo '<p><a href="'. get_term_link($category->slug, 'marketplace_cat') .'" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> '. $category->count . '</p> ';
            $categoryID =  $category->term_id;
            
            $args=array(
                'taxonomy' => 'marketplace_cat',
                'child_of' => $categoryID,
                'hide_empty' => '0',
                'orderby' => 'term_order'
            );
            $categories=get_categories($args);
            foreach($categories as $category) { 
                echo '<p> ---- <a href="'.get_home_url().'/show-marketplace-page/?cat='.$category->slug.'" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> '. $category->count . '</p> ';
            }
        }
    } 
?>