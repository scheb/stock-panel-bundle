$(document).ready(function() {
	//External links
	$('a[rel*=external]').click( function() {
		window.open(this.href);
		return false;
	});

    var setPrivacy = function(isEnabled) {
        $.cookie('privacy', isEnabled ? 1 : 0, { expires: 360 });
        if (isEnabled) {
            $(".privacy").hide();
            $(".btn-privacy .glyphicon").addClass("glyphicon-eye-close").removeClass("glyphicon-eye-open");
        }
        else {
            $(".privacy").show();
            $(".btn-privacy .glyphicon").addClass("glyphicon-eye-open").removeClass("glyphicon-eye-close");
        }
    };

    var togglePrivacy = function() {
        if ($.cookie('privacy') == "1") {
            setPrivacy(false);
        }
        else {
            setPrivacy(true);
        }
    };

    $(".btn-privacy").click(togglePrivacy);
    setPrivacy($.cookie('privacy') == "1");
});
