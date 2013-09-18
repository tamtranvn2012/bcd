<div class="icon32" id="icon-plugins"><br></div>
<h2><?php echo MPT_TITLE;?></h2>

<div id="mpt_wrap"> 
    
    <p class="mpt_intro">This plugin allows you to activate or deactivate any MU (must-use) plugins that are installed. This works by appending <strong>.OFF</strong> to the plugin's file name, e.g., <em>my-mu-plugin.php</em> becomes <em>my-mu-plugin.php.OFF</em>. A bolded plugin name indicates that plugin is currently active. For more information on MU-plugins, visit the WordPress.org <a href="http://codex.wordpress.org/Must_Use_Plugins" target="_new">Codex</a>.</p>
    <form method="post" action="<?php echo MPT_PARENT_SLUG . '?page=' . MPT_MENU_SLUG . '&update=true';?>" id="mpt_mup_form"><fieldset>
        <legend>MU Plugins</legend>
        <div class="mpt_plugin-list">
            <?php settings_fields('mpt_options'); ?>
            <div class="hide-if-no-js mpt_row mpt_check-all-row"><label>
                <input type="checkbox" id="mpt_mup_checkall" <?php checked(1, MPT_ALL_PLUGINS_ACTIVE);?> />
                <span class="mpt_name-col mpt_check-all"><?php _e('Check All')?></span>
            </label></div>
            <div id="mpt_mup_checkboxes">
                <?php
    $odd = true;
    foreach ($plugins as $name => $val) {
		$odd_or_even = ($odd ? 'mpt_row-odd' : 'mpt_row-even');
        $odd = ! $odd;
        $is_active_class = ($plugins[$name] ? 'mpt_plugin-active' : '');
    ?>
                <div class="mpt_row <?php echo $odd_or_even;?>"><label>
                    <input name="mpt_options[<?php echo $name;?>]" type="checkbox" value="1" <?php checked(1, $val); ?>  />
                    <span class="mpt_name-col mpt_plugin-name <?php echo $is_active_class;?>">
                        <?php _e($name);?>
                    </span>
                </label></div><!-- .mpt_row -->
                <?php
    } // foreach ($plugins as $name => $val)
    ?>
            </div><!-- #mpt_mup_checkboxes -->
        </div><!-- .plugin-list -->
        <div class="mpt_button-wrap">
        	<input id="mpt_submit" type="submit" class="button-primary" value="<?php _e('Update MU Plugins') ?>" />
        </div>
    </fieldset></form>
</div><!-- .wrap --> 
