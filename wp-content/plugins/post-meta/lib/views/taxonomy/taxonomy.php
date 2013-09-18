<?php
global $postMeta; 

if($data){
    $title = "Edit your custom taxonomy :( $data[type] )";
    $hidden = "<input type='hidden' name='edit' value='edit' /><input type='hidden' name='edit_key' value='$editKey' />";
    $button_txt ="Update Custom Taxonomy";
}else{
    $title ="Add new custom Taxonomy";
    $hidden = '';
    $button_txt ='Create Custom Taxonomy';
}
?>
<div class="widefat stuffbox metabox-holder" style="padding: 0 !important;">
      <h3><?php echo $title; ?></h3>
      <div class="inside" style="padding:10px 10px;">
          <div class="msg"></div>
          <form id="pm_taxonomy_form" action="" method="post" onsubmit="pmUpdateTaxonomy(this); return false;" >
            <?php wp_nonce_field( 'nonce', 'pm_nonce' );  ?>
            <div id="pm_tabs" style="padding: 10px;">
                <ul>
                    <li><a href="#options"><span>Options</span></a></li>
                    <li><a href="#advanced-label"><span>Advanced Label Options</span></a></li>
                    <li><a href="#advanced-options"><span>Advanced Options</span></a></li>
                </ul>
                <div id="options">
                
                    <?php echo $postMeta->render("taxonomyOptions",array('taxonomy'=>$data),'taxonomy'); ?>
                
                </div>
                <div id="advanced-label">
                    
                    <?php echo $postMeta->render("taxonomyAdvLabel",array('taxonomy'=>$data['labels']),'taxonomy'); ?>
                    
                </div>
                <div id="advanced-options">
                    
                    
                    <?php echo $postMeta->render("taxonomyAdvOptions",array('taxonomy'=>$data['option']),'taxonomy'); ?>
                    
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