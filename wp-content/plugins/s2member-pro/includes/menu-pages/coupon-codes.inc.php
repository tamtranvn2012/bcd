<?php
/**
* Menu page for s2Member Pro ( Coupon Codes page ).
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
* @package s2Member\Menu_Pages
* @since 1.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_pro_menu_page_coupon_codes"))
	{
		/**
		* Menu page for s2Member Pro ( Coupon Codes page ).
		*
		* @package s2Member\Menu_Pages
		* @since 110531
		*/
		class c_ws_plugin__s2member_pro_menu_page_coupon_codes
			{
				public function __construct ()
					{
						echo '<div class="wrap ws-menu-page">' . "\n";
						/**/
						echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
						echo '<h2>s2Member® Pro Form ( Coupon Codes )</h2>' . "\n";
						/**/
						echo '<table class="ws-menu-page-table">' . "\n";
						echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
						echo '<tr class="ws-menu-page-table-tr">' . "\n";
						echo '<td class="ws-menu-page-table-l">' . "\n";
						/**/
						echo '<form method="post" name="ws_plugin__s2member_pro_options_form" id="ws-plugin--s2member-pro-options-form">' . "\n";
						echo '<input type="hidden" name="ws_plugin__s2member_options_save" id="ws-plugin--s2member-options-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-options-save")) . '" />' . "\n";
						/**/
						echo '<div class="ws-menu-page-group" title="( Pro Form ) Coupon Code Configuration" default-state="open">' . "\n";
						/**/
						echo '<div class="ws-menu-page-section ws-plugin--s2member-pro-coupon-codes-section">' . "\n";
						echo '<h3>Coupon Code Configuration File ( optional, to provide discounts )</h3>' . "\n";
						echo '<p>Currently, this is ONLY compatible with "Pro Forms for PayPal® &amp; Authorize.Net®", which are enabled by the s2Member Pro Module. Coupon Codes allow you to provide discounts ( through a special promotion ). A Customer may enter a Coupon Code at checkout, and depending on the Code they enter, a discount may be applied. Coupon Codes can be configured to provide a flat-rate discount, or a percentage-based discount. You can have an unlimited number of Coupon Codes. You can also force Coupon Codes to automatically expire on a particular date in the future.</p>' . "\n";
						echo '<p>In order to display a "Coupon Code" field on your Checkout Form, you MUST add this special Shortcode attribute: <code>accept_coupons="1"</code>. If you would like to force-feed a default Coupon Code ( optional ), you can add this special Shortcode attribute as well: <code>coupon="[your default code]"</code>. Or, you could also pass <code>?s2p-coupon=[your default code]</code> in the query string of a URL leading to a Checkout Form.</p>' . "\n";
						/**/
						echo '<table class="form-table">' . "\n";
						echo '<tbody>' . "\n";
						echo '<tr>' . "\n";
						/**/
						echo '<td>' . "\n";
						/**/
						echo '<textarea name="ws_plugin__s2member_pro_coupon_codes" id="ws-plugin--s2member-pro-coupon-codes" rows="10" wrap="off" spellcheck="false" style="width:99%;">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_coupon_codes"]) . '</textarea><br />' . "\n";
						/**/
						echo 'One Coupon Code per line please, using a pipe ( <code>|</code> ) delimitation.' . "\n";
						/**/
						echo '<div class="ws-menu-page-hr"></div>' . "\n";
						/**/
						echo 'Here are a few Coupon Code examples that you can follow:<br />' . "\n";
						/**/
						echo '<ul>' . "\n"; /* Explaining this by example. */
						echo '<li><code>SAVE-10|10%</code> ( Saves the Customer 10% )</li>' . "\n";
						echo '<li><code>SAVE-20|20%</code> ( Saves the Customer 20% )</li>' . "\n";
						echo '<li><code>2$OFF|2.00</code> ( $2.00 off the normal price )</li>' . "\n";
						echo '<li><code>EASTER|5.00</code> ( $5.00 off the normal price )</li>' . "\n";
						echo '<li><code>CHRISTMAS|5.00|12/31/2020</code> ( $5.00 off, expires Dec 31st, 2020 )</li>' . "\n";
						echo '<li><code>CHRISTMAS-25|25%|01/01/2021</code> ( 25% off, expires Jan 1st, 2021 )</li>' . "\n";
						echo '<li><code>100%OFF|100%</code> ( the final Regular Billing Rate would still be <strong>$0.01</strong> )</li>' . "\n";
						echo '</ul>' . "\n";
						/**/
						echo '<em>* s2Member will NEVER allow the Regular Billing Rate ( or Total ) to be less than: <strong>$0.01</strong>.<br />' . "\n";
						echo 'If you want to offer something 100% free, please use a Free Registration Form instead.<br />';
						echo 'Either that, or you can offer a Free Trial Period in your Shortcode.</em>' . "\n";
						/**/
						echo '<div class="ws-menu-page-hr"></div>' . "\n";
						/**/
						echo '<em>By default, s2Member will apply the discount to ALL amounts, including any Regular/Recurring fees.<br />' . "\n";
						echo '* However, you may configure Coupon Codes that will ONLY apply to (ta) Trial Amounts, or (ra) Regular Amounts.</em>' . "\n";
						/**/
						echo '<ul>' . "\n"; /* Explaining this by example. */
						echo '<li><code>SAVE-10|10%||ta-only</code> ( 10% off an Initial/Trial Amount. The ta="" attribute in your Shortcode. )</li>' . "\n";
						echo '<li><code>SAVE-15|15%||ra-only</code> ( 15% off the Regular Amount(s). The ra="" attribute in your Shortcode. )</li>' . "\n";
						echo '<li><code>XMAS|5.00|12/31/2021|ra-only</code> ( $5 off Regular Amount(s). The ra="" attribute in your Shortcode. )</li>' . "\n";
						echo '<li><code>5PER|5%|12/31/2021|all</code> ( 5% off All Amounts. This is the default behavior "all". )</li>' . "\n";
						echo '</ul>' . "\n";
						/**/
						echo '<em>* As noted above, s2Member will NEVER allow the (ra) Regular Amount to be less than: <strong>$0.01</strong>.<br />' . "\n";
						echo 'However, s2Member WILL allow the (ta) Trial Amount to be discounted all the way down to <strong>$0.00</strong>.</em>' . "\n";
						/**/
						echo '</td>' . "\n";
						/**/
						echo '</tr>' . "\n";
						echo '</tbody>' . "\n";
						echo '</table>' . "\n";
						echo '</div>' . "\n";
						/**/
						echo '</div>' . "\n";
						/**/
						echo '<div class="ws-menu-page-hr"></div>' . "\n";
						/**/
						echo '<p class="submit"><input type="submit" class="button-primary" value="Save All Changes" /></p>' . "\n";
						/**/
						echo '</form>' . "\n";
						/**/
						echo '</td>' . "\n";
						/**/
						echo '<td class="ws-menu-page-table-r">' . "\n";
						c_ws_plugin__s2member_menu_pages_rs::display ();
						echo '</td>' . "\n";
						/**/
						echo '</tr>' . "\n";
						echo '</tbody>' . "\n";
						echo '</table>' . "\n";
						/**/
						echo '</div>' . "\n";
					}
			}
	}
/**/
new c_ws_plugin__s2member_pro_menu_page_coupon_codes ();
?>