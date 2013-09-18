<?php
/**
* Shortcode `[s2Member-Pro-ClickBank-Button /]` ( inner processing routines ).
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
* @package s2Member\ClickBank
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_pro_clickbank_button_in"))
	{
		/**
		* Shortcode `[s2Member-Pro-ClickBank-Button /]` ( inner processing routines ).
		*
		* @package s2Member\ClickBank
		* @since 1.5
		*/
		class c_ws_plugin__s2member_pro_clickbank_button_in
			{
				/**
				* Shortcode `[s2Member-Pro-ClickBank-Button /]`.
				*
				* @package s2Member\ClickBank
				* @since 1.5
				*
				* @attaches-to ``add_shortcode("s2Member-Pro-ClickBank-Button");``
				*
				* @param array $attr An array of Attributes.
				* @param str $content Content inside the Shortcode.
				* @param str $shortcode The actual Shortcode name itself.
				* @return str The resulting ClickBank® Button Code, HTML markup.
				*/
				public static function sc_clickbank_button ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
					{
						c_ws_plugin__s2member_no_cache::no_cache_constants (true); /* No caching on pages that contain this Button. */
						/**/
						$attr = c_ws_plugin__s2member_utils_strings::trim_quot_deep ((array)$attr); /* Force array, and fix &quot; in attrs. */
						/**/
						$attr = shortcode_atts (array ("cbp" => "0", "ids" => "0", "exp" => "72", "level" => "1", "ccaps" => "", "desc" => "", "custom" => $_SERVER["HTTP_HOST"], "tp" => "0", "tt" => "D", "rp" => "1", "rt" => "M", "rr" => "1", "modify" => "0", "cancel" => "0", "sp" => "0", "image" => "default", "output" => "anchor"), $attr);
						/**/
						$attr["tt"] = strtoupper ($attr["tt"]); /* Term lengths absolutely must be provided in upper-case format. Only after running shortcode_atts(). */
						$attr["rt"] = strtoupper ($attr["rt"]); /* Term lengths absolutely must be provided in upper-case format. Only after running shortcode_atts(). */
						$attr["ccaps"] = strtolower ($attr["ccaps"]); /* Custom Capabilities must be typed in lower-case format. Only after running shortcode_atts(). */
						$attr["rr"] = ($attr["rt"] === "L") ? "0" : $attr["rr"]; /* Lifetime Subscriptions do NOT recur. Only after running shortcode_atts(). */
						/**/
						if ($attr["modify"] || $attr["cancel"]) /* This is a special routine for ClickBank® Modifications/Cancellations. These are (one in the same). */
							{
								$default_image = $GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images/clickbank-edit-button.png"; /* Default Image. */
								/**/
								$code = trim (file_get_contents (dirname (dirname (dirname (dirname (__FILE__)))) . "/templates/buttons/clickbank-cancellation-button.html"));
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
								$default_image = $GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images/clickbank-button.png"; /* Default Image. */
								/**/
								$attr["sp_ids_exp"] = "sp:" . $attr["ids"] . ":" . $attr["exp"]; /* Combined "sp:ids:expiration hours". */
								/**/
								$code = trim (file_get_contents (dirname (dirname (dirname (dirname (__FILE__)))) . "/templates/buttons/clickbank-sp-checkout-button.html"));
								$code = preg_replace ("/%%images%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images")), $code);
								$code = preg_replace ("/%%wpurl%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ())), $code);
								/**/
								$code = preg_replace ("/%%item%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["cbp"])), $code);
								$code = preg_replace ("/%%vendor%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_clickbank_username"])), $code);
								$code = preg_replace ("/%%invoice%%/", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($attr["sp_ids_exp"])), $code);
								$code = preg_replace ("/%%desc%%/", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($attr["desc"])), $code);
								$code = preg_replace ("/%%custom%%/", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($attr["custom"])), $code);
								/**/
								$code = preg_replace ("/\<\?php echo S2MEMBER_CURRENT_USER_IP; \?\>/", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($_SERVER["REMOTE_ADDR"])), $code);
								/**/
								$code = preg_replace ("/%%referencing%%/", (($referencing = c_ws_plugin__s2member_utils_users::get_user_subscr_or_wp_id ()) ? c_ws_plugin__s2member_utils_strings::esc_ds ("&amp;s2_referencing=" . urlencode ($referencing)) : ""), $code);
								/**/
								$code = $_code = ($attr["image"] && $attr["image"] !== "default") ? preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["image"])) . '"', $code) : preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($default_image)) . '"', $code);
								/**/
								$code = ($attr["output"] === "anchor") ? $code : $code; /* Buttons already anchor format. */
								preg_match ("/ href\=\"(.*?)\"/", $code, $m); /* Grab the full URL from the href attribute. */
								$code = ($attr["output"] === "url") ? preg_replace ("/&amp;/i", "&", $m[1]) : $code;
							}
						else /* Otherwise, we'll process this Button normally, using the Membership routines. */
							{
								$default_image = $GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images/clickbank-button.png"; /* Default Image. */
								/**/
								$attr["level_ccaps_eotper"] = (!$attr["rr"] && $attr["rt"] !== "L") ? $attr["level"] . ":" . $attr["ccaps"] . ":" . $attr["rp"] . " " . $attr["rt"] : $attr["level"] . ":" . $attr["ccaps"];
								$attr["level_ccaps_eotper"] = rtrim ($attr["level_ccaps_eotper"], ":"); /* Clean any trailing separators from this string. */
								/**/
								$code = trim (file_get_contents (dirname (dirname (dirname (dirname (__FILE__)))) . "/templates/buttons/clickbank-checkout-button.html"));
								$code = preg_replace ("/%%images%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member_pro"]["c"]["dir_url"] . "/images")), $code);
								$code = preg_replace ("/%%wpurl%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr (site_url ())), $code);
								/**/
								$code = preg_replace ("/%%item%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["cbp"])), $code);
								$code = preg_replace ("/%%vendor%%/", c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_clickbank_username"])), $code);
								$code = preg_replace ("/%%invoice%%/", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($attr["level_ccaps_eotper"])), $code);
								$code = preg_replace ("/%%desc%%/", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($attr["desc"])), $code);
								$code = preg_replace ("/%%p1%%/", (($attr["rr"]) ? c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($attr["tp"] . " " . $attr["tt"])) : ""), $code);
								$code = preg_replace ("/%%p3%%/", (($attr["rr"]) ? c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($attr["rp"] . " " . $attr["rt"])) : ""), $code);
								$code = preg_replace ("/%%custom%%/", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($attr["custom"])), $code);
								/**/
								$code = (!$attr["rr"]) ? /* Remove `&amp;s2_subscr_id=s2-<?php echo uniqid(); ?>` if NOT recurring. */
								preg_replace ("/&amp;s2_subscr_id\=s2-\<\?php echo uniqid\(\); \?\>/", "", $code) : /* ~ NOT recurring. */
								preg_replace ("/\<\?php echo uniqid\(\); \?\>/", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (uniqid ())), $code);
								/**/
								$code = preg_replace ("/\<\?php echo S2MEMBER_CURRENT_USER_IP; \?\>/", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($_SERVER["REMOTE_ADDR"])), $code);
								/**/
								$code = preg_replace ("/%%referencing%%/", (($referencing = c_ws_plugin__s2member_utils_users::get_user_subscr_or_wp_id ()) ? c_ws_plugin__s2member_utils_strings::esc_ds ("&amp;s2_referencing=" . urlencode ($referencing)) : ""), $code);
								/**/
								$code = $_code = ($attr["image"] && $attr["image"] !== "default") ? preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($attr["image"])) . '"', $code) : preg_replace ('/ src\="(.*?)"/', ' src="' . c_ws_plugin__s2member_utils_strings::esc_ds (esc_attr ($default_image)) . '"', $code);
								/**/
								$code = ($attr["output"] === "anchor") ? $code : $code; /* Buttons already anchor format. */
								preg_match ("/ href\=\"(.*?)\"/", $code, $m); /* Grab the full URL from the href attribute. */
								$code = ($attr["output"] === "url") ? preg_replace ("/&amp;/i", "&", $m[1]) : $code;
							}
						/**/
						return $code;
					}
			}
	}
?>