$(document).ready(function(){
	var time = 5000;
	var active = 1;
	$('*[id^=vincita]:not(#vincita' + active + ')').fadeOut(1);
	var int = setInterval(function(){
		active = (active == $('*[id^=vincita]').length ? 1 : active + 1);
		$('*[id^=vincita]:not(#vincita' + active + ')').slideUp(400);
		$('#vincita' + active).slideDown(400);
	}, time);
});