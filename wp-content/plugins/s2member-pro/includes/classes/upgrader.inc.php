<?php
/**
* s2Member Pro upgrader.
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
* @package s2Member\Upgrader
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_pro_upgrader"))
	{
		/**
		* s2Member Pro upgrader.
		*
		* @package s2Member\Upgrader
		* @since 1.5
		*/
		class c_ws_plugin__s2member_pro_upgrader
			{
				/**
				* Upgrade wizard.
				*
				* @package s2Member\Upgrader
				* @since 1.5
				*
				* @return str Upgrade wizard, HTML markup.
				*/
				public static function wizard ()
					{
						$_p = !empty ($_POST) ? c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST)) : array ();
						$error = isset ($GLOBALS["ws_plugin__s2member_pro_upgrade_error"]) ? $GLOBALS["ws_plugin__s2member_pro_upgrade_error"] : "";
						$stored = get_transient (md5 ("ws_plugin__s2member_pro_upgrade_credentials"));
						/**/
						$username = !empty ($_p["ws_plugin__s2member_pro_upgrade_username"]) ? $_p["ws_plugin__s2member_pro_upgrade_username"] : "";
						$username = (!$username && !empty ($stored["username"])) ? $stored["username"] : $username;
						$username = (!$username) ? "Username" : $username;
						/**/
						$password = !empty ($_p["ws_plugin__s2member_pro_upgrade_password"]) ? $_p["ws_plugin__s2member_pro_upgrade_password"] : "";
						$password = (!$password && !empty ($stored["password"])) ? $stored["password"] : $password;
						$password = (!$password) ? "Password" : $password;
						/**/
						$upgradew = '<form method="post" style="margin: 5px 0 5px 0;" onsubmit="jQuery (\'input#ws-plugin--s2member-pro-upgrade-submit\', this).attr (\'disabled\', \'disabled\').val (\'Upgrading... ( please wait )\');">';
						$upgradew .= '<input type="hidden" name="ws_plugin__s2member_pro_upgrade" id="ws-plugin--s2member-pro-upgrade" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-pro-upgrade")) . '" />';
						/**/
						$upgradew .= apply_filters ("ws_plugin__s2member_pro_upgrade_wizard_instructions", '<p><strong>Or upgrade automatically. Provide your login details for s2Member.com</strong>.</p>', get_defined_vars ());
						/**/
						$upgradew .= '<input type="text" name="ws_plugin__s2member_pro_upgrade_username" id="ws-plugin--s2member-pro-upgrade-username" value="' . format_to_edit ($username) . '"' . ( ($username === "Username") ? ' style="color:#999999;"' : '') . ' onfocus="if(this.value === \'Username\'){ this.value = \'\'; } this.style.color = \'\';" onblur="if(!this.value){ this.value = \'Username\'; this.style.color = \'#999999\'; }" />';
						$upgradew .= '<input type="' . esc_attr (( ($password === "Password") ? "text" : "password")) . '" name="ws_plugin__s2member_pro_upgrade_password" id="ws-plugin--s2member-pro-upgrade-password" value="' . format_to_edit ($password) . '"' . ( ($password === "Password") ? ' style="color:#999999;"' : '') . ' onfocus="if(this.value === \'Password\'){ this.value = \'\'; } this.style.color = \'\'; this.type = \'Password\';" onblur="if(!this.value){ this.value = \'Password\'; this.style.color = \'#999999\'; this.type = \'text\'; }" />';
						$upgradew .= '<input type="submit" id="ws-plugin--s2member-pro-upgrade-submit" value="Upgrade s2Member Pro Automatically" />';
						/**/
						$upgradew .= ($error) ? '<p><em>' . $error . '</em></p>' : '';
						/**/
						$upgradew .= '</form>';
						/**/
						return $upgradew;
					}
				/**
				* Upgrade processor.
				*
				* @package s2Member\Upgrader
				* @since 1.5
				*
				* @attaches-to ``add_action("admin_init");``
				*
				* @return null
				*/
				public static function upgrade () /* Pro Upgrader. */
					{
						global $wp_filesystem; /* Need this global object reference. */
						/**/
						if (!empty ($_POST["ws_plugin__s2member_pro_upgrade"]) && ($nonce = $_POST["ws_plugin__s2member_pro_upgrade"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-pro-upgrade") && ($_p = c_ws_plugin__s2member_utils_strings::trim_deep (stripslashes_deep ($_POST))))
							{
								if (@set_time_limit (0) !== "nill" && ((int)@ini_get ("memory_limit") >= 256 || @ini_set ("memory_limit", "256M") !== "nill") && (int)@ini_get ("memory_limit") >= 256) /* Ot oh! We have insufficient memory? */
									{
										if (!empty ($_p["ws_plugin__s2member_pro_upgrade_username"]) && !empty ($_p["ws_plugin__s2member_pro_upgrade_password"]) && is_array ($cs_s2member_pro_upgrade = maybe_unserialize (c_ws_plugin__s2member_utils_urls::remote ("http://www.s2member.com/?cs_s2member_pro_upgrade[username]=" . urlencode ($_p["ws_plugin__s2member_pro_upgrade_username"]) . "&cs_s2member_pro_upgrade[password]=" . urlencode ($_p["ws_plugin__s2member_pro_upgrade_password"]) . "&cs_s2member_pro_upgrade[version]=" . urlencode (WS_PLUGIN__S2MEMBER_PRO_VERSION)))) && !empty ($cs_s2member_pro_upgrade["zip"]) && !empty ($cs_s2member_pro_upgrade["ver"]))
											{
												set_transient (md5 ("ws_plugin__s2member_pro_upgrade_credentials"), array ("username" => $_p["ws_plugin__s2member_pro_upgrade_username"], "password" => $_p["ws_plugin__s2member_pro_upgrade_password"]), 5184000);
												/**/
												c_ws_plugin__s2member_pro_upgrader::maintenance (true); /* Create the .maintenance file now. We don't want anything loading up on the site during this process. WordPress® will NOT load when this file exists. */
												/**/
												if (WP_Filesystem (array (), ($plugins_dir = dirname (dirname (dirname (dirname (__FILE__)))))) && ($plugin_dir = dirname (dirname (dirname (__FILE__))))) /* These are important directories. */
													{
														if ($wp_filesystem->put_contents (($tmp_zip = wp_tempnam (basename ($plugin_dir) . ".zip", trailingslashit ($plugins_dir))), c_ws_plugin__s2member_utils_urls::remote ($cs_s2member_pro_upgrade["zip"]), FS_CHMOD_FILE))
															{
																if ((!is_dir ($plugin_dir . "-new") || $wp_filesystem->delete ($plugin_dir . "-new", true)) && $wp_filesystem->mkdir ($plugin_dir . "-new"))
																	{
																		if (!is_wp_error (unzip_file ($tmp_zip, $plugin_dir . "-new"))) /* Unzip into the /s2member-pro-new plugin dir. */
																			{
																				if (!is_dir ($plugin_dir) || $wp_filesystem->delete ($plugin_dir, true)) /* Point of no return. */
																					{
																						if ($wp_filesystem->move ($plugin_dir . "-new/s2member-pro", $plugin_dir)) /* All set? */
																							{
																								$wp_filesystem->delete ($plugin_dir . "-new", true) . $wp_filesystem->delete ($tmp_zip);
																								/**/
																								$notice = 's2Member Pro successfully updated to v' . esc_html ($cs_s2member_pro_upgrade["ver"]) . '.';
																								/**/
																								do_action ("ws_plugin__s2member_pro_during_successfull_upgrade", get_defined_vars ()); /* Hooks/Filters. */
																								/**/
																								c_ws_plugin__s2member_admin_notices::enqueue_admin_notice ($notice, "blog|network:*"); /* Via s2Member Framework. */
																								c_ws_plugin__s2member_pro_upgrader::maintenance (false); /* Remove the .maintenance file now. Allow access again. */
																								/**/
																								wp_redirect (self_admin_url ("/plugins.php"));
																								/**/
																								exit (); /* Clean exit. */
																							}
																						else /* Bummer. OK, now we'll deal with cleanup & error reporting. */
																							{
																								$wp_filesystem->delete ($plugin_dir . "-new", true) . $wp_filesystem->delete ($tmp_zip);
																								/**/
																								$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Critical upgrade failure. Error #0009. Please upgrade via FTP.";
																							}
																					}
																				else /* Bummer. OK, now we'll deal with cleanup & error reporting. */
																					{
																						$wp_filesystem->delete ($plugin_dir . "-new", true) . $wp_filesystem->delete ($tmp_zip);
																						/**/
																						$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Automatic upgrade failed. Error #0008. Please upgrade via FTP.";
																					}
																			}
																		else /* Bummer. OK, now we'll deal with cleanup & error reporting. */
																			{
																				$wp_filesystem->delete ($plugin_dir . "-new", true) . $wp_filesystem->delete ($tmp_zip);
																				/**/
																				$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Automatic upgrade failed. Error #0007. Please upgrade via FTP.";
																			}
																	}
																else /* Bummer. OK, now we'll deal with cleanup & error reporting. */
																	{
																		$wp_filesystem->delete ($plugin_dir . "-new", true) . $wp_filesystem->delete ($tmp_zip);
																		/**/
																		$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Automatic upgrade failed. Error #0006. Please upgrade via FTP.";
																	}
															}
														else /* Bummer. OK, now we'll deal with cleanup & error reporting. */
															{
																$wp_filesystem->delete ($plugin_dir . "-new", true) . $wp_filesystem->delete ($tmp_zip);
																/**/
																$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Automatic upgrade failed. Error #0005. Please upgrade via FTP.";
															}
													}
												else /* Bummer. OK, now deal with error reporting ( no cleanup ). */
													{
														$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Automatic upgrade failed. Error #0004. Please upgrade via FTP.";
													}
												/* Remove .maintenance file. Note: remember to remove this after upgrade success too; before exiting ( above ). */
												c_ws_plugin__s2member_pro_upgrader::maintenance (false); /* Remove the .maintenance file now. Allow access again. */
											}
										else if ($cs_s2member_pro_upgrade === "503 Service Unavailable") /* In this case: service is intentionally unavailable. */
											{
												$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Upgrade failed. Service currently unavailable. Please upgrade via FTP.";
											}
										else if ($cs_s2member_pro_upgrade === "403 Forbidden") /* Service unable to authenticate download via user/pass. */
											{
												$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Upgrade failed. Invalid Username/Password ( please try again ).";
											}
										else /* Else, display the default error ( server unavailable ). This happens due to connectivity issues. */
											{
												$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Upgrade failed. Connection failed ( please try again ).";
											}
									}
								else /* Insufficient memory. This error requires special attention. Unzipping large files requires memory. */
									{
										$GLOBALS["ws_plugin__s2member_pro_upgrade_error"] = "Not enough memory. " . /* Not enough memory. */
										"Unzipping s2Member Pro via WordPress® requires 256MB of RAM. Please upgrade via FTP instead.</code>.";
									}
							}
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Maintenance mode.
				*
				* @package s2Member\Upgrader
				* @since 1.5
				*
				* @param bool $enable If true, enable maintenance mode. If false, disable maintenance mode.
				* @return null
				*/
				public static function maintenance ($enable = NULL)
					{
						global $wp_filesystem; /* Need this global object reference. */
						/**/
						if (apply_filters ("ws_plugin__s2member_pro_upgrade_maintenance", ($_SERVER["HTTP_HOST"] !== "www.s2member.com"), get_defined_vars ()))
							{
								if ($enable === true && WP_Filesystem (array (), ABSPATH) && ($maintenance = $wp_filesystem->abspath () . ".maintenance"))
									$wp_filesystem->delete ($maintenance) . $wp_filesystem->put_contents ($maintenance, '<?php $upgrading = ' . time () . '; ?>', FS_CHMOD_FILE);
								/**/
								else if ($enable === false && WP_Filesystem (array (), ABSPATH) && ($maintenance = $wp_filesystem->abspath () . ".maintenance"))
									$wp_filesystem->delete ($maintenance);
							}
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>