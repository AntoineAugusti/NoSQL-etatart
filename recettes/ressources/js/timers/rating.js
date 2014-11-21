$('#slider-rating').noUiSlider({
	start: 5,
	connect: "lower",
	range: {
		'min': 1,
		'max': 10
	},
	format: wNumb({
		decimals: 0
	})
});

function setStars() {
	var total = 10;
	var nbStars = $("#slider-rating").val();
	var html = '';
	var yellowStar = '<i class="recipes__star mdi-action-star-rate yellow"></i>';
	var grayStar = '<i class="recipes__star mdi-action-star-rate"></i>';

	for (var i = 1; i <= nbStars; i++)
		html += yellowStar;

	for (i = nbStars; i < total; i++)
		html += grayStar;

	$("#display-stars").html(html);
}

if ($('#slider-rating').length) {
	setStars();
}
$('#slider-rating').on('slide', setStars);
$('#slider-rating').Link('lower').to($('#rating'));