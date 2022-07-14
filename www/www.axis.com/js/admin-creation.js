$(document).ready(function() {
	$("#ddl_user_id").fSelect({});
	$('#ddl_user_id').on('change', function() {
		var selectuser = $('#ddl_user_id').val();
		if(selectuser!="")
		{
			console.log('user changed');
			window.location='admin-user-creation-form.php?mode=update&user_id='+selectuser;
		}
		e.prevantDefault();
 
});

});
