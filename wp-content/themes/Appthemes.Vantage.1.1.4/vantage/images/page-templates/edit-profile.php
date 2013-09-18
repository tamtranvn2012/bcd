<?php
/*
 * Template Name: Edit Profile
 *
 * This template must be assigned to a page
 * in order for it to work correctly
 *
 */

    $author=$_GET['id'];
    ?>
            <h2>Infor Account:</h2>
            <div style="float: left;margin:5px;padding: 5px;width:100%;" class="authors">
            <a style="float: left;width:100px;margin:5px;" href="<?php echo home_url().'/edit-profile/?id='.$author; ?>" title="<?php the_author_meta( 'display_name', $author ); ?>"><?php echo get_avatar($author); ?></a>
			<a style="font-size: 15px;text-decoration:none;" href="<?php echo home_url().'/edit-profile/?id='.$author;  ?>" title="<?php the_author_meta( 'display_name', $author ); ?>"><?php the_author_meta( 'display_name', $author ); ?></a><br />
            User Login:<b style="font-size: 15px;"><?php the_author_meta( 'User Login', $author ); ?></b><br />
            Phone:<b style="font-size: 15px;"><?php the_author_meta( 'phone', $author ); ?></b><br />
            Address:<b style="font-size: 15px;"><?php the_author_meta( 'address', $author ); ?></b><br />
            Website:<b style="font-size: 15px;"><?php the_author_meta( 'website', $author ); ?></b><br />
            Company:<b style="font-size: 15px;"><?php the_author_meta( 'company', $author ); ?></b><br />
            Email:<i><?php the_author_meta( 'user_email', $author ); ?></i><br />
            Description:<b style="font-size: 15px;"><?php the_author_meta( 'description', $author ); ?></b><br />
            </div>
<?php  

?>