<?php
add_action('init', 's2_payment_notification'); function s2_payment_notification()
	{
		if(!empty($_GET['s2_payment_notification'])) // In my URL, I have `?s2_payment_notification=yes`, that's what I'm looking for here.
			{
				if(!empty($_GET['user_id']) && !empty($_GET['item_number'])) // In my URL, I have `&user_id=%%user_id%%&item_number=%%item_number%%`, that's what I'm looking for here.
					{
						$user_id = (integer)$_GET['user_id']; // I'm expecting an integer in this value.
						$item_number = (string)$_GET['item_number']; // I'm expecting a string in this value.
						
						$user = new WP_User($user_id); // Get a WordPress® User object instance so I can work with this customer.
						
						// Here I might perform any number of tasks related to this user. Such as creating a user option value in WordPress.
						update_user_option($user_id, 'my_custom_data_for_this_user', $item_number);
						
						// I could also collect details about this user, by accessing properties of my WP_User object instance.
						$first_name = $user->first_name;
						$last_name = $user->last_name;
						$email = $user->user_email;
						$username = $user->user_login;
						
						// I can also pull s2Member® option values related to this user.
						$s2member_subscr_id = get_user_option('s2member_subscr_id', $user_id);
						$s2member_custom_fields = get_user_option('s2member_custom_fields', $user_id);
						$s2member_custom = get_user_option('s2member_custom', $user_id);
						$s2member_registration_ip = get_user_option('s2member_registration_ip', $user_id);
						$s2member_paid_registration_times = get_user_option('s2member_paid_registration_times', $user_id);
						$s2member_first_payment_txn_id = get_user_option('s2member_first_payment_txn_id', $user_id);
						$s2member_last_payment_time = get_user_option('s2member_last_payment_time', $user_id);
						$s2member_auto_eot_time = get_user_option('s2member_auto_eot_time', $user_id);
						$s2member_file_download_access_log = get_user_option('s2member_file_download_access_log', $user_id);
						
						// I could also log this transaction, by creating a log entry in a static text file on-site.
						file_put_contents(WP_CONTENT_DIR.'/plugins/s2member-logs/my.log', 'Payment Notification Received for User ID: '.$user_id."\n", FILE_APPEND);
					}
				exit; // We can exit here. There's no reason to continue loading WordPress® or my theme during an API Notification.
			}
	}