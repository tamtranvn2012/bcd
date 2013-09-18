<?php
/**
* s2Member Pro Remote Operations API ( inner processing routines ).
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* This WordPress® plugin ( s2Member Pro ) is comprised of two parts:
*
* o (1) Its PHP code is licensed under the GPL license, as is WordPress®.
* 	You should have received a copy of the GNU General Public License,
* 	along with this software. In the main directory, see: /licensing/
* 	If not, see: {@link http://www.gnu.org/licenses/}.
*
* o (2) All other parts of ( s2Member Pro ); including, but not limited to:
* 	the CSS code, some JavaScript code, images, and design;
* 	are licensed according to the license purchased.
* 	See: {@link http://www.s2member.com/prices/}
*
* Unless you have our prior written consent, you must NOT directly or indirectly license,
* sub-license, sell, resell, or provide for free; part (2) of the s2Member Pro Module;
* or make an offer to do any of these things. All of these things are strictly
* prohibited with part (2) of the s2Member Pro Module.
*
* Your purchase of s2Member Pro includes free lifetime upgrades via s2Member.com
* ( i.e. new features, bug fixes, updates, improvements ); along with full access
* to our video tutorial library: {@link http://www.s2member.com/videos/}
*
* @package s2Member\API_Remote_Ops
* @since 110713
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_pro_remote_ops_in"))
	{
		/**
		* s2Member Pro Remote Operations API ( inner processing routines ).
		*
		* @package s2Member\API_Remote_Ops
		* @since 110713
		*/
		class c_ws_plugin__s2member_pro_remote_ops_in
			{
				/**
				* Creates a new User.
				*
				* @package s2Member\API_Remote_Ops
				* @since 110713
				*
				* @param array An input array of Remote Operation parameters.
				* @return str Returns a serialized ``WP_User()`` object on success,
				* 	else returns a string beginning with `Error:` on failure;
				* 	which will include details regarding the error.
				*/
				public static function create_user ($op = FALSE)
					{
						if (!empty ($op["op"]) && $op["op"] === "create_user" && !empty ($op["data"]) && is_array ($op["data"]))
							{
								$GLOBALS["ws_plugin__s2member_registration_vars"] = array (); /* Vars. */
								$vars = &$GLOBALS["ws_plugin__s2member_registration_vars"]; /* Reference. */
								/**/
								$vars["ws_plugin__s2member_custom_reg_field_user_login"] = $op["data"]["user_login"];
								$vars["ws_plugin__s2member_custom_reg_field_user_email"] = $op["data"]["user_email"];
								/**/
								$GLOBALS["ws_plugin__s2member_generate_password_return"] = $op["data"]["user_pass"];
								$op["data"]["user_pass"] = wp_generate_password (); /* Now generate the Password. */
								/**/
								$vars["ws_plugin__s2member_custom_reg_field_first_name"] = $op["data"]["first_name"];
								$vars["ws_plugin__s2member_custom_reg_field_last_name"] = $op["data"]["last_name"];
								/**/
								$vars["ws_plugin__s2member_custom_reg_field_s2member_level"] = $op["data"]["s2member_level"];
								$vars["ws_plugin__s2member_custom_reg_field_s2member_ccaps"] = $op["data"]["s2member_ccaps"];
								/**/
								$vars["ws_plugin__s2member_custom_reg_field_s2member_registration_ip"] = $op["data"]["s2member_registration_ip"];
								/**/
								$vars["ws_plugin__s2member_custom_reg_field_s2member_subscr_gateway"] = $op["data"]["s2member_subscr_gateway"];
								$vars["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"] = $op["data"]["s2member_subscr_id"];
								$vars["ws_plugin__s2member_custom_reg_field_s2member_custom"] = $op["data"]["s2member_custom"];
								/**/
								$vars["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"] = $op["data"]["s2member_auto_eot_time"];
								/**/
								$vars["ws_plugin__s2member_custom_reg_field_s2member_notes"] = $op["data"]["s2member_notes"];
								/**/
								$vars["ws_plugin__s2member_custom_reg_field_opt_in"] = $op["data"]["opt_in"];
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
									foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
										{
											$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
											$field_id_class = preg_replace ("/_/", "-", $field_var);
											/**/
											if (isset ($op["data"]["custom_fields"][$field_var]))
												$vars["ws_plugin__s2member_custom_reg_field_" . $field_var] = $op["data"]["custom_fields"][$field_var];
										}
								/**/
								$create_user["user_login"] = $op["data"]["user_login"]; /* Copy this into a separate array for `wp_create_user()`. */
								$create_user["user_pass"] = $op["data"]["user_pass"]; /* Copy this into a separate array for `wp_create_user()`. */
								$create_user["user_email"] = $op["data"]["user_email"]; /* Copy this into a separate array for `wp_create_user()`. */
								/**/
								if (((is_multisite () && ($new_user = c_ws_plugin__s2member_registrations::ms_create_existing_user ($create_user["user_login"], $create_user["user_email"], $create_user["user_pass"]))) || ($new_user = wp_create_user ($create_user["user_login"], $create_user["user_pass"], $create_user["user_email"]))) && !is_wp_error ($new_user))
									{
										if (is_object ($user = new WP_User ($new_user)) && ($user_id = $user->ID))
											{
												($op["data"]["notification"]) ? wp_new_user_notification ($user_id, $op["data"]["user_pass"]) : null;
												return serialize (array ("ID" => $user_id)); /* Return serialized array with User info. */
											}
										else /* Else the creation of the User account may have failed. */
											return "Error: Creation may have failed. Unable to obtain WP_User.";
									}
								else if (is_wp_error ($new_user) && $new_user->get_error_code ()) /* Error? */
									return "Error: " . $new_user->get_error_message (); /* Return message. */
								/**/
								else /* Else we really don't know why creation failed. Return generic error. */
									return "Error: User creation failed for an unknown reason. Please try again.";
							}
						else /* Empty request, or calling upon wrong Remote Op. */
							return "Error: Empty or invalid request ( `create_user` ). Please try again.";
					}
				/**
				* Modifies an existing User.
				*
				* @package s2Member\API_Remote_Ops
				* @since 110713
				*
				* @param array An input array of Remote Operation parameters.
				* @return str Returns a serialized ``WP_User()`` object on success,
				* 	else returns a string beginning with `Error:` on failure;
				* 	which will include details regarding the error.
				*/
				public static function modify_user ($op = FALSE)
					{
						if (!empty ($op["op"]) && $op["op"] === "modify_user" && !empty ($op["data"]) && is_array ($op["data"]))
							{
								return "Error: Empty or invalid request ( `modify_user` ). Please try again.";
							}
						else /* Empty request, or calling upon wrong Remote Op. */
							return "Error: Empty or invalid request ( `modify_user` ). Please try again.";
					}
				/**
				* Deletes an existing User.
				*
				* @package s2Member\API_Remote_Ops
				* @since 110713
				*
				* @param array An input array of Remote Operation parameters.
				* @return str Returns a serialized ``WP_User()`` object on success,
				* 	else returns a string beginning with `Error:` on failure;
				* 	which will include details regarding the error.
				*/
				public static function delete_user ($op = FALSE)
					{
						if (!empty ($op["op"]) && $op["op"] === "delete_user" && !empty ($op["data"]) && is_array ($op["data"]))
							{
								return "Error: Empty or invalid request ( `delete_user` ). Please try again.";
							}
						else /* Empty request, or calling upon wrong Remote Op. */
							return "Error: Empty or invalid request ( `delete_user` ). Please try again.";
					}
			}
	}
?>