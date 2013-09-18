jQuery(document).ready(function($) {
/*
 * Code to execute as soon as possible goes here
 * Can use $ inside this function.
 *
 */

	// Disable submit button on click then submit form
	$('#mpt_submit').click(function() {
		$(this) .
			attr('disabled', 'disabled') .
			attr('value', 'Updating . . .') .
			parents('form').submit()
		;
	}); // END Disable submit button on click then submit form
	
	

	// Check all checkboxes
	// credit: http://bit.ly/U07PAG
	var checkall = $('#mpt_mup_checkall');
	var checkboxes = $('#mpt_mup_checkboxes :checkbox').not(checkall);
	checkall.click(function () {
		checkboxes.attr('checked', this.checked);
	});
	checkboxes.change(function() {
		checkall[0].checked = this.checked && checkboxes.filter(':checked').length === checkboxes.length;
	}); // END Check all checkboxes
	
	

});

