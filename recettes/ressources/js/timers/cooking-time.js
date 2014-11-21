$('#slider-cooking-time').noUiSlider({
	start: 20,
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

function setCookingTime() {
	var icon = '<i class="mdi-image-timer"></i>';

	$("#display-cooking-time").html(extractHoursAndMinutesFromTimer("slider-cooking-time", icon));
}
if ($('#slider-cooking-time').length) {
	setCookingTime();
}
$('#slider-cooking-time').on('slide', setCookingTime);
$('#slider-cooking-time').Link('lower').to($('#cookingTime'));