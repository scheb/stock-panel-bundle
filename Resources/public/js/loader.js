$(document).ready(function() {
	//External links
	$('a[rel*=external]').click( function() {
		window.open(this.href);
		return false;
	});
});