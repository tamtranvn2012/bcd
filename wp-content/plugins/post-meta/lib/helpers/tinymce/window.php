<?php

if ( !defined('ABSPATH') )
    die('You are not allowed to call this page directly.');

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Add Post Meta Shortcode</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo PM_HELPER_URL  ?>tinymce/tinymce.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo PM_ASSECTS_URL  ?>js/post_meta_admin.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo PM_ASSECTS_URL ?>css/ui/jquery.ui.all.css" media="all" />
    <base target="_self" />
</head>
<style>
.pm_loading{
    background: url('<?php echo PM_ASSECTS_URL ?>css/jquery/loading.gif') no-repeat center center;
    padding: 10px;
}
</style>
<?php
global $postMeta;            
        $ajaxurl    = admin_url( 'admin-ajax.php' );
        $nonceText  = $postMeta->nonceText();
        $nonce      = wp_create_nonce( $nonceText );
        echo "<script type='text/javascript'>ajaxurl='$ajaxurl';pm_nonce='$nonce';</script>";
?>
<script type="text/javascript">

jQuery(document).ready(function(){ 
        post_type= jQuery('#post_type', window.parent.document).val();
        post_ID= jQuery('#post_ID', window.parent.document).val();
        
    jQuery('#g_meta_key_list').live('change',function(){
        g_meta_key = jQuery(this).val();
        if(g_meta_key){
                    arg='g_meta_key='+g_meta_key+'&post_type='+post_type+'&post_ID'+post_ID;
                     AjaxCall( jQuery(this), 'pm_sc_get_field_meta_key_list', arg, function(data){
                                jQuery('#meta-key').html(data);
                            });
                
            }else{
                jQuery('#meta-key').html('');
            }
    });


});
        

    function getType(element){
            type =jQuery(element).val();
            arg='type='+type+'&post_type='+post_type+'&post_ID'+post_ID;
            
            if(type=='field'){
                
               AjaxCall( jQuery(element).parent('label'), 'pm_sc_get_group_list', arg, function(data){
                        jQuery('#group_list_tr').show();
                        jQuery('#group-list').html(data);
                        jQuery('#meta-key').html('');
                        jQuery('#field-fs').show();
                        jQuery('.field-case').hide();
                        });
               }else{
               AjaxCall( jQuery(element).parent('label'), 'pm_sc_get_group_meta_key_list', arg, function(data){
                            jQuery('#group_list_tr').hide();
                            jQuery('#group-list').html();
                            jQuery('#meta-key').html(data);
                            jQuery('#field-fs').hide();
                            jQuery('.field-case').show();
                        });
               }
        }
    
     function indexCustom(element){
        if(jQuery(element).val()){
            jQuery(element).closest('.index-fs').find('.index-custom').hide();    
        }else{
            jQuery(element).closest('.index-fs').find('.index-custom').show();
        }
        
    }

</script>
<style>
.panel_wrapper, #link div.current {
    height: 170px !important;
}
.index-custom {
    width: 30px;
}
</style>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="postMeta" action="#">
	<div class="tabs">
		<ul>
			<li id="pmMetaKey_tab" class="current"><span><a href="javascript:mcTabs.displayTab('pmMetaKey_tab','pmMetaKey_panel');" onmousedown="return false;"><?php echo _e( 'Post Meta Pro') ?></a></span></li>
            <li id="pm_index_tab"><span><a href="javascript:mcTabs.displayTab('pm_index_tab','pm_index_panel');" onmousedown="return false;"><?php echo _e( 'Index setting' ) ?></a></span></li>
            <!--<li id="pm_img_tab"><span><a href="javascript:mcTabs.displayTab('pm_img_tab','pm_img_panel');" onmousedown="return false;"><?php echo _e( 'Field preview setting' ) ?></a></span></li>-->
		</ul>
	</div>
	
	<div class="panel_wrapper">
		<!-- Meta Key panel -->
		<div id="pmMetaKey_panel" class="panel current">
		<br />
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"  valign="top"><label for="type"><?php _e("Type :"); ?></label></td>
            <td>
                <label><input name="type" type="radio" onclick="getType(this);" value="field"  /> <?php _e('Field') ;?></label><br />
    			<label><input name="type" type="radio" onclick="getType(this);" value="group"  /> <?php _e('Group') ;?></label>
            </td>
          </tr>
          <tr style="display: none;" id="group_list_tr">
            <td nowrap="nowrap"><label for="type"><?php _e("Select Group :"); ?></label></td>
            <td id="group-list"></td>
          </tr>
           <tr>
            <td nowrap="nowrap"><label for="type"><?php _e("Meta Key :"); ?></label></td>
            <td id="meta-key"></td>
          </tr>
        </table>
		</div>
		<!-- Meta Key panel -->
        
        		<!-- index panel -->
		<div id="pm_index_panel" class="panel">
    		<br />
            <fieldset class="index-fs">
                <legend>Group</legend>
                <table border="0" cellpadding="4" cellspacing="0">
                        <tr>
                            <td valign="top"><label for="type"><?php _e("Group Index:"); ?></label></td>
                            <td>
                                <label class="field-case"><input name="groupIndex" type="radio"  onclick="indexCustom(this);"  value="all"  /> <?php _e('All Duplicate') ;?><br /></label>
                                <label class="field-case"><input name="groupIndex" type="radio"  onclick="indexCustom(this);" checked="true" value=""  /> <?php _e('Custom Index') ;?><br /></label>
                                <label><input type="text" class="index-custom" value="1" name="groupIndexCustom" /></label>
                            </td>
                        </tr>                     
                    </table>
            </fieldset>
            
            <fieldset class="index-fs" id="field-fs" style="display: none;">
                <legend>Field</legend>
                <table border="0" cellpadding="4" cellspacing="0">
                        <tr>
                            <td valign="top"><label for="type"><?php _e("Field Index:"); ?></label></td>
                            <td>
                                <label><input name="fieldIndex" type="radio" onclick="indexCustom(this);"  value="all"  /> <?php _e('All Duplicate') ;?></label><br />
                                <label><input name="fieldIndex" type="radio" onclick="indexCustom(this);" checked="true" value=""  /> <?php _e('Custom Index') ;?></label><br />
                                <label><input type="text" class="index-custom" value="1" name="fieldIndexCustom" /></label>
                            </td>
                        </tr>
                    </table>
            </fieldset>
             
		</div>
		<!-- index panel -->
        
        
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="<?php _e("Cancel"); ?>" onclick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="<?php _e("Insert"); ?>" onclick="insertPostMetaLink();" />
		</div>
	</div>
</form>
</body>
</html>