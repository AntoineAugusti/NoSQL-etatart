function setStars(nbStars) {
	var total = 10;
	var html = '';
	var yellowStar = '<i class="recipes__star mdi-action-star-rate yellow" data-id="';
	var grayStar = '<i class="recipes__star mdi-action-star-rate" data-id="';

	for (var i = 1; i <= nbStars; i++)
		html += yellowStar + i + '"></i>';

	for (i = nbStars + 1; i <= total; i++)
		html += grayStar + i + '"></i>';

	// Update the input
	$("#rating").val(nbStars);

	// Update stars in the HTML
	$("#display-stars").html(html);
}

$(document).ready(function() {
	// Initialize with the default number of stars
	if ($('#display-stars').length) {
		setStars(5);
	}

	$(document).on('click', '#display-stars .recipes__star', function() {
		var nbStars = parseInt($(this).attr("data-id"), 10);

		if (nbStars >= 1 && nbStars <= 10) {
			setStars(nbStars);
		}
	});
});