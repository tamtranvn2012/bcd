<?php
function displayAddons(){
?>
	<form method="post" action="options.php#add-ons">
		<?php $wppb_addonOptions = get_option('wppb_premium_addon_settings'); ?>
		<?php settings_fields('wppb_premium_addon_settings'); ?>
		
		
		<h2><?php _e('Activate/Deactivate Addons', 'profilebuilder');?></h2>
		<h3><?php _e('Activate/Deactivate Addons', 'profilebuilder');?></h3>
		<table id="wp-list-table widefat fixed pages" cellspacing="0">
			<thead>
				<tr>
					<th id="manage-column" id="addonHeader" scope="col"><?php _e('Name/Description', 'profilebuilder');?></th>
					<th id="manage-column" scope="col"><?php _e('Status', 'profilebuilder');?></th>
				</tr>
			</thead>
				<tbody>
					<tr>  
						<td id="manage-columnCell"><?php _e('User-Listing', 'profilebuilder');?></td> 
						<td> 
							<input type="radio" name="wppb_premium_addon_settings[userListing]" value="show" <?php if ($wppb_addonOptions['userListing'] == 'show') echo 'checked';?> /><font size="1"><?php _e('Active', 'profilebuilder');?></font><span style="padding-left:20px"></span>
							<input type="radio" name="wppb_premium_addon_settings[userListing]" value="hide" <?php if ($wppb_addonOptions['userListing'] == 'hide') echo 'checked';?>/><font size="1"><?php _e('Inactive', 'profilebuilder');?></font>
						</td> 
					</tr>
					<tr>  
						<td id="manage-columnCell"><?php _e('Custom Redirects', 'profilebuilder');?></td> 
						<td id="manage-columnCell"> 
							<input type="radio" name="wppb_premium_addon_settings[customRedirect]" value="show" <?php if ($wppb_addonOptions['customRedirect'] == 'show') echo 'checked';?> /><font size="1"><?php _e('Active', 'profilebuilder');?></font><span style="padding-left:20px"></span>
							<input type="radio" name="wppb_premium_addon_settings[customRedirect]" value="hide" <?php if ($wppb_addonOptions['customRedirect'] == 'hide') echo 'checked';?> /><font size="1"><?php _e('Inactive', 'profilebuilder');?></font>
						</td> 
					</tr>
				</tbody>
		</table>
		<div align="right">
			<input type="hidden" name="action" value="update" />
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /> 
			</p>
			</form>
		</div>
<?php
}
?>

<?php

function userListing(){
	//first thing we will have to do is create a default settings on first-time run of the addon
	$userListingSettings = get_option('userListingSettings','not_found');
	if ($userListingSettings == 'not_found'){
		$userListingSettingsArg = array( 'sortingCriteria' => 'userName', 
										 'sortingOrder'=> 'ascending',
										 'sortingNumber'=> '25');
		add_option('userListingSettings', $userListingSettingsArg);
	}
?>
	<form method="post" action="options.php#userListing">
	<?php $userListingSettings = get_option('userListingSettings'); ?>
	<?php settings_fields('userListingSettings'); ?>
	
	<h2><?php _e('User-Listing', 'profilebuilder');?></h2>
	<h3><?php _e('User-Listing', 'profilebuilder');?></h3>
	<p>
	<?php _e('To create a page containing the users registered to this current site/blog, insert the following shortcode in a (blank) page: ', 'profilebuilder');?><strong>[wppb-list-users]</strong>.<br/><br/>
	
	<?php _e('Please select the default user-listing (can be temporarily overwritten in the front-end):', 'profilebuilder');?>
	</p>
	
	<table class="sortingTable">
		<tr class="sortingTableRow">
			<td class="sortingTableCell1"><span style="padding-left:20px"></span> &rarr; <?php _e('Sorting Criteria: ', 'profilebuilder');?></td>
			<td class="sortingTableCell2">
				<select class="sortingOrderCriteria" name="userListingSettings[sortingCriteria]">
					<option <?php if ($userListingSettings['sortingCriteria'] == 'userName'){ echo 'selected="yes" ';} ?>value="userName">Username</option>
					<option <?php if ($userListingSettings['sortingCriteria'] == 'name'){ echo 'selected="yes" ';} ?>value="name">Name</option>
					<option <?php if ($userListingSettings['sortingCriteria'] == 'role'){ echo 'selected="yes" ';} ?>value="role">User Role</option>
					<option <?php if ($userListingSettings['sortingCriteria'] == 'numberOfPosts'){ echo 'selected="yes" ';} ?>value="numberOfPosts">Number of Posts</option>
					<option <?php if ($userListingSettings['sortingCriteria'] == 'signupDate'){ echo 'selected="yes" ';} ?>value="signupDate">Sign-up Date</option>
				</select>
			</td>
		</tr>
		<tr class="sortingTableRow">
			<td class="sortingTableCell1"><span style="padding-left:20px"></span> &rarr; <?php _e('Sorting Order: ', 'profilebuilder');?></td>
			<td class="sortingTableCell2">
				<select class="sortingOrderSelect" name="userListingSettings[sortingOrder]">
					<option <?php if ($userListingSettings['sortingOrder'] == 'ascending'){ echo 'selected="yes" ';} ?> value="ascending">Ascending</option>
					<option <?php if ($userListingSettings['sortingOrder'] == 'descending'){ echo 'selected ="yes" ';} ?> value="descending">Descending</option>
				</select>
			</td>
		</tr>
		<tr class="sortingTableRow">
			<td class="sortingTableCell1"><span style="padding-left:20px"></span> &rarr; <?php _e('Users/Page: ', 'profilebuilder');?></td>
			<td class="sortingTableCell2">
				<select class="sortingNumberSelect" name="userListingSettings[sortingNumber]">
					<option <?php if ($userListingSettings['sortingNumber'] == '5'){ echo 'selected="yes" ';} ?> value="5">5</option>
					<option <?php if ($userListingSettings['sortingNumber'] == '10'){ echo 'selected="yes" ';} ?> value="10">10</option>
					<option <?php if ($userListingSettings['sortingNumber'] == '25'){ echo 'selected="yes" ';} ?> value="25">25</option>
					<option <?php if ($userListingSettings['sortingNumber'] == '50'){ echo 'selected ="yes" ';} ?> value="50">50</option>
					<option <?php if ($userListingSettings['sortingNumber'] == '100'){ echo 'selected ="yes" ';} ?> value="100">100</option>
					<option <?php if ($userListingSettings['sortingNumber'] == '150'){ echo 'selected ="yes" ';} ?> value="150">150</option>
					<option <?php if ($userListingSettings['sortingNumber'] == '200'){ echo 'selected ="yes" ';} ?> value="200">200</option>
					<option <?php if ($userListingSettings['sortingNumber'] == '250'){ echo 'selected ="yes" ';} ?> value="250">250</option>
					<option <?php if ($userListingSettings['sortingNumber'] == '500'){ echo 'selected ="yes" ';} ?> value="500">500</option>
					<option <?php if ($userListingSettings['sortingNumber'] == '1000'){ echo 'selected ="yes" ';} ?> value="1000">1000</option>
				</select>
			</td>
		</tr>
	</table>
	
	<div align="right">
		<input type="hidden" name="action" value="update" />
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /> 
		</p>
	</form>
	</div>
	
<?php
}


function customRedirect(){
	//first thing we will have to do is create a default settings on first-time run of the addon
	$customRedirectSettings = get_option('customRedirectSettings','not_found');
		if ($customRedirectSettings == 'not_found'){
			$customRedirectSettingsArg = array( 'afterRegister' => 'no', 
												'afterLogin'=> 'no',
												'afterRegisterTarget' => '', 
												'afterLoginTarget'=> '',
												'loginRedirect' => 'no',
												'loginRedirectLogout' => 'no',
												'registerRedirect' => 'no',
												'recoverRedirect' => 'no',
												'dashboardRedirect' => 'no',
												'loginRedirectTarget' => '', 
												'loginRedirectTargetLogout' => '', 
												'registerRedirectTarget'=> '',
												'recoverRedirectTarget' => '', 
												'dashboardRedirectTarget' => '');
			add_option('customRedirectSettings', $customRedirectSettingsArg);
		}
?>
	
	<form method="post" action="options.php#customRedirect">
	<?php $customRedirectSettings = get_option('customRedirectSettings'); ?>
	<?php settings_fields('customRedirectSettings'); ?>

	
	
	<h2><?php _e('Custom Redirects', 'profilebuilder');?></h2>
	<h3><?php _e('Custom Redirects', 'profilebuilder');?></h3>


	<p>
		Redirects on custom page requests:
	</p>
	
	<table class="redirectTable">
		<thead class="disableLoginAndRegistrationTableHead">
			<tr>
				<th class="manage-column" scope="col"><?php _e('Action', 'profilebuilder');?></th>
				<th class="manage-column" scope="col"><?php _e('Redirect', 'profilebuilder');?></th>
				<th class="manage-column" scope="col"><?php _e('URL', 'profilebuilder');?></th>
			</tr>
		</thead>
		<tr class="redirectTableRow">
			<td class="redirectTableCell1"><?php _e('After Registration:', 'profilebuilder');?></td>
			<td>
				<input type="radio" name="customRedirectSettings[afterRegister]" value="yes" <?php if ($customRedirectSettings['afterRegister'] == 'yes') echo 'checked';?> /><font size="1"><?php _e('Yes', 'profilebuilder');?></font><span style="padding-left:20px"></span>
				<input type="radio" name="customRedirectSettings[afterRegister]" value="no" <?php if ($customRedirectSettings['afterRegister'] == 'no') echo 'checked';?>/><font size="1"><?php _e('No', 'profilebuilder');?></font>
			</td>
			<td class="redirectTableCell2"><input name="customRedirectSettings[afterRegisterTarget]" class="redirectFirstInput" type="text" value="<?php echo $customRedirectSettings['afterRegisterTarget'];?>" /></td>
		</tr>
		<tr class="redirectTableRow">
			<td class="redirectTableCell1"><?php _e('After Login:', 'profilebuilder');?></td>
			<td>
				<input type="radio" name="customRedirectSettings[afterLogin]" value="yes" <?php if ($customRedirectSettings['afterLogin'] == 'yes') echo 'checked';?> /><font size="1"><?php _e('Yes', 'profilebuilder');?></font><span style="padding-left:20px"></span>
				<input type="radio" name="customRedirectSettings[afterLogin]" value="no" <?php if ($customRedirectSettings['afterLogin'] == 'no') echo 'checked';?>/><font size="1"><?php _e('No', 'profilebuilder');?></font>
			</td>
			<td class="redirectTableCell2"><input name="customRedirectSettings[afterLoginTarget]" class="redirectSecondInput" type="text" value="<?php echo $customRedirectSettings['afterLoginTarget'];?>" /></td>
		</tr>
		<tr class="redirectTableRow">
			<td class="redirectTableCell1">
				Recover Password (*)
			</td>
			<td>
				<input type="radio" name="customRedirectSettings[recoverRedirect]" value="yes" <?php if ($customRedirectSettings['recoverRedirect'] == 'yes') echo 'checked';?> /><font size="1"><?php _e('Yes', 'profilebuilder');?></font><span style="padding-left:20px"></span>
				<input type="radio" name="customRedirectSettings[recoverRedirect]" value="no" <?php if ($customRedirectSettings['recoverRedirect'] == 'no') echo 'checked';?>/><font size="1"><?php _e('No', 'profilebuilder');?></font>
			</td>
			<td class="redirectTableCell2">
				<input name="customRedirectSettings[recoverRedirectTarget]" class="redirectThirdInput" type="text" value="<?php echo $customRedirectSettings['recoverRedirectTarget'];?>" />
			</td>
		</tr>
	</table>
	<?php echo '<font size="1" color="grey">(*) '.__('When activated this feature will redirect the user on both the default Wordpress password recovery page and the "Lost password?" link used by Profile Builder on the front-end login page.', 'profilebuilder').' </font>'; ?>
	
	<br/><br/><br/>
	
	<p>
		Redirects on default WordPress page requests:
	</p>
	
	<table class="disableLoginAndRegistrationTable">
		<thead class="disableLoginAndRegistrationTableHead">
			<tr>
				<th class="manage-column" scope="col"><?php _e('Requested WP Page', 'profilebuilder');?></th>
				<th class="manage-column" scope="col"><?php _e('Redirect', 'profilebuilder');?></th>
				<th class="manage-column" scope="col"><?php _e('URL', 'profilebuilder');?></th>
			</tr>
		</thead>
		<tr class="disableLoginAndRegistrationTableRow">
			<td class="disableLoginAndRegistrationTableCell1">
				Default WP Login Page(*)
			</td>
			<td class="disableLoginAndRegistrationTableCell2">
				<input type="radio" name="customRedirectSettings[loginRedirect]" value="yes" <?php if ($customRedirectSettings['loginRedirect'] == 'yes') echo 'checked';?> /><font size="1"><?php _e('Yes', 'profilebuilder');?></font><span style="padding-left:20px"></span>
				<input type="radio" name="customRedirectSettings[loginRedirect]" value="no" <?php if ($customRedirectSettings['loginRedirect'] == 'no') echo 'checked';?>/><font size="1"><?php _e('No', 'profilebuilder');?></font>
			</td>
			<td class="disableLoginAndRegistrationTableCell3">
				<input name="customRedirectSettings[loginRedirectTarget]" class="loginRedirectTarget" type="text" value="<?php echo $customRedirectSettings['loginRedirectTarget'];?>" />
			</td>
		</tr>
		<tr class="disableLoginAndRegistrationTableRow">
			<td class="disableLoginAndRegistrationTableCell1">
				Default WP Logout Page(**)
			</td>
			<td class="disableLoginAndRegistrationTableCell2">
				<input type="radio" name="customRedirectSettings[loginRedirectLogout]" value="yes" <?php if ($customRedirectSettings['loginRedirectLogout'] == 'yes') echo 'checked';?> /><font size="1"><?php _e('Yes', 'profilebuilder');?></font><span style="padding-left:20px"></span>
				<input type="radio" name="customRedirectSettings[loginRedirectLogout]" value="no" <?php if ($customRedirectSettings['loginRedirectLogout'] == 'no') echo 'checked';?>/><font size="1"><?php _e('No', 'profilebuilder');?></font>
			</td>
			<td class="disableLoginAndRegistrationTableCell3">
				<input name="customRedirectSettings[loginRedirectTargetLogout]" class="loginRedirectTarget" type="text" value="<?php echo $customRedirectSettings['loginRedirectTargetLogout'];?>" />
			</td>
		</tr>
		<tr class="disableLoginAndRegistrationTableRow">
			<td class="disableLoginAndRegistrationTableCell1">
				Default WP Register Page
			</td>
			<td class="disableLoginAndRegistrationTableCell2">
				<input type="radio" name="customRedirectSettings[registerRedirect]" value="yes" <?php if ($customRedirectSettings['registerRedirect'] == 'yes') echo 'checked';?> /><font size="1"><?php _e('Yes', 'profilebuilder');?></font><span style="padding-left:20px"></span>
				<input type="radio" name="customRedirectSettings[registerRedirect]" value="no" <?php if ($customRedirectSettings['registerRedirect'] == 'no') echo 'checked';?>/><font size="1"><?php _e('No', 'profilebuilder');?></font>
			</td>
			<td class="disableLoginAndRegistrationTableCell3">
				<input name="customRedirectSettings[registerRedirectTarget]" class="registerRedirectTarget" type="text" value="<?php echo $customRedirectSettings['registerRedirectTarget'];?>" />
			</td>
		</tr>
		<tr class="disableLoginAndRegistrationTableRow">
			<td class="disableLoginAndRegistrationTableCell1">
				Default WP Dashboard (***)
			</td>
			<td class="disableLoginAndRegistrationTableCell2">
				<input type="radio" name="customRedirectSettings[dashboardRedirect]" value="yes" <?php if ($customRedirectSettings['dashboardRedirect'] == 'yes') echo 'checked';?> /><font size="1"><?php _e('Yes', 'profilebuilder');?></font><span style="padding-left:20px"></span>
				<input type="radio" name="customRedirectSettings[dashboardRedirect]" value="no" <?php if ($customRedirectSettings['dashboardRedirect'] == 'no') echo 'checked';?>/><font size="1"><?php _e('No', 'profilebuilder');?></font>
			</td>
			<td class="disableLoginAndRegistrationTableCell3">
				<input name="customRedirectSettings[dashboardRedirectTarget]" class="dashboardRedirectTarget" type="text" value="<?php echo $customRedirectSettings['dashboardRedirectTarget'];?>" />
			</td>
		</tr>
	</table>
	<?php echo '<font size="1" color="grey">(*) '.__('Before login. Works best if used in conjuction with "After logout".', 'profilebuilder').' </font><br/>'; ?>
	<?php echo '<font size="1" color="grey">(**) '.__('After logout. Works best if used in conjuction with "Before logout".', 'profilebuilder').' </font><br/>'; ?>
	<?php echo '<font size="1" color="grey">(***) '.__('Redirects every user-role EXCEPT the ones with administrator privilages (can manage options).', 'profilebuilder').' </font>'; ?>
	
	<div align="right">
		<input type="hidden" name="action" value="update" />
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /> 
		</p>
	</form>
	</div>
	
<?php	
}