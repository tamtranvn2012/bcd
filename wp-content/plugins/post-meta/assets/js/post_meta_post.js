(function($){
        $(document).ready(function(){         
            jQuery("#publish").live('click',function(){
                
                          if('undefined' != typeof tinyMCEPreInit){
                                jQuery(".pm_field_item .pm_wp_edior").each(function(){
                                  var editor_text = jQuery(this).attr('id');
                                  jQuery(jQuery('#'+editor_text)).attr('value', tinyMCE.get(editor_text).getContent());
                                });
                              }
                                
                jQuery("#post").validationEngine();
                if( !jQuery("#post").validationEngine("validate")) {
                                    $('.pc_error').remove();
                                    $('#publishing-action #ajax-loading').hide();
                                    $('#publishing-action #publish').removeClass("button-primary-disabled");
                                    $('#major-publishing-actions').append( $('<div class="pc_error">Sorry, some required fields are missing. Please Fill Required field first</div>') );
                                    return false;
                                }
                                else{
                                    $('.pc_error').remove();
                                    $('#publishing-action #ajax-loading').show();
                                    return true;
                                }
                
            });
            
            
            
              $('#save-post').click(function(){
                //bypass the validation calling directly the submit action from the dom
                $('#post')[0].submit();
            
                //hiding the error messages
                //this messages  will be printed no matter if the validation was bypassed
                $('.formError').hide();
              });         
                      
        });      
})(jQuery);


 

function loadInitScript(){
        jQuery(".pm_datetime").datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss', changeYear: true });
        jQuery(".pm_date").datepicker({ dateFormat: 'yy-mm-dd', changeYear: true });   
        jQuery(".pm_time").timepicker({timeFormat: 'hh:mm:ss'}); 

}
//load button for image media
jQuery(document).ready(function() { 
        loadInitScript();
        pmImageUploader();
        pmAudioUploader();
        pmVideoUploader();
        pmFileUploader();
        pmSortable();
        pm_wp_editor();
        
    
        jQuery('.duplicate-add').live('click',function() {  
            element = jQuery(this);
            cloneField = element.closest('.pm_field').clone(true);
            jQuery('input:not(:checkbox,:radio), select, textarea', cloneField).val('');
            jQuery(':input[type=checkbox], :input[type=radio]', cloneField).removeAttr('checked');
            jQuery('.file_preview_thum', cloneField).html('<img src="'+pm_jsvar.on_preview+'" />');
            jQuery('.file_thum_manage',cloneField).hide();
            
            /* wp editor */
            jQuery('.wp_themeSkin',cloneField).remove();
            we_class=jQuery('textarea.pm_wp_edior',cloneField).attr('class');
            we_name=jQuery('textarea.pm_wp_edior',cloneField).attr('name');
            we_id=jQuery('textarea.pm_wp_edior',cloneField).attr('id');
            jQuery('textarea.pm_wp_edior',cloneField).replaceWith('<textarea name="'+we_name+'" id="'+we_id+'" class="'+we_class+' pm_add_wp_edior"></textarea>');//.unbind().wysiwyg({initialContent:" "});
            //jQuery('textarea.pm_wp_edior',cloneField).css('diplay','block');//.unbind().wysiwyg({initialContent:" "});
            /* End wp editor */
 
 
            metaKey = element.attr('meta_key');
            //allClass = element.closest('.pm_field').attr('class');
            targetClass= 'repeat-'+metaKey;
            targetGroupClass='pm_field_group_'+metaKey
            //fieldLocation = jQuery('.'+targetClass+':last');
            fieldLocation = element.closest('.pm_field');
            //jQuery('.'+targetGroupClass).append(cloneField).slideDown("slow",function(){    });

            cloneField.insertAfter(fieldLocation).fadeIn("slow");
            /*
            jQuery('#last_'+metaKey).val(function(e,n){ // Set the last meta key value
                return Number(n)+1;
            })*/
            
             element.closest('.pm_group').find('.'+targetClass).each(function (index, value){
                jQuery(this).find('.pm_field_index').parents('em').css('display','inline');
                jQuery(this).find('.pm_field_index').html(index+1);
                arrayIndex=index+1;
                //jQuery(this).find('input:not(:file), select, textarea').attr('name','mofields['+metaKey+']['+arrayIndex+']');
                jQuery(this).find('.pm_field_item').find('input:not(:file , :checkbox), select, textarea').attr('name',function(key,name){
                                    
                                                pattern =  /mofields\[([0-9a-z_]+)\]\[(\d+)\]\[(\d+)\]$/i;
                                                 var match =  pattern.exec(name);
                                                name ='mofields['+match[1]+']['+match[2]+']['+arrayIndex+']';
                                                return name  ;                     
                                            });
                jQuery(this).find('.pm_field_item').find(':input[type=checkbox]').attr('name',function(key,name){
                                    pattern =  /mofields\[([0-9a-z_]+)\]\[(\d+)\]\[(\d+)\]/i;
                                                 var match =  pattern.exec(name);
                                                name ='mofields['+match[1]+']['+match[2]+']['+arrayIndex+'][]';
                                                return name  ;
                    
                });
                jQuery(this).find('.duplicate-remove').show();
                jQuery(this).find('.hndle').show();
                if(arrayIndex>1){
                    jQuery(this).find('input, select, textarea, .pm_img_upload_button, .pm_audio_upload_button, .pm_video_upload_button, .pm_file_upload_button').attr('id',function(key,name){
                        name =name+'_'+arrayIndex;
                        return name ;                 
                    });
                    //jQuery('.pm_img_upload_button').attr('id',ia+'1');
                    element.closest('.pm_field_group').css('border','1px dashed #000000');
                }
                date_class = jQuery(this).find('input[type=datetime]').attr('class');
                    pattern =  /pm\_(datetime|time|date)/i;
                     var item =  pattern.exec(date_class);
                     if(item && item != 'undifine'){
                        dateformet = item[1];
                        if(dateformet == 'datetime'){
                            jQuery(this).find('input[type=datetime]').removeClass('hasDatepicker').unbind().datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss', changeYear: true });
                         }else if(dateformet == 'date'){
                            jQuery(this).find('input[type=datetime]').removeClass('hasDatepicker').unbind().datepicker({ dateFormat: 'yy-mm-dd', changeYear: true });  
                         }if(dateformet == 'time'){
                            jQuery(this).find('input[type=datetime]').removeClass('hasDatepicker').unbind().timepicker({timeFormat: 'hh:mm:ss'});  
                         }else{
                            
                         }
                     }
                
             });
             
             pmImageUploader();
             pmAudioUploader();
             pmVideoUploader();
             pmFileUploader();
             pm_wp_editor();
             
             return false;
        }); 
        
        jQuery('.duplicate-add-group').live('click',function(){
                item=jQuery(this);
                
                group_key=jQuery(this).attr('group_id');
                post_type=jQuery(this).attr('post_type');
                meta_key =jQuery(this).attr('meta_key');
                count=jQuery(this).closest('.inside').find('#group_count').val();
                group_count=Number(count)+1;
                data='group_key='+group_key+'&post_type='+post_type+'&group_count='+group_count+'&action=pm_load_group';
                jQuery.ajax({
                type: "post",
                url: ajaxurl,
                data: data,
                success: function( data ){
                    item.closest('.inside').append(data).slideDown('slow');
                            /*
                            item.closest('.inside').find('input[id^="last_"]').each(function(index,value){
                                jQuery(this).val(function(e,n){ // Set the last meta key value
                                    return Number(n)+1;
                                });
                            pmImageUploader();
                            pmAudioUploader();
                            pmVideoUploader();
                            });
                            loadInitScript();
                            pmSortable();
                            */
                            item.closest('.inside').find('#group_count').val(function(e,n){ // Set the last meta key value
                                    return Number(n)+1;
                                });
                            
                            if(Number(item.closest('.inside').find('#group_count').val())>1){
                                item.closest('.inside').find('.pm-group-control').find('.duplicate-remove-group').show();
                            }
                            item.closest('.inside').find('.pm-group-control').find('.group_count_label').each(function(index,valu){
                               i=index+1;
                               jQuery(this).html(i); 
                            });
                            pmImageUploader();
                            pmAudioUploader();
                            pmVideoUploader();
                            loadInitScript();
                            pmFileUploader();
                            pmSortable();
                            pm_wp_editor();                                
                    }
                    
                });
                
                return false;
            
        });
        jQuery('.duplicate-remove-group').live('click',function(){
            item=jQuery(this).closest('.inside').find('.pm-group-control');
            jQuery(this).closest('.pm_group').slideUp("slow",function(){
                jQuery(this).remove();
                
            });
            jQuery(this).closest('.inside').find('#group_count').val(function(e,n){ // Set the last meta key value
                                    return Number(n)-1;
                                });
            if(Number(jQuery(this).closest('.inside').find('#group_count').val())==1){
                                jQuery(this).closest('.inside').find('.pm-group-control').find('.duplicate-remove-group').hide();
                            }
            
            item.each(function(index,valu){
                               i=index+1;
                               //alert(i);
                               jQuery(this).html(i); 
                            });
            return false;
            
        });
        
        jQuery('.duplicate-remove').live('click',function() {
            
            element = jQuery(this);
            parent_group = element.closest('.pm_group');//.find('.'+targetClass).size();
            
            jQuery(this).closest('.pm_field').slideUp("slow",function() { 
                        jQuery(this).remove();
                        metaKey = element.attr('meta_key');
                        
                        /*jQuery('#last_'+metaKey).val(function(e,n){ // Set the last meta key value
                            return Number(n)-1;
                        })*/
                        targetClass= 'repeat-'+metaKey;
                        //classSize = jQuery('.'+targetClass).size();
                        //classSize = element.closest('.pm_group').find('.'+targetClass).size();
                        classSize=parent_group.find('.'+targetClass).size();
                        if(classSize==1){
                            parent_group.find('.'+targetClass).find('.pm_field_index').parents('em').hide();
                            parent_group.find('.'+targetClass).find('.pm_field_item').find('input:not(:file , checkbox), select, textarea').attr('name',function(key,name){

                                            
                                            pattern =  /mofields\[([0-9a-z_]+)\]\[(\d+)\]\[(\d+)\]/i;
                                             var match =  pattern.exec(name);
                                             name ='mofields['+match[1]+']['+match[2]+'][1]';
                                            return name  ;                     
                                        });
                            parent_group.find('.'+targetClass).find('.pm_field_item').find(':input[type=checkbox]').attr('name',function(key,name){

                                            
                                            pattern =  /mofields\[([0-9a-z_]+)\]\[(\d+)\]\[(\d+)\]/i;
                                             var match =  pattern.exec(name);
                                             name ='mofields['+match[1]+']['+match[2]+'][1][]';
                                            return name  ;                     
                                        });
                            
                            parent_group.find('.'+targetClass).find('.duplicate-remove').hide();
                            parent_group.find('.'+targetClass).find('.hndle').hide();
                            parent_group.find('.'+targetClass).closest('.pm_field_group').css('border','none');
                        }else{
                            parent_group.find('.'+targetClass).each(function (index, value){
                                jQuery(this).find('.pm_field_index').parents('em').css('display','inline');
                                jQuery(this).find('.pm_field_index').html(index+1);//\[(\d+)\]$
                                arrayIndex=index+1;
                                jQuery(this).find('input:not(:file , checkbox), select, textarea').attr('name',function(key,name){

                                            
                                            pattern =  /mofields\[([0-9a-z_]+)\]\[(\d+)\]\[(\d+)\]/i;
                                             var match =  pattern.exec(name);
                                            name ='mofields['+match[1]+']['+match[2]+']['+arrayIndex+']';
                                            return name  ;                     
                                        });
                                jQuery(this).find('.pm_field_item').find(':input[type=checkbox]').attr('name',function(key,name){
                                                        pattern =  /mofields\[([0-9a-z_]+)\]\[(\d+)\]\[(\d+)\]/i;
                                                                     var match =  pattern.exec(name);
                                                                    name ='mofields['+match[1]+']['+match[2]+']['+arrayIndex+'][]';
                                                                    return name  ;
                                        
                                    });
                             });
                        }
                
                });     
                
                /*
                 metaKey = element.attr('meta_key');
                        jQuery('#last_'+metaKey).val(function(e,n){ // Set the last meta key value
                            return Number(n)-1;
                        })
                        targetClass= 'repeat-'+metaKey;
                        //classSize = jQuery('.'+targetClass).size();
                        a = jQuery(this).closest('.pm_group').find('.'+targetClass);
                        classSize = jQuery(this).closest('.pm_group').find('.'+targetClass).size();
                        alert(classSize);
                        b=jQuery(this).parent().parent().parent().html();
                            alert(b);
                        if(classSize==2){
                            jQuery('.'+targetClass).find('.pm_field_index').parents('em').hide();
                            jQuery('.'+targetClass).find('input, select, textarea').attr('name','mofields['+metaKey+']');
                            jQuery('.'+targetClass).find('.duplicate-remove').hide();
                            jQuery('.'+targetClass).find('.hndle').hide();
                            a.closest('.pm_field_group').css('border','none');
                            
                        }else{
                            jQuery('.'+targetClass).each(function (index, value){
                                jQuery(this).find('.pm_field_index').parents('em').css('display','inline');
                                jQuery(this).find('.pm_field_index').html(index+1);
                                arrayIndex=index+1;
                                jQuery(this).find('input, select, textarea').attr('name','mofields['+metaKey+']['+arrayIndex+']');
                             });
                            
                        } */
                   
             return false;
        });
        
        
function pmImageUploader( ){
jQuery(".pm_img_upload_button").each(function(index){
            var item = jQuery(this);
            targetfield = jQuery(this).prev('.pm_uploaded_url');
        fileuploader.upload='Image Upload';
        var divID = jQuery(this).attr("id");
        var fieldID = jQuery(this).attr("pm_field_id");
        
        allowedExtensions = jQuery(this).attr("extension");
        maxSize = jQuery(this).attr("maxsize");
        if( !allowedExtensions )
            allowedExtensions = "jpg,jpeg,png,gif";
        if( !maxSize )
            maxSize = 1 * 1024 * 1024;            
        
        var uploader = new qq.FileUploader({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            element: document.getElementById(divID),
            // path to server-side upload script
            //template:'<div>Upload image</div>',
            action: pm_jsvar.uploaderURL,
            params: {"pm_nonce":pm_nonce },
            allowedExtensions: allowedExtensions.split(","),
            sizeLimit: maxSize,
            multiple: false,
            onComplete: function(id, fileName, responseJSON){
                if( !responseJSON.success ) return;
                handle = jQuery('#'+fieldID);
                arg = 'imgurl='+responseJSON.filepath;
                item.parents('.file_input').children('.pm_uploaded_url').val(responseJSON.filepath);
                AjaxCall( handle, 'pm_img_preview', arg, function(data){
                            item.parents('.file_input').children('.pc-error').remove();
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_preview_thum').html(data);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').find('.dl').attr('href',pm_jsvar.uploadurl+responseJSON.filepath);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').css('display','block');  
                                  
                    });
                
            }
        });         
    });
    
}   

function pmAudioUploader( ){
jQuery(".pm_audio_upload_button").each(function(index){
            var item = jQuery(this);
            targetfield = jQuery(this).prev('.pm_uploaded_url');
        fileuploader.upload='Audio Upload';
        var divID = jQuery(this).attr("id");        
        allowedExtensions = jQuery(this).attr("extension");
        maxSize = jQuery(this).attr("maxsize")
        if( !allowedExtensions )
            allowedExtensions = "jpg,jpeg,png,gif,mp3";
        if( !maxSize )
            maxSize = 5 * 1024 * 1024;            
        
        var uploader = new qq.FileUploader({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            element: document.getElementById(divID),
            // path to server-side upload script
            //template:'<div>Upload image</div>',
            action: pm_jsvar.uploaderURL,
            params: {"pm_nonce":pm_nonce},
            allowedExtensions: allowedExtensions.split(","),
            sizeLimit: maxSize,
            onComplete: function(id, fileName, responseJSON){
                if( !responseJSON.success ) return;
                handle = jQuery('#'+divID);
                arg = 'url='+responseJSON.filepath+'&id='+divID;
                item.parents('.file_input').children('.pm_uploaded_url').val(responseJSON.filepath);
                AjaxCall( handle, 'pm_audio_preview', arg, function(data){
                            item.parents('.file_input').children('.pc-error').remove();
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_preview_thum').html(data);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').find('.dl').attr('href',pm_jsvar.uploadurl+responseJSON.filepath);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').css('display','block');  
                                  
                    });
                
            }
        });         
    });
    
}

function pmVideoUploader( ){
jQuery(".pm_video_upload_button").each(function(index){
            var item = jQuery(this);
            targetfield = jQuery(this).prev('.pm_uploaded_url');
        fileuploader.upload='Video Upload';
        var divID = jQuery(this).attr("id");        
        allowedExtensions = jQuery(this).attr("extension");
        maxSize = jQuery(this).attr("maxsize")
        if( !allowedExtensions )
            allowedExtensions = "mp4,avi,flv,wmv";
        if( !maxSize )
            maxSize = 50 * 1024 * 1024;            
        
        var uploader = new qq.FileUploader({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            element: document.getElementById(divID),
            // path to server-side upload script
            //template:'<div>Upload image</div>',
            action: pm_jsvar.uploaderURL,
            params: { "pm_nonce":pm_nonce},
            allowedExtensions: allowedExtensions.split(","),
            sizeLimit: maxSize,
            onComplete: function(id, fileName, responseJSON){
                if( !responseJSON.success ) return;
                handle = jQuery('#'+divID);
                arg = 'url='+responseJSON.filepath+'&id='+divID;
                item.parents('.file_input').children('.pm_uploaded_url').val(responseJSON.filepath);
                AjaxCall( handle, 'pm_video_preview', arg, function(data){
                            item.parents('.file_input').children('.pc-error').remove();
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_preview_thum').html(data);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').find('.dl').attr('href',pm_jsvar.uploadurl+responseJSON.filepath);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').css('display','block');  
                                  
                    });
                
            }
        });         
    });
    
}      

function pmFileUploader( ){
jQuery(".pm_file_upload_button").each(function(index){
            var item = jQuery(this);
            targetfield = jQuery(this).prev('.pm_uploaded_url');
        fileuploader.upload='File Upload';
        var divID = jQuery(this).attr("id");        
        allowedExtensions = jQuery(this).attr("extension");
        maxSize = jQuery(this).attr("maxsize")
        if( !allowedExtensions )
            allowedExtensions = "zip,rar,pdf";
        if( !maxSize )
            maxSize = 10 * 1024 * 1024;            
        
        var uploader = new qq.FileUploader({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            element: document.getElementById(divID),
            // path to server-side upload script
            //template:'<div>Upload image</div>',
            action: pm_jsvar.uploaderURL,
            params: { "pm_nonce":pm_nonce },
            allowedExtensions: allowedExtensions.split(","),
            sizeLimit: maxSize,
            onComplete: function(id, fileName, responseJSON){
                if( !responseJSON.success ) return;
                handle = jQuery('#'+divID);
                arg = 'url='+responseJSON.filepath+'&id='+divID;
                item.parents('.file_input').children('.pm_uploaded_url').val(responseJSON.filepath);
                AjaxCall( handle, 'pm_file_preview', arg, function(data){
                            item.parents('.file_input').children('.pc-error').remove();
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_preview_thum').html(data);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').find('.dl').attr('href',pm_jsvar.uploadurl+responseJSON.filepath);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').css('display','block');  
                                  
                    });
                
            }
        });         
    });
    
}
 
    
});

function pmDeleteFile(element){
    if( confirm('Confirm to remove?') ){
        jQuery(element).parents('.file_thum_manage').parents('.file_preview').parents('.file_wrapper').children('.file_input').children('.pm_uploaded_url').val('');
        jQuery(element).parents('.file_thum_manage').parents('.file_preview').children('.file_preview_thum').html('<img src="'+pm_jsvar.on_preview+'" />');
        jQuery(element).parents('.file_thum_manage').css('display','none'); 
        }
}

 jQuery('.pc_media_upload_button').live('click',function() {
       
        var item = jQuery(this);
         targetfield = jQuery(this).prev('.pm_uploaded_url');
         formfield = targetfield.attr('name');
         tb_show('Attach file', 'media-upload.php?pm_media_file=1&type=image&TB_iframe=1&width=640&height=169');
         
         window.original_send_to_editor = window.send_to_editor;
         
             window.send_to_editor = function(html) {
                if (formfield) {
                 imgurl = jQuery('img',html).attr('src');
                 tb_remove();
                 jQuery(targetfield).val(imgurl);
                     data='action=pm_img_preview&imgurl='+imgurl;
            
                    	jQuery.ajax({
                		type: "post",
                        url: ajaxurl,
                        data: data,
                		beforeSend: function() { jQuery('.file_preview_thum').append(jQuery('Loading..')); },
                		success: function( data ){
                		      item.parents('.file_input').children('.pc-error').remove();
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_preview_thum').html(data);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').find('.dl').attr('href',imgurl);
                             item.parents('.file_input').parents('.file_wrapper').children('.file_preview').children('.file_thum_manage').css('display','block');                     
                		}
                	});
                    
                    formfield =null;
                    }
                 else{
                    window.original_send_to_editor(html);
                 }
            }
         return false;
    });


function pmSortable(){
    jQuery('.pm_sortable').sortable({ 
                                    opacity: 0.6 ,
                                    handle: '.hndle',
                                    //placeholder: 'ui-state-highlight',
                                    forceHelperSize: true,
                                    axis: 'y',
                                    update: function() { 
                                                var_class=jQuery(this).attr('class');
                                                pattern =  /pm\_field\_group\_([a-zA-Z0-9_-]+)/i;
                                                 var item =  pattern.exec(var_class);
                                                 metaKey = item[1];
                                                 targetClass= 'repeat-'+metaKey;
                                                 /* rich text */
                                                 jQuery(this).closest('.pm_group').find('.'+targetClass).each(function (index, value){
                                                        jQuery(this).find('textarea.pm_rich_text.pm_new').prev('.wysiwyg').find('iframe').attr('id',function(key,id){
                                                            if(id){
                                                                alert(id);
                                                               alert(jQuery('#'+id).html());
                                                            }
                                                        });
                                                        textarea_valu='';
                                                        jQuery(this).find('textarea.pm_rich_text.pm_new').prev('.wysiwyg').remove();
                                                        
                                                        jQuery(this).find('textarea.pm_rich_text.pm_new').replaceWith('<textarea name="" id="" class="pm_post_input pm_rich_text pm_new">'+textarea_valu+'</textarea>');//.unbind().wysiwyg({initialContent:" "});
                                                    /*end rich text */
                                                        jQuery(this).find('.pm_field_index').parents('em').css('display','inline');
                                                        jQuery(this).find('.pm_field_index').html(index+1);
                                                        arrayIndex=index+1;
                                                        jQuery(this).find('input:not(:file , checkbox), select, textarea').attr('name',function(key,name){
                                                                    pattern =  /mofields\[([0-9a-z_]+)\]\[(\d+)\]\[(\d+)\]/i;
                                                                     var match =  pattern.exec(name);
                                                                    name ='mofields['+match[1]+']['+match[2]+']['+arrayIndex+']';
                                                                    return name  ;                     
                                                                });
                                                        jQuery(this).find('.pm_field_item').find(':input[type=checkbox]').attr('name',function(key,name){
                                                                                pattern =  /mofields\[([0-9a-z_]+)\]\[(\d+)\]\[(\d+)\]/i;
                                                                                             var match =  pattern.exec(name);
                                                                                            name ='mofields['+match[1]+']['+match[2]+']['+arrayIndex+'][]';
                                                                                            return name  ;
                                                                
                                                            });
                                                        jQuery(this).find('.duplicate-remove').show();
                                                        if(arrayIndex>1){
                                                            jQuery(this).find('input, select, textarea').attr('id',function(key,name){
                                                                name =name+'_'+arrayIndex;
                                                                return name                       
                                                            });
                                                        }
                                                        jQuery(this).find('textarea.pm_rich_text.pm_new').wysiwyg({initialContent:" "});
                                                     });
                                            	}
                                    });
}


function pm_wp_editor(){
       jQuery(".pm_field_item .pm_add_wp_edior").each( function(index,value){
          var editor_text = jQuery(this).attr('id');
          tinyMCE.execCommand('mceAddControl', true, editor_text); 
          jQuery(this).removeClass('pm_add_wp_edior');
        });
};
