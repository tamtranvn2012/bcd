<?php
global $postMeta; 

if($data){
    $title = "Edit your custom post type :( $data[type] )";
    $hidden = "<input type='hidden' name='edit' value='edit' /><input type='hidden' name='edit_key' value='$editKey' />";
    $button_txt ="Update Custom Post Type";
}else{
    $title ="Add new custom post type";
    $hidden = '';
    $button_txt ='Create Custom Post Type';
}
?>
<div class="widefat stuffbox metabox-holder" style="padding: 0 !important;">
      <h3><?php echo $title; ?></h3>
      <div class="inside" style="padding:10px 10px;">
          <div class="msg"></div>
          <form id="pm_posttype_form" action="" method="post" onsubmit="pmUpdatePostType(this); return false;" >
            <?php wp_nonce_field( 'nonce', 'pm_nonce' );  ?>
            <div id="pm_tabs" style="padding: 10px;">
                <ul>
                    <li><a href="#options"><span>Options</span></a></li>
                    <li><a href="#advanced-label"><span>Advanced Label Options</span></a></li>
                    <li><a href="#advanced-options"><span>Advanced Options</span></a></li>
                </ul>
                <div id="options">
                
                    <?php echo $postMeta->render("postTypeOptions",array('postType'=>$data),'posttype'); ?>
                
                </div>
                <div id="advanced-label">
                    
                    <?php echo $postMeta->render("postTypeAdvLabel",array('postType'=>$data['labels']),'posttype'); ?>
                    
                </div>
                <div id="advanced-options">
                    
                    
                    <?php echo $postMeta->render("postTypeAdvOptions",array('postType'=>$data['option']),'posttype'); ?>
                    
                </div>
            </div>
            
            <p>
                <?php echo $hidden; ?>
                <input type="submit" class="button button-primary" id="submit" value="<?php echo $button_txt; ?>" />
            </p>
            
          </form>
        <div class="msg"></div>
      </div>
</div>
<script type="text/javascript">
jQuery(function() { 
    jQuery( "#pm_tabs" ).tabs();    
});


</script>