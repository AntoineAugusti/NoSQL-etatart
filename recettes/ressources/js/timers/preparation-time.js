$('#slider-preparation-time').noUiSlider({
	start: 10,
	step: 5,
	connect: "lower",
	range: {
		'min': 0,
		'max': 180
	},
	format: wNumb({
		decimals: 0
	})
});

function setPreparationTime() {
	var icon = '<i class="mdi-image-timer"></i>';

	$("#display-preparation-time").html(extractHoursAndMinutesFromTimer("slider-preparation-time", icon));
}
if ($('#slider-preparation-time').length) {
	setPreparationTime();
}
$('#slider-preparation-time').on('slide', setPreparationTime);
$('#slider-preparation-time').Link('lower').to($('#preparationTime'));