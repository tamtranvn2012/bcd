<?php
/**
** A base module for [select2] and [select2*]
**/

/* Shortcode handler */

add_action( 'init', 'wpcf7_add_shortcode_select2', 5 );

function wpcf7_add_shortcode_select2() {
	wpcf7_add_shortcode( array( 'select2', 'select2*' ),
		'wpcf7_select_shortcode_handler2', true );
}

function wpcf7_select_shortcode_handler2( $tag ) {
    $html ='aaaaaaaaaaa';
	return $html;
}


/* Validation filter */

add_filter( 'wpcf7_validate_select2', 'wpcf7_select_validation_filter2', 10, 2 );
add_filter( 'wpcf7_validate_select2*', 'wpcf7_select_validation_filter2', 10, 2 );

function wpcf7_select_validation_filter2( $result, $tag ) {
	$tag = new WPCF7_Shortcode( $tag );

	$name = $tag->name;

	if ( isset( $_POST[$name] ) && is_array( $_POST[$name] ) ) {
		foreach ( $_POST[$name] as $key => $value ) {
			if ( '' === $value )
				unset( $_POST[$name][$key] );
		}
	}

	if ( $tag->is_required() ) {
		if ( ! isset( $_POST[$name] )
		|| empty( $_POST[$name] ) && '0' !== $_POST[$name] ) {
			$result['valid'] = false;
			$result['reason'][$name] = wpcf7_get_message( 'invalid_required' );
		}
	}

	return $result;
}


/* Tag generator */

add_action( 'admin_init', 'wpcf7_add_tag_generator_menu_select2', 25 );

function wpcf7_add_tag_generator_menu_select2() {
	if ( ! function_exists( 'wpcf7_add_tag_generator2' ) )
		return;

	wpcf7_add_tag_generator2( 'menu2', __( 'Drop-down menu categories', 'wpcf7' ),
		'wpcf7-tg-pane-menu2', 'wpcf7_tg_pane_menu2' );
}

function wpcf7_tg_pane_menu2( &$contact_form ) {
?>
<div id="wpcf7-tg-pane-menu" class="hidden">
<form action="">
<table>
<tr><td><input type="checkbox" name="required" />&nbsp;<?php echo esc_html( __( 'Required field?', 'wpcf7' ) ); ?></td></tr>
<tr><td><?php echo esc_html( __( 'Name', 'wpcf7' ) ); ?><br /><input type="text" name="name" class="tg-name oneline" /></td><td></td></tr>
</table>

<table>
<tr>
<td><code>id</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
<input type="text" name="id" class="idvalue oneline option" /></td>

<td><code>class</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
<input type="text" name="class" class="classvalue oneline option" /></td>
</tr>

<tr>
<td><?php echo esc_html( __( 'Choices', 'wpcf7' ) ); ?><br />
<textarea name="values"></textarea><br />
<span style="font-size: smaller"><?php echo esc_html( __( "* One choice per line (1).", 'wpcf7' ) ); ?></span>
</td>

<td>
<br /><input type="checkbox" name="multiple" class="option" />&nbsp;<?php echo esc_html( __( 'Allow multiple selections?', 'wpcf7' ) ); ?>
<br /><input type="checkbox" name="include_blank" class="option" />&nbsp;<?php echo esc_html( __( 'Insert a blank item as the first option?', 'wpcf7' ) ); ?>
</td>
</tr>
</table>

<div class="tg-tag"><?php echo esc_html( __( "Copy this code and paste it into the form left.", 'wpcf7' ) ); ?><br /><input type="text" name="select" class="tag" readonly="readonly" onfocus="this.select()" /></div>

<div class="tg-mail-tag"><?php echo esc_html( __( "And, put this code into the Mail fields below (2)", 'wpcf7' ) ); ?><br /><span class="arrow">&#11015;</span>&nbsp;<input type="text" class="mail-tag" readonly="readonly" onfocus="this.select()" /></div>
</form>
</div>
<?php
}

?>