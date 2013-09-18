<?php if (!defined('PROFILE_BUILDER_VERSION')) exit('No direct script access allowed');
/**
 * Functions Load
 *
 */

// Set up the AJAX hooks
add_action("wp_ajax_hook_wppb_delete", 'wppb_delete' );

function wppb_delete(){
	if ($_POST['what'] == 'avatar'){
		update_user_meta( $_POST['currentUser'], $_POST['customFieldName'], '');
		update_user_meta( $_POST['currentUser'], 'resized_avatar_'.$_POST['customFieldID'], '');
		//echo $_POST['_ajax_nonce'];
		echo 'done';
		die();
	}elseif ($_POST['what'] == 'attachment'){
		update_user_meta( $_POST['currentUser'], $_POST['customFieldName'], '');
		//echo $_POST['_ajax_nonce'];
		echo 'done';
		die();
	}
}


//the function to check the serial number and save a variable in the DB
function wppb_check_serial_number(){
	$serial_number_set = get_option('wppb_profile_builder_pro_serial','not_found');
	if ($serial_number_set != 'not_found'){
		$SN = get_option('wppb_profile_builder_pro_serial');
		
		// check to see if curling is enabled
		if ( function_exists('curl_version') == "Enabled" ){ 
			//initialize cURL-ing
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "http://cozmoslabs.com/check_serialnumber.php");
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "serialNumberSent=".$SN);
			$response = curl_exec ($curl);
			curl_close ($curl);
		
			// update the serial number status in the database
			update_option( 'serial_number_availability', $response );
		}
	}
}

//the function used to overwrite the avatar across the wp installation
function wppb_changeDefaultAvatar($avatar, $id_or_email, $size, $default, $alt) {
  global $wpdb;
  
  /* Get user info. */ 
  if(is_object($id_or_email)){
	$my_user_id = $id_or_email->user_id;
  }
  elseif(is_numeric($id_or_email)){
	$my_user_id = $id_or_email; 
  }elseif(!is_integer($id_or_email)){
	$user_info = get_user_by_email($id_or_email);
	$my_user_id = $user_info->ID;
  }else  
	$my_user_id = $id_or_email; 

  $arraySettingsPresent = get_option('wppb_custom_fields','not_found');
  if ($arraySettingsPresent != 'not_found'){
	$wppbFetchArray = get_option('wppb_custom_fields');
	foreach( $wppbFetchArray as $value ){
	  if ( $value['item_type'] == 'avatar'){
		$customUserAvatar = get_user_meta($my_user_id, 'resized_avatar_'.$value['id'], true);
		if (($customUserAvatar != '') || ($customUserAvatar != null)){				
			$avatar = "<img alt='{$alt}' src='{$customUserAvatar}' class='avatar avatar-{$value['item_options']} photo avatar-default' height='{$size}' width='{$size}' />";
		}
	  }
	}
  }

  return $avatar;
}


//the function used to resize the avatar image; the new function uses a user ID as parameter to make pages load faster
function wppb_resize_avatar($userID){
	// include the admin image API
	require_once(ABSPATH . '/wp-admin/includes/image.php');
	
	
	// retrieve first a list of all the current custom fields
	$wppbFetchArray = get_option('wppb_custom_fields');
	
	foreach ( $wppbFetchArray as $key => $value){
		if ($value['item_type'] == 'avatar'){
		
			// retrieve the original image (in original size)
			$originalAvatar = get_user_meta($userID, $value['item_metaName'], true);
			
			// we need to check if this field has an image uploaded, or else we would get an error
			if ($originalAvatar != ''){
			
				// retrieve width and height of the image
				$width = $height = '';
				
				//this checks if it only has 1 component
				if (is_numeric($value['item_options'])){
					$width = $height = $value['item_options'];
				//this checks if the entered value has 2 components
				}else{
					$sentValue = explode(',',$value['item_options']);
					$width = $sentValue[0];
					$height = $sentValue[1];
				}
					
			
				// retrieve the path where exactly in the upload dir the image is : /profile_builder/avatars/userID_ID_originalAvatar_NAME.EXTENSION 
				$searchOld = strpos ($originalAvatar, '/profile_builder/avatars/');
				$imagePartialPath = substr($originalAvatar, $searchOld);
					
				// get path to image to be resized
				$wpUploadPath = wp_upload_dir(); // Array of key => value pairs
				$imagePath = $wpUploadPath['basedir'].$imagePartialPath;
				
				//add a filter for the user to select crop or resizing
				$crop = true;
				$crop = apply_filters('wppb_image_crop_resize', $crop);
				
				//we need to check if the image is not, in fact, smaller then the preset values, or it will give a fatal error
				$imageSize = getimagesize($imagePath);
				if (($imageSize[0] > $width) && ($imageSize[1] > $heaight)){
					$thumb = image_resize($imagePath, $width, $height, $crop);
				
					// value to add in the usermeta as saved image
					$copyFrom = strpos($thumb, '/profile_builder/');
					$newImagePartial = substr($thumb, $copyFrom);
					$newImage = $wpUploadPath['baseurl'].$newImagePartial;
					
					update_user_meta( $userID, 'resized_avatar_'.$value['id'], $newImage);
				}else{
					// value to add in the usermeta as saved image
					$copyFrom = strpos($imagePath, '/profile_builder/');
					$newImagePartial = substr($imagePath, $copyFrom);
					$newImage = $wpUploadPath['baseurl'].$newImagePartial;
					
					update_user_meta( $userID, 'resized_avatar_'.$value['id'], $newImage);
				}
			}
		}
	}
}








if ( !is_admin() ){
	//check if the plugin has the addons module
	$addonPresent = WPPB_PLUGIN_DIR . '/premium/addon/addon.php';
	if (file_exists($addonPresent)){
		//get the currently loaded page
		global $pagenow;

		//the part for the WP register page
		if (($pagenow == 'wp-login.php') && (isset($_GET['action'])) && ($_GET['action'] == 'register')){
			$customRedirectSettings = get_option('customRedirectSettings','not_found');
			
			if ($customRedirectSettings != 'not_found'){
				if (($customRedirectSettings['registerRedirect'] == 'yes') && (trim($customRedirectSettings['registerRedirectTarget']) != '')){
					include ('wp-includes/pluggable.php');
					
					$redirectLink = trim($customRedirectSettings['registerRedirectTarget']);
					$findHttp = strpos($redirectLink, 'http');
					
					if ($findHttp === false)
						wp_redirect( 'http://'.$redirectLink );
					else wp_redirect( $redirectLink );
					
					exit;
				}
			}
		//the part for the WP password recovery
		}elseif (($pagenow == 'wp-login.php') && (isset($_GET['action'])) && ($_GET['action'] == 'lostpassword')){
			$customRedirectSettings = get_option('customRedirectSettings','not_found');
			
			if ($customRedirectSettings != 'not_found'){
				if (($customRedirectSettings['recoverRedirect'] == 'yes') && (trim($customRedirectSettings['recoverRedirectTarget']) != '')){
					include ('wp-includes/pluggable.php');
					
					$redirectLink = trim($customRedirectSettings['recoverRedirectTarget']);
					$findHttp = strpos($redirectLink, 'http');
					
					if ($findHttp === false)
						wp_redirect( 'http://'.$redirectLink );
					else wp_redirect( $redirectLink );
					
					exit;
				}
			}
		//the part for WP login; BEFORE login; this part only covers when the user isn't logged in and NOT when he just logged out
		}elseif ((($pagenow == 'wp-login.php') && (!isset($_GET['action'])) && (!isset($_GET['loggedout']))) || (isset($_GET['redirect_to']) && ($_GET['action'] != 'logout'))){
			$customRedirectSettings = get_option('customRedirectSettings','not_found');
			
			if ($customRedirectSettings != 'not_found'){
				if (($customRedirectSettings['loginRedirect'] == 'yes') && (trim($customRedirectSettings['loginRedirectTarget']) != '')){
					include ('wp-includes/pluggable.php');
					
					$redirectLink = trim($customRedirectSettings['loginRedirectTarget']);
					$findHttp = strpos($redirectLink, 'http');
					
					if ($findHttp === false)
						wp_redirect( 'http://'.$redirectLink );
					else wp_redirect( $redirectLink );
					
					exit;
				}
			}
		//the part for WP login; AFTER logout; this part only covers when the user was logged in and has logged out
		}elseif (($pagenow == 'wp-login.php') && (isset($_GET['loggedout'])) && ($_GET['loggedout'] == 'true')){
			$customRedirectSettings = get_option('customRedirectSettings','not_found');
			
			if ($customRedirectSettings != 'not_found'){
				if (($customRedirectSettings['loginRedirectLogout'] == 'yes') && (trim($customRedirectSettings['loginRedirectTargetLogout']) != '')){
					include ('wp-includes/pluggable.php');
					
					$redirectLink = trim($customRedirectSettings['loginRedirectTargetLogout']);					
					$findHttp = strpos($redirectLink, 'http');
					
					if ($findHttp === false)
						wp_redirect( 'http://'.$redirectLink );
					else wp_redirect( $redirectLink );
					
					exit;
				}
			}
			
		}
	}
}
	

//the function needed to block access to the admin-panel (if requisted)
function wppb_restrict_dashboard_access(){
	
	if (!is_admin())
        return '';

	elseif ((is_admin()) && (!current_user_can( 'manage_options' ))){
		$customRedirectSettings = get_option('customRedirectSettings','not_found');
		if ($customRedirectSettings != 'not_found'){
			if (($customRedirectSettings['dashboardRedirect'] == 'yes') && (trim($customRedirectSettings['dashboardRedirectTarget']) != '')){
			
				$redirectLink = trim($customRedirectSettings['dashboardRedirectTarget']);
				$findHttp = strpos($redirectLink, 'http');
				
				if ($findHttp === false)
					$redirectLink = 'http://'.$redirectLink;
				
				wp_redirect( $redirectLink );
				exit;

			}
		}
	}
}
add_action('admin_init','wppb_restrict_dashboard_access');



/**
 * Registers the css to the datepicker on the front-end
 *
 */
function wppb_register_datepicker_styles() {
	$myStyleUrl = WPPB_PLUGIN_URL.'/premium/assets/css/ui-lightness/jquery-ui-1.8.14.custom.css';
	wp_register_style('wppb_jqueryStyleSheet', $myStyleUrl);
}
add_action('init', 'wppb_register_datepicker_styles');

/**
 * Add the css to the datepicker on the front-end
 *
 * @uses $wppb_shortcode_on_front global. Used to check if the shortcode is present on the page.
 * $wppb_shortcode_on_front global is set to true in wppb_front_end_profile_info() and wppb_front_end_register()
 */
function wppb_add_datepicker_styles() {
	global  $wppb_shortcode_on_front;
	
	if( $wppb_shortcode_on_front == true ){
		wp_print_styles( 'wppb_jqueryStyleSheet' );
	}
}
add_action('wp_footer', 'wppb_add_datepicker_styles');

/**
 * Registers the datepicker js to the fontend and wppb_init js
 *
 */
function wppb_register_datepicker_script() {
	wp_register_script( 'wppb_jqueryDatepicker2', WPPB_PLUGIN_URL.'/premium/assets/js/jquery-ui-datepicker.min.js', array( 'jquery', 'jquery-ui-core' ) );
	wp_register_script( 'wppb_init', WPPB_PLUGIN_URL.'/premium/assets/js/wppb_init.js', array( 'wppb_jqueryDatepicker2' ) );
}    
add_action('init', 'wppb_register_datepicker_script');

/**
 * Add the datepicker to the fontend and wppb_init 
 *
 * @uses $wppb_shortcode_on_front global. Used to check if the shortcode is present on the page..
 * $wppb_shortcode_on_front global is set to true in wppb_front_end_profile_info() and wppb_front_end_register()
 */
function wppb_add_datepicker_script() {
	global  $wppb_shortcode_on_front;
	
	if( $wppb_shortcode_on_front == true ){
		wp_print_scripts( 'wppb_jqueryDatepicker2' );
		wp_print_scripts( 'wppb_init' );
	}
}    
add_action('wp_footer', 'wppb_add_datepicker_script');


add_action( 'admin_print_styles-profile.php', 'wppb_add_datepicker_styles_admin_panel');
add_action( 'admin_print_styles-user-edit.php', 'wppb_add_datepicker_styles_admin_panel');

/* function to add the css to the datepicker on the admin side */
function wppb_add_datepicker_styles_admin_panel(  ) {
	
		$myStyleUrl = WPPB_PLUGIN_URL.'/premium/assets/css/ui-lightness/jquery-ui-1.8.14.custom.css';
		wp_register_style('wppb_admin_jqueryStyleSheet', $myStyleUrl);
		wp_enqueue_style( 'wppb_admin_jqueryStyleSheet');
	
}
add_action( 'admin_enqueue_scripts', 'wppb_add_datepicker_script_admin_panel');

/* function to add the jquery for the datepicker on the admin side */
function wppb_add_datepicker_script_admin_panel( $hook ) {
	if(( $hook == 'profile.php' ) || ($hook == 'user-edit.php')){
		wp_enqueue_script('jquery-ui-core');
		
		wp_register_script( 'wppb_admin_jqueryDatepicker2', WPPB_PLUGIN_URL.'/premium/assets/js/jquery-ui-datepicker.min.js');
		wp_enqueue_script( 'wppb_admin_jqueryDatepicker2' );
	}   
}    