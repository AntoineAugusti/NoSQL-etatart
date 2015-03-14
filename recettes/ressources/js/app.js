// Tooltips and popovers
(function() {
	$('[data-toggle="popover"]').popover();
	$('[data-toggle="tooltip"]').tooltip();
})();

$(".chosen-select").chosen({
	create_option: true,
	persistent_create_option: true,
	skip_no_results: true,
	create_option_text: "Add your ingredient",
});

// Material design
$(document).ready(function() {
	$.material.init();
});

function pad(num, size) {
	var s = num + "";
	while (s.length < size) s = "0" + s;
	return s;
}

function extractHoursAndMinutesFromTimer(divID, icon) {
	var time = $("#"+divID).val();
	var hours, minutes;

	hours = Math.floor(time / 60);
	minutes = Math.floor(time % 60);

	return icon + ' ' + hours + ' h ' + pad(minutes, 2);
}