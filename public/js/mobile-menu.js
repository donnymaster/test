	$('#menuBtn').click(function() {
		$(this).toggleClass('act');
			if($(this).hasClass('act')) {
                $('.mainMenu').addClass('act');
                $('body').css('overflow', 'hidden');
			}
			else {
                $('.mainMenu').removeClass('act');
                $('body').css('overflow', 'auto');
			}
    });