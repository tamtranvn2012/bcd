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
    <div class="col-xs-10">
            <h2><?php the_author_meta( 'company', $author ); ?></h2>
            <div style="float: left;margin:5px;padding: 5px;width:100%;" class="authors">
            <a style="float: left;width:100px;margin:5px;" title="<?php the_author_meta( 'display_name', $author ); ?>"><?php echo get_avatar($author); ?></a>
            <b style="font-size: 15px;"><?php the_author_meta( 'phone', $author ); ?></b><br />
            <b style="font-size: 15px;"><?php the_author_meta( 'address', $author ); ?></b><br />
            <b style="font-size: 15px;"><?php the_author_meta( 'website', $author ); ?></b><br />
            <i><?php the_author_meta( 'user_email', $author ); ?></i><br />
            <b style="font-size: 15px;"><?php the_author_meta( 'description', $author ); ?></b><br />
            </div>
   </div>
<?php  

?>