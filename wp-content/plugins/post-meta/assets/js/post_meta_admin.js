/* Post type Manage Page  */

function pmUpdatePostType(element){
    jQuery(element).validationEngine();
    if( !jQuery(element).validationEngine("validate") ) {
                    
                    jQuery('.pc_error').remove(); 
                    jQuery('.pc_success').remove(); 
                    }else{
                        arg=jQuery( element ).serialize();
                        bindElement =jQuery('#submit');
                        jQuery('.pc_error').remove(); 
                        jQuery('.pc_success').remove();
                        
                        JsonAjaxCall( jQuery(element), "pm_post_type_update", arg, function(data){
                                    jQuery('.msg').children(".pc_error").remove();
                                    jQuery('.msg').html(data.msg);
                                    if(data.menu){
                                        jQuery('#pm_posttype_menu').append(data.menu).fadeIn("slow");
                                    }
                        });
                    }
    
}


function editPostType(element){
    
    arg = "post_type_key="+jQuery(element).attr('rel');
    AjaxCall( jQuery(element), 'pm_post_type_edit', arg, function(data){
        jQuery("#pm_loading_area").html( data ); 
        
        jQuery('.pm_manage_menu_option a').each(function(){
            jQuery(this).addClass('button');
            jQuery(this).removeClass('button-primary');
        }); 
        
        jQuery(element).removeClass('button');
        jQuery(element).addClass('button-primary'); 
    });
    
}

function deletePostType(element){
    if( confirm('Confirm to remove?') ){
        arg = "post_type_key="+jQuery(element).attr('rel');
        AjaxCall( jQuery(element), 'pm_post_type_delete', arg, function(data){
            jQuery(element).parents('.pm_manage_menu_option').parents('.pm_menu_option').remove();
        });
    }
}

function addPostType(element){
    AjaxCall( jQuery(element), 'pm_post_type_add','', function(data){
        jQuery("#pm_loading_area").html( data ); 
        jQuery('.pm_manage_menu_option a').each(function(){
            jQuery(this).addClass('button');
            jQuery(this).removeClass('button-primary');
        }); 
    });
}


function pmPostTypeSuggetion(element){
    
        jQuery('#advanced-label input[name*=pm_posttype]:text').each(function(index,value) {
              rel = jQuery(this).attr('rel');
              label = jQuery('#pm_posttype_name').val();
              if(!rel){
                rel =label;
              }else{
                
                if(rel=='All'){
                    rel='All '+label;
                }else if(rel=='Add'){
                    rel='Add '+label;
                }else if(rel=='All New'){
                    rel='All New '+label;
                }else if(rel=='Add'){
                    rel='Edit '+label;
                }else if(rel=='Edit'){
                    rel='Edit '+label;
                }else if(rel=='New'){
                    rel='New '+label;
                }else if(rel=='View'){
                    rel='View '+label;
                }else if(rel=='No found'){
                    rel='No '+label+' found';
                }else if(rel=='No found in Trash'){
                    rel='No '+label+' found in Trash';
                }else if (rel =='Parent:'){
                    rel='Parent '+label+':';
                }else{
                    rel=jQuery(this).attr('rel')+label;
                }
                
              }
              jQuery(this).val(rel);
            });
            jQuery('#pm_posttype_label').val(jQuery(element).val()+'s');
    
}
    


/*  End */

/* Taxonomy manage page */
function pmUpdateTaxonomy(element){
    jQuery(element).validationEngine();
                    if( !jQuery(element).validationEngine("validate") ) {
                    
                        jQuery('.pc_error').remove(); 
                        jQuery('.pc_success').remove(); 
                    }else{
                        arg=jQuery( element ).serialize();
                        bindElement = jQuery('#submit');
                        jQuery('.pc_error').remove(); 
                        jQuery('.pc_success').remove();
                        JsonAjaxCall( jQuery(element), "pm_taxonomy_update", arg, function(data){
                                    jQuery('.msg').children(".pc_error").remove();
                                    jQuery('.msg').html(data.msg);
                                    if(data.menu){
                                        jQuery('#pm_taxonomy_menu').append(data.menu).fadeIn("slow");
                                    }
                        });
                    }
    
}

function editTaxonomy(element){
    
    arg = "taxonomy_key="+jQuery(element).attr('rel');
    AjaxCall( jQuery(element), 'pm_taxonomy_edit', arg, function(data){
        jQuery("#pm_loading_area").html( data ); 
        
        jQuery('.pm_manage_menu_option a').each(function(){
            jQuery(this).addClass('button');
            jQuery(this).removeClass('button-primary');
        }); 
        
        jQuery(element).removeClass('button');
        jQuery(element).addClass('button-primary'); 
    });
    
}

function deleteTaxonomy(element){
    if( confirm('Confirm to remove?') ){
        arg = "taxonomy_key="+jQuery(element).attr('rel');
        AjaxCall( jQuery(element), 'pm_taxonomy_delete', arg, function(data){
            jQuery(element).parents('.pm_manage_menu_option').parents('.pm_menu_option').remove(); 
        });
    }
}

function addTaxonomy(element){
    AjaxCall( jQuery(element), 'pm_taxonomy_add', '', function(data){
        jQuery("#pm_loading_area").html( data ); 
        jQuery('.pm_manage_menu_option a').each(function(){
            jQuery(this).addClass('button');
            jQuery(this).removeClass('button-primary');
        }); 
    });
}


function pmTaxonomySuggetion(element){
    jQuery('#advanced-label input[name*=pm_taxonomy]:text').each(function(index,value) {
              rel = jQuery(this).attr('rel');
              label = jQuery('#pm_taxonomy_name').val();
              if(!rel){
                rel =label;
              }else{
                if(rel=='Search'){
                    rel='Search '+label;
                }else if(rel=='Add New'){
                    rel='Add New '+label;
                }else if(rel=='Popular'){
                    rel='Popular '+label;
                }else if(rel=='All'){
                    rel='All '+label;
                }else if(rel=='Parent'){
                    rel='Parent '+label;
                }else if(rel=='Parent:'){
                    rel='Parent '+label+':';
                }else if(rel=='Edit'){
                    rel='Edit '+label;
                }else if(rel=='Update'){
                    rel='Update '+label;
                }else if(rel=='New Name'){
                    rel='New '+label+' Name';
                }else if(rel=='Separate  with commas'){
                    rel='Separate '+label+' with commas';
                }else if(rel=='Choose from the most used'){
                    rel='Choose from the most used '+label;
                }else{
                    rel=jQuery(this).attr('rel')+label;
                }
                
              }
              jQuery(this).val(rel);
            });
            jQuery('#pm_taxonomy_label').val(jQuery(element).val()+'s');
    
}

/* End Taxonomy */
jQuery('.pm_field_meta_key').click(function(){
        
        label=jQuery(this).parents('.inside').children('.pm_field_segment').children('.pm_field_label');
        group_meta_key=jQuery(this).parents('.inside').parents('.inside').children('.meta_box_info').children('.pm_segment').children('.pm_group_meta_key').val();
        //alert(group_meta_key);
          if (label.val().length > 0 && jQuery(this).val() == '') {
            label.stringToSlug({
              space:'_',
              getPut:jQuery(this), 
              prefix:group_meta_key + " ",
              replace:/\s?\([^\)]*\)/gi
            });
          }
        
    });
    jQuery('.pm_field_label').click(function(){
        
        meta_key=jQuery(this).parents('.inside').children('.pm_field_segment').children('.pm_field_meta_key');
        group_meta_key=jQuery(this).parents('.inside').parents('.inside').children('.meta_box_info').children('.pm_segment').children('.pm_group_meta_key').val();
        alert(jQuery(this).val());
          if (jQuery(this).val().length > 0) {
            jQuery(this).stringToSlug({
              space:'_',
              getPut:meta_key, 
              prefix:group_meta_key + " ",
              replace:/\s?\([^\)]*\)/gi
            });
          }
        
    });

 function meta_option_toggole_field(toggleIcon){
    jQuery(toggleIcon).parents('.box').children('.inside').toggle();
 }
 function meta_option_toggole(toggleIcon){
    jQuery(toggleIcon).parents('.postbox').children('.inside').toggle();
 }
 
function meta_option_remove_field( removeIcon ){
    if( confirm('Confirm to remove?') ){
        jQuery(removeIcon).parents('.postbox').parents('.meta-field').remove();
    }    
}
function meta_option_remove_meta_box( removeIcon ){
    if( confirm('Confirm to remove?') ){
        jQuery(removeIcon).parents('.postbox').parents('.meta-box-sortables').remove();
    }    
}

function moNewGroup( element ){
    
        jQuery('#not-found').remove();
        newGroupID = parseInt( jQuery('#last_group_id').val() ) + 1;
        arg = 'id=' + newGroupID + '&toggle='+ true + '&post_type=' + jQuery(element).attr('post_type');
        AjaxCall( element, 'pm_add_group', arg, function(data){
        jQuery("#pm_group_container").append( data );
        jQuery('#last_group_id').val( newGroupID );
        });
    //newID = parseInt( jQuery("#last_id").val() ) + 1;
    //arg = 'field_type=' + jQuery(element).attr('field_type');
    //alert(arg);
    /*
    pfAjaxCall( element, 'um_add_field', arg, function(data){
        jQuery("#um_fields_container").append( data );        
        jQuery("#last_id").val( newID );
    });*/
}


function manageGroup( element ){
    arg = "post_type="+jQuery(element).attr('rel');
       
    AjaxCall( element, 'pm_manage_group', arg, function(data){
        jQuery("#pm_loading_area").html( data );
        
        jQuery('.pm_post_meta_option a').each(function(){
            jQuery(this).addClass('button');
            jQuery(this).removeClass('button-primary');
        }); 
        
        jQuery(element).removeClass('button');
        jQuery(element).addClass('button-primary'); 
    });
}

function moNewField( element ){ 
    group_id = jQuery(element).attr('group_id');
    post_type= jQuery(element).attr('post_type');
    field_type= jQuery(element).attr('field_type');
    last_field_id =jQuery("#last_"+group_id+"_field_id").val();//jQuery(".field_count_"+group_id+":last").val();
    newFieldID = parseInt( last_field_id ) + 1;
    arg = "group_id="+group_id+"&post_type="+post_type+"&field_type="+field_type+"&field_id="+newFieldID;
    //alert(field_type);
    AjaxCall( element, 'pm_add_field', arg, function(data){
        jQuery('#not-found').remove();
        jQuery(element).parents('.metabox-option-list').children(".metabox-fields-holder").append( data );
        jQuery("#last_"+group_id+"_field_id").val(newFieldID);   
    });
}

function moChangeGroupTitle( element ){
    title = jQuery(element).val();
    if( !title ){ title = 'Untitled Group'; }
    jQuery(element).parents(".postbox").children("h3").text(title);
}
function moChangeFieldTitle( element ){
  
    title = jQuery(element).val();
    if( !title ){ title = 'Untitled Field'; }
    jQuery(element).parents(".fieldbox").children("h3").children(".pm_admin_field_title").text(title);
            meta_key=jQuery(element).parents('.field-holder').children('.pm_field_segment').children('.pm_field_meta_key');
            jQuery(element).parents(".fieldbox").children("h3").children(".pm_metakey_handl").children('.pm_meta_key').text(meta_key.val());
        group_meta_key=jQuery(element).parents('.inside').parents('.inside').children('.meta_box_info').children('.pm_segment').children('.pm_group_meta_key').val();
            jQuery(element).stringToSlug({
              space:'_',
              getPut: meta_key, 
              prefix: group_meta_key + " ",
              replace:/\s?\([^\)]*\)/gi
            });
}

function moChangeFieldMetaKey( element ){
    metakey = jQuery(element).val();
    jQuery(element).parents(".fieldbox").children("h3").children('.pm_metakey_handl').children(".pm_meta_key").text(metakey);
}

function meta_option_group_save( element ){
    
    jQuery(element).validationEngine();
    if( jQuery(element).validationEngine("validate") ){
                    //jQuery(".inside").css('display','none');
                    jQuery('.pc_error').remove(); 
                    jQuery('.pc_success').remove();               
                    bindElement = jQuery("#submit");
                    pm_post_type = jQuery("#pm_post_type").val();
                    arg = jQuery( element ).serialize()+"&post_type="+pm_post_type;
                    //alert(arg);
                    AjaxCall( bindElement, 'meta_option_group_save', arg, function(data){
                        jQuery('#msg').children(".pc_error").remove();
                        jQuery('#msg').html(data);
                    });
    }else{
        jQuery(".vError").closest(".inside").css('display','block');
        //jQuery(".inside").css('display','block');
        jQuery('.pc_success').remove();
        jQuery('#msg').html('<div class="pc_error"> Some Required field need to fill </div>');
                    return false; 
    }
}
function moChangeField(element ,fieldID, groupID){
    arg = jQuery('#field' + groupID + fieldID + ' * ').serialize();
    AjaxCall( element, "pm_change_field", arg, function(data){
        jQuery(element).parents(".meta-field").replaceWith(data);
    });
}


function editMetaKey(element){
    if(jQuery(element).is(':checked')) {
           jQuery(element).parent().prev('.pm_segment').find('.pm_group_meta_key').attr('readonly', false);
         }else{
            jQuery(element).parent().prev('.pm_segment').find('.pm_group_meta_key').attr('readonly', true);
         }

}


function pmSuggetion(element){
    jQuery('#advanced-label input[name*=pm_posttype]:text').each(function(index,value) {
              rel = jQuery(this).attr('rel');
              label = jQuery('#pm_posttype_labal').val();
              //rel = str_replace('%s',label,rel);//
              rel=rel.replace('%s',label);
             // rel=jQuery(this).attr('rel')+label;
              jQuery(this).val(rel);
            });
}
/*  Import Export */

function pmExport(element){
    jQuery(element).validationEngine();
    if( jQuery(element).validationEngine("validate") ){
         arg = jQuery( element ).serialize(); 
          document.location.href = ajaxurl + "?action=pm_export&" + arg;  
    }
    return false; 
}

function pmImport(element){
    jQuery('.pc-error').remove();
        jQuery(element).validationEngine();
    if( jQuery(element).validationEngine("validate") ){
        bindElement = jQuery("#import-submit");
         arg = jQuery( element ).serialize(); 
         AjaxCall( bindElement, 'pm_import', arg, function(data){
                        jQuery('.pc-error').remove();
                        jQuery('#msg').children(".pc_error").remove();
                        jQuery('#msg').html(data);
                    });  
    }
    return false;
}

/* End Import Export */

/* Settings */

function pmUpdateSettings(element){
    
        jQuery(element).validationEngine();
    if( jQuery(element).validationEngine("validate") ){
                    //jQuery(".inside").css('display','none');
                    jQuery('.pc_error').remove(); 
                    jQuery('.pc_success').remove();               
                    bindElement = jQuery("#submit");
                    pm_post_type = jQuery("#pm_post_type").val();
                    arg = jQuery( element ).serialize();
                    //alert(arg);
                    AjaxCall( bindElement, 'pm_update_settings', arg, function(data){
                        jQuery('#msg').children(".pc_error").remove();
                        jQuery('#msg').html(data);
                    });
    }else{
        jQuery(".vError").closest(".inside").css('display','block');
        //jQuery(".inside").css('display','block');
        jQuery('.pc_success').remove();
        jQuery('#msg').html('<div class="pc_error"> Some Required field need to fill </div>');
        return false; 
    }
    
}

function getinfo(element){
    sel=jQuery(element).val();
    if(!sel){
        jQuery('.custom_file_size').remove();
        field ='<div class="pm_field_segment custom_file_size"><label class="pm_label">Max File Size Custom </label> <input type="text" name="settings[file][max_file_size_custom]" id="max_file_size_custom", value="" class="pm_input validate[required]" /><div class="pm_note">Only Megabyte as integer (e.g. 100)</div> </div>';
        target=jQuery(element).closest('.pm_field_segment');
        jQuery(field).insertAfter(target);
    }else{
        jQuery('.custom_file_size').remove();
    }
}

function restoreSettings(element){
    if( confirm('Are you sure to restore') ){
        arg='a=a';
           AjaxCall( element, 'pm_reset_settings', arg, function(data){
                        jQuery('#msg').html(data);
                    }); 
    }
    
}
/* END settings */

function getProMsg(element){
    
    if( confirm('This feature only available in pro version\n Get Post Meta Pro version http://post-meta.com') ){
        window.open('http://post-meta.com');
    }
}










function AjaxCall( element, action, arg, handle){
    if(action) data = "action=" + action;
    if(arg)    data = arg + "&action=" + action;
    if(arg && !action) data = arg;
    data = data ;
    
    var n = data.search("pm_nonce");
    if(n<0){
        data = data + "&pm_nonce=" + pm_nonce;
    }

	jQuery.ajax({
		type: "post",
        url: ajaxurl,
        data: data,
		beforeSend: function() { jQuery("<span class='pm_loading'></span>").insertAfter(element); },
		success: function( data ){
            jQuery(".pm_loading").remove();
            handle(data);
		}
	});    
}


function JsonAjaxCall( element, action, arg, handle){
    if(action) data = "action=" + action;
    if(arg)    data = arg + "&action=" + action;
    if(arg && !action) data = arg;
    
    var n = data.search("pm_nonce");
    if(n<0){
        data = data + "&pm_nonce=" + pm_nonce;
    }
    
	jQuery.ajax({
		type: "post",
        url: ajaxurl,
        data:data,
        dataType:'JSON',            
		beforeSend: function() { jQuery("<span class='pm_loading'></span>").insertAfter(element); },
        success:function(data){
                    jQuery(".pm_loading").remove();
                        handle(data);
                             },
          error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
	});    
}

