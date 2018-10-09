$(document).ready(function(){
	setBackground();
	$(window).on('resize', function(ev){
		setBackground()
	});
	function setBackground(){
		var h = $('body .header')[0].clientHeight;
		$('body').css('background-position', '0px ' + h +'px');
	}
});