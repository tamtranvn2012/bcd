<?php  
global $postMeta;

?>
<input type="hidden" name="post_type" id="pm_post_type" value="<?php echo $post_type; ?>" />
    <form id="group_form" method='post' action='options.php' onsubmit="meta_option_group_save(this); return false;">
        
        <div id='pm_manage_group'>
                    <div style="float: left;">
                     <input type="button" post_type="<?php  echo $post_type; ?>" class="button-primary" onclick="moNewGroup(this);" value='New Group' />
              	     <input type="submit" class="button button-primary" name="submit" id="submit" value="Save Custom Option" />
                    </div>
                    <div style="float: right;">Manage Meta Option <?php  echo $post_type; ?></div>
       	</div>
        <div id="msg"></div>
                    <div id="pm_group_container" class="meta-group-holder  ui-sortable ui-droppable">             
                                
                                <?php
                                    $pm_options = get_option($postMeta->options['post_meta']);
                                    $meta_boxs =$pm_options[$post_type];
                                     if(is_array($meta_boxs) && !empty($meta_boxs)){
                                     
                                             $i=0;
                                          foreach($meta_boxs['group'] as $meta_box_id => $meta_box){
                                            $i++;
                                            $postMeta->render('group', array('meta_box'=>$meta_box,'loop'=>$i,'id'=>$meta_box_id,'post_type'=>$post_type),'postmeta');
                                            } //end of metaboxes 
                                     
                                     }
                                     else{
                                        echo '<div id="not-found">No Group Found </div>';
                                     }
                             ?>  
                        </div> <!-- pm_group_container   -->
        <div id='pm_manage_group'>
                    <div style="float: left;">
                     <input type="button" post_type="<?php  echo $post_type; ?>" class="button-primary" onclick="moNewGroup(this);" value='New Group' />
              	     <input type="submit" class="button button-primary" name="submit" id="submit" value="Save Custom Option" />
                    </div>
       	</div>                              
                 </form>
                            <?php $maxKey      = $postMeta->maxKey( $meta_boxs['group'] ); ?>
                            <?php $last_group_id    = $maxKey ? $maxKey : 0 ?>
                        <input type='hidden' id='last_group_id' value='<?php echo $last_group_id; ?>' />
<script>
jQuery(function() {
                jQuery('.meta-group-holder').sortable();
                jQuery('.metabox-fields-holder').sortable();
                 
});

</script>