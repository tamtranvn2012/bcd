<?php



if( !class_exists( 'pmSupportModel' ) ) :

class pmSupportModel {
    
    
    
        function clearCache(){
            global $postMeta;
            $cacheData=get_option(    $postMeta->options[ 'cache' ]   );
            
            unset( $cacheData[ 'last_ver_check' ] );
            unset( $cacheData[ 'pm_new_ver' ] );
            
            update_option($postMeta->options['cache'],$cacheData);
        }
        function verifyNonce( $adminOnly=false ){
            global $postMeta;
            $nonce      = @$_REQUEST['pm_nonce'];
            $nonceText  = $postMeta->nonceText();
            if( !wp_verify_nonce( $nonce, $nonceText ) ) die('Security check');                                
            return true;      
        }
           
       /**
         * get maximum key of an array
         */
        function maxKey( $arr ){
            if( !is_array( $arr ) ) return false;
            if( !$arr ) return false;
            
            $keys = array();
            foreach( $arr as $k => $v )
                $keys[] = $k;
            return max( $keys );
        }
        
        
        /**
        * return all post types
        *
        *  This function is a wrapper of  wordpress's get_post_types function
        *  here be  filter  a non-related post types of magic fields
        *
        *  @return array
        */
        function pm_get_post_types( $args = array('public' => true), $output = 'object', $operator = 'and' ){
        global $wpdb;
        
        $post_types = get_post_types( $args, $output, $operator );
        
        foreach ( $post_types as $key => $type ) {
          if( $output == 'names' ) {
            if( $type == 'attachment' ) {
              unset($post_types[$key]);
            }
          } else if ($output == 'object' ) {
            unset($post_types['attachment']);
          }
        }
        
        return $post_types;
        }
        
        
        
        
           /**
     * Get fields by 
     * @param $by: key, field_group
     * @param $value: 
     */    
    function getFields( $by=null, $param=null, $get=null, $isFree=false ){
        global $postMeta;
        $fieldList = $postMeta->pmFields();
        if(!$by){
            return false; 
        }
        if( $by =='key' ){
            foreach( $fieldList as $key => $fieldData ){  
                            $result[$key] = $fieldData['title'];
                    }
        }
        return isset( $result ) ? $result : false;
    }
    
    function manageType($type=null){
        global $postMeta;
        
        $posttypes=$postMeta->pm_get_post_types();
              foreach($posttypes as  $pt):
              $html .="<div class='pm_post_meta'>
                            
                            <div class='pm_post_meta_option'>
                                <span><b>$pt->label</b><small>({$pt->labels->menu_name})</small></span>
                                
                                    <a href='#ManaagePostMeta' rel='$pt->name' class='button' onclick='manageGroup(this); return false;' >Manage Groups/Fields</a>
                                    
                            </div>
                        </div>";
             endforeach;              
         return $html;
    }
    
    function pmPostTypeList(){
        global $postMeta;
        $pm_post_types = get_option( $postMeta->options['post_types'] );
        $html ='';
        $html .='<div id="pm_posttype_menu">';
        if($pm_post_types){
            foreach($pm_post_types as $key => $post_type){
                $html .="<div class='pm_menu_option'>
                                <span><b>{$post_type['name']}</b></span>
                                <span class='pm_manage_menu_option'>
                                    <a href='#Edit' rel='$key' onclick='editPostType(this); return false;' class='button' >Edit</a>  
                                    <a href='#Delete' rel='$key' class='button delete' onclick='deletePostType(this); return false;' >Delete</a>
                                </span>
                            </div>";
            }
        }else{
            $html .="<div class='pm_nodata'> No Custom Post Type found</div>";
        }
        $html .="</div>";
        $html .="<center><input type='button' class='button button-primary pm_menu_button' onclick='addPostType(this); return false;' value='Add New Post Type' /></center>";
        
        return $html;
    }
    
    function pmTaxonomyList(){
        global $postMeta;
        $pm_taxonomies = get_option( $postMeta->options['taxonomies'] );
        $html ='';
        $html .='<div id="pm_taxonomy_menu">';
        if($pm_taxonomies){
            foreach($pm_taxonomies as $key => $pm_taxonomy){
                $html .="<div class='pm_menu_option'>
                                <span><b>{$pm_taxonomy[name]}</b></span>
                                <span class='pm_manage_menu_option'>
                                    <a href='#Edit' rel='$key' class='button' onclick='editTaxonomy(this); return false;' >Edit</a> 
                                    <a href='#Delete' rel='$key' class='button delete' onclick='deleteTaxonomy(this); return false;' >Delete</a>
                                </span>
                            </div>";
            }
        }else{
            $html .="<div class='pm_nodata'> No Custom Taxonomy found</div>";
        }
        $html .="</div>";
        $html .="<center><input type='button' class='button button-primary pm_menu_button' onclick='addTaxonomy(this); return false;' value='Add New Taxonomy' /></center>";
        
        return $html;
    }
    

}

endif;

?>
