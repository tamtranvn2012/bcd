<?php
global $postMeta; 
$settings=get_option($postMeta->options['settings']);

?>
        
          <form id="pm_settings_form" action="" method="post" onsubmit="pmUpdateSettings(this); return false;" >
            <div id="pm_tabs" style="padding: 10px;">
                <ul>
                    <li><a href="#pm_settings_file"><span>File</span></a></li>
                </ul>
                <div id="pm_settings_general">
                
                
                </div>
                <div id="pm_settings_file">
                    
                    <?php echo $postMeta->render("settingFile",array('file'=>$settings['file']),'setting'); ?>
                    
                </div>
            </div>
            
            <p>
                <a href="#Restore" class="button" onclick="restoreSettings(this); return false;" id="restore" >Restore default settings</a>  <input type="submit" class="button-primary" id="submit" value="Save Settings" />
            </p>
            
          </form>
          <div id='msg'></div>
<script type="text/javascript">
jQuery(function() { 
    jQuery( "#pm_tabs" ).tabs();    
});


</script>