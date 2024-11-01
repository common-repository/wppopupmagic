jQuery( function( $ ) {
	$('input[name=post_name]').closest('label').hide()	;
	$('input[name=post_password]').closest('.inline-edit-group').hide();
	$('.inline-edit-date').hide();
	$('.inline-edit-date').prev('label').hide();
	$('.inline-edit-status').siblings().hide();
	$('select[name=_status]').find('option[value="pending"], option[value="private"]').remove();
	
	if ( $('#message').length > 0 ) {
		$('#wppum-message').hide();
	}
});
