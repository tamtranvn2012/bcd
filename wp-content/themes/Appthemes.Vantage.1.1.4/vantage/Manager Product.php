<?php
// Template Name:Manager Product
?>
<?php
if($_GET)
{
$author=$_GET['id'];

?>
            
            <div style="float: left;margin:5px;padding: 5px;width:100%;" class="authors">
            <h2>Information Account</h2><br />
            <a style="float: left;width:100px;margin:5px;" title="<?php the_author_meta( 'display_name', $author); ?>"><?php echo get_avatar($author); ?></a>
			<a style="font-size: 15px;text-decoration:none;" href="<?php echo get_author_posts_url( $author ); ?>" title="<?php the_author_meta( 'display_name', $author ); ?>"><?php the_author_meta( 'display_name', $author ); ?></a><br />
			
            Company:<b style="font-size: 15px;"><?php the_author_meta( 'company', $author); ?></b><br />
            Email:<i><?php the_author_meta( 'user_email', $author ); ?></i>
            </div>
<?php
}else{
    
    echo '<p align="center"><h2>No Account</h2></p>';
}
?>