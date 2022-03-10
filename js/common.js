// make bootstrap nav links activation work
$("ul.navbar-nav a").each(function(index, element) {
	if ($(this).attr("href") == window.location.pathname) {
		$(this).addClass("active");
	}
});