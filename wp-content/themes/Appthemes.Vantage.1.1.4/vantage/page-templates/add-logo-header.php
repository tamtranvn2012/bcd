<?php
    // Template Name: Add logo header
?>


<div class="col-xs-10">
    
    <div class="span7" >

        <?php //$wp_upload_dir=wp_upload_dir(); echo var_dump($wp_upload_dir);?>
        <?php //echo $wp_upload_dir['url'].'<hr/>'.do_shortcode('[contact-form-7 id="690" title="Add logo header"]'); ?>
        
        <?php  echo do_shortcode('[gravityform id=1]');?>    
        </div>
    
    
<div class="span3">
<?php

    get_sidebar('right');
?>
</div>

</div>