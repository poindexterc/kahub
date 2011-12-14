$myjquery(document).ready(function (){
    var cal = Calendar.setup({
	showTime : 24,
	onSelect: function(cal) { cal.hide() }
	});
	cal.manageFields("r_DOB", "r_DOB", "%Y-%m-%d %H:%M:00");
	cal.manageFields("r_DOB", "r_DOB", "%Y-%m-%d %H:%M:00");
});
				