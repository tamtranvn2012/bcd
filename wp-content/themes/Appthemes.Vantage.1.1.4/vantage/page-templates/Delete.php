<?php
// Template Name:Delete

?>

<?php
   // wp_delete_post($_GET['id']);
?>

<div class="col-xs-10">

 <div class="span7"> 
                        <div class="div_form row">
                                <p style="margin-top: 35px;">
                                <img align="left" src="<?php echo  get_stylesheet_directory_uri().'/images/deletes.png';?>" alt=""/>
                                <h2>Delete product "<?php echo $_GET['names']; ?>" success!</h2>
                                <a href="<?php  echo get_home_url().'/show-find/'; ?>">Go back list product</a><br />
                                <a href="<?php  echo get_home_url().'/user/'.$_GET['authors']; ?>">Go back manager product user</a>
                                </p>
                                
                        </div>
                    
</div>

	


 <div class="span3"><?php get_sidebar('right'); ?></div>
</div>