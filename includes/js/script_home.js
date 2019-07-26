
jQuery(function($) {
	var validation_holder;
	
	$("form#search_form input[name='submit']").click(function() {
	
	var validation_holder = 0;
		
		var trip 			= $("form#search_form input[name='trip']");
		var tripVal			= $("form#search_form  input[name='trip']:checked").val();
		var source 			= $("form#search_form input[name='source']").val();
		var destination 	= $("form#search_form input[name='destination']").val();
		var onwarddate 		= $("form#search_form input[name='onwarddate']").val();
		var returndate 		= $("form#search_form input[name='returndate']").val();

		
		/* validation start */	
		if(trip.is(':checked') == false) {
			$("span.val_trip").html("Please select the journey type.").addClass('validate');
			validation_holder = 1;
		} else {
			$("span.val_trip").html("");
			}
		if(source == "") {
			$("span.val_source").html("Please enter the source").addClass('validate');
			validation_holder = 1;
		} else {
			$("span.val_source").html("");
			}
		if(destination == "") {
			$("span.val_destination").html("Please enter the destination.").addClass('validate');
			validation_holder = 1;
		} else {
			$("span.val_destination").html("");
			}
		if(onwarddate == "") {
			$("span.val_onwarddate").html("Please select the onward date.").addClass('validate');
			validation_holder = 1;
		} else {
			$("span.val_onwarddate").html("");
			}
		if(returndate == "" && tripVal =='Return Trip') {
			$("span.val_returndate").html("Please select the return date..").addClass('validate');
			validation_holder = 1;
		} else {
			$("span.val_returndate").html("");
			}
		
		if(validation_holder == 1) { // if have a field is blank, return false
			$("p.validate_msg").slideDown("fast");
			return false;
		}  validation_holder = 0; // else return true
		/* validation end */	
	}); // click end 

}); // jQuery End

$( function() {
$( "#onwarddate" ).datepicker();
$( "#returndate" ).datepicker();
} );