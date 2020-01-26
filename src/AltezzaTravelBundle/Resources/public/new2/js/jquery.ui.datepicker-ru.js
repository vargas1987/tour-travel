/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
$(function(){
	$('input.date').datepicker({
		dateFormat : 'd M yy',
		showOn: "both",
		buttonImage: "",
		buttonImageOnly: false
	});
	$('input.date_from').datepicker({
		dateFormat : 'd M yy',
		showOn: "both",
		buttonImage: "",
		buttonImageOnly: false,
		minDate: '0',
		onSelect: function(dateText, inst){
			minDate ();
		}
	});
	$('input.date_to').datepicker({
		dateFormat : 'd M yy',
		minDate : '+1d',
		showOn: "both",
		buttonImage: "",
		buttonImageOnly: false
	});

    $('button.ui-datepicker-trigger').remove();
});
function minDate () {
	_mindate = $('input.date_from').datepicker("getDate");
	$('input.date_to').datepicker("option", "minDate", new Date(_mindate) );
}