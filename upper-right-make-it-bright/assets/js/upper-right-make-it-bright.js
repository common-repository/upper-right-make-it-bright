jQuery(function($){
	$('header.site-header').removeClass('site-header');

	// Fixed and Scrolled Headers, togethe with this widget area, are freaking stupid.
	// Let's stop covering content on random sizes, by adding a body margin to the top that's
	// the same height as this widget area.

	if( $('.upper-right-make-it-bright .site-header').css('position') == 'fixed' ){
		$('body.upper-right-make-it-bright').css({'margin-top':$('#brightness-over-9000').height()+'px'});
	} else {
		$('body.upper-right-make-it-bright').css({'margin-top':0});
	}

	$(window).on('resize', function(){
		if( $('.upper-right-make-it-bright .site-header').css('position') == 'fixed' ){
			$('body.upper-right-make-it-bright').css({'margin-top':$('#brightness-over-9000').height()+'px'});
		} else {
			$('body.upper-right-make-it-bright').css({'margin-top':0});
		}
	});
});
