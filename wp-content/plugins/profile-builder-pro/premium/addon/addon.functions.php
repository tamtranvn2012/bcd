<?php
//function to set up default valies of the cookies (needs to be run on init)
function wppb_setCookies(){
	//create default cookie values
	if ((!isset ($_COOKIE['sortCriteria'])))
		setcookie("sortCriteria", '');
	if ((!isset ($_COOKIE['sortOrder'])))
		setcookie("sortOrder", '');
	if ((!isset ($_COOKIE['sortNumber'])))
		setcookie("sortNumber", '');
		
	//set cookies if form has been submitted
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update' ) {
		setcookie("sortCriteria", $_POST['setSortingCriteria']);
		setcookie("sortOrder", $_POST['setSortingOrder']);
		setcookie("sortNumber", $_POST['setSortingNumber']);
	}
}
add_action('init', 'wppb_setCookies');

//function to return date format for the user-listing function
function wppb_returnSignupDate($id){
	global $wpdb;
	$date = $wpdb->get_var($wpdb->prepare('SELECT user_registered FROM '.$wpdb->users.' WHERE ID="'.$id.'"'));
	$date = explode(' ', $date);
	$date = explode('-', $date[0]);
	return $date[2].'/'.$date[1].'/'.$date[0];
}

//function to create a readable time format
function wppb_getSignUpDate($time){
	
	$timeArray = explode ( '/' , $time );
	$var1 = (int)$timeArray[0];
	$var2 = (int)$timeArray[1];
	$var3 = (int)$timeArray[2];
	$time = $var3*10000+$var2*100+$var1;
	return $time;
}

//function to sort the multi-array
function wppb_sortmulti($array, $index, $order, $natsort=FALSE, $case_sensitive=FALSE) {
	if(is_array($array) && count($array)>0) {
		foreach(array_keys($array) as $key)
		$temp[$key]=$array[$key][$index];
		if(!$natsort) {
			if ($order=='ascending')
				asort($temp);
			else   
				arsort($temp);
		}
		else
		{
			if ($case_sensitive===true)
				natsort($temp);
			else
				natcasesort($temp);
		if($order=='descending')
			$temp=array_reverse($temp,TRUE);
		}
		foreach(array_keys($temp) as $key)
			if (is_numeric($key))
				$sorted[]=$array[$key];
			else   
				$sorted[$key]=$array[$key];
		return $sorted;
	}
    return $sorted;
}


//the function containing the contents of the userlisting
function wppb_userlisting_contents(){
	//verify if we already have arguments in the permalink
	$verifyLink = get_permalink();
	$questionMarkPosition = strpos ( $verifyLink , '?' );
	if ($questionMarkPosition !== FALSE ) //we already have 1 "?"
		$passedArgument = '&';
	else $passedArgument = '?';

	//check to see if we don't need to display only one user-information
	if (isset($_GET['userID'])){		
		
		get_currentuserinfo();
		$wppb_defaultOptions = get_option('wppb_default_settings');
		
		
		$userlistingFilterArray['topBackButton'] = '<a href=\'javascript:history.go(-1)\' class="wppb-back"><img src="'.WPPB_PLUGIN_URL.'/assets/images/arrow_left.png" title="Click here to go back" alt="<"/></a>';
		$userlistingFilterArray['topBackButton'] = apply_filters('wppb_userlisting_top_back_button', $userlistingFilterArray['topBackButton']);
		echo $userlistingFilterArray['topBackButton'];
		

		?>
		<!-- <div class="wppb_holder" id="wppb_modify">-->
		<div class="wppb_holder" id="wppb_userListing">
			<table id="userListingDisplayTable">
				<?php
				$userlistingFilterArray['nameRow'] = '
					<tr class="userListingDisplayTableRow">
						<td class="userListingDisplayTableCell1" colspan="2">
							<span id="header"><strong>'. __('Name', 'profilebuilder') .'</strong></span>
						</td>
					</tr>';
				$userlistingFilterArray['nameRow'] = apply_filters('wppb_userlisting_name_row', $userlistingFilterArray['nameRow']);
				echo $userlistingFilterArray['nameRow'];
				
				if ($wppb_defaultOptions['username'] == 'show'){
					$userData = get_the_author_meta( 'user_login', $_GET['userID'] );
					if ($userData == '')
						$userData = '-';
					$userlistingFilterArray['usernameRow'] = '
						<tr class="userListingDisplayTableRow">							
							<td class="userListingDisplayTableCell2">
								<span id="inputName">'. __('Username', 'profilebuilder') .':</span>
							</td>
							<td class="userListingDisplayTableCell3">
								<span id="inputValue">'.$userData.'</span>
							</td>
						</tr>';
					$userlistingFilterArray['usernameRow'] = apply_filters('wppb_userlisting_username_row', $userlistingFilterArray['usernameRow']);
					echo $userlistingFilterArray['usernameRow'];
				}
				
				if ($wppb_defaultOptions['firstname'] == 'show'){
					$userData = get_the_author_meta( 'first_name', $_GET['userID'] );
					if ($userData == '')
						$userData = '-';				
					$userlistingFilterArray['firstNameRow'] = '
						<tr class="userListingDisplayTableRow">							
							<td class="userListingDisplayTableCell2">
								<span id="inputName">'. __('First Name', 'profilebuilder') .':</span>
							</td>
							<td class="userListingDisplayTableCell3">
								<span id="inputValue">'.$userData.'</span>
							</td>
						</tr>';
					$userlistingFilterArray['firstNameRow'] = apply_filters('wppb_userlisting_firstname_row', $userlistingFilterArray['firstNameRow']);
					echo $userlistingFilterArray['firstNameRow'];
				}

				if ($wppb_defaultOptions['lastname'] == 'show'){
					$userData = get_the_author_meta( 'last_name', $_GET['userID'] );
					if ($userData == '')
						$userData = '-';						
					$userlistingFilterArray['lastNameRow'] = '
						<tr class="userListingDisplayTableRow">							
							<td class="userListingDisplayTableCell2">
								<span id="inputName">'. __('Last Name', 'profilebuilder') .':</span>
							</td>
							<td class="userListingDisplayTableCell3">
								<span id="inputValue">'.$userData.'</span>
							</td>
						</tr>';
					$userlistingFilterArray['lastNameRow'] = apply_filters('wppb_userlisting_lastname_row', $userlistingFilterArray['lastNameRow']);
					echo $userlistingFilterArray['lastNameRow'];
				}

				if ($wppb_defaultOptions['nickname'] == 'show'){
					$userData = get_the_author_meta( 'nickname', $_GET['userID'] );
					if ($userData == '')
						$userData = '-';				
					$userlistingFilterArray['nicknameRow'] = '
						<tr class="userListingDisplayTableRow">							
							<td class="userListingDisplayTableCell2">
								<span id="inputName">'. __('Nickname', 'profilebuilder') .':</span>
							</td>
							<td class="userListingDisplayTableCell3">
								<span id="inputValue">'.$userData.'</span>
							</td>
						</tr>';
					$userlistingFilterArray['nicknameRow'] = apply_filters('wppb_userlisting_nickname_row', $userlistingFilterArray['nicknameRow']);
					echo $userlistingFilterArray['nicknameRow'];
				}

				if ($wppb_defaultOptions['dispname'] == 'show'){
					$userData = get_the_author_meta( 'display_name', $_GET['userID'] );
					if ($userData == '')
						$userData = '-';				
					$userlistingFilterArray['displayNameRow'] = '
						<tr class="userListingDisplayTableRow">							
							<td class="userListingDisplayTableCell2">
								<span id="inputName">'. __('Display name publicly as', 'profilebuilder') .':</span>
							</td>
							<td class="userListingDisplayTableCell3">
								<span id="inputValue">'.$userData.'</span>
							</td>
						</tr>';
					$userlistingFilterArray['displayNameRow'] = apply_filters('wppb_userlisting_displayname_row', $userlistingFilterArray['displayNameRow']);
					echo $userlistingFilterArray['displayNameRow'];
				}

				if ($wppb_defaultOptions['website'] == 'show'){
					$userlistingFilterArray['contactInfoRow'] = '
						<tr class="userListingDisplayTableRow">
							<td class="userListingDisplayTableCell1" colspan="2">
								<span id="header"><strong>'. __('Contact Info', 'profilebuilder') .'</strong></span>
							</td>
						</tr>';
					$userlistingFilterArray['contactInfoRow'] = apply_filters('wppb_userlisting_contactinfo_row', $userlistingFilterArray['contactInfoRow']);
					echo $userlistingFilterArray['contactInfoRow'];
					
					$userData = get_the_author_meta( 'user_url', $_GET['userID'] );
					if ($userData == '')
						$userData = '-';	
					$userlistingFilterArray['websiteRow'] = '
						<tr class="userListingDisplayTableRow">							
							<td class="userListingDisplayTableCell2">
								<span id="inputName">'. __('Website', 'profilebuilder') .':</span>
							</td>
							<td class="userListingDisplayTableCell3">
								<span id="inputValue">'.$userData.'</span>
							</td>
						</tr>';
					$userlistingFilterArray['websiteRow'] = apply_filters('wppb_userlisting_website_row', $userlistingFilterArray['websiteRow']);
					echo $userlistingFilterArray['websiteRow'];
				}

				if ($wppb_defaultOptions['bio'] == 'show'){
					$userlistingFilterArray['aboutYourselfRow'] = '
						<tr class="userListingDisplayTableRow">
							<td class="userListingDisplayTableCell1" colspan="2">
								<span id="header"><strong>'. __('About Yourself', 'profilebuilder') .'</strong></span>
							</td>
						</tr>';
					$userlistingFilterArray['aboutYourselfRow'] = apply_filters('wppb_userlisting_aboutyourself_row', $userlistingFilterArray['aboutYourselfRow']);
					echo $userlistingFilterArray['aboutYourselfRow'];

					$bio = get_user_meta( $_GET['userID'], 'description', true);
					if ($bio == '')
						$bio = '-';
					$desc = nl2br($bio);
					
					$userlistingFilterArray['bioInfoRow'] = '
						<tr class="userListingDisplayTableRow">							
							<td class="userListingDisplayTableCell2">
								<span id="inputName">'. __('Biographical Info', 'profilebuilder') .':</span>
							</td>
							<td class="userListingDisplayTableCell3">
								<span id="inputValue">'.$desc.'</span>
							</td>
						</tr>';
					$userlistingFilterArray['bioInfoRow'] = apply_filters('wppb_userlisting_bioinfo_row', $userlistingFilterArray['bioInfoRow']);
					echo $userlistingFilterArray['bioInfoRow'];
				}

			//the listing of the custom fields
			/* fetch a new custom-fields (only the types) array from the database */
			$wppbFetchArray = get_option('wppb_custom_fields');
			
			if (count($wppbFetchArray) >= 1){
				foreach($wppbFetchArray as $key => $value){
					switch ($value['item_type']) {
						case "heading":{												
							$userlistingFilterArray['customFieldHeaderRow'] = '
								<tr class="userListingDisplayTableRow">
									<td class="userListingDisplayTableCell1" colspan="2">
										<span id="header"><strong>'.$value['item_title'].'</strong></span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldHeaderRow'] = apply_filters('wppb_userlisting_customfield_header_row', $userlistingFilterArray['customFieldHeaderRow']);
							echo $userlistingFilterArray['customFieldHeaderRow'];
							break;
						}				
						case "input":{
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);
							if ($userData == '')
								$userData = '-';
							
							$userlistingFilterArray['customFieldInputRow'] = '
								<tr class="userListingDisplayTableRow">									
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'.$value['item_title'].':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">'.$userData.'</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldInputRow'] = apply_filters('wppb_userlisting_customfield_input_row', $userlistingFilterArray['customFieldInputRow']);
							echo $userlistingFilterArray['customFieldInputRow'];
							
							if ($value['item_desc'] != ''){
								$userlistingFilterArray['customFieldInputDesciptionRow'] = '
									<tr class="userListingDisplayTableRow">										
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'.$value['item_desc'].'</span>
										</td>
									</tr>';
								$userlistingFilterArray['customFieldInputDesciptionRow'] = apply_filters('wppb_userlisting_customfield_input_description_row', $userlistingFilterArray['customFieldInputDesciptionRow']);
								echo $userlistingFilterArray['customFieldInputDesciptionRow'];
							}
							break;
						}
						case "checkbox":{
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);
							$userDataArray = explode(',', $userData);
							$checkBoxValue = $value['item_options'];
							$newValue = str_replace(' ', '#@space@#', $checkBoxValue);  //we need to escape the spaces in the options list, because it won't save
							$checkboxValue = explode(',', $value['item_options']);
							$checkboxValue2 = explode(',', $newValue);
							$nr = count($userDataArray);

							$userlistingFilterArray['customFieldCheckboxRow'] = '
								<tr class="userListingDisplayTableRow">
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'.$value['item_title'].':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">';
											if ($userData == '')
												$userlistingFilterArray['customFieldCheckboxRow'] .= '-';
											else{
												for($i=0; $i<$nr-2; $i++)
													$userlistingFilterArray['customFieldCheckboxRow'] .= $userDataArray[$i]. ', ';
												$userlistingFilterArray['customFieldCheckboxRow'] .= $userDataArray[$nr-2];
											}
									$userlistingFilterArray['customFieldCheckboxRow'] .= '</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldCheckboxRow'] = apply_filters('wppb_userlisting_customfield_checkbox_row', $userlistingFilterArray['customFieldCheckboxRow']);
							echo $userlistingFilterArray['customFieldCheckboxRow'];
							if ($value['item_desc'] != ''){							
								$userlistingFilterArray['customFieldCheckboxDescRow'] = '
									<tr class="userListingDisplayTableRow">										
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'.$value['item_desc'].'</span>
										</td>
									</tr>';	
								$userlistingFilterArray['customFieldCheckboxDescRow'] = apply_filters('wppb_userlisting_customfield_checkbox_description_row', $userlistingFilterArray['customFieldCheckboxDescRow']);
								echo $userlistingFilterArray['customFieldCheckboxDescRow'];

							}
							break;
						}
						case "radio":{	
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);
							if ($userData == '')
								$userData = '-';
							$radioValue = explode(',', $value['item_options']);
							
							$userlistingFilterArray['customFieldRadioRow'] = '
								<tr class="userListingDisplayTableRow">									
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'. $value['item_title'] .':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">'.$userData.'</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldRadioRow'] = apply_filters('wppb_userlisting_customfield_radio_row', $userlistingFilterArray['customFieldRadioRow']);
							echo $userlistingFilterArray['customFieldRadioRow'];
							if ($value['item_desc'] != ''){							
								$userlistingFilterArray['customFieldRadioDescRow'] = '
									<tr class="userListingDisplayTableRow">										
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'. $value['item_desc'] .'</span>
										</td>
									</tr>';	
								$userlistingFilterArray['customFieldRadioDescRow'] = apply_filters('wppb_userlisting_customfield_radio_description_row', $userlistingFilterArray['customFieldRadioDescRow']);
								echo $userlistingFilterArray['customFieldRadioDescRow'];
							}							

							break;
						}
						case "select":{
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);
							$selectValue = explode(',', $value['item_options']);

							$userlistingFilterArray['customFieldSelectRow'] = '
								<tr class="userListingDisplayTableRow">									
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'.$value['item_title'].':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">'.$userData.'</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldSelectRow'] = apply_filters('wppb_userlisting_customfield_select_row', $userlistingFilterArray['customFieldSelectRow']);
							echo $userlistingFilterArray['customFieldSelectRow'];
							if ($value['item_desc'] != ''){							
								$userlistingFilterArray['customFieldSelectDescRow'] = '
									<tr class="userListingDisplayTableRow">										
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'.$value['item_desc'].'</span>
										</td>
									</tr>';	
								$userlistingFilterArray['customFieldSelectDescRow'] = apply_filters('wppb_userlisting_customfield_select_description_row', $userlistingFilterArray['customFieldSelectDescRow']);
								echo $userlistingFilterArray['customFieldSelectDescRow'];									
							}	
							
							break;
						}
						case "countrySelect":{
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);
							if ($userData == '')
								$userData = '-';
							
							$userlistingFilterArray['customFieldCountrySelectRow'] = '
								<tr class="userListingDisplayTableRow">									
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'.$value['item_title'].':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">'.$userData.'</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldCountrySelectRow'] = apply_filters('wppb_userlisting_customfield_countryselect_row', $userlistingFilterArray['customFieldCountrySelectRow']);
							echo $userlistingFilterArray['customFieldCountrySelectRow'];	
							if ($value['item_desc'] != ''){							
								$userlistingFilterArray['customFieldCountrySelectDescRow'] = '
									<tr class="userListingDisplayTableRow">										
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'.$value['item_desc'].'</span>
										</td>
									</tr>';	
								$userlistingFilterArray['customFieldCountrySelectDescRow'] = apply_filters('wppb_userlisting_customfield_countryselect_description_row', $userlistingFilterArray['customFieldCountrySelectDescRow']);
								echo $userlistingFilterArray['customFieldCountrySelectDescRow'];										
							}								
							
							break;
						}
						case "timeZone":{
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);

							$userlistingFilterArray['customFieldTimezoneRow'] = '
								<tr class="userListingDisplayTableRow">									
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'.$value['item_title'].':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">'.$userData.'</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldTimezoneRow'] = apply_filters('wppb_userlisting_customfield_timezone_row', $userlistingFilterArray['customFieldTimezoneRow']);
							echo $userlistingFilterArray['customFieldTimezoneRow'];	
							if ($value['item_desc'] != ''){							
								$userlistingFilterArray['customFieldTimezoneDescRow'] = '
									<tr class="userListingDisplayTableRow">
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'.$value['item_desc'].'</span>
										</td>
									</tr>';	
								$userlistingFilterArray['customFieldTimezoneDescRow'] = apply_filters('wppb_userlisting_customfield_timezone_description_row', $userlistingFilterArray['customFieldTimezoneDescRow']);
								echo $userlistingFilterArray['customFieldTimezoneDescRow'];										
							}	

							break;
						}
						case "datepicker":{	
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);
							if ($userData == '')
								$userData = '-';
						
							$userlistingFilterArray['customFieldDatepickerRow'] = '
								<tr class="userListingDisplayTableRow">
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'.$value['item_title'].':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">'.$userData.'</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldDatepickerRow'] = apply_filters('wppb_userlisting_customfield_datepicker_row', $userlistingFilterArray['customFieldDatepickerRow']);
							echo $userlistingFilterArray['customFieldDatepickerRow'];	
							if ($value['item_desc'] != ''){							
								$userlistingFilterArray['customFieldDatepickerDescRow'] = '
									<tr class="userListingDisplayTableRow">
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'.$value['item_desc'].'</span>
										</td>
									</tr>';	
								$userlistingFilterArray['customFieldDatepickerDescRow'] = apply_filters('wppb_userlisting_customfield_datepicker_description_row', $userlistingFilterArray['customFieldDatepickerDescRow']);
								echo $userlistingFilterArray['customFieldDatepickerDescRow'];										
							}								
					
							break;
						}
						case "textarea":{
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);
						
							$userlistingFilterArray['customFieldTextareaRow'] = '
								<tr class="userListingDisplayTableRow">									
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'.$value['item_title'].':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">'.nl2br($userData).'</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldTextareaRow'] = apply_filters('wppb_userlisting_customfield_textarea_row', $userlistingFilterArray['customFieldTextareaRow']);
							echo $userlistingFilterArray['customFieldTextareaRow'];	
							if ($value['item_desc'] != ''){							
								$userlistingFilterArray['customFieldTextareaDescRow'] = '
									<tr class="userListingDisplayTableRow">
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'.$value['item_desc'].'</span>
										</td>
									</tr>';
								$userlistingFilterArray['customFieldTextareaDescRow'] = apply_filters('wppb_userlisting_customfield_textarea_description_row', $userlistingFilterArray['customFieldTextareaDescRow']);
								echo $userlistingFilterArray['customFieldTextareaDescRow'];										
							}							
						
							break;
						}
						case "upload":{	
							$imgSource = WPPB_PLUGIN_URL . '/assets/images/';
							$script = WPPB_PLUGIN_URL . '/premium/functions/';
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);
							$fileName = str_replace ( get_bloginfo('home').'/wp-content/uploads/profile_builder/attachments/userID_'.$_GET['userID'].'_attachment_', '', $userData );
							
							$userlistingFilterArray['customFieldUploadRow'] = '
								<tr class="userListingDisplayTableRow">
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'.$value['item_title'].':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">';
										if (($userData == '') || ($userData == get_bloginfo('url').'/wp-content/uploads/profile_builder/attachments/')){
											$userlistingFilterArray['customFieldUploadRow'] .= '</span><span class="wppb-description-delimiter2"><u>'. __('Current file', 'profilebuilder') .'</u>: </span><span class="wppb-description-delimiter2">'. __('No uploaded attachment', 'profilebuilder') .'</span>';
										}
										else{
											$userlistingFilterArray['customFieldUploadRow'] .= '</span><span class="wppb-description-delimiter2"><u>'. __('Current file', 'profilebuilder') .'</u>: '.$fileName.'<a href="'.$userData.'" target="_blank" class="wppb-cattachment"><img src="'.$imgSource.'attachment.png" title="'. __('Click to see the current attachment', 'profilebuilder') .'"></a></span>';
										}										
									$userlistingFilterArray['customFieldUploadRow'] .= '</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldUploadRow'] = apply_filters('wppb_userlisting_customfield_upload_row', $userlistingFilterArray['customFieldUploadRow']);
							echo $userlistingFilterArray['customFieldUploadRow'];		
							if ($value['item_desc'] != ''){							
								$userlistingFilterArray['customFieldUploadDescRow'] = '
									<tr class="userListingDisplayTableRow">
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'.$value['item_desc'].'</span>
										</td>
									</tr>';	
								$userlistingFilterArray['customFieldUploadDescRow'] = apply_filters('wppb_userlisting_customfield_upload_desciption_row', $userlistingFilterArray['customFieldUploadDescRow']);
								echo $userlistingFilterArray['customFieldUploadDescRow'];									
							}							
							
							break;
						}
						case "avatar":{	
						
							// check first if the avatar size didn't change, if so create a new one with the new dimensions 
							$imgSource = WPPB_PLUGIN_URL . '/assets/images/';
							$userData = get_user_meta($_GET['userID'], $value['item_metaName'], true);  // to use for the link
							$userData2 = get_user_meta($_GET['userID'], 'resized_avatar_'.$value['id'], true); 	//to use for the preview	
						
							if ($userData != ''){
								if ($userData2 == ''){
									wppb_resize_avatar($currentUser);
									$userData2 = get_user_meta($currentUser, 'resized_avatar_'.$value['id'], true); 	//to use for the preview	
								}
									
								//get image info
								$info = getimagesize($userData2);
								
								//this checks if it only has 1 component
								if (is_numeric($value['item_options'])){
									$width = $height = $value['item_options'];
								//this checks if the entered value has 2 components
								}else{
									$sentValue = explode(',',$value['item_options']);
									$width = $sentValue[0];
									$height = $sentValue[1];
								}
								
								//call the avatar resize function if needed
								if (($info[0] != $width) || ($info[1] != $height)){
									wppb_resize_avatar($_GET['userID']);
									//re-fetch user-data
									$userData2 = get_user_meta($_GET['userID'], 'resized_avatar_'.$value['id'], true);
								}
							}
							
							$userlistingFilterArray['customFieldAvatarRow'] = '
								<tr class="userListingDisplayTableRow">
									<td class="userListingDisplayTableCell2">
										<span id="inputName">'. $value['item_title'] .':</span>
									</td>
									<td class="userListingDisplayTableCell3">
										<span id="inputValue">';
									if (($userData == '') || ($userData == get_bloginfo('url').'/wp-content/uploads/profile_builder/avatars/')){
										$avatarImage = get_avatar($_GET['userID'], $value['item_options'] );
										$userlistingFilterArray['customFieldAvatarRow'] .= $avatarImage;
									}
									else{
										//get image info
										$info = getimagesize($userData2);
										// display the resized image
										$userlistingFilterArray['customFieldAvatarRow'] .= '<br/><span class="avatar-border"><IMG SRC="'.$userData2.'" TITLE="'. __('Avatar', 'profilebuilder') .'" ALT="'. __('Avatar', 'profilebuilder') .'" HEIGHT='.$info[1].' WIDTH='.$info[0].'></span>';
										// display a link to the bigger image to see it clearly
										$userlistingFilterArray['customFieldAvatarRow'] .= '<a href="'.$userData.'" target="_blank" class="wppb-cattachment"><img src="'.$imgSource.'attachment.png" title="'. __('Click to see the current attachment', 'profilebuilder') .'"></a>';
									}
									$userlistingFilterArray['customFieldAvatarRow'] .=  '</span>
									</td>
								</tr>';
							$userlistingFilterArray['customFieldAvatarRow'] = apply_filters('wppb_userlisting_customfield_avatar_row', $userlistingFilterArray['customFieldAvatarRow']);
							echo $userlistingFilterArray['customFieldAvatarRow'];	
							if ($value['item_desc'] != ''){							
								$userlistingFilterArray['customFieldAvatarDescRow'] = '
									<tr class="userListingDisplayTableRow">										
										<td class="userListingDisplayTableCell2"></td>
										<td class="userListingDisplayTableCell3">
											<span class="wppb-description-delimiter2">'. $value['item_desc'] .'</span>
										</td>
									</tr>';
								$userlistingFilterArray['customFieldAvatarDescRow'] = apply_filters('wppb_userlisting_customfield_avatar_description_row', $userlistingFilterArray['customFieldAvatarDescRow']);
								echo $userlistingFilterArray['customFieldAvatarDescRow'];										
							}								

							break;
						}
					}
				}
			}
			echo '</table>';
		echo '</div>';
		
		?>
			
		<?php
		$userlistingFilterArray['bottomBackButton'] = '<a href=\'javascript:history.go(-1)\' class="wppb-back"><img src="'.WPPB_PLUGIN_URL.'/assets/images/arrow_left.png" title="Click here to go back" alt="<"/></a>';
		$userlistingFilterArray['bottomBackButton'] = apply_filters('wppb_userlisting_bottom_back_button', $userlistingFilterArray['bottomBackButton']);
		echo $userlistingFilterArray['bottomBackButton'];
		
	}else{
		//get the sorting criteria and order from the database or the $_POST if it's been requested
		$userListingSettings = get_option('userListingSettings');
		if (isset($_POST['setSortingCriteria']))
			$sortCriteria = $_POST['setSortingCriteria'];
		elseif ($_COOKIE['sortCriteria'] != '')
			$sortCriteria = $_COOKIE["sortCriteria"];
		else $sortCriteria = $userListingSettings['sortingCriteria'];
		if (isset($_POST['setSortingOrder']))
			$sortOrder = $_POST['setSortingOrder'];
		elseif ($_COOKIE['sortOrder'] != '')
			$sortOrder = $_COOKIE["sortOrder"];
		else $sortOrder = $userListingSettings['sortingOrder'];
		if (isset($_POST['setSortingNumber']))
			$sortNumber = $_POST['setSortingNumber'];
		elseif ($_COOKIE['sortNumber'] != '')
			$sortNumber = $_COOKIE["sortNumber"];
		else $sortNumber = $userListingSettings['sortingNumber'];
		
		echo '
		<form method="post" action="" id="userListingForm">
		<span>'. __('Users listed by:', 'profilebuilder') .'</span>';
		
		?>
		<select class="sortingOrderCriteria2" name="setSortingCriteria">
			<option <?php if ($sortCriteria == 'userName'){ echo 'selected="yes" ';} ?>value="userName">Username</option>
			<option <?php if ($sortCriteria == 'name'){ echo 'selected="yes" ';} ?>value="name">Name</option>
			<option <?php if ($sortCriteria == 'role'){ echo 'selected="yes" ';} ?>value="role">User Role</option>
			<option <?php if ($sortCriteria == 'numberOfPosts'){ echo 'selected="yes" ';} ?>value="numberOfPosts">Number of Posts</option>
			<option <?php if ($sortCriteria == 'signupDate'){ echo 'selected="yes" ';} ?>value="signupDate">Sign-up Date</option>
		</select>
		
		<select class="sortingOrderSelect2" name="setSortingOrder">
			<option <?php if ($sortOrder == 'ascending'){ echo 'selected="yes" ';} ?> value="ascending">Ascending</option>
			<option <?php if ($sortOrder == 'descending'){ echo 'selected ="yes" ';} ?> value="descending">Descending</option>
		</select>
		
		<?php
		echo '<span>. '. __('Displaying', 'profilebuilder') .'</span>';
		?>
		<select class="sortingNumberSelect2" name="setSortingNumber">
			<option <?php if ($sortNumber == '5'){ echo 'selected="yes" ';} ?> value="5">5</option>
			<option <?php if ($sortNumber == '10'){ echo 'selected="yes" ';} ?> value="10">10</option>
			<option <?php if ($sortNumber == '25'){ echo 'selected="yes" ';} ?> value="25">25</option>
			<option <?php if ($sortNumber == '50'){ echo 'selected ="yes" ';} ?> value="50">50</option>
			<option <?php if ($sortNumber == '100'){ echo 'selected ="yes" ';} ?> value="100">100</option>
			<option <?php if ($sortNumber == '150'){ echo 'selected ="yes" ';} ?> value="150">150</option>
			<option <?php if ($sortNumber == '200'){ echo 'selected ="yes" ';} ?> value="200">200</option>
			<option <?php if ($sortNumber == '250'){ echo 'selected ="yes" ';} ?> value="250">250</option>
			<option <?php if ($sortNumber == '500'){ echo 'selected ="yes" ';} ?> value="500">500</option>
			<option <?php if ($sortNumber == '1000'){ echo 'selected ="yes" ';} ?> value="1000">1000</option>
		</select>
		<?php
		echo '<span>'.__('users/page', 'profilebuilder').'.</span>';
		?>
		<input type="hidden" name="action" value="update" />
		<input type="submit" class="button-primary-reorder" value="<?php _e('Reorder') ?>" /> 
		</form>
		<?php
		//create empty holder array
		$allUserInfo = array();
		
		$getUsersArg = '';
		$getUsersArg = apply_filters('wppb_userlisting_get_users_param', $getUsersArg);
		
		//get all users
		$localBlogusers = get_users($getUsersArg);
		foreach ($localBlogusers as $user) {
			$user_extra_info = get_userdata($user->ID);
			$userRole = new WP_User($user->ID);
			$args = array('author'=>$user->ID, 'numberposts'=> -1);
			$allPosts = get_posts($args);
			$postsNumber = count($allPosts);
			$userlistingFilterArray['moreInfo'] = '<a href="'.get_permalink().$passedArgument.'userID='.$user->ID.'" class="wppb-more"><img src="'.WPPB_PLUGIN_URL.'/assets/images/arrow_right.png" title="'. __('Click here to see more information about this user.', 'profilebuilder') .'" alt=">"></a>';
			$userlistingFilterArray['moreInfo'] = apply_filters('wppb_userlisting_more_info', $userlistingFilterArray['moreInfo']);
			//check to see if the user has set an avatar, then return it or set it to the wordpress default
			
			$signUp = wppb_getSignUpDate ( $var = wppb_returnSignupDate($user->ID));
			$avatarSize = '16';
			$avatarSize = apply_filters('wppb_userlisting_avatar_size', $avatarSize);
			$avatarImage = get_avatar($user->ID, $avatarSize );
			//create the name
			$name = '';
			if ($user_extra_info->display_name != '')
				$name = $user_extra_info->display_name;
			elseif ($user_extra_info->nickname != '')
				$name = $user_extra_info->nickname;
			elseif (($user_extra_info->user_lastname != '') && ($user_extra_info->user_firstname != ''))
				$name = $user_extra_info->user_firstname . ' ' . $user_extra_info->user_lastname;
			elseif ($user_extra_info->user_firstname != '')
				$name = $user_extra_info->user_firstname;
			elseif ($user_extra_info->user_lastname != '')
				$name =  $user_extra_info->user_lastname;
			else $name = $user->user_login;
			
			$userlistingFilterArray['name'] = apply_filters('wppb_userlisting_name', $name);
				
			$localArray = array(0 => $avatarImage,
								1 => $user->user_login,
								2 => $userlistingFilterArray['name'],
								6 => $userRole->roles[0],
								7 => $postsNumber,
								8 => wppb_returnSignupDate($user->ID),
								9 => $userlistingFilterArray['moreInfo'],
								10 => $signUp,
								11 => get_author_posts_url($user->ID));
			//push it to the holder-array
			array_push ( $allUserInfo , $localArray );
		
		}
		
		//order the array given the sorting criteria and order
		$numberOfElements = count ($allUserInfo);
		
		switch ($sortCriteria) {
			case 'userName':
				$allUserInfo = wppb_sortmulti ($allUserInfo, 1, $sortOrder, $natsort=FALSE, $case_sensitive=FALSE);
				$index = 1;
				break;
			case 'name':
				$allUserInfo = wppb_sortmulti ($allUserInfo, 2, $sortOrder, $natsort=FALSE, $case_sensitive=FALSE);
				$index = 2;
				break;
			case 'role':
				$allUserInfo = wppb_sortmulti ($allUserInfo, 6, $sortOrder, $natsort=FALSE, $case_sensitive=FALSE);
				$index = 6;
				break;
			case 'numberOfPosts':
				$allUserInfo = wppb_sortmulti ($allUserInfo, 7, $sortOrder, $natsort=FALSE, $case_sensitive=FALSE);
				$index = 7;
				break;
			case 'signupDate':
				$allUserInfo = wppb_sortmulti ($allUserInfo, 10, $sortOrder, $natsort=FALSE, $case_sensitive=FALSE);
				$index = 8;
				break;
		}
		
		//start creating the pagination
		include 'pagination.class.php';
		$pagination = new pagination;
		
		$userListingSettings = get_option('userListingSettings');
		$usersPerPage = $sortNumber;
		
		$userInfoPages = $pagination->generate($allUserInfo, $usersPerPage); //specify results per page
		
		//create paginated table
		$userlistingFilterArray['userlistingTable'] = '
		<table id="userListingTable" cellspacing="0">
				<thead>
					<tr>
						<th class="userListingTableHeading1" scope="col" colspan="2"><span>Username</span></th>
						<th class="userListingTableHeading2" scope="col"><span>Name</span></th>
						<th class="userListingTableHeading3" scope="col"><span>User Role</span></th>
						<th class="userListingTableHeading4" scope="col"><span>Posts</span></th>
						<th class="userListingTableHeading5" scope="col"><span>Sign-up Date</span></th>
						<th class="userListingTableHeading6" scope="col"><span>More</span></th>
					</tr>
				</thead>
					<tbody>';
					foreach ($userInfoPages as $key => $value){
						$userlistingFilterArray['userlistingTable'] .= '<tr class="tableRow" onmouseover="style.backgroundColor=\'grey\'; style.color=\'white\';" onmouseout="style.backgroundColor=\'\'; style.color=\'\';">';
						$userlistingFilterArray['userlistingTable'] .= '
							<td class="avatarColumn">'.$userInfoPages[$key][0].'
							</td>
							<td class="loginNameColumn"> 
								<span>'.$userInfoPages[$key][1].'</span>
							</td> 
							<td class="nameColumn"> 
								<span>'.$userInfoPages[$key][2].'</span>
							</td> 
							<td class="roleColumn"> 
								<span>'.$userInfoPages[$key][6].'</span>
							</td> 
							<td class="postsColumn"> 
								<span><a href="'.$userInfoPages[$key][11].'">'.$userInfoPages[$key][7].'</a></span>
							</td> 
							<td class="signUpColumn"> 
								<span>'.$userInfoPages[$key][8].'</span>
							</td> 
							<td class="moreInfoColumn"> 
								<span>'.$userInfoPages[$key][9].'</span>
							</td> 
						</tr>';
					}
						
					$userlistingFilterArray['userlistingTable'] .= '
					</tbody>
			</table>';
		$userlistingFilterArray['userlistingTable'] = apply_filters('wppb_userlisting_userlisting_table', $userlistingFilterArray['userlistingTable']);
		echo $userlistingFilterArray['userlistingTable'];	
		
		$pageNumbers = '<br/><div class="pageNumberDisplay" align="right">'.$pagination->links().'</div>';
		$userlistingFilterArray['userlistingTablePagination'] = apply_filters('wppb_userlisting_userlisting_table_pagination', $pageNumbers);
		echo $userlistingFilterArray['userlistingTablePagination'];			
	}
}


//the function for the user-listing
function wppb_list_all_users($atts){

	$userlistingFilterArray = array();

	//get value set in the shortcode as parameter, default to "public" if not set
	extract(shortcode_atts(array('visibility' => 'public'), $atts));
	
	//if the visibility was set to "restricted" then we need to check if the current user browsing the site/blog is logged in or not
	if ($visibility == 'restricted'){
		if ( is_user_logged_in() ) {
			wppb_userlisting_contents();
		}elseif ( !is_user_logged_in() ) {
			$userlistingFilterArray['notLoggedIn'] = '<p class="error">You need to be logged in to view the userlisting!</p>';
			$userlistingFilterArray['notLoggedIn'] = apply_filters('wppb_not_logged_in_error_message', $userlistingFilterArray['notLoggedIn']);
			echo $userlistingFilterArray['notLoggedIn'];
		}
	}else{
		wppb_userlisting_contents();
	}
}
?>