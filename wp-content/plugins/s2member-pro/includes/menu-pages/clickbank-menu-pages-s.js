/**
* Core JavaScript routines for ClickBank® menu pages.
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
/*
These routines are all specific to this software.
*/
jQuery(document).ready (function($)
	{
		var esc_attr = esc_html = function(str) /* Convert special characters. */
			{
				return String(str).replace (/"/g, '&quot;').replace (/\</g, '&lt;').replace (/\>/g, '&gt;');
			};
		/**/
		if (location.href.match (/page\=ws-plugin--s2member-pro-clickbank-ops/))
			{
				$('select#ws-plugin--s2member-auto-eot-system-enabled').change (function()
					{
						var $this = $(this), val = $this.val ();
						var $viaCron = $('p#ws-plugin--s2member-auto-eot-system-enabled-via-cron');
						/**/
						if (val == 2) /* Display Cron instructions. */
							$viaCron.show ()
						else /* Hide instructions. */
							$viaCron.hide ();
					});
			}
		/**/
		else if (location.href.match (/page\=ws-plugin--s2member-pro-clickbank-buttons/))
			{
				$('div.ws-menu-page select[id]').filter (function() /* Filter all select elements with an id. */
					{
						return this.id.match (/^ws-plugin--s2member-pro-level[1-9][0-9]*-type$/);
					}).change (function()
					{
						var button = this.id.replace (/^ws-plugin--s2member-pro-(.+?)-type$/g, '$1');
						/**/
						var termDisabled = ($(this).val () === 'recurring') ? true : false;
						var periodsDisabled = ($(this).val () === 'standard') ? true : false;
						/**/
						$('p#ws-plugin--s2member-pro-' + button + '-term-line').css ('display', (termDisabled ? 'none' : ''));
						$('p#ws-plugin--s2member-pro-' + button + '-periods-line').css ('display', (periodsDisabled ? 'none' : ''));
						/**/
						(termDisabled) ? $('select#ws-plugin--s2member-pro-' + button + '-term').val ('1-M') : null;
						(periodsDisabled) ? $('select#ws-plugin--s2member-pro-' + button + '-p1').val ('0-D') : null;
						(periodsDisabled) ? $('select#ws-plugin--s2member-pro-' + button + '-p3').val ('1-M') : null;
					/**/
					}).trigger ('change');
				/**/
				$('div.ws-menu-page input[id]').filter (function() /* Filter all input elements with an id. */
					{
						return this.id.match (/^ws-plugin--s2member-pro-level[1-9][0-9]*-ccaps$/);
					}).keyup (function()
					{
						var value = this.value.replace (/^(-all|-al|-a|-)[;,]*/gi, ''), _all = (this.value.match (/^(-all|-al|-a|-)[;,]*/i)) ? '-all,' : '';
						if (value.match (/[^a-z_0-9,]/)) /* Only if there is a problem with the actual values; because this causes interruptions. */
							this.value = _all + $.trim ($.trim (value).replace (/[ \-]/g, '_').replace (/[^a-z_0-9,]/gi, '').toLowerCase ());
					});
				/**/
				ws_plugin__s2member_pro_clickbankButtonGenerate = function(button) /* Handles ClickBank® Button Generation. */
					{
						var shortCodeTemplate = '[s2Member-Pro-ClickBank-Button %%attrs%% image="default" output="anchor" /]', shortCodeTemplateAttrs = '', labels = {};
						var codeHrefTemplate = 'http://%%item%%.%%vendor%%.pay.clickbank.net/?s2_invoice=%%invoice%%&s2_desc=%%desc%%&s2_custom=%%custom%%';
						var vendor = '<?php echo c_ws_plugin__s2member_utils_strings::esc_sq($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_clickbank_username"]); ?>';
						var currentUserIp = '<?php echo c_ws_plugin__s2member_utils_strings::esc_sq ($_SERVER["REMOTE_ADDR"]); ?>';
						/**/
						eval("<?php echo c_ws_plugin__s2member_utils_strings::esc_dq($vars['labels']); ?>");
						/**/
						var shortCode = $('input#ws-plugin--s2member-pro-' + button + '-shortcode');
						var code = $('textarea#ws-plugin--s2member-pro-' + button + '-button');
						/**/
						var level = button.replace (/^level/, ''); /* Just strip the button name to get the Level number. */
						var label = labels['level' + level].replace (/"/g, ""); /* Labels may NOT contain any double-quotes. */
						var desc = $.trim ($('input#ws-plugin--s2member-pro-' + button + '-desc').val ().replace (/"/g, ""));
						/**/
						var prodType = $('select#ws-plugin--s2member-pro-' + button + '-type').val ().replace (/[^A-Z]/gi, '').toLowerCase ();
						var prodItem = $('input#ws-plugin--s2member-pro-' + button + '-item-number').val ().replace (/[^0-9]/g, '');
						/**/
						if (prodType === 'standard') /* In this case, we used the Fixed-Term configuration option. */
							{
								var trialPeriod = '0', trialTerm = 'D'; /* Just use the defaults in this case. */
								var regPeriod = $('select#ws-plugin--s2member-pro-' + button + '-term').val ().split ('-')[0].replace (/[^0-9]/g, '');
								var regTerm = $('select#ws-plugin--s2member-pro-' + button + '-term').val ().split ('-')[1].replace (/[^A-Z]/g, '');
								var regRecur = '0'; /* No, it is NOT recurring. */
							}
						else if (prodType === 'recurring') /* Here we use the ClickBank® Trial Period and Re-Bill configuration. */
							{
								var trialPeriod = $('select#ws-plugin--s2member-pro-' + button + '-p1').val ().split ('-')[0].replace (/[^0-9]/g, '');
								var trialTerm = $('select#ws-plugin--s2member-pro-' + button + '-p1').val ().split ('-')[1].replace (/[^A-Z]/g, '');
								var regPeriod = $('select#ws-plugin--s2member-pro-' + button + '-p3').val ().split ('-')[0].replace (/[^0-9]/g, '');
								var regTerm = $('select#ws-plugin--s2member-pro-' + button + '-p3').val ().split ('-')[1].replace (/[^A-Z]/g, '');
								var regRecur = '1'; /* Yes, it IS recurring. */
							}
						/**/
						var cCaps = $.trim ($.trim ($('input#ws-plugin--s2member-pro-' + button + '-ccaps').val ()).replace (/^(-all|-al|-a|-)[;,]*/gi, '').replace (/[ \-]/g, '_').replace (/[^a-z_0-9,]/gi, '').toLowerCase ());
						cCaps = ($.trim ($('input#ws-plugin--s2member-pro-' + button + '-ccaps').val ()).match (/^(-all|-al|-a|-)[;,]*/i)) ? ((cCaps) ? '-all,' : '-all') + cCaps.toLowerCase () : cCaps.toLowerCase ();
						/**/
						var levelCcapsPer = (prodType === 'standard' && regTerm !== 'L') ? level + ':' + cCaps + ':' + regPeriod + ' ' + regTerm : level + ':' + cCaps;
						levelCcapsPer = levelCcapsPer.replace (/\:+$/g, ''); /* Clean any trailing separators from this string. */
						/**/
						if (!prodItem) /* Must have a Product Item Number to work with. */
							{
								alert('— Oops, a slight problem: —\n\nPlease supply a valid ClickBank® Product Item #.');
								return false;
							}
						else if (!desc) /* Each Button should have a Description. */
							{
								alert('— Oops, a slight problem: —\n\nPlease type a Description for this Button.');
								return false;
							}
						/**/
						codeHrefTemplate += '&s2_customer_ip=<?php echo esc_html("<?php echo S2MEMBER_CURRENT_USER_IP; ?>"); ?>';
						codeHrefTemplate = (prodType === 'recurring') ? codeHrefTemplate.replace (/%%invoice%%/g, '%%invoice%%&s2_p1=%%p1%%&s2_p3=%%p3%%') + '&s2_subscr_id=s2-<?php echo esc_html("<?php echo uniqid(); ?>"); ?>' : codeHrefTemplate;
						codeHrefTemplate = codeHrefTemplate.replace (/%%item%%/g, encodeURIComponent(prodItem)).replace (/%%vendor%%/g, encodeURIComponent(vendor)).replace (/%%invoice%%/g, encodeURIComponent(levelCcapsPer)).replace (/%%desc%%/g, encodeURIComponent(desc));
						codeHrefTemplate = codeHrefTemplate.replace (/%%p1%%/g, encodeURIComponent(trialPeriod + ' ' + trialTerm)).replace (/%%p3%%/g, encodeURIComponent(regPeriod + ' ' + regTerm));
						codeHrefTemplate = codeHrefTemplate.replace (/%%custom%%/g, encodeURIComponent('<?php echo c_ws_plugin__s2member_utils_strings::esc_sq ($_SERVER["HTTP_HOST"]); ?>'));
						code.html (code.html ().replace (/ href\="(.*?)"/, ' href="' + esc_attr(codeHrefTemplate) + '"'));
						/**/
						shortCodeTemplateAttrs += 'cbp="' + esc_attr(prodItem) + '" level="' + esc_attr(level) + '" ccaps="' + esc_attr(cCaps) + '" desc="' + esc_attr(desc) + '" custom="<?php echo c_ws_plugin__s2member_utils_strings::esc_sq (esc_attr ($_SERVER["HTTP_HOST"])); ?>"';
						shortCodeTemplateAttrs += ' tp="' + esc_attr(trialPeriod) + '" tt="' + esc_attr(trialTerm) + '" rp="' + esc_attr(regPeriod) + '" rt="' + esc_attr(regTerm) + '" rr="' + esc_attr(regRecur) + '"';
						shortCode.val (shortCodeTemplate.replace (/%%attrs%%/, shortCodeTemplateAttrs));
						/**/
						$('div#ws-plugin--s2member-pro-' + button + '-button-prev').html (code.val ().replace (/\<a/, '<a target="_blank"').replace (/(s2_customer_ip\=)(.+?)(&|")/, '$1' + currentUserIp + '$3').replace (/(s2_subscr_id\=)(.+?)(&|")/, '$1s2-' + Math.round (new Date ().getTime ()) + '$3'));
						/**/
						alert('Your Button has been generated.\nPlease copy/paste the Shortcode Format into your Membership Options Page.');
						/**/
						shortCode.each (function() /* Focus and select the recommended Shortcode. */
							{
								this.focus (), this.select ();
							});
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_pro_clickbankSpButtonGenerate = function() /* Handles ClickBank® Button Generation for Specific Post/Page Access. */
					{
						var shortCodeTemplate = '[s2Member-Pro-ClickBank-Button %%attrs%% image="default" output="anchor" /]', shortCodeTemplateAttrs = '';
						var codeHrefTemplate = 'http://%%item%%.%%vendor%%.pay.clickbank.net/?s2_invoice=%%invoice%%&s2_desc=%%desc%%&s2_custom=%%custom%%';
						var vendor = '<?php echo c_ws_plugin__s2member_utils_strings::esc_sq($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["pro_clickbank_username"]); ?>';
						var currentUserIp = '<?php echo c_ws_plugin__s2member_utils_strings::esc_sq ($_SERVER["REMOTE_ADDR"]); ?>';
						/**/
						var shortCode = $('input#ws-plugin--s2member-pro-sp-shortcode');
						var code = $('textarea#ws-plugin--s2member-pro-sp-button');
						/**/
						var prodItem = $('input#ws-plugin--s2member-pro-sp-item-number').val ().replace (/[^0-9]/g, '');
						/**/
						var leading = $('select#ws-plugin--s2member-pro-sp-leading-id').val ().replace (/[^0-9]/g, '');
						var additionals = $('select#ws-plugin--s2member-pro-sp-additional-ids').val () || [];
						var hours = $('select#ws-plugin--s2member-pro-sp-hours').val ().replace (/[^0-9]/g, '');
						var desc = $.trim ($('input#ws-plugin--s2member-pro-sp-desc').val ().replace (/"/g, ''));
						/**/
						if (!prodItem) /* Must have a Product Item Number to work with. Otherwise, Button generation will fail. */
							{
								alert('— Oops, a slight problem: —\n\nPlease supply a valid ClickBank® Product Item #.');
								return false;
							}
						else if (!leading) /* Must have a Leading Post/Page ID to work with. Otherwise, Link generation will fail. */
							{
								alert('— Oops, a slight problem: —\n\nPlease select a Leading Post/Page.\n\n*Tip* If there are no Posts/Pages in the menu, it\'s because you\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> Restriction Options -> Specific Post/Page Access.');
								return false;
							}
						else if (!desc) /* Each Button should have a Description. */
							{
								alert('— Oops, a slight problem: —\n\nPlease type a Description for this Button.');
								return false;
							}
						/**/
						for (var i = 0, ids = leading; i < additionals.length; i++)
							if (additionals[i] && additionals[i] !== leading)
								ids += ',' + additionals[i];
						/**/
						var spIdsHours = 'sp:' + ids + ':' + hours; /* Combined sp:ids:expiration hours. */
						/**/
						codeHrefTemplate += '&s2_customer_ip=<?php echo esc_html("<?php echo S2MEMBER_CURRENT_USER_IP; ?>"); ?>';
						codeHrefTemplate = codeHrefTemplate.replace (/%%item%%/g, encodeURIComponent(prodItem)).replace (/%%vendor%%/g, encodeURIComponent(vendor)).replace (/%%invoice%%/g, encodeURIComponent(spIdsHours)).replace (/%%desc%%/g, encodeURIComponent(desc));
						codeHrefTemplate = codeHrefTemplate.replace (/%%custom%%/g, encodeURIComponent('<?php echo c_ws_plugin__s2member_utils_strings::esc_sq ($_SERVER["HTTP_HOST"]); ?>'));
						code.html (code.html ().replace (/ href\="(.*?)"/, ' href="' + esc_attr(codeHrefTemplate) + '"'));
						/**/
						shortCodeTemplateAttrs += 'cbp="' + esc_attr(prodItem) + '" sp="1" ids="' + esc_attr(ids) + '" exp="' + esc_attr(hours) + '" desc="' + esc_attr(desc) + '"';
						shortCodeTemplateAttrs += ' custom="<?php echo c_ws_plugin__s2member_utils_strings::esc_sq (esc_attr ($_SERVER["HTTP_HOST"])); ?>"';
						shortCode.val (shortCodeTemplate.replace (/%%attrs%%/, shortCodeTemplateAttrs));
						/**/
						$('div#ws-plugin--s2member-pro-sp-button-prev').html (code.val ().replace (/\<a/, '<a target="_blank"').replace (/(s2_customer_ip\=)(.+?)(&|")/, '$1' + currentUserIp + '$3'));
						/**/
						alert('Your Button has been generated.\nPlease copy/paste the Shortcode Format into your WordPress® Editor.');
						/**/
						shortCode.each (function() /* Focus and select the recommended Shortcode. */
							{
								this.focus (), this.select ();
							});
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_pro_clickbankRegLinkGenerate = function() /* Handles ClickBank® Link Generation. */
					{
						var level = $('select#ws-plugin--s2member-pro-reg-link-level').val ().replace (/[^0-9]/g, '');
						var subscrID = $.trim ($('input#ws-plugin--s2member-pro-reg-link-subscr-id').val ());
						var custom = $.trim ($('input#ws-plugin--s2member-pro-reg-link-custom').val ());
						var cCaps = $.trim ($.trim ($('input#ws-plugin--s2member-pro-reg-link-ccaps').val ()).replace (/[ \-]/g, '_').replace (/[^a-z_0-9,]/gi, '').toLowerCase ());
						var fixedTerm = $.trim ($('input#ws-plugin--s2member-pro-reg-link-fixed-term').val ().replace (/[^A-Z 0-9]/gi, '').toUpperCase ());
						var $link = $('p#ws-plugin--s2member-pro-reg-link'), $loading = $('img#ws-plugin--s2member-pro-reg-link-loading');
						/**/
						var levelCcapsPer = (fixedTerm && !fixedTerm.match (/L$/)) ? level + ':' + cCaps + ':' + fixedTerm : level + ':' + cCaps;
						levelCcapsPer = levelCcapsPer.replace (/\:+$/g, ''); /* Clean any trailing separators from this string. */
						/**/
						if (!subscrID) /* We must have a Paid Subscr. ID value. */
							{
								alert('— Oops, a slight problem: —\n\nPaid Subscr. ID is a required value.');
								return false;
							}
						else if (!custom || custom.indexOf ('<?php echo c_ws_plugin__s2member_utils_strings::esc_sq ($_SERVER["HTTP_HOST"]); ?>') !== 0)
							{
								alert('— Oops, a slight problem: —\n\nThe Custom Value MUST start with your domain name.');
								return false;
							}
						else if (fixedTerm && !fixedTerm.match (/^[1-9]+ (D|W|M|Y|L)$/)) /* Check format. */
							{
								alert('— Oops, a slight problem: —\n\nThe Fixed Term Length is not formatted properly.');
								return false;
							}
						/**/
						$link.hide (), $loading.show (), $.post (ajaxurl, {action: 'ws_plugin__s2member_reg_access_link_via_ajax', ws_plugin__s2member_reg_access_link_via_ajax: '<?php echo c_ws_plugin__s2member_utils_strings::esc_sq (wp_create_nonce ("ws-plugin--s2member-reg-access-link-via-ajax")); ?>', s2member_reg_access_link_subscr_gateway: 'clickbank', s2member_reg_access_link_subscr_id: subscrID, s2member_reg_access_link_custom: custom, s2member_reg_access_link_item_number: levelCcapsPer}, function(response)
							{
								$link.show ().html ('<a href="' + esc_attr(response) + '" target="_blank" rel="external">' + esc_html(response) + '</a>'), $loading.hide ();
							});
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_pro_clickbankSpLinkGenerate = function() /* Handles ClickBank® Link Generation. */
					{
						var leading = $('select#ws-plugin--s2member-pro-sp-link-leading-id').val ().replace (/[^0-9]/g, '');
						var additionals = $('select#ws-plugin--s2member-pro-sp-link-additional-ids').val () || [];
						var hours = $('select#ws-plugin--s2member-pro-sp-link-hours').val ().replace (/[^0-9]/g, '');
						var $link = $('p#ws-plugin--s2member-pro-sp-link'), $loading = $('img#ws-plugin--s2member-pro-sp-link-loading');
						/**/
						if (!leading) /* Must have a Leading Post/Page ID to work with. Otherwise, Link generation will fail. */
							{
								alert('— Oops, a slight problem: —\n\nPlease select a Leading Post/Page.\n\n*Tip* If there are no Posts/Pages in the menu, it\'s because you\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> Restriction Options -> Specific Post/Page Access.');
								return false;
							}
						/**/
						for (var i = 0, ids = leading; i < additionals.length; i++)
							if (additionals[i] && additionals[i] !== leading)
								ids += ',' + additionals[i];
						/**/
						$link.hide (), $loading.show (), $.post (ajaxurl, {action: 'ws_plugin__s2member_sp_access_link_via_ajax', ws_plugin__s2member_sp_access_link_via_ajax: '<?php echo c_ws_plugin__s2member_utils_strings::esc_sq (wp_create_nonce ("ws-plugin--s2member-sp-access-link-via-ajax")); ?>', s2member_sp_access_link_ids: ids, s2member_sp_access_link_hours: hours}, function(response)
							{
								$link.show ().html ('<a href="' + esc_attr(response) + '" target="_blank" rel="external">' + esc_html(response) + '</a>'), $loading.hide ();
							});
						/**/
						return false;
					};
			}
	});