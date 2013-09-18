<div class="span2" style="margin-top:10px;">
<?php
if($_SERVER['REQUEST_URI']=='/bcdD/classsified/'){
?>
	<div class="sidebar">
		<div class="title">
			Services
		</div><!--end title-->
			<?php
					$args=array(
						'taxonomy' => 'listing_category',
						'child_of' => $categoryID,
						'hide_empty' => '0',
						'orderby' => 'term_order',
                        'parent' => 150
					);
					$categories=get_categories($args);
					foreach($categories as $category) { 
						echo '<p><a href="'.get_home_url().'/show-find/?cat='.$category->slug.'" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ('. $category->count . ')</p> ';
					}
			?>
	</div><!--end siderbar-->
<?php
}
elseif($_SERVER['REQUEST_URI']=='/bcdD/video/'){
?>
	<div class="sidebar">
		<div class="title">
			Categories
		</div><!--end title-->
			<?php
					$args=array(
						'taxonomy' => 'category',
						'child_of' => $categoryID,
						'hide_empty' => '0',
						'orderby' => 'term_order',
                        'parent' => 292
					);
					$categories=get_categories($args);
					foreach($categories as $category) { 
						echo '<p><a href="'.get_home_url().'/show-find/?cat='.$category->slug.'" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ('. $category->count . ')</p> ';
					}
			?>
	</div><!--end siderbar-->

<?php
}
elseif($_SERVER['REQUEST_URI']=='/bcdD/market-place/'){
?>
	<div class="sidebar">
		<div class="title">
			Categories
		</div><!--end title-->
			<?php
					$args=array(
						'taxonomy' => 'listing_category',
						'child_of' => $categoryID,
						'hide_empty' => '0',
						'orderby' => 'term_order',
                        'parent' => 233
					);
					$categories=get_categories($args);
					foreach($categories as $category) { 
						echo '<p><a href="'.get_home_url().'/show-find/?cat='.$category->slug.'" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ('. $category->count . ')</p> ';
					}
			?>
	</div><!--end siderbar-->

<?php
}
else{
?>
	<div class="sidebar">
		<div class="title">
			Categories
		</div><!--end title-->
			<?php
			$args=array(
			'taxonomy' => 'listing_category',
			'hierarchical' => '1',
			'number'	=> 20,
			'hide_empty' => '0',
			'pad_counts' => '1',
			'orderby' => 'term_order',
			);
            
            
			$categories=get_categories($args);
			foreach($categories as $category) { 
				if($category->parent == 0 ){
				//	echo '<p><a href="'.get_home_url().'/listings/?cat='.$category->slug.'" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ('. $category->count . ')</p> ';
					$categoryID =  $category->term_id;
					
					$args=array(
						'taxonomy' => 'listing_category',
						'child_of' => $categoryID,
						'hide_empty' => '0',
						'orderby' => 'term_order'
					);
					$categories=get_categories($args);
					foreach($categories as $category) { 
						echo '<p><a href="'.get_home_url().'/show-find/?cat='.$category->slug.'" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> ('. $category->count . ')</p> ';
					}
				}
			} 
			?>
	</div><!--end siderbar-->
<?php    
};
?>
</div><!--end sider-->