<?php
if( !class_exists( 'pmHelpModel' ) ) :

class pmHelpModel {
    
    
    /**
     * @ This function will retuen All Custom meta key which is created ny Meta Optopn plugin 
     */
    
     function getMetaKeyList(){
        global $postMeta;
        
            $postTypes=get_option($postMeta->options['post_meta']);
            $html = '';
            
            $html .= "<div class='pm_meta_key_list'>";
                  foreach($postTypes as  $key => $postType):
            
                       $html .="<h4>Meta Key For $key </h4>";
                       
                        if($postType['group']){
                           foreach($postType['group'] as $group){
                                if($group['field']){
                                        foreach($group['field'] as $field){
                                            $html .="<ul>"; 
                                                $html .="<li>{$field['meta_key']}</li>";
                                            $html .="</ul>"; 
                                        }
                                    }else{$html .= "No Custom Field Found";}
                            } 
                        }else{ $html .= "No Custom Group Found";}
                          
                    endforeach;
                    
            $html .="</div>";
            return $html;
    } 
    
    function home(){
        global $postMeta;
        $html =null;
        $html .="<b>{$postMeta->title} ( Version : {$postMeta->version} )</b></br>";
        $html .="----------------------------------------------------</br></br>";
        $html .="<ul>";
        $html .="<li>Manage Post Meta > Manage Group/Fields </li>";
        $html .="<li>After creating custom field or group use shortcode or loop function to display them.</li>";
        $html .="<li>Post Meta <a href='{$postMeta->website}/documentation/' target='_blank' >Documentation.</a></li>";
        $html .="<li>Posy Meta <a href='{$postMeta->website}/video-tutorial/' target='_blank' >Video Tutorial.</a></li>";
        $html .="<li>Premium support <a href='{$postMeta->website}/forums/' target='_blank'>forum here.</a></li>";
        $html .="<li>If you have any question or problem , Contact us <a href='{$postMeta->website}/contact-us/' target='_blank'>here.</a></li>";
        $html .="</ul>";
        
        $html .="<div style='padding:10px'><i><b>Please help us to develop a useful plugin by giving us advice and guideline <a href='{$postMeta->website}/contact-us/' target='_blank'>Click here</a></b></i></div>";
        
        if(!$postMeta->isPro()){
            $html .="</br></br>";
            $html .="<div style='width:100%;text-align:center;'>";
            $html .="<a class='button-primary' href='{$postMeta->website}' target='_blank'> Get Post Meta Pro </a>";
            $html .="<a href='{$postMeta->website}/donation/' style='margin-left:250px'  target='_blank'><img src='".PM_ASSECTS_URL."images/donate-button.png'>";
            $html .="</div>";
        }
        
        return $html;
    }
    
    function getPostMetaPro(){
        global $postMeta;
        $html ='';
        $html .='<h4>Current Feature:</h4>
                    <ul class="pm-list">
                        <li>1. Duplicate Group </li>
                        <li>2. Additional Field</li>
                                <ul>
                                    <li>Image upload</li>
                                    <li>Audio upload</li>
                                    <li>Video upload</li>
                                    <li>File upload</li>
                                </ul>
                        <li>3. Allow shortcode</li>
                        <li>3. Import & Export</li>
                        <li>4. Unlimited licence</li>
                        <li>5. Live Time support</li>
                        <li>5. Premium forum support </li>
                    </ul>
                ';
         
         $html .="<center><a class='button-primary' href='{$postMeta->website}' target='_blank'> Get Post Meta Pro </a><center>";  
                
        return $html;
    }
    
    function getStart(){
        global $postMeta;
        $base_url = get_bloginfo('url');
        $html ="";
        $html .="<b>Post Meta</b>";
        $html .="<p><b>Step 1.</b> <a href='$base_url/wp-admin/admin.php?page=post-meta'>Post Meta ></a> Manage Groups/fields > Set your Group and field with proper settings (Meta key).<p>"; 
        $html .="<p><b>Step 2.</b> Write shortcode in your post, page or your custom post type  </p>";
        $html .="<div class='pm-hr'></div>";
        $html .="<b>Custom post type</b>";
        $html .="<p><a href='$base_url/wp-admin/admin.php?page=manage-post-types'> Post Types</a> > Make sure the label and other fields </p>";
        $html .="<div class='pm-hr'></div>";
        $html .="<b>Custom Taxonomy</b>";
        $html .="<p><a href='$base_url/wp-admin/admin.php?page=manage-taxonomies'> Taxonomies</a> > Make sure the label and other fields </p>";
        
        $html .="<center><a class='button-primary' href='{$postMeta->website}/documentation/' target='_blank'> Documentation </a></center>";  
                
        return $html;
    }
}

endif;
?>