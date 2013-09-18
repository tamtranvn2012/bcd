<?php
/**
* Shortcode `[s2Member-Pro-ccBill-Button /]` ( inner processing routines ).
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
* @package s2Member\ccBill
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_pro_ccbill_button_in"))
	{
		/**
		* Shortcode `[s2Member-Pro-ccBill-Button /]` ( inner processing routines ).
		*
		* @package s2Member\ccBill
		* @since 1.5
		*/
		class c_ws_plugin__s2member_pro_ccbill_button_in
			{
				/**
				* Shortcode `[s2Member-Pro-ccBill-Button /]`.
				*
				* @package s2Member\ccBill
				* @since 1.5
				*
				* @attaches-to ``add_shortcode("s2Member-Pro-ccBill-Button");``
				*
				* @param array $attr An array of Attributes.
				* @param str $content Content inside the Shortcode.
				* @param str $shortcode The actual Shortcode name itself.
				* @return str The resulting ccBill® Button Code, HTML markup.
				*/
				public static function sc_ccbill_button ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
					{
						c_ws_plugin__s2member_no_cache::no_cache_constants (true); /* No caching on pages that contain this Button. */
						/**/
						$attr = c_ws_plugin__s2member_utils_strings::trim_quot_deep ((array)$attr); /* Force array, and fix &quot; in attrs. */
						/**/
						$attr = shortcode_atts (array ("ids" => "0", "exp" => "72", "level" => "1", "ccaps" => "", "desc" => "", "cc" => "USD", "custom" => $_SERVER["HTTP_HOST"], "ta" => "0", "tp" => "0", "tt" => "D", "ra" => "2.95", "rp" => "1", "rt" => "M", "rr" => "1", "modify" => "0", "cancel" => "0", "sp" => "0", "image" => "default", "output" => "anchor"), $attr);
						/**/
						$attr["tt"] = strtoupper ($attr["tt"]); /* Term lengths absolutely must be provided in upper-case format. Only after running shortcode_atts(). */
						$attr["rt"] = strtoupper ($attr["rt"]); /* Term lengths absolutely must be provided in upper-case format. Only after running shortcode_atts(). */
						$attr["ccaps"] = strtolower ($attr["ccaps"]); /* Custom Capabilities must be typed in lower-case format. Only after running shortcode_atts(). */
						/**/
						if ($attr["rr"] && ($attr["ta"] <= 0 || $attr["tp"] <= 0 || !$attr["tt"])) /* With ccBill®, a Recurring Subscription MUST have an Initial/Trial Period. */
							eval ('$attr["ta"] = $attr["ra"]; $attr["tp"] = $attr["rp"]; $attr["tt"] = $attr["rt"];'); /* In this case, just use the same as Regular values. */
						/**/
						if ($attr["modify"] || $attr["cancel"]) /* This is a special routine for ccBill® Modifications/Cancellations. These are (one in the same). */
							{
								$default_image = $GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images/ccbill-edit-button.png"; /* Default Image. */
								/**/
								$code = trim (file_get_contents (dirname (dirname (dirname (dirname (__FILE__)))) . "/templates/buttons/ccbill-cancellation-button.html"));
								$code = preg_replace ("/%%images%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images")), $code);
								$code = preg_replace ("/%%wpurl%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ())), $code);
								/**/
								$code = $_code = ($attr["image"] && $attr["image"] !== "default") ? preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["image"])) . '"', $code) : preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($default_image)) . '"', $code);
								/**/
								$code = ($attr["output"] === "anchor") ? $code : $code; /* Buttons already anchor format. */
								preg_match ("/ href\=\"(.*?)\"/", $code, $m); /* Grab the full URL from the href attribute. */
								$code = ($attr["output"] === "url") ? preg_replace ("/&amp;/i", "&", $m[1]) : $code;
							}
						/**/
						else if ($attr["sp"]) /* This is a special routine for Specific Post/Page Buttons. Specific Post/Page Buttons use a different template. */
							{
								$default_image = $GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images/ccbill-button.png"; /* Default Image. */
								/**/
								$attr["sp_ids_exp"] = "sp:" . $attr["ids"] . ":" . $attr["exp"]; /* Combined "sp:ids:expiration hours". */
								/**/
								$code = trim (file_get_contents (dirname (dirname (dirname (dirname (__FILE__)))) . "/templates/buttons/ccbill-sp-checkout-button.html"));
								$code = preg_replace ("/%%images%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images")), $code);
								$code = preg_replace ("/%%wpurl%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ())), $code);
								/**/
								$vars = array ("clientAccnum" => $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_client_id"], "clientSubacc" => $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_client_sid"], "formName" => $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_form_name"],/**/
								"formPrice" => $attr["ra"], "formPeriod" => round ($attr["exp"] / 24), "currencyCode" => c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_currency_numr ($attr["cc"]), "s2_desc" => $attr["desc"], "s2_invoice" => $attr["sp_ids_exp"], "s2_custom" => $attr["custom"], "s2_customer_ip" => $_SERVER["REMOTE_ADDR"]);
								/**/
								if ($referencing = c_ws_plugin__s2member_utils_users::get_user_subscr_or_wp_id ()) /* Are we referencing a User/Member in the database? */
									$vars["s2_referencing"] = $referencing; /* Add this into the $vars array. */
								/**/
								$code = preg_replace ("/%%url%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_link_gen ($vars))), $code);
								/**/
								$code = $_code = ($attr["image"] && $attr["image"] !== "default") ? preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["image"])) . '"', $code) : preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($default_image)) . '"', $code);
								/**/
								$code = ($attr["output"] === "anchor") ? $code : $code; /* Buttons already anchor format. */
								$code = ($attr["output"] === "url") ? c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_link_gen ($vars) : $code;
							}
						else /* Otherwise, we'll process this Button normally, using the Membership routines. */
							{
								$default_image = $GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images/ccbill-button.png"; /* Default Image. */
								/**/
								$attr["desc"] = (!$attr["desc"]) ? $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $attr["level"] . "_label"] : $attr["desc"];
								/**/
								$attr["level_ccaps_eotper"] = (!$attr["rr"]) ? $attr["level"] . ":" . $attr["ccaps"] . ":" . $attr["rp"] . " " . $attr["rt"] : $attr["level"] . ":" . $attr["ccaps"];
								$attr["level_ccaps_eotper"] = rtrim ($attr["level_ccaps_eotper"], ":"); /* Clean any trailing separators from this string. */
								/**/
								$code = trim (file_get_contents (dirname (dirname (dirname (dirname (__FILE__)))) . "/templates/buttons/ccbill-checkout-button.html"));
								$code = preg_replace ("/%%images%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images")), $code);
								$code = preg_replace ("/%%wpurl%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ())), $code);
								/**/
								if (!$attr["rr"]) /* This is NOT a Recurring Subscription ( i.e. an Initial/Trial Period is NOT possible ). */
									$vars = array ("clientAccnum" => $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_client_id"], "clientSubacc" => $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_client_sid"], "formName" => $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_form_name"],/**/
									"formPrice" => $attr["ra"], "formPeriod" => c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_per_term_2_days ($attr["rp"], $attr["rt"]), "currencyCode" => c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_currency_numr ($attr["cc"]), "s2_p1" => "0 D", "s2_p3" => $attr["rp"] . " " . $attr["rt"], "s2_desc" => $attr["desc"], "s2_invoice" => $attr["level_ccaps_eotper"], "s2_custom" => $attr["custom"], "s2_customer_ip" => $_SERVER["REMOTE_ADDR"]);
								/**/
								else /* Otherwise, we need to include both an Initial and Regular/Recurring period. This will ALWAYS recur. */
									$vars = array ("clientAccnum" => $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_client_id"], "clientSubacc" => $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_client_sid"], "formName" => $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_ccbill_form_name"],/**/
									"formPrice" => $attr["ta"], "formPeriod" => c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_per_term_2_days ($attr["tp"], $attr["tt"]), "formRecurringPrice" => $attr["ra"], "formRecurringPeriod" => c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_per_term_2_days ($attr["rp"], $attr["rt"]), "formRebills" => "99", "currencyCode" => c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_currency_numr ($attr["cc"]), "s2_p1" => $attr["tp"] . " " . $attr["tt"], "s2_p3" => $attr["rp"] . " " . $attr["rt"], "s2_desc" => $attr["desc"], "s2_invoice" => $attr["level_ccaps_eotper"], "s2_custom" => $attr["custom"], "s2_customer_ip" => $_SERVER["REMOTE_ADDR"]);
								/**/
								if ($referencing = c_ws_plugin__s2member_utils_users::get_user_subscr_or_wp_id ()) /* Are we referencing an account already in the database? */
									$vars["s2_referencing"] = $referencing; /* Add this into the $vars array. */
								/**/
								$code = preg_replace ("/%%url%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_link_gen ($vars))), $code);
								/**/
								$code = $_code = ($attr["image"] && $attr["image"] !== "default") ? preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["image"])) . '"', $code) : preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($default_image)) . '"', $code);
								/**/
								$code = ($attr["output"] === "anchor") ? $code : $code; /* Buttons already anchor format. */
								$code = ($attr["output"] === "url") ? c_ws_plugin__s2member_pro_ccbill_utilities::ccbill_link_gen ($vars) : $code;
							}
						/**/
						return $code;
					}
			}
	}
?>